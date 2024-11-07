<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <?php include(APPDIR.'views/layouts/errors.php'); ?>
            <h1 class="mt-4">Customer</h1>
            <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Customer List</li>
                </ol>
                
                <p><a href="/customers/add" class="btn btn-xs btn-info">Add Customer</a></p>

                <div class='table-responsive'>
                    <table class='table table-striped table-hover table-bordered'>
                    <tr>
                        <th>ID</th>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach($customers as $row) { ?>
                    <tr>
                        <td><?=htmlentities($row->CustomerID);?></td>
                        <td><?=htmlentities($row->FirstName);?></td>
                        <td><?=htmlentities($row->LastName);?></td>
                        <td><?=htmlentities($row->Email);?></td>
                        <td><?=htmlentities($row->Phone);?></td>
                        <td><?=htmlentities($row->Address);?></td>
                        <td>
                            <a href="/customers/edit/<?=$row->CustomerID;?>" class="btn btn-xs btn-warning"><i class='fa fa-edit text-light'></i></a>
                            <?php if($userloggedIn == "superadmin"){?>
                                <a href="javascript:del('<?=$row->CustomerID;?>','<?=$row->FirstName." ".$row->LastName;?>')" class="btn btn-xs btn-danger"><i class='fa fa-trash text-light'></i></a>
                            <?php }?>
                        </td>
                    </tr>
                    <?php } ?>
                    </table>
                </div>

                <script language="JavaScript" type="text/javascript">
                function del(id, title) {
                    if (confirm("Are you sure you want to delete '" + title + "'?")) {
                        window.location.href = 'customers/delete/' + id;
                    }
                }
                </script>

            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; WMS Smart Stock 2024</div>
                    <!-- <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div> -->
                </div>
            </div>
        </footer>
    </div>
</div>
<?php include(APPDIR.'views/layouts/footer.php');?>
