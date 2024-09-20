<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
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

                    <div class='table-responsive'>
                        <table class='table table-striped table-hover table-bordered'>
                        <tr>
                           <th>Order No#</th>
                           <th>Order Date</th>
                           <th>Warehouse</th>
                           <th>Customer</th>
                           <th>Total Amount</th>
                        </tr>
                        <?php foreach($orders as $row) { ?>
                        <tr>
                            <td><?=htmlentities($row->OrderID);?></td>
                            <td><?=htmlentities($row->OrderDate);?></td>
                            <td><?=htmlentities($row->Warehouse);?></td>
                            <td><?=htmlentities($row->FirstName." ".$row->LastName);?></td>
                            <td><?=htmlentities($row->TotalAmount);?></td>
                            <td>
                                <a href="/products/edit/<?=$row->OrderID;?>" class="btn btn-xs btn-warning">Edit</a>
                                <a href="javascript:del('<?=$row->OrderID;?>','<?=$row->OrderID;?>')" class="btn btn-xs btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </table>
                    </div>

                    <script language="JavaScript" type="text/javascript">
                    function del(id, title) {
                        if (confirm("Are you sure you want to delete '" + title + "'?")) {
                            window.location.href = 'orders/delete/' + id;
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
