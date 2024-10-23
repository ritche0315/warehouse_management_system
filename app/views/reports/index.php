<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
?>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <?php include(APPDIR.'views/layouts/errors.php'); ?>
            <h1 class="mt-4">Reports</h1>
            <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">View Reports</li>
                </ol>

                <select name="report-type" id="report-type" class='form-select w-25 mb-3' onchange='reportSelectElementOnChange()'>
                    <option value="0">Select report type:</option>
                    <option value="1">Orders</option>
                    <option value="2">Inventory</option>
                    <option value="3">Customers</option>
                    <option value="4">Suppliers</option>
                    <option value="5">Products</option>
                </select>

                <div class='table-responsive'>
                    <table class='table table-striped table-hover table-bordered' id='report-table'>
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
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

<script>

    const reportTypeEl = document.querySelector('#report-type');

    const theadEl = document.querySelector('#report-table > thead');
    const tbodyEl = document.querySelector('#report-table > tbody');

    function reportSelectElementOnChange(){
        switch(reportTypeEl.value){
            case "1":
                alert('Orders')
                break
            case "2":
                alert('Inventory')
                break
            case "3":
                alert('Customers')
                break
            case "4":
                alert('Suppliers')
                break
            case "5":
                alert('Products')
                break
            default:
                alert('Please select report type.')
        }
    }

    function renderTable(table){
        var orderitems = <?php echo json_encode($orderitems); ?>;
        var inventory = <?php echo json_encode($inventories); ?>;
        var customers = <?php echo json_encode($customers); ?>;
        var suppliers = <?php echo json_encode($suppliers); ?>;
        var products = <?php echo json_encode($products); ?>;

        switch(reportTypeEl.value){
            case "Orders":
                
                break
            case "Inventory":
                break
            case "Customers":
                break
            case "Suppliers":
                break
            case "Products":
                break
            default:
                alert('Please select report type.')
        }
        
    }

  


</script>
<?php include(APPDIR.'views/layouts/footer.php');?>
