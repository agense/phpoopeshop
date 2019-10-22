<!-- Modal -->
<div class="modal fade" id="imgDetailsModal" tabindex="-1" role="dialog" aria-labelledby="imgDetailsModal" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="modal-body-holder"> 	
       <h2 class="modal-title">Edit Images:</h2>
       <hr>
       <div class="alert alert-danger hide alert-dismissible" id="update-errors">
          <button type="button" class="close" id="close-alert">
              <span aria-hidden="true">&times;</span>
           </button>
           <div id="update-errors-content"></div>

       </div>
       <div id='product-update-grid'></div>
       <hr />
       <!--Product Image Upload form-->
       <form class="form" action="#" method="POST" enctype="multipart/form-data" id="image-upload-form" data-product="<?= $this->product->id ?>">
     	  <?= FH::uploadMultipleBlock('product_images', 'Upload New Images', ['class' => 'form-control'], ['class' => 'form-group']);?>
       </form>
      </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>

</div>	
