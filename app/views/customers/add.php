<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
include(APPDIR.'views/layouts/errors.php');
?>

<div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Add Customer</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">register new customer</li>
                </ol>
                
                <form method="post">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="control-group">
                                <label class="control-label" for="sku">First Name</label>
                                <input class="form-control" id="firstName" type="text" name="firstName" value="<?=(isset($_POST['firstName']) ? $_POST['firstName'] : '');?>" required  />
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="lastName">Last Name</label>
                                <input class="form-control" id="lastName" type="text" name="lastName" value="<?=(isset($_POST['lastName']) ? $_POST['lastName'] : '');?>" required  />
                            </div>

                            
                            <div class="control-group">
                                <label for="address" class="control-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= (isset($_POST['address']) ? $_POST['address'] : '');?>" required/>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="control-group">
                                <label for="email" class="control-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= (isset($_POST['email']) ? $_POST['email'] : '');?>" required/>
                            </div>

                            <div class="control-group">
                                <label for="phone" class="control-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= (isset($_POST['phone']) ? $_POST['phone'] : '');?>" required/>
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
