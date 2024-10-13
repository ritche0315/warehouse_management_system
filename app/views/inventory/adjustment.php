<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
                <?php include(APPDIR.'views/layouts/errors.php'); ?>
                <h1 class="mt-4">Inventory Adjustment</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Inventory Adjustment form</li>
                </ol>
                
                <form method="post">

                    <div class="row">

                        <div class="col-md-3">
                            <div class="control-group">
                                <label for="product" class='control-label'>Product</label>
                                <select name="product" id="product" class='form-select' onchange='productOnChange()'>
                                </select>
                            </div>
                            <div class="control-group">
                                <label for="currentQuantity" class='control-label'>Current Quantity</label>
                                <input type="number" name="currentQuantity" id="currentQuantity" class='form-control' readonly>
                            </div>
                            <div class="control-group">
                                <label for="quantity" class='control-label'>Quantity</label>
                                <input type="number" name="quantity" id="quantity" class='form-control' onkeyup='quantityOnKeyUp()'>
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
    var productSelect = document.querySelector('#product');
    const currentQuantity = document.querySelector('#currentQuantity')
    const quantity = document.querySelector('#quantity')
    var products = <?php echo json_encode($products); ?>

    window.onload = (()=>{
        populateProductOnProductSelect()
    })();


    function populateProductOnProductSelect(){

        
        
        var html = `<option value='0'>Select Product</option>`

        products.map(product=>{
            html += `
                <option value='${product.ProductID}'>${product.Name}</option>
            `
        })

        productSelect.innerHTML = html
        
    }

    function productOnChange(){
        
        products.map(product=>{
            if(product.ProductID == productSelect.value){
                currentQuantity.value = product.Quantity
            }
        })
    }
</script>

<?php include(APPDIR.'views/layouts/footer.php');?>
