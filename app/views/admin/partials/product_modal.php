<!-- Modal -->
<div class="modal fade" id="productDetailsModal" tabindex="-1" role="dialog" aria-labelledby="productDetailsModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
      <div class="row">  
      <div class="col-lg-12">
        <h1><span id="product-name" class="modal-title"></span></h1> 
        <p>Code: <span id="product-code"></span></p>  
        <div class="medium-image-holder">
          <img id="product_featured_img" src="" alt="">
        </div><br />
      </div>  
      <div class="col-lg-6">
        
        <p>Price: <span id="product-price"></span></p> 
        <p>Discount Price: <span id="product_price_disc"></span></p> 
        <p>Category: <span id="product-category"></span></p> 
        <p>Top Category: <span id="product-top-category"></span></p> 
      </div>
       <div class="col-lg-6">
        <p>Brand: <span id="product-brand"></span></p>  
        <p>Material: <span id="product-material"></span></p> 
        <p>Color: <span id="product-color"></span></p> 
        <p>Featured Product: <span id="product-featured"></span></p> 
       </div>
      <div class="col-lg-12">
        <p>Product Description: <br /><span id="product-description"></span></p>
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn main-btn-dark" id="modal_edit_btn">Edit Product</a>
      </div>
    </div>
  </div>
</div>
<!--End of modal-->