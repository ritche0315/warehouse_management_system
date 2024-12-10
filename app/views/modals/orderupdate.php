

<!-- Modal -->
<div class="modal modal-lg fade orderUpdateModal" id="orderUpdateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Order</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="card">
            <div class="card-header">
                <div class="control-group bg-warning p-2 fw-bold">
                  <label for="orderUpdate-orderId" class="form-label">Order ID:</label>
                  <label class="form-label me-3" id="orderUpdate-orderId"></label>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2">
                     <div class="control-group">
                        <label for="orderUpdateCustomer" class="form-label">Customer:</label>
                        <select name="orderUpdateCustomer" id="orderUpdateCustomer" class='form-select'>
                            <option value='0' selected>Choose...</option>
                            <?php   foreach($customers as $customer){
                                echo "<option value='".$customer->CustomerID."'>".$customer->FirstName.' '.$customer->LastName."</option>";
                            }?>
                        </select>
                     </div>
                </div>
                <div class="table-responsive" id="orderUpdateTableWrapper">
                  <p class='fs-5'>Order Items</p>
                  <table class="table table-bordered" id="orderUpdateTable">
                    <thead>
                      <th>OrderItemID</th>
                      <th>OrderID</th>
                      <th>Item Name</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Subtotal</th>
                      <th>Action</th>
                    </thead>
                    <tbody></tbody>
                  </table>
                  <div class="mb-2 d-flex justify-content-end">
                     <label for="updateOrder-totalAmount " class="form-label fw-bold me-1">Total Amount:</label>
                     <label class="form-label me-3 fw-bold" id='updateOrder-totalAmount'>0.00</label>
                     <label for="updateOrder-totalQuantity" class="form-label fw-bold me-1">Total Items:</label>
                     <label class="form-label fw-bold" id='updateOrder-totalItems'>0</label>
                  </div>
                </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="updateOrder-btnSave">save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>