<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <?php include(APPDIR.'views/layouts/errors.php'); ?>
            <h1 class="mt-4">Edit Supplier</h1>
            <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Edit supplier form</li>
                </ol>
                
                <form method="post">

    <div class="row">

        <div class="col-md-6">

            <div class="control-group">
                <label class="control-label" for="name">Name</label>
                <input class="form-control" id="name" type="text" name="name" value="<?= $supplier->Name ?>" required  />
            </div>

            <div class="control-group">
                <label for="address" class='control-label mt-2'>Address</label>
                <input class='form-control' type="text" name="address" id="address" value="<?= $supplier->Address ?>" required>
            </div>
            

        </div>

        <div class="col-md-6">

            <div class="control-group">
                <label for="phone" class="control-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $supplier->Phone ?>" required/>
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



<?php include(APPDIR.'views/layouts/footer.php');?>
