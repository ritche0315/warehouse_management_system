<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
use App\Helpers\Session;
?>
<?php $warehouseid = null;?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-12">
                    <?php include(APPDIR.'views/layouts/errors.php'); ?>
                    <p class="mt-3 fw-light fs-3">Add Order</p>
                </div>
                
                <div class="col">
                    <p class='bg-dark text-light p-3'>Orderline</p>
                    <div class="mb-3 px-3">
                        <label for="search-barcode" class='form-label'>Search/Scan Barcode:</label>
                        <input type='text' name="barcode" id="search-barcode" class='form-control'/>
                    </div>
                    <div class="mb-3 px-3">
                        <div class="table-responsive border border-normal" style='max-height: 400px; overflow-y: auto;'>
                            <table class="table table-bordered" id="orderTable">
                                <thead>
                                    <th>Barcode</th>
                                    <th>Item Name</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Sub Total</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-3 px-3 d-flex justify-content-end gap-2">
                        <button type="button" class='btn btn-danger' id='btnVoid'>VOID</button>
                    </div>
                </div>
                <div class="col-md-4 px-0" style="background-color: #F2F4F3;">
                    <div class="bg-dark">
                        <label for="totalItems" class='form-label text-light p-3'>Total items:</label>
                        <label class='form-label text-light' id='totalItems'>0</label>
                    </div>
                    <div class="bg-warning">
                        <label for="totalAmount" class='form-label p-3 fs-4 fw-bold'>Total Amount:</label>
                        <label class='form-label fs-4 fw-bold' id='totalAmount'>0.00</label>
                    </div>

                    <p class='text-light p-3 bg-dark'>Customer Information</p>
                    <div class="mb-3 px-3">
                        <label for="select-customer" class='form-label'>Choose Customer:</label>
                        <select name="select-customer" id="select-customer" class='form-select'>
                            <option value='0' selected>Choose...</option>
                            <?php   foreach($customers as $customer){
                                echo "<option value='".$customer->CustomerID."'>".$customer->FirstName.' '.$customer->LastName."</option>";
                            }?>
                        </select>
                    </div>
                    <div class="px-3 mb-5 d-flex justify-content-end">
                        <button type="button" class='btn btn-success fs-4' id='btnSubmitOrder'>Submit Order</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Smart Stock 2024</div>
            </div>
        </div>
    </footer>
</div>

<script>
    //datasources
    //elements
    const searchBarcodeInput = document.querySelector('#search-barcode');  
    const btnSubmitOrder = document.querySelector('#btnSubmitOrder');
    const table = document.querySelector('#orderTable');  
    const tbody = document.querySelector('#orderTable > tbody');  
    const totalItemsEl = document.querySelector('#totalItems');  
    const totalAmountEl = document.querySelector('#totalAmount');  
    const selectCustomerEl = document.querySelector('#select-customer');
    
    let selectedRow = null; // Variable to keep track of the selected row  

    function calculateTotalItemsAndTotalAmount() {  
        const rows = Array.from(tbody.rows); // Get the rows from tbody  

        const totalItems = rows.reduce((sum, row) => {  
            const value = parseInt(row.children[3].innerText) || 0;  
            return sum + value;  
        }, 0);  

        const totalAmount = rows.reduce((sum, row) => {  
            const value = parseFloat(row.children[4].innerText) || 0;  
            return sum + value;  
        }, 0);  

        totalItemsEl.innerText = totalItems;  
        totalAmountEl.innerText = totalAmount.toFixed(2);  
    }  

    // Event delegation for selecting a row  
    tbody.addEventListener('click', function (e) {  
        const row = e.target.closest('tr'); // Get clicked row  
        if (row) {  
            // Highlight the selected row  
            if (selectedRow) {  
                selectedRow.classList.remove('selected'); // Remove highlight from previously selected row  
            }  
            selectedRow = row; // Assign the new selected row  
            selectedRow.classList.add('selected'); // Highlight the currently selected row  
        }  
    });  

    // Function to find a row by barcode (for existing functionality)  
    function findRowByBarcode(barcode) {  
        // Find the row with the specified barcode  
        return Array.from(tbody.rows).find(row => (row.children[0].innerText).toLowerCase() === barcode);  
    }  

    // Search barcode  
    searchBarcodeInput.addEventListener('keydown', function (event) {  
        if (event.key === 'Enter') {  
            const barcode = searchBarcodeInput.value; // Replace this with the actual barcode you are searching for  
            
            const existingRow = findRowByBarcode(barcode); 
            
            if (existingRow) {  
                // If row exists, increase the quantity  
                const qtyCell = existingRow.children[3];  
                const existingQuantity = parseInt(qtyCell.innerText) || 0;  
                const newQuantity = existingQuantity + 1; // Increase by 1  
                qtyCell.innerText = newQuantity;  

                // Update the total for this row  
                const total = parseFloat(existingRow.children[2].innerText) * newQuantity; // Recalculate total  
                existingRow.children[4].innerText = total.toFixed(2); // Update total in index 4  
                calculateTotalItemsAndTotalAmount();
            } else { 
                fetch('/inventory/fetch_inventory/'+barcode)
                .then(response=> response.json())
                .then(responseData =>{
                    
                    if(responseData){
                        const html = `<tr>  
                            <td>${responseData.Barcode}</td>  
                            <td>${responseData.Name}</td>  
                            <td>${responseData.UnitPrice}</td>  
                            <td class='qty'>1</td>  
                            <td>${parseFloat(responseData.UnitPrice).toFixed(2)}</td>  
                        </tr>`;  
            
                        tbody.innerHTML += html;
                        calculateTotalItemsAndTotalAmount(); // Update overall totals  
                    }
                    else{
                        alert('barcode not found, please try again !')
                    }
                }).catch(err=> console.log(err))
            }  

            
            // Optional: Clear the input field after action  
            searchBarcodeInput.value = '';  
        }  
    });  

    // Handle void button click  
    document.getElementById('btnVoid').addEventListener('click', function () {  
        if (selectedRow) {  
            selectedRow.remove(); // Remove the selected row  
            selectedRow = null; // Reset selected row  
            calculateTotalItemsAndTotalAmount(); // Update totals after a row is deleted  
        } else {  
            alert('Please select a row to void.'); // Alert if no row is selected  
        }  
    });  

    // Add click event listener to quantity cells
    tbody.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('qty')) {
            const qtyCell = e.target;
            const currentQty = parseInt(qtyCell.innerText) || 0;
            const newQty = prompt('Enter new quantity:', currentQty);

            if (newQty !== null) {
                const quantity = parseInt(newQty);
                if (!isNaN(quantity) && quantity > 0) {
                    qtyCell.innerText = quantity;

                    // Update the total for this row
                    const row = qtyCell.closest('tr');
                    const unitPrice = parseFloat(row.children[2].innerText);
                    const total = unitPrice * quantity;
                    row.children[4].innerText = total.toFixed(2);

                    calculateTotalItemsAndTotalAmount(); // Update overall totals
                } else {
                    alert('Please enter a valid quantity.');
                }
            }
        }
    });

    btnSubmitOrder.addEventListener('click', ()=>{
        if(totalAmountEl.innerText == "0.00"){
            alert('Submit order failed, Orderline is empty');
            return;
        }
        
        if(selectCustomerEl.value == '0'){
            alert('Please select a customer');
            return;
        }
        const rows = Array.from(tbody.rows);

        const order = {
            'totalAmount': totalAmountEl.innerText,
            'totalItems': totalItemsEl.innerText,
            'customerId': selectCustomerEl.value
        }

        
        const tableRows = document.querySelectorAll('#orderTable tbody tr');  
        const orderDetails = [];  
        
        tableRows.forEach(row => {  
            const cells = row.querySelectorAll('td');  
            const rowData = {  
                barcode: cells[0].innerText,  
                quantity: cells[3].innerText,  
                subtotal: cells[4].innerText  
            };  
            orderDetails.push(rowData);  
        });  

        const formData = new FormData();
        formData.append("data", JSON.stringify({"order":order, "orderdetails": orderDetails}));
        
        fetch('/orders/add_order', {
            method:'POST',
            body: formData
        })
        .then(response=> response.json())
        .then(responseData => {
            alert(responseData.message);
            tbody.innerHTML = ``;
            totalAmountEl.innerText = "0.00";
            totalItemsEl.innerText = "0";
            selectCustomerEl.value = '0';
        })
        .catch(err=> console.log(err))
        // rows.forEach(row=>{
        //    fetch('/')
        // })
    })

</script>
<?php include(APPDIR.'views/layouts/footer.php');?>
