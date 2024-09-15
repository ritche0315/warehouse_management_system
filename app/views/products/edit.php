<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/errors.php');
?>

<h1>Edit Product</h1>

<form method="post">

    <div class="row">

        <div class="col-md-6">

            <div class="control-group">
                <label class="control-label" for="sku">SKU</label>
                <input class="form-control" id="sku" type="text" name="sku" value="<?=$product->SKU;?>" required  />
            </div>

            <div class="control-group">
                <label class="control-label" for="name">Name</label>
                <input class="form-control" id="name" type="text" name="name" value="<?=$product->Name;?>" required  />
            </div>

            

        </div>

        <div class="col-md-6">

            <div class="control-group">
                <label for="description" class="control-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" value="<?= $product->Description;?>" required/>
            </div>

            <div class="control-group">
                <label for="unitPrice" class="control-label">UnitPrice</label>
                <input type="text" class="form-control" id="unitPrice" name="unitPrice" value="<?= $product->UnitPrice;?>" required/>
            </div>

        </div>

    </div>

    <br>

    <p><button type="submit" class="btn btn-success" name="submit"><i class="fa fa-check"></i> Submit</button></p>

</form>

<?php include(APPDIR.'views/layouts/footer.php');?>
