<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
?>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <?php include(APPDIR.'views/layouts/errors.php'); ?>
            <h1 class="mt-4">Users</h1>
            <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">User List</li>
                </ol>
                    <p><a href="/users/add" class="btn btn-xs btn-info">Add User</a></p>

                    <div class='table-responsive'>
                        <table class='table table-striped table-hover table-bordered'>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach($users as $row) { ?>
                        <tr>
                            <td><?=htmlentities($row->id);?></td>
                            <td><?=htmlentities($row->username);?></td>
                            <td><?=htmlentities($row->password);?></td>
                            <td><?=htmlentities($row->email);?></td>
                            <td>
                                <a href="/users/edit/<?=$row->id;?>" class="btn btn-xs btn-warning"><i class='fa fa-edit text-light'></i></a>
                                <?php 
                                    if($userloggedIn == "superadmin"){
                                ?>
                                <a href="javascript:del('<?=$row->id;?>','<?=$row->id;?>')" class="btn btn-xs btn-danger"><i class='fa fa-trash'></i></a>
                                <?php }?>
                            </td>
                        </tr>
                        <?php } ?>
                        </table>
                    </div>

                    <script language="JavaScript" type="text/javascript">
                    function del(id, title) {
                        if (confirm("Are you sure you want to delete '" + title + "'?")) {
                            window.location.href = 'users/delete/' + id;
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
