

<!-- Modal -->
<div class="modal fade orderItemModal" id="orderItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Order Item Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="card">
            <div class="card-header">
                Order ID:
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="control-group">
                            <label class="control-label">Product Name:&nbsp;</label>
                            <label class="control-label" id='orderItemProdName'>ProdNameVal</label>
                        </div>
                        <div class="control-group">
                            <label class="control-label mt-3">Unit Price:&nbsp;</label>
                            <label class="control-label" id='orderItemUnitPrice'>ProdNameVal</label>
                        </div>
                        <div class="control-group">
                            <label class="control-label mt-3">Quantity:&nbsp;</label>
                            <label class="control-label" id='orderItemQty'>ProdNameVal</label>
                        </div>
                        <div class="control-group">
                            <label class="control-label mt-3">Total Price:&nbsp;</label>
                            <label class="control-label" id='orderItemTotalPrice'>ProdNameVal</label>
                        </div>
                    </div>
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