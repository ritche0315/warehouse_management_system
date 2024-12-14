<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
               <?php include(APPDIR.'views/layouts/errors.php');?>
                <h1 class="mt-4">Add New Stocks</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Add New Stocks form</li>
                </ol>
                
                <form method="post">

                    <div class="row">

                        <div class="col-md-6">
                            
                            <div class="control-group">
                                <select class="form-select mb-3" aria-label="warehouse" id="warehouse" name="warehouse">
                                <option value="0">Select Warehouse</option>
                                <?php foreach($warehouses as $row) { ?>
                            
                                    <option value="<?= $row->WarehouseID;?>"><?= $row->Name; ?></option>
                                <?php }?>
                                </select>
                            </div>

                            <div class="control-group">
                                
                                <select class="form-select mb-3" aria-label="product" id="product" name="product">
                                <option value="0">Select Product</option>
                                <?php foreach($products as $row) { ?>
                            
                                    <option value="<?= $row->ProductID;?>"><?= $row->Name; ?></option>
                                <?php }?>
                                </select>
                            </div>

                            
                            <div class="control-group">
                                <label for="quantity" class="control-label">Quantity</label>
                                <input type="number" onkeyup="onKeyUpQunatity()" onchange='onKeyUpQunatity()' class="form-control" id="quantity" name="quantity" value="<?= (isset($_POST['quantity']) ? $_POST['quantity'] : '');?>" required/>
                            </div>

                        </div>


                    </div>

                    <br>

                    <p><button type="submit" class="btn btn-success" name="submit"><i class="fa fa-check"></i> Submit</button></p>

                </form>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2023</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>
    const quantityInputEl = document.querySelector('#quantity');
    
    function onKeyUpQunatity(){
        if(quantityInputEl.value <= 0 && quantityInputEl.value != ""){
            alert('Please enter quantity value not less than or equal to 0');
            quantityInputEl.value = "";
        }
    }

</script>
<?php include(APPDIR.'views/layouts/footer.php');?>
