<!-- Modal -->
<div class="modal fade" id="categoryDetailsModal" tabindex="-1" role="dialog" aria-labelledby="categoryDetailsModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h2  class="modal-title">Category: <span id="modal-header"></span></h2>
      <div class="medium-image-holder mb-3">
          <img id="modal_featured_img" src="" alt="">
      </div>
      <p>Parent Category: <span id="modal-parent_category"></span></p>
      <p>Featured Category: <span id="modal-featured"></span></p>
      <p>Category Description: <br /><span id="modal-description"></span></p>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn main-btn-dark" id="modal_edit_btn">Edit Category</a>
      </div>
    </div>
  </div>
</div>
<!--End of modal-->