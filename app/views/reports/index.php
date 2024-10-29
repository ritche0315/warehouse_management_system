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

                <div class='d-flex gap-4'>
                    <div class="form-group flex-grow-1" style='max-width: 400px;'>
                        <label for="report-type" class='form-label'>Report Type:</label>
                        <select name="report-type" id="report-type" class='form-select' onchange='reportSelectElementOnChange()'>
                            <option value="0">Select report type:</option>
                            <option value="1">Orders</option>
                            <option value="2">Inventory</option>
                            <option value="3">Customers</option>
                            <option value="4">Suppliers</option>
                            <option value="5">Products</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="datefrom" class='form-label'>Date From:</label>
                        <input type="date" name="datefrom" id="datefrom" class='form-control'>

                    </div>
                    <div class="form-group">
                        <label for="dateTo" class='form-label'>Date To:</label>
                        <input type="date" name="dateTo" id="dateTo" class='form-control'>
                    </div>
                    <div class="form-group">
                        <label class='form-label'></label>
                        <button type='button' id='search' class='btn btn-primary form-control mt-2' onclick='searchBtnClicked()'>Search</button>
                    </div>
                </div>
              
                
                <div class='mt-3 fs-4'>Reports From to </div>
                <div class='table-responsive mt-3'>
                    <table class='table table-striped table-hover table-bordered' id='report-table'>
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class='d-flex justify-content-end'>
                    <div class='flex-grow-1 fw-bold' id='totalRows'></div>
                    <div class='fw-bold' id='total'></div>
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
    const total = document.querySelector('#total')
    const totalRows = document.querySelector('#totalRows')
    function reportSelectElementOnChange(){
        switch(reportTypeEl.value){
            case "1":
                renderTable("Orders")
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
    function searchBtnClicked(){

        const dateFrom = document.querySelector('#datefrom')
        const dateTo = document.querySelector('#dateTo')

        const formData = new FormData();
        formData.append("dateFrom", dateFrom.value)
        formData.append("dateTo", dateTo.value)

        fetch('/reports/get_orderitem_report', {
            method: 'post',
            body:formData
        })
        .then(response=> response.json())
        .then(responseData=>{
            console.log(responseData)
        })
        .catch(err=> console.log(err))

        return;
        let totalAmount = 0;
        const uniqueKeys = [...orderitems.reduce((keys, obj) => {
            Object.keys(obj).forEach(key => keys.add(key));
            return keys;
        }, new Set())];

        // uniqueKeys[] = "Action"; 
        uniqueKeys.forEach(key=>{
            html += `<th>${key}</th>`
        })
        theadEl.innerHTML = html

        html = ``;

        orderitems.map(orderitem=>{
            html += `
                    <tr>
                    <td>${orderitem.OrderID}</td>
                    <td>${orderitem.OrderDate}</td>
                    <td>${orderitem.Warehouse}</td>
                    <td>${orderitem.Customer}</td>
                    <td>${orderitem.Product}</td>
                    <td>${orderitem.UnitPrice}</td>
                    <td>${orderitem.Quantity}</td>
                    <td>${orderitem.TotalPrice}</td>
                    </tr>
            `
            totalAmount += orderitem.TotalPrice;
        })

        tbodyEl.innerHTML = html;

        total.innerText = 'Total: '+totalAmount
        totalRows.innerText = 'Total Rows: '+orderitems.length
    }
    function renderTable(table){
        var orderitems = <?php echo json_encode($orderitems); ?>;
        var inventory = <?php echo json_encode($inventories); ?>;
        var customers = <?php echo json_encode($customers); ?>;
        var suppliers = <?php echo json_encode($suppliers); ?>;
        var products = <?php echo json_encode($products); ?>;
        var html = ``
        
        switch(table){
            case "Orders":
                let totalAmount = 0;
                const uniqueKeys = [...orderitems.reduce((keys, obj) => {
                    Object.keys(obj).forEach(key => keys.add(key));
                    return keys;
                }, new Set())];

                // uniqueKeys[] = "Action"; 
                uniqueKeys.forEach(key=>{
                    html += `<th>${key}</th>`
                })
                theadEl.innerHTML = html

                html = ``;

                orderitems.map(orderitem=>{
                    html += `
                            <tr>
                            <td>${orderitem.OrderID}</td>
                            <td>${orderitem.OrderDate}</td>
                            <td>${orderitem.Warehouse}</td>
                            <td>${orderitem.Customer}</td>
                            <td>${orderitem.Product}</td>
                            <td>${orderitem.UnitPrice}</td>
                            <td>${orderitem.Quantity}</td>
                            <td>${orderitem.TotalPrice}</td>
                            </tr>
                    `
                    totalAmount += orderitem.TotalPrice;
                })

                tbodyEl.innerHTML = html;

                total.innerText = 'Total: '+totalAmount
                totalRows.innerText = 'Total Rows: '+orderitems.length
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
