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
                    <div class='container-fluid'>
                        
                        <div class="row" >
                            <div class="col">
                                <form class='mt-3 p-3 bg-light shadow-lg' id='orderForm' method='post'>
                                    <div class="row">
                                        <div class="col col-lg-3">
                                            <select name="warehouse" id="warehouse" class='form-select' onchange='selectWarehouseOnChange()'>
                                                <option value="0">Select Warehouse</option>
                                                <?php 
                                                    foreach($warehouses as $warehouse){
                                                        echo "<option value='".$warehouse->WarehouseID."'>".$warehouse->Name."</option>";
                                                    }
                                                
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col col-lg-3">
                                            <button id='btnNewOrder' class='btn btn-primary' onclick='newOrderBtnClicked()'><i class='fa fa-circle-plus'></i>&nbsp; New Order</button>
                                            <button id='btnCancelOrder' class='btn btn-danger' onclick='cancelBtnClicked()'><i class='fa fa-close'></i>&nbsp; Cancel</button>
                                        </div>
                                    </div>
                                    <div class="row" id='orderEntry'>
                                        <div class="col col-lg-3">
                                        <div class="control-group">
                                                <label for="warehouseID" class='control-label'>Warehouse ID</label>
                                                <input type="text" name='warehouseID' id='warehouseID' class='form-control'>
                                            </div>
                                            <div class="control-group">
                                                <label for="selectCustomer" class='control-label'>Customer</label>
                                                <select name="selectCustomer" id="selectCustomer" class='form-select ' onchange=''>
                                                    <option value="0">Select Customer</option>
                                                    <?php
                                                        foreach($customers as $customer){
                                                            echo "<option value='".$customer->CustomerID."'>".$customer->FirstName." ".$customer->LastName."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="control-group">
                                                <label for="selectProduct" class='control-label'>Product</label>
                                                <select name="selectProduct" id="selectProduct" class='form-select' onchange='selectProductOnChange()'>
                                                 
                                                </select>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="col col-lg-3">

                                            <div class="control-group">
                                                <label for="prodname" class='control-label'>Product Name</label>
                                                <input type="text" name='prodname' id='prodname' class='form-control'>
                                            </div>

                                            <div class="control-group">
                                                <label for="quantity" class='control-label'>Quantity</label>
                                                <input type="number" name='quantity' id='quantity' class='form-control' value='1' onchange='quantityOnChange()'>
                                            </div>

                                            <div class="control-group">
                                                <label for="unitPrice" class='control-label'>Unit Price</label>
                                                <input type="number" name='unitPrice' id='unitPrice' class='form-control' value='0'>
                                            </div>

                                            

                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="control-group">
                                                <label for="totalAmount" class='control-label'>Total Amount</label>
                                                <input type="number" name='totalAmount' id='totalAmount' class='form-control' value='0'>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                             <div class="control-group">
                                                <input type="submit" value="Submit" name='submit' class='btn btn-success mt-3'>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
               

            </div>
                
        </div>
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

<script>
    
    //row1
    var selectWarehouseEl = document.querySelector('#warehouse')
    var btnNewOrder = document.querySelector('#btnNewOrder')
    var btnCancelOrder = document.querySelector('#btnCancelOrder')
    
    var selectProductEl = document.querySelector('#selectProduct')
    var orderEntry = document.querySelector('#orderEntry')                                 
    var prodName = document.querySelector('#prodname')
    var quantity = document.querySelector('#quantity')
    var totalAmount = document.querySelector('#totalAmount')
    var warehouseID = document.querySelector('#warehouseID')
    var unitPrice = document.querySelector('#unitPrice')
                                                        
    window.onload= (()=>{ //initialize components

        //disabled new order button
        btnNewOrder.disabled = true
        //hide cancel order button
        btnCancelOrder.style.display = "none";
        //hide order entry
        orderEntry.style.display = "none"
    })()

   

    function selectWarehouseOnChange(){
        if(selectWarehouseEl.value == "0"){
            btnNewOrder.disabled = true
        }else{
            btnNewOrder.disabled = false
        }
       
    }

    function newOrderBtnClicked(){
        btnCancelOrder.style.display = "";
        btnNewOrder.disabled = true
        selectWarehouseEl.disabled = true
        warehouseID.value = selectWarehouseEl.value
        orderEntry.style.display = ""
        populateProductOnSelectProduct()

    }

    function cancelBtnClicked(){
        window.location.href = '/orders/add'
    }


    function selectProductOnChange(){
        let products = <?php echo json_encode($products)?>

        products.map(product=>{
            if(selectProductEl.value == product.InventoryID) {
                prodName.value = product.Name
                
              
                const qty = quantity.value;

                unitPrice.value = product.UnitPrice
                totalAmount.value = Number(product.UnitPrice * qty);
            }
        
        });
    }

    function quantityOnChange(){
        let products = <?php echo json_encode($products)?>

        products.map(product=>{
            if(selectProductEl.value == product.InventoryID) {

                const unitPrice = product.UnitPrice
                const qty = quantity.value;
                totalAmount.value = Number(unitPrice * qty);
            }
        
        });
    }

    function populateProductOnSelectProduct(){
        let products = <?php echo json_encode($products)?>

        var html = `<option value='0'>Select Product</option>`

        products.map(product=>{
            if(product.WarehouseID == selectWarehouseEl.value){
                html += `<option value='${product.InventoryID}' data-product='${product.Name}'>${product.Name}</option>`
            }
        })
        
        selectProductEl.innerHTML = html
    }
</script>


<?php include(APPDIR.'views/layouts/footer.php');?>
