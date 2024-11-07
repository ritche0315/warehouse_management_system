<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <?php include(APPDIR.'views/layouts/errors.php'); ?>
            <h1 class="mt-4">Inventory</h1>
            <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Product Stocks</li>
                </ol>
                
                <p><a href="/inventory/add" class="btn btn-xs btn-info">Add Inventory</a></p>

                <div class='table-responsive'>
                    <table class='table table-striped table-hover table-bordered'>
                    <tr>
                        <th>ID</th>
                        <th>Warehouse Name</th>
                        <th>Warehouse Location</th>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach($inventories as $row) { ?>
                    <tr>
                        <td><?=htmlentities($row->InventoryID);?></td>
                        <td><?=htmlentities($row->WarehouseName);?></td>
                        <td><?=htmlentities($row->WarehouseLocation);?></td>
                        <td><?=htmlentities($row->SKU);?></td>
                        <td><?=htmlentities($row->Name);?></td>
                        <td><?=htmlentities($row->Description);?></td>
                        <td><?=htmlentities($row->UnitPrice);?></td>
                        <td><?=htmlentities($row->Quantity);?></td>
                        <td>
                            <a href="/inventory/edit/<?=$row->InventoryID;?>" class="btn btn-xs btn-warning"><i class='fa fa-edit text-light'></i></a>
                            <?php if($userloggedIn == "superadmin"){?>
                            <a href="javascript:del('<?=$row->InventoryID;?>','<?=$row->InventoryID;?>')" class="btn btn-xs btn-danger"><i class='fa fa-trash'></i></a>
                            <?php }?>
                        </td>
                    </tr>
                    <?php } ?>
                    </table>
                </div>
                
                <script language="JavaScript" type="text/javascript">
                function del(id, title) {
                    if (confirm("Are you sure you want to delete '" + title + "'?")) {
                        window.location.href = 'inventory/delete/' + id;
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
