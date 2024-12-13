<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/sbnav.php');
include(APPDIR.'views/layouts/errors.php');
?>
<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Admin Dashboard</li>
        </ol>
        <hr>
        <div class="row">
          <div class="col d-flex justify-content-evenly flex-wrap">
              <!-- customer -->
              <div class="card mt-3" style='width: 300px;'>
                <div class="card-header text-center bg-success text-light">Customers</div>
                <div class="card-body">
                  <div class='d-flex align-items-center'>
                    <span class='text text-gray fs-4 flex-grow-1 fw-bold'><?= $reports['customers']; ?></span>
                    <span></span>
                    <i class='fa fa-users fs-3'></i>
                  </div>
                  <div>
                    <a href="/customers" class='btn btn-link mt-3 w-100'>View Customers</a>
                  </div>
                </div>
              </div>

              <div class="card mt-3" style='width: 300px;'>
                <div class="card-header text-center bg-success text-light">Suppliers</div>
                <div class="card-body">
                  <div class='d-flex align-items-center'>
                    <span class='text text-gray fs-4 flex-grow-1 fw-bold'><?= $reports['suppliers']; ?></span>
                    <span></span>
                    <i class='fa fa-truck-field fs-3'></i>
                  </div>
                  <div>
                    <a href="/supplier" class='btn btn-link mt-3 w-100'>View Suppliers</a>
                  </div>
                </div>
              </div>

              <div class="card mt-3" style='width: 300px;'>
                <div class="card-header text-center bg-success text-light">Inventory</div>
                <div class="card-body">
                  <div class='d-flex align-items-center'>
                    <span class='text text-gray fs-4 flex-grow-1 fw-bold'><?= $reports['inventory']; ?></span>
                    <span></span>
                    <i class='fa fa-boxes-stacked fs-3'></i>
                  </div>
                  <div>
                    <a href="/inventory" class='btn btn-link mt-3 w-100'>View Inventory</a>
                  </div>
                </div>
              </div>

              <div class="card mt-3" style='width: 300px;'>
                <div class="card-header text-center bg-success text-light">Orders</div>
                <div class="card-body">
                  <div class='d-flex align-items-center'>
                    <span class='text text-gray fs-4 flex-grow-1 fw-bold'><?= $reports['orders']; ?></span>
                    <span></span>
                    <i class='fa fa-clipboard fs-3'></i>
                  </div>
                  <div>
                    <a href="/orders" class='btn btn-link mt-3 w-100'>View Orders</a>
                  </div>
                </div>
              </div>
            
          </div>
        </div>
        <div class="row mt-5 ms-3">
          <hr>
            <div class="col d-flex align-items-center flex-column">
                <!-- <h3 class='fw-light'>View Data Order items</h3> -->
                <div style='width:50%;'>
                  <div style="position: relative; height:30vh; width: 100%;" class='d-flex justify-content-center align-items-center'>
                      <canvas id="myChart"></canvas>
                  </div>
                </div>
            </div>
        </div>

    </div>
</main>
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; <i class='fa fa-boxes-stacked'></i>&nbsp;Smart Stock 2024</div>
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

<script>

//   const ctx = document.getElementById('myChart');
//     var reports = </?php echo json_encode($reports); ?>;
 
    
//     var orderitems = </?php echo json_encode($orderitems); ?>;
//     const labels = orderitems.map(item => item.Name);
//     const data = orderitems.map(item => item.TotalQuantity);

// new Chart(ctx, {
//   type: 'bar',
//   data: {
//     labels: labels,
//     datasets: [{
//       label: '# Order items',
//       data: data,
//       borderWidth: 1
//     }]
//   },
//   options: {
//     scales: {
//       y: {
//         beginAtZero: true
//       }
//     }
//   }
// });
</script>