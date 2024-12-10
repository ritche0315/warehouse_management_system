

<!-- Modal -->
<div class="modal modal-lg fade orderDetailsModal" id="orderDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Order Items</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="card">
            <div class="card-header">
                <div class="control-group bg-warning p-2 fw-bold">
                  <label for="orderId" class="form-label">Order ID:</label>
                  <label class="form-label me-3" id="orderId"></label>
                  <!-- <label for="customerName" class="form-label">Customer Name:</label>
                  <label class="form-label" id="customerName"></label> -->
                </div>
                <!-- <div class="control-group">
                    <label for="searchOrderId" class="form-label mt-2">Search Order ID:</label>
                    <input type="text" name="searchOrderId" id="searchOrderId" class='form-control'>
                </div> -->
            </div>
            <div class="card-body">
                <div class="table-responsive" id="orderDetailsTableWrapper">
                  <table class="table table-bordered" id="orderDetailsTable">
                    <thead>
                      <th>OrderID</th>
                      <th>Item Name</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Subtotal</th>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>