<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <?php include(APPDIR.'views/layouts/errors.php'); ?>
            <h1 class="mt-4">Edit User</h1>
            <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Edit user form</li>
                </ol>
                
                <form method="post">

    <div class="row">

        <div class="col-md-6">

            <div class="control-group">
                <label class="control-label" for="username">Username</label>
                <input class="form-control" id="username" type="text" name="username" value="<?= $user->username ?>" required  />
            </div>
            
            <div class="control-group">
                <label for="email" class="control-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user->email ?>" required/>
            </div>

        </div>

        <div class="col-md-6">

            <div class="control-group">
                <label for="password" class='control-label'>Password</label>
                <input class='form-control' type="password" name="password" id="password" value="" required>
            </div>

            <div class="control-group">
                <label for="password_confirm" class='control-label'>Confirm Password</label>
                <input class='form-control' type="password" name="password_confirm" id="password_confirm" value="" required>
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
