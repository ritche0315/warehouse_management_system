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
                            <div class="col">
                                <form class='mt-3 p-3 bg-light shadow-lg' method='post'>
                                    <div class="row">
                                        <div class="col col-lg-3">
                                            <h5 class='fw-light text-secondary mt-3'>Customer Information</h4>
                                            <div class="control-group">
                                                <select name="selectCustomer" id="selectCustomer" class='form-select ' onchange=''>
                                                    <option value="0">Select Customer</option>
                                                    <?php
                                                        foreach($customers as $customer){
                                                            echo "<option value='".$customer->CustomerID."'>".$customer->FirstName." ".$customer->LastName."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <h5 class='fw-light text-secondary mt-3'>Product Information</h4>
                                            <div class="control-group">
                                                <select name="selectProduct" id="selectProduct" class='form-select' onchange='selectProductOnChange()'>
                                                 
                                                </select>
                                            </div>
                                            <div class="control-group">
                                                <label for="prodname" class='control-label'>Product</label>
                                                <input type="text" name='prodname' id='prodname' class='form-control'>
                                            </div>
                                            <div class="control-group">
                                                <label for="quantity" class='control-label'>Quantity</label>
                                                <input type="number" name='quantity' id='quantity' class='form-control' value='1'>
                                            </div>
                                            <div class="control-group">
                                                <input type="submit" value="Add" name='submit' class='btn btn-success mt-3'>
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
