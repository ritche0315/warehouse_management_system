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
                    <div class="form-group">
                        <label class='form-label'></label>
                        <a href="/reports" class='form-control btn btn-success mt-2'><i class='fa fa-arrows-rotate'></i></a>
                    </div>
                
                </div>
              
                <div class='mt-3 d-flex'>
                    <div class='fs-5 flex-grow-1'>Results:</div>
                    <button type="button" class='btn btn-dark' id='btnPrint' onclick='generatePDF()'><i class='fa fa-print'></i></button>
                </div>
                
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    const reportTypeEl = document.querySelector('#report-type');

    const theadEl = document.querySelector('#report-table > thead');
    const tbodyEl = document.querySelector('#report-table > tbody');
    const reportTableEl = document.querySelector('#report-table');


    const total = document.querySelector('#total')
    const totalRows = document.querySelector('#totalRows')

    const btnPrintEl = document.querySelector('#btnPrint')
    window.onload = (()=>{
        btnPrintEl.style.display = "none";
    })();

    async function generatePDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        // Convert HTML table to canvas
        const canvas = await html2canvas(reportTableEl);
        const imgData = canvas.toDataURL("image/png");

        // Add the image of the table to the PDF
        const imgWidth = 180;
        const pageHeight = doc.internal.pageSize.height;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        const position = 10; // Position the table at 10 units from the top

        doc.addImage(imgData, "PNG", 10, position, imgWidth, imgHeight);
        doc.save("table.pdf");
    }

    function reportSelectElementOnChange(){
        switch(reportTypeEl.value){
            case "1":
                renderTable("Orders")
                btnPrintEl.style.display = "";
                break
            case "2":
                renderTable("Inventory")
                btnPrintEl.style.display = "";
                break
            case "3":
                renderTable('Customers')
                btnPrintEl.style.display = "";
                break
            case "4":
                renderTable('Suppliers')
                btnPrintEl.style.display = "";
                break
            case "5":
                renderTable('Products')
                btnPrintEl.style.display = "";
                break
            default:
                alert('Please select report type.')
        }
    }

    function searchBtnClicked(){

        const dateFrom = document.querySelector('#datefrom')
        const dateTo = document.querySelector('#dateTo')

        if(dateFrom.value == ""){
            alert("DateFrom is required");
            return;
        }

        if(dateTo.value == ""){
           alert("DateTo is required");
           return;
        }

        const formData = new FormData();
        formData.append("dateFrom", dateFrom.value)
        formData.append("dateTo", dateTo.value)



        
        switch(reportTypeEl.value){
            //orders
            case "1":
                fetch('/reports/get_orderitem_report', {
                    method: 'post',
                    body:formData
                })
                .then(response=> response.json())
                .then(responseData=>{
                    
                    let html = ``;
                    let orderitems = responseData;

                    

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
                        totalAmount += parseFloat(orderitem.TotalPrice);
                    })

                    tbodyEl.innerHTML = html;

                    total.innerText = 'Total: '+totalAmount
                    totalRows.innerText = 'Total Rows: '+orderitems.length
                })
                .catch(err=> console.log(err))

                break;
            case "2":
                break;
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
        var html = ``
        var totalQuantity = 0;
        var totalAmount = 0;

        switch(table){
            case "Orders":
                theadEl.innerHTML = ``
                tbodyEl.innerHTML = ``
                html = ``;
                totalQuantity = 0;
                totalAmount = 0;

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
                    totalAmount += parseFloat(orderitem.TotalPrice);
                })

                tbodyEl.innerHTML = html;

                total.innerText = 'Total: '+totalAmount
                totalRows.innerText = 'Total Rows: '+orderitems.length
                break;
            case "Inventory":
                
                theadEl.innerHTML = ``
                tbodyEl.innerHTML = ``
                html = ``;
                totalQuantity = 0;

                const inventoryKeys = [...inventory.reduce((keys, obj) => {
                    Object.keys(obj).forEach(key => keys.add(key));

                    return keys;
                }, new Set())];


                inventoryKeys.forEach(key=>{
                    
                    if(key == "WarehouseID" || key == "ProductID"){
                        return;
                    }
                    html += `<th>${key}</th>`
                })

                theadEl.innerHTML = html

                html = ``;

                inventory.map(inv=>{
                    html += `
                            <tr>
                            <td>${inv.InventoryID}</td>
                            <td>${inv.SKU}</td>
                            <td>${inv.Name}</td>
                            <td>${inv.Description}</td>
                            <td>${inv.UnitPrice}</td>
                            <td>${inv.Quantity}</td>
                            <td>${inv.WarehouseName}</td>
                            <td>${inv.WarehouseLocation}</td>
                            </tr>
                    `
                    totalQuantity += parseInt(inv.Quantity);
                })

                tbodyEl.innerHTML = html;

                total.innerText = 'Total Quantity: '+totalQuantity
                totalRows.innerText = 'Total Rows: '+inventory.length
           
                break
            case "Customers":
                theadEl.innerHTML = ``
                tbodyEl.innerHTML = ``
                totalQuantity = 0;
                totalAmount = 0;
                html = ``;

                const customerKeys = [...customers.reduce((keys, obj) => {
                    Object.keys(obj).forEach(key => keys.add(key));

                    return keys;
                }, new Set())];


                customerKeys.forEach(key=>{
                    
                    // if(key == "WarehouseID" || key == "ProductID"){
                    //     return;
                    // }
                    html += `<th>${key}</th>`
                })

                theadEl.innerHTML = html

                html = ``;

                customers.map(customer=>{
                    html += `
                            <tr>
                            <td>${customer.CustomerID}</td>
                            <td>${customer.FirstName}</td>
                            <td>${customer.LastName}</td>
                            <td>${customer.Email}</td>
                            <td>${customer.Phone}</td>
                            <td>${customer.Address}</td>
                            </tr>
                    `
                    // totalQuantity += customer.Quantity;
                })

                tbodyEl.innerHTML = html;

                // total.innerText = 'Total Quantity: '+totalQuantity
                totalRows.innerText = 'Total Rows: '+customers.length
                break
            case "Suppliers":
                theadEl.innerHTML = ``
                tbodyEl.innerHTML = ``
                totalQuantity = 0;
                html = ``;
                const suppliersKeys = [...suppliers.reduce((keys, obj) => {
                    Object.keys(obj).forEach(key => keys.add(key));

                    return keys;
                }, new Set())];


                suppliersKeys.forEach(key=>{
                    
                    // if(key == "WarehouseID" || key == "ProductID"){
                    //     return;
                    // }
                    html += `<th>${key}</th>`
                })

                theadEl.innerHTML = html

                html = ``;

                suppliers.map(supplier=>{
                    html += `
                            <tr>
                            <td>${supplier.SupplierID}</td>
                            <td>${supplier.Name}</td>
                            <td>${supplier.Address}</td>
                            <td>${supplier.Phone}</td>
                            </tr>
                    `
                    // totalQuantity += customer.Quantity;
                })

                tbodyEl.innerHTML = html;

                // total.innerText = 'Total Quantity: '+totalQuantity
                totalRows.innerText = 'Total Rows: '+suppliers.length
                break
            case "Products":
                theadEl.innerHTML = ``
                tbodyEl.innerHTML = ``
                totalQuantity = 0;
                totalAmount = 0;

                html = ``;
                const productsKeys = [...products.reduce((keys, obj) => {
                    Object.keys(obj).forEach(key => keys.add(key));

                    return keys;
                }, new Set())];


                productsKeys.forEach(key=>{
                    
                    if(key == "SupplierID"){
                        return;
                    }
                    html += `<th>${key}</th>`
                })

                theadEl.innerHTML = html

                html = ``;

                products.map(product=>{
                    html += `
                            <tr>
                            <td>${product.ProductID}</td>
                            <td>${product.SKU}</td>
                            <td>${product.Name}</td>
                            <td>${product.Description}</td>
                            <td>${product.UnitPrice}</td>
                            <td>${product.SupplierName}</td>
                            </tr>
                    `
                    totalAmount += parseFloat(product.UnitPrice);
                })

                tbodyEl.innerHTML = html;

                total.innerText = 'Total Amount: '+totalAmount
                totalRows.innerText = 'Total Rows: '+suppliers.length
                break
            default:
                alert('Please select report type.')
        }
        
    }

  


</script>
<?php include(APPDIR.'views/layouts/footer.php');?>
