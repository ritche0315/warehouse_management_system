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
                <p><a href="/orders/add" class="btn btn-xs btn-info">Add Order</a></p>

                

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

<?php include(APPDIR.'views/layouts/footer.php');?>
