<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
use App\Helpers\Session;
?>


<div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <?php include(APPDIR.'views/layouts/errors.php'); ?>
                <h1 class="mt-4">Order</h1>
                <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Order List</li>
                </ol>
                <p>
				<a href="/orders/add" class="btn btn-xs btn-info text-light"><i class='fa fa-circle-plus text-light me-1'></i>Add Order</a>
				<!-- <button type='button' class="btn btn-xs btn-danger text-light"><i class='fa fa-close text-light me-1'></i>Cancel Order</button>-->
				</p>

                <div class="table-responsive" id="ordersTableWrapper">
                <table class="table table-bordered table-light" id='ordersTable'>
                    <thead class='sticky-top table-dark'>
                        <th>OrderID</th>
                        <th>OrderDate</th>
                        <th>Catered By</th>
                        <th>Customer</th>
                        <th>Total Quantity</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>

            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; SmartStock 2024</div>
                    <div>
                        <!--<a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>-->
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <?php include(APPDIR.'views/modals/orderdetails.php');?>
    <?php include(APPDIR.'views/modals/orderupdate.php');?>
<script>
    const orders = <?php echo json_encode($orders);?>;
    const ordersTableEl = document.querySelector('#ordersTable');
    const tbody = ordersTableEl.children[1];
    
    const orderDetailsTableEl = document.querySelector('#orderDetailsTable');
    const orderUpdateTableEl = document.querySelector('#orderUpdateTable');
    const updateOrdertotalItemsEl = document.querySelector('#updateOrder-totalItems');
    const updateOrdertotalAmountEl = document.querySelector('#updateOrder-totalAmount');
    const orderDateEl = document.querySelector('#orderDate');

    const orderIdEl = document.querySelector('#orderUpdate-orderId');
    let selectedRow = null; // Variable to keep track of the selected row  
    var updateOrderItems = [];

    // Event delegation for selecting a row  
   // Event listener for tbody click events  
	tbody.addEventListener('click', (e) => {  
    const button = e.target.closest('button'); // Get clicked button  

    const row = button.parentElement.parentElement; // Traverse to the row  
    // Get the first cell in that row  
    const orderid = row.cells[0].innerText; // cell index starts from 0 
    //const  customerName = row.cells[3].innerText;
    if (button && button.classList.contains('viewBtn')) {  
        fetch('/orderdetails/fetch_orderdetails/'+orderid)
        .then(response => response.json())
        .then(responseData => {

            let tbody2 = orderDetailsTableEl.children[1];
            const orderdetails = responseData.orderdetails
        
            // tbody2.innerHTML += `<tr><td>1</td></tr>`;
            let html = ``
            orderdetails.forEach(orderdetail =>{
                html += `<tr>
                    <td>${orderdetail.OrderID}</td>
                    <td>${orderdetail.Name}</td>
                    <td>${orderdetail.PriceSold}</td>
                    <td>${orderdetail.Quantity}</td>
                    <td>${orderdetail.SubTotal}</td>
                </tr>`
            })
            tbody2.innerHTML = html;
			
			document.querySelector('#orderId').innerText = orderid;
			//document.querySelector('#customerName').innerText = customerName;
            const modal = new bootstrap.Modal('#orderDetailsModal', null);  
            modal.show();  
        })
        .catch(err => console.log(err))
        
    } 
    
    if(button && button.classList.contains('editBtn')){
        fetch('/orderdetails/fetch_orderdetails/'+orderid)
        .then(response => response.json())
        .then(responseData => {

            let tbody2 = orderUpdateTableEl.children[1];
            const orderdetails = responseData.orderdetails
        
            // tbody2.innerHTML += `<tr><td>1</td></tr>`;
            let html = ``
            orderdetails.forEach(orderdetail =>{
                html += `<tr>
                    <td>${orderdetail.OrderDetail_ID}</td>
                    <td>${orderdetail.OrderID}</td>
                    <td>${orderdetail.Name}</td>
                    <td>${orderdetail.PriceSold}</td>
                    <td class='qty'>${orderdetail.Quantity}</td>
                    <td>${orderdetail.SubTotal}</td>
                    </tr>`
                    // <td><button type='button' class='btn btn-danger btn-remove'><i class='fa fa-minus'></i></button></td>
            })
            tbody2.innerHTML = html;
			
            
            // fetch order
            fetch('/orders/fetch_order/'+orderid)
            .then(response => response.json())
            .then(responseData=>{
                if(responseData){
                    // console.log(responseData)
                    document.querySelector('#orderUpdate-orderId').innerText = orderid;
                    document.querySelector('#orderUpdateCustomer').value = responseData.order.CustomerID;
                    orderDateEl.value = responseData.order.OrderDate;
                    calculateTotalItemsAndTotalAmount();
                    const modalOrderUpdate = new bootstrap.Modal('#orderUpdateModal', null);  
                    modalOrderUpdate.show();  
                }
            })
            .catch(err=>console.log(err))
        })
        .catch(err => console.log(err))
      
    }
//     if(button && button.classList.contains('cancelBtn')){
//         const orderStatus = row.cells[6].innerText;
//         if(orderStatus == "Cancelled"){
//             alert('Order Already Cancelled');
//             return
//         }
//         if (window.confirm("Do you really want to cancel this order?")) {
            
            
//             const formData = new FormData();
//             formData.append('orderId', orderid);
//             formData.append('status', "Cancelled")
//             formData.append('remarks', "Order Cancelled");    
            

//             fetch('/orders/cancel_order', {
//                 method: 'POST',
//                 body: formData
//             })
//             .then(response => response.json())
//             .then(responseData=>{
                
//                 if(responseData){
//                     alert(responseData.message);
//                     window.location.href = '/orders'
// ;                }
//             })
//             .catch(err=> console.log(err))

            
//         }

//     }
});  

// Function to populate orders into the orders table  
function populateOrdersToOrdersTable() {  
    let html = ``
    orders.forEach(order=>{
        html += `  
            <tr>  
                <td>${order.OrderID}</td>  
                <td>${order.OrderDate}</td>  
                <td>${order.Operator}</td>  
                <td>${order.Customer}</td>  
                <td>${order.TotalQuantity}</td>  
                <td>${order.TotalAmount}</td>
                <td>
                    <button class='btn btn-success viewBtn'><i class='fa fa-eye'></i></button>
                    <button class='btn btn-warning editBtn'><i class='fa fa-edit text-light'></i></button>
                </td>  
            </tr>  
    `})// Use map and join to create and set innerHTML  
    tbody.innerHTML = html;
}

//updateOrder

    // Add click event listener to quantity cells
    const orderUpdateTbody = orderUpdateTableEl.children[1];

     // Event delegation for selecting a row  
    //  orderUpdateTbody.addEventListener('click', function (e) {  
    //     const row = e.target.closest('tr'); // Get clicked row  
    //     if (row) {  
    //         // Highlight the selected row  
    //         if (selectedRow) {  
    //             selectedRow.classList.remove('selected'); // Remove highlight from previously selected row  
    //         }  
    //         selectedRow = row; // Assign the new selected row  
    //         selectedRow.classList.add('selected'); // Highlight the currently selected row  
    //     }  
    // });  
 
    (()=>{
        
        orderUpdateTbody.addEventListener('click', function (e) {
            const selectedRowOnUpdateTable = e.target.parentElement.parentElement; // Traverse to the row  
            
            // Get the first cell in that row  
            // const updateOrderid = updateRow.cells[0].innerText; // cell index starts from 0 
          
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
                        const unitPrice = parseFloat(row.children[3].innerText);
                        const total = unitPrice * quantity;
                        row.children[5].innerText = total.toFixed(2);
    
    
                        const orderitemId = row.children[0].innerText//get orderdetail_id
    
                            let isExist = false;
                            for(let i=0; i < updateOrderItems.length; i++){
                                if(updateOrderItems[i].orderItemId == orderitemId){
                                    isExist = true;
                                    updateOrderItems[i].quantity = quantity;
                                    updateOrderItems[i].subtotal = total;
                                    break;
                                }
                            }
    
                            if(!isExist){
                                updateOrderItems.push({'orderItemId': orderitemId, 'quantity': quantity, 'unitPrice': unitPrice, 'subtotal':total})
                            }
                        
    
                        calculateTotalItemsAndTotalAmount(); // Update overall totals
                    } else {
                        alert('Please enter a valid quantity.');
                    }
                }
            }
          
    
            
        });

    })();


    (()=>{
        // Event listener for removing a row when the remove button is clicked
        orderUpdateTbody.addEventListener('click', function (e) {
            const button = e.target.closest('.btn-remove'); // Check if the clicked element is a remove button
            if (button) {
                const row = button.closest('tr'); // Get the row containing the button
                if (row) {
                    // Confirm before removing the row
                    if (confirm('Are you sure you want to remove this item?')) {
                        row.remove(); // Remove the row from the table

                        // Optionally, update the order items array
                        const orderitemId = row.children[0].innerText; // Get the order item ID
                        // updateOrderItems = updateOrderItems.filter(item => item.orderItemId !== orderitemId);
                        const orderId = row.children[1].innerText;
                        const formData = new FormData();
                        formData.append('orderItemId', orderitemId);
                        formData.append('orderId', orderId);

                        fetch('/orderdetails/remove_orderdetail',{
                            method:'POST',
                            body:formData
                        })
                        .then(response => response.json())
                        .then(responseData => {
                            console.log(responseData)
                        })
                        .catch(err=> console.log(err))
                        // Recalculate totals
                        calculateTotalItemsAndTotalAmount();
                    }
                }
            }
        });

    })();
    function calculateTotalItemsAndTotalAmount() {  
        const rows = Array.from(orderUpdateTbody.rows); // Get the rows from tbody  

        const totalItems = rows.reduce((sum, row) => {  
            const value = parseInt(row.children[4].innerText) || 0;  
            return sum + value;  
        }, 0);  

        const totalAmount = rows.reduce((sum, row) => {  
            const value = parseFloat(row.children[5].innerText) || 0;  
            return sum + value;  
        }, 0);  

        updateOrdertotalItemsEl.innerText = totalItems;  
        updateOrdertotalAmountEl.innerText = totalAmount.toFixed(2);  
    } 

  

    //save btn clicked
    document.querySelector('#updateOrder-btnSave').addEventListener('click',()=>{
        
        const customerEl = document.querySelector('#orderUpdateCustomer');

        const totalAmount = updateOrdertotalAmountEl.innerText;
        const totalItems = updateOrdertotalItemsEl.innerText;
        const customer = customerEl.value;
        const orderId = orderIdEl.innerText;
        const orderDate = orderDateEl.value;

        let formData = new FormData();

        formData.append('data', JSON.stringify({
            'order': {'orderId': orderId, 'totalAmount': totalAmount, 'totalItems': totalItems, 'customer': customer, 'orderDate': orderDate},
            'updateOrderItems': updateOrderItems
        }))

        fetch('/orders/update_order',{
            method:'POST',
            body: formData
        })
        .then(response => response.json())
        .then(responseData => {
            if(responseData){
                console.log(responseData);
                alert(responseData.message);
                window.location.href = '/orders';
            }
        })
        .catch(err => console.log(err))
    })



    window.onload=(()=>{
        populateOrdersToOrdersTable();
    })();
</script>


<?php include(APPDIR.'views/layouts/footer.php');?>
