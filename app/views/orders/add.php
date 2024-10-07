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
                    <h1 class="mt-4">Add Order</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Order Entry</li>
                    </ol>
                </div>

                <div class="col">
                    <div class="container">
                        <div class="row g-2">
                            <div class="col p-3 border d-flex align-items-center gap-3">
                                <div class='fw-bold'>Order No#:&nbsp; <?=$issuedNo;?></div>
                                <div>|</div>
                                <div class='fw-medium'>Customer:</div>
                                <div class='flex-grow-1'>
                                    <div class="control-group">
                                            <div id='customerSearch-wrapper'>
                                                <input type="customer" id='customer' class="form-control" name='customer'onkeyup="searchCustomer()" placeholder="Search Customer">
                                                <div id="customer-searchfilter-container" class='bg-light border d-flex flex-column'>
                                                    <?php
                                                    // Loop through each item in the PHP array and output it as a list item
                                                    foreach ($customers as $item) {
                                                        echo "<button type='button' class='btn btn-secondary rounded-0 customerItemButton' data-customerid='".htmlspecialchars($item->CustomerID)."'>" . htmlspecialchars($item->FirstName)." ".htmlspecialchars($item->LastName)  . "</button>";
                                                    }
                                                    ?>
                                                </div>                                        
                                            
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col p-3 col-md-4 border">
                                <div class="p-3 border h-100">
                                    <div class='text-secondary mb-4'>Product Information</div>
                                    <form id='productForm'>
                                        <div class="row">
                                            <div class="col">

                                                <div class="control-group">
                                                    <!-- <label for="warehouse" class="control-label">Select warehouse</label> -->
                                                    <select class='form-select' name='warehouse-select' id='warehouse-select'>
                                                        <option value="0" selected>Select warehouse</option>
                                                        <?php foreach($warehouses as $warehouse){ ?>
                                                            <option value=<?=$warehouse->WarehouseID?>><?=$warehouse->Name?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <div id='productSearch-wrapper'>
                                                        
                                                        <label for="product" class="control-label">Search Product</label>
                                                        <input type="text" class="form-control" onkeyup='searchFunction()' name='product' id='product' placeholder="Search Product" required>
                                                       
                                                        <div id="myUL" class='bg-light border d-flex flex-column'>
                                                           
                                                        </div>
                                                    </div>
                                                                                                        
                                                </div>
                                                
                                                <script>
                                                    
                                                   //product search
                                                    function searchFunction() {
                                                        // Get the search input value and convert it to lowercase
                                                        var input = document.getElementById('product');
                                                        var filter = input.value.toLowerCase();
                                                        // Get the list of items
                                                        var ul = document.getElementById("myUL");
                                                        var li = ul.getElementsByTagName('button');


                                                        //if input is empty
                                                        if(filter.length == 0) { 
                                                             // Loop through all list items, and hide those that don't match the search query
                                                            for (var i = 0; i < li.length; i++) {
                                                                li[i].classList.remove("found")
                                                            
                                                            }

                                                            return;
                                                        }
    
                                                        // Loop through all list items, and hide those that don't match the search query
                                                        for (var i = 0; i < li.length; i++) {
                                                            var txtValue = li[i].textContent || li[i].innerText;
                                                            
                                                            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                                                                li[i].classList.add("found");
                                                            }
                                                            
                                                            else {
                                                                li[i].classList.remove("found");
                                                            }

                                                            

                                                        }
                                                    }


                                                </script>

                                                <div class="control-group">
                                                    <label for="warehouse" class="control-label">Warehouse</label>
                                                    <input type="text" class="form-control" name='warehouse' id='warehouse' required>
                                                </div>

                                                <div class="control-group">
                                                    <label for="prodName" class="control-label">Name</label>
                                                    <input type="text" class="form-control" name='prodName' id='prodName' required>
                                                </div>
                                                
                                                
                                                <div class="control-group">
                                                    <label for="quantity" class="control-label">Quantity</label>
                                                    <input type="number" class="form-control" name='quantity' value='1' id='quantity'>
                                                </div>
                                            </div>
                                            
                                            <div class="control-group">
                                                <button type='submit' class="btn btn-success offset-5 mt-3">Add</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <script>

                                        // customer search fn
                                            function searchCustomer() {
                                                // Get the search input value and convert it to lowercase
                                                var input = document.getElementById('customer');
                                                var filter = input.value.toLowerCase();
                                                // Get the list of items
                                                var ul = document.getElementById("customer-searchfilter-container");
                                                var li = ul.getElementsByTagName('button');


                                                //if input is empty
                                                if(filter.length == 0) { 
                                                        // Loop through all list items, and hide those that don't match the search query
                                                    for (var i = 0; i < li.length; i++) {
                                                        li[i].classList.remove("found")
                                                    
                                                    }

                                                    return;
                                                }

                                                // Loop through all list items, and hide those that don't match the search query
                                                for (var i = 0; i < li.length; i++) {
                                                    var txtValue = li[i].textContent || li[i].innerText;
                                                    
                                                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                                                        li[i].classList.add("found");
                                                    }
                                                    
                                                    else {
                                                        li[i].classList.remove("found");
                                                    }

                                                    

                                                }
                                            }


                                        //add button click event on customer item button          
                                        const customerItemButton = document.getElementsByClassName('customerItemButton')

                                        Array.from(customerItemButton).forEach(item=>{
                                            item.addEventListener('click', ()=>{
                                                const customer = document.querySelector('#customer')
                                                customer.value = item.textContent
                                                customer.dataset.customerid = item.dataset.customerid
                                                 // Get the list of items
                                                var ul = document.getElementById("customer-searchfilter-container");
                                                var li = ul.getElementsByTagName('button');
                                                // Loop through all list items, and hide those that don't match the search query
                                                for (var i = 0; i < li.length; i++) {
                                                        li[i].classList.remove("found");

                                                }

                                            })
                                        })
                                        


                                           
                                    </script>
                                    
                                </div>
                            </div>
                            <div class="col p-3 col-md-8 border">
                                <div class="col-12">
                                    <div class="table-responsive border" style="height: 400px;">
                                        <table class='table table-borderless' id='itemlist-table'>
                                            <thead class='table-secondary'>
                                                <th>#</th>
                                                <th>SKU</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>UnitPrice</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                        <!-- Total row count display -->
                                    <!-- Display Total Row Count and Total Amount -->
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div id="rowCountDisplay" class="text-start ms-3">Total Items: 0</div>
                                        <div id="totalAmountDisplay" class="text-end me-3 fw-bold">Total Amount: 0.00</div>
                                    </div>
                                    <form id='orderSubmitForm' class='d-flex justify-content-end gap-2 my-3 mx-2 align-items-center'>
                                    <!-- <div class='flex-fill'>Total:</div> -->
                                    <button type='submit' class="btn btn-success mt-3" id='btn-submitorder'>Submit Order</button>
                                    <button class="btn btn-danger mt-3">Cancel Order</button>
                                    </form>
                            </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
                
        </div>
        <script>
            var orderItems = [];
            
            const form = document.querySelector('#productForm')
            form.addEventListener('submit', (e)=>{
                e.preventDefault()
                var products = <?php echo json_encode($products);?>

                var productInput = document.querySelector('#prodName')
                const  quantity = document.querySelector('#quantity')
                const customer = document.querySelector('#customer')
                const warehouseInput = document.querySelector('#warehouse')
                const searchProductInput = document.querySelector('#product')
                

                // Check if product exists in the product list
                products.map(product => {
                        if (product.Name == productInput.value) {
                        
                        // Check if the product is already in orderItems
                        let existingProduct = orderItems.find(item => item.name.toLowerCase() === productInput.value.toLowerCase());

                        if (existingProduct) {
                            // Update existing product quantity and total
                            var total = parseInt(quantity.value) * parseInt(product.UnitPrice);
                            existingProduct.qty = parseInt(existingProduct.qty) + parseInt(quantity.value);
                            existingProduct.total = parseInt(existingProduct.total) + total;

                        } else {
                            // Add new product to the orderItems array
                            let total = parseInt(quantity.value) * parseInt(product.UnitPrice);

                          

                            orderItems.push({
                                "customer": parseInt(customer.dataset.customerid),
                                "warehouseid": parseInt(warehouseInput.dataset.warehouseid),
                                "rowCount": orderItems.length + 1,
                                "sku": product.SKU,
                                "prodId":product.ProductID,
                                "name": product.Name,
                                "qty": parseInt(quantity.value),
                                "unitPrice": product.UnitPrice,
                                "total": total
                            });

                            console.log(orderItems)

                        }

                        // Update the orderItems table
                        populateOrderItems(orderItems);
                        

                    }
                });
                
                 productInput.value = ''
                 quantity.value = 1
                 customer.value = ''
                 warehouseInput.value = ''
                 searchProductInput.value = ''
            })

         

            function populateOrderItems(orderItems){
                const tbody = document.querySelector('#itemlist-table > tbody');
                tbody.innerHTML = '';

                orderItems.map((orderItem, index) => {
                    tbody.innerHTML += `
                        <tr data-index="${index}">
                            <td>${orderItem.rowCount}</td>
                            <td>${orderItem.sku}</td>
                            <td>${orderItem.name}</td>
                            <td>${orderItem.qty}</td>
                            <td>${orderItem.unitPrice}</td>
                            <td>${orderItem.total}</td>
                            <td>
                                <button type='button' class='btn btn-danger delete-btn' data-index="${index}">
                                    <i class='fa fa-trash'></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });

                // Attach delete event listener to each delete button
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        let index = e.target.closest('button').getAttribute('data-index');
                        deleteOrderItem(index);
                    });
                });

                // Update the total row count display
                updateRowCount();

                 // Update the total amount display
                calculateTotalAmount();
            }

            // Function to delete an order item
            function deleteOrderItem(index) {
                // Remove the item from the array
                orderItems.splice(index, 1);

                // Re-populate the table
                populateOrderItems(orderItems);
            }

            // Function to update and display the total row count
            function updateRowCount() {
                const rowCount = orderItems.length;
                const rowCountDisplay = document.querySelector('#rowCountDisplay');
                
                // Display the total number of rows
                rowCountDisplay.textContent = `Total Rows: ${rowCount}`;
            }

            // Function to calculate and display the total amount
            function calculateTotalAmount() {
                let totalAmount = orderItems.reduce((sum, item) => sum + parseInt(item.total), 0);
                const totalAmountDisplay = document.querySelector('#totalAmountDisplay');
                
                // Display the total amount
                totalAmountDisplay.textContent = `Total Amount: ₱${totalAmount.toFixed(2)}`;
            }

            //submitorder
            const orderSubmitForm = document.querySelector('#orderSubmitForm')
            orderSubmitForm.addEventListener('submit', (e)=>{
                e.preventDefault()
                
                let formData = new FormData()
                formData.append('data', JSON.stringify(orderItems))

                fetch('/orders/submit_order',{
                    method:'POST',
                    body: formData
                })
                .then(response=>{
                    return response.json()
                })
                .then(responseData=>{
                    console.log(responseData)
                })
                .catch(err=> console.log(err))
            })

        </script>

        <script>
            const prodName = document.querySelector('#prodName')
            const product = document.querySelector('#product')
            const quantity = document.querySelector("#quantity")
            const warehouse = document.querySelector('#warehouse')
            const warehouseSelect = document.querySelector('#warehouse-select')
            const productContainer = document.querySelector('#myUL')
                                                            
            const productInventory = <?php echo json_encode($products);?>

            var html = ``
            productInventory.map(prod=>{
                if(prod.WarehouseID == warehouseSelect.value){
                    
                    html += `
                        <button type='button' class='btn btn-secondary rounded-0 productItemButton' data-warehouse='${JSON.stringify({"WarehouseID":prod.WarehouseID, "WarehouseName": prod.WarehouseName})}'>${prod.Name}</button>
                    `
                }

            })

            productContainer.innerHTML = html


            //add button click event on product item button                                       
            const productItemButton = document.getElementsByClassName('productItemButton')
            
            Array.from(productItemButton).forEach(item=>{
                item.addEventListener('click', ()=>{
                    const warehouse = JSON.parse(item.dataset.warehouse)

                    const warehouseInput = document.querySelector('#warehouse')
                    warehouseInput.value = warehouse.WarehouseName
                    warehouseInput.dataset.warehouseid = warehouse.WarehouseID

                    const productName = document.querySelector('#prodName')
                    productName.value = item.textContent

                    const product = document.querySelector('#product')
                    product.value = item.textContent

                        // Get the list of items
                    var ul = document.getElementById("myUL");
                    var li = ul.getElementsByTagName('button');
                    // Loop through all list items, and hide those that don't match the search query
                    for (var i = 0; i < li.length; i++) {
                            li[i].classList.remove("found");

                    }

                })
            })


            warehouseSelect.addEventListener('change', ()=>{
                if(warehouseSelect.value == "0"){
                    disableFields()
                    return;
                }

                const selectedItemValue = warehouseSelect.value
                enableFields()
                warehouseSelect.disabled = true
                html = ``
                productInventory.map(prod=>{
                    if(prod.WarehouseID == warehouseSelect.value){
                        
                        html += `
                            <button type='button' class='btn btn-secondary rounded-0 productItemButton' data-warehouse='${JSON.stringify({"WarehouseID":prod.WarehouseID, "WarehouseName": prod.WarehouseName}) }'>${prod.Name}</button>
                        `
                    }

                })

                productContainer.innerHTML = html

                //add button click event on product item button                                       
            const productItemButton = document.getElementsByClassName('productItemButton')
            
            Array.from(productItemButton).forEach(item=>{
                item.addEventListener('click', ()=>{
                    const warehouse = JSON.parse(item.dataset.warehouse)

                    const warehouseInput = document.querySelector('#warehouse')
                    warehouseInput.value = warehouse.WarehouseName
                    warehouseInput.dataset.warehouseid = warehouse.WarehouseID

                    const productName = document.querySelector('#prodName')
                    productName.value = item.textContent

                    const product = document.querySelector('#product')
                    product.value = item.textContent

                        // Get the list of items
                    var ul = document.getElementById("myUL");
                    var li = ul.getElementsByTagName('button');
                    // Loop through all list items, and hide those that don't match the search query
                    for (var i = 0; i < li.length; i++) {
                            li[i].classList.remove("found");

                    }

                })
            })
                })


            const disableFields = ()=>{
               
                    prodName.disabled = true
                    product.disabled = true
                    quantity.disabled = true
                    warehouse.disabled = true
                 
            }
            const enableFields = ()=>{
               
                    prodName.disabled = false
                    product.disabled = false
                    quantity.disabled = false
                    warehouse.disabled = false
                 
            }


            
            
            disableFields()



        </script>
    </main>
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Smart Stock 2024</div>
                <div>
                    <!-- <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div> -->
            </div>
        </div>
    </footer>
    </div>
</div>



<?php include(APPDIR.'views/layouts/footer.php');?>
