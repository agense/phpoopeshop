<?php $this->setSiteTitle('Category Products'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<?php $product = $this->product ?>
    <!-- BREADCRUMBS-->
    <section class="section-slim">
            <div class="light-separator"></div>
            <div class="bread-crumbs">
                <span class="bread-crumb back-link">
                    <a href="<?=PROOT.'products'.DS.'show'.DS.$product->parent_category.DS.$product->product_category?>" class="link-minified"><span><i class="fi fi-line-angle-left"></i></span>Back</a>   
                </span>     
                <span class="bread-crumb"><a href="<?= PROOT ?>" class="link-minified">Home</a></span>
                <span class="f-slash">/</span>
                <span class="bread-crumb"><a href="<?=PROOT.'products'.DS.'show'.DS.$product->parent_category_slug?>" class="link-minified"><?= $product->parent_category ?></a></span>
                <span class="f-slash">/</span>
                <span class="bread-crumb"><a href="<?=PROOT.'products'.DS.'show'.DS.$product->parent_category_slug.DS.$product->product_category_slug?>" class="link-minified"><?= $product->product_category ?></a></span>
                <span class="f-slash">/</span>
                <span class="bread-crumb"><span class="link-minified"><?= $product->product_name ?></span></span>
            </div>
            <div class="light-separator"></div>
        </section>
    <!-- BREADCRUMBS-->

<!--PRODUCT SECTION-->
<section class="section-top">
    <div class="row">
        <div class="col-md-6">
        	<?php if(count($product->product_images) > 0):?>
            <!--Product Slider-->
            <div class="product-slider-holder d-block">
            <div class="product-slider">
            	<?php foreach($product->product_images as $product_image):?>
                <div class="product-slider-item">
                    <img src="<?=PROOT.DS.$product->uploadPath.DS.$product_image?>" alt="" class="product-slider-image">
                </div>
                <?php endforeach;?>
            </div>
            <!--End Product Slider-->
            <!--Product Slider Nav-->
            <div class="product-slider-nav">
            	<?php foreach($product->product_images as $product_image):?>
                    <div class="product-slider-nav-item">
                        <img src="<?=PROOT.DS.$product->uploadPath.DS.$product_image?>" alt="">
                    </div>
                    <?php endforeach;?>
                </div>
                <!--End of Product Slider Nav-->
        </div>
        <?php else: ?>
        <div class="product-slider-holder d-block"><img src="<?= $product->displayImage() ?>" alt=""></div>
        <?php endif;?>
        </div>
        <div class="col-md-6">
             <div class="product-info-holder pro-display">
                 <?php if(Helpers::checkNew($product->product_upload_date)): ?>
                    <div class="new-item-single-product">New In</div>
                <?php endif;?> 
                 <h3 class="product-brand"><?= $product->product_brand ?></h3>    
                 <h2 class="product-title"><?= $product->product_name ?></h2>

                <div class="product-price"> 
                 <?php if($product->product_price_discounted):?>
                 <!--Price on sale-->
                    <span class="sale sale-btn">
                        <span class="btn-icon"><i class="fi fi-forward-all-arrow"></i></span>On Sale
                    </span>
                    <span class="price-full overline price-cross"><?= Helpers::formatPrice($product->product_price) ?></span> 
                    <span class="price-discounted"><?= Helpers::formatPrice($product->product_price_discounted) ?></span> 
                 <?php else: ?>	
                        <span class="price-full"><?= Helpers::formatPrice($product->product_price) ?></span> 
                <?php endif;?>
                <span class="price-includes"> 
                    incl. VAT & free-shipping from <span><?= CURRENCY?></span><span class="free-shipping">100.00</span>
                </span>
                </div>
                 <!--End price on sale-->
                 <div class="product-quantity">
                 <?php if($product->product_quantity > 0): ?>
                    <form action="" method="">
                        <label for="p-quantity">Quantity</label>
                            <select name="select" id="p-quantity">
                            	<?php 
                            	 $options = "";
                                 for($i = 1; $i <= $product->product_quantity; $i++){
                                    $options .= '<option value="'.$i.'">'.$i.'</option>';
                                 }
                            	?>
                                <?= $options ?>
                            </select>    
                    </form>
                <?php endif; ?>
                    <div class="product-availability">
                    	<span>Availability:</span> 
                    	<?php $available = ($product->product_quantity > 0) ? TRUE : FALSE ;?>
                    	<?php if($available): ?>
                         <span class="text-green">In Stock</span>
                         <span>| Delivery time 1-4 working days</span>
                        <?php else: ?> 
                        <span class="text-red">Sold Out</span>	
                        <?php endif;?>	
                    </div>
                </div>
                <div class="error-notice"></div>
                <div class="product-action-buttons d-block">
                <?php if($available): ?>	
                <div class="add-card">
                        <button type="button" class="btn btn-black" id="card-add" data-id="<?=$product->id?>">
                            <span class="btn-icon"><i class="fi fi-shopping-bag"></i></span>
                            <span btn-mini-txt>Add To Cart</span>
                        </button> 
                 </div>
                 <?php else: ?>
                 	<p class="sold-out-msg">Add the product to your wishlist to buy once it becomes available!</p>
                 <?php endif;?> 
                 <div class="add-whishlist">
                     <button type="button" class="btn-golden-inverse" id="favorites-add" data-id="<?=$product->id?>" data-product="<?= $product->product_name ?>">
                         <span  class="btn-icon"><i class="fi fi-heart-black"></i></span>
                         <span btn-mini-txt>Add To Whishlist</span>
                     </button> 
                 </div>
                </div>
             </div>
        </div>
    </div>
    </section>
<section class="section">   
    <div class="row">
        <div class="col mx-auto text-center my-3">
            <ul class="nav nav-tabs justify-content-center" id="prodcutTabs">
                    <li class="nav-item">
                      <a class="nav-link mini-tab active" id="desc-tab">Description</a>
                    </li>
                    <span class="vertical-separator">|</span>
                    <li class="nav-item">
                      <a class="nav-link mini-tab" id="details-tab">Details</a>
                    </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                    <div class="" id="desc">
                        <div class="description text-center w-75 mx-auto"><?= $product->product_description ?></div>      
                    </div>
                    <div class="" id="details">
                            <div class="description text-center w-75 mx-auto">
                                    <ul>
                                        <li>Article No: <span class="det pl-2"><?= $product->product_code ?></span></li>
                                        <li>Type: <span class="det pl-2"><?= $product->product_category ?></span></li>
                                        <li>Material: <span class="det pl-2"><?= $product->product_material ?></span></li>
                                        <li>Color: <span class="det pl-2"><?= $product->product_color ?></span></li>
                                    </ul>
                              </div>
                    </div>
            </div>
        </div>          
    </div>
</section>
<!--END PRODUCT SECTION-->
<!--BONUS POINTS-->
<section class="section">
    <div class="bonuses d-flex justify-content-around align-items-center">
        <div class="bonus d-block text-center">
            <span class="bonus-content d-block"><i class="fi fi-gift-wrap"></i></span>
            <span class="bonus-title d-block">Gift Wrapped</span>
        </div>
        <div class="bonus d-block text-center">
                <span class="bonus-content d-block"><i class="fi fi-tags"></i></span>
                <span class="bonus-title d-block">14 days returns</span>
        </div>
        <div class="bonus d-block text-center">
                <span class="bonus-content d-block"><i class="fi fi-truck"></i></span>
                <span class="bonus-title d-block">Express Shipping</span>
        </div>
    </div>
</section>
<!--END BONUS POINTS-->

<!--RELATED PRODUCTS SECTION-->
 <?php if(count($this->relatedItems) > 0 ): ?>
    <section class="section">  
    <div class="white-headline-holder">
        <h4 class="white-headline-md">Similar Products</h4>
    </div> 
    <div class="row">
        <div class="col slider-col">
            <div class="suggestion-slider-holder">
            <div class="suggestion-slider products-container">
            <?php 
            $products = $this->relatedItems;
            $this->partial('', 'grid-products', ['classes' => 'suggestions-slider-item', 'products' => $products]);?>
            </div>
            </div>
        </div>
     </div>
</section>
 <?php endif;?> 
 
 <!--PRODUCT ADDED MODAL WINDOW-->
<div class="modal-holder cart-modal modal-hidden">
    <div class="modal-center">
        <div class="modal-content-holder">
        <div class="modal-heading text-center dark-headline-md">Item has been added to the cart</div>
        <div class="item-desc text-sm text-center">
            <span class="added-item-name"></span> : 
            <span class="added-item-qty"></span>
        </div>
        <div class="modal-btn">
             <a href="<?=PROOT.'cart'.DS?>" class="btn btn-golden"><span class="btn-icon"><i class="fi fi-shopping-bag"></i></span>Go To Cart</a>
             <a href="<?= PROOT.'products'.DS.'show'.DS.$this->product->parent_category_slug.DS?>" class="btn btn-black-inverse"><span class="btn-icon"><i class="fi fi-diamond"></i></span>Continue Shopping</a>   
        </div>
        </div>
        <div class="modal-closer">&times;</div>
    </div>
</div>

 <!--PRODUCT ADDED TO WHISHLIST MODAL WINDOW-->
<div class="modal-holder whishlist-modal modal-hidden">
    <div class="modal-center">
        <div class="modal-content-holder">
        <div class="modal-heading text-center dark-headline-md">Item has been added to the whishlist</div>
        <div class="item-desc text-sm text-center">
            <span class="added-item-name"></span> 
        </div>
        <div class="modal-btn">
             <a href="<?=PROOT.'whishlist'.DS?>" class="btn btn-golden"><span class="btn-icon"><i class="fi fi-shopping-bag"></i></span>Go To Whishlist</a>
             <a href="<?= PROOT.'products'.DS.'show'.DS.$this->product->parent_category_slug.DS?>" class="btn btn-black-inverse"><span class="btn-icon"><i class="fi fi-diamond"></i></span>Continue Shopping</a>   
        </div>
        </div>
        <div class="modal-closer">&times;</div>
    </div>
</div>
<!--END OF MODAL WINDOw-->        
<!-- END OF RELATED PRODUCTS SECTION-->
<?php $this->end(); ?>
