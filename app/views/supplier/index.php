<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
?>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <?php include(APPDIR.'views/layouts/errors.php'); ?>
            <h1 class="mt-4">Supplier</h1>
            <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Supplier List</li>
                </ol>
                    <p><a href="/supplier/add" class="btn btn-xs btn-info">Add Supplier</a></p>

                    <div class='table-responsive'>
                        <table class='table table-striped table-hover table-bordered'>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach($suppliers as $row) { ?>
                        <tr>
                            <td><?=htmlentities($row->SupplierID);?></td>
                            <td><?=htmlentities($row->Name);?></td>
                            <td><?=htmlentities($row->Address);?></td>
                            <td><?=htmlentities($row->Phone);?></td>
                            <td>
                                <a href="/supplier/edit/<?=$row->SupplierID;?>" class="btn btn-xs btn-warning"><i class='fa fa-edit text-light'></i></a>
                                <?php if($userloggedIn == "superadmin"){?>
                                <a href="javascript:del('<?=$row->SupplierID;?>','<?=$row->Name;?>')" class="btn btn-xs btn-danger"><i class='fa fa-trash'></i></a>
                                <?php }?>
                            </td>
                        </tr>
                        <?php } ?>
                        </table>
                    </div>

                    <script language="JavaScript" type="text/javascript">
                    function del(id, title) {
                        if (confirm("Are you sure you want to delete '" + title + "'?")) {
                            window.location.href = 'supplier/delete/' + id;
                        }
                    }
                    </script>
                

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
