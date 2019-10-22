<?php $this->setSiteTitle('Whishlist'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<?php $wlist = isset($this->whishlist->products) ? $this->whishlist->products : []; ?>
<section class="section">
    <div class="row">
         <?php $this->partial('', 'user-sidebar', []); ?> 

        <div class="col-md-9 my-5">
          <!--Session Errors-->
          <div class="mx-5 mb-4">
             <?= Session::displayMsg(); ?> 
          </div>
          <div class="cart-holder">
            <div class="white-headline-holder">
                <h1 class="white-headline-md">My Whishlist</h1>
             </div> 
            <?php if(count($wlist) > 0): ?>
               <div class="cart-header d-flex justify-content-between align-items-end">
               <?php 
               $itemNo = count($wlist);
               $itemNo = ($itemNo == 1) ? $itemNo.' item' : $itemNo.' items' ?> 
               <div class="grey-headline-md mb-0">There are <?=  $itemNo ?> in your whishlist</div>
               <a href="<?= PROOT.'whishlist'.DS.'clear' ?>" class="link-golden-minified wlist-clear">
                <i class="fi fi-close-square"></i>&nbsp;Clear Whishlist</a>
               </div>
               <div class="error-notice"></div>
               
               <!--Cart table-->
               <div class="cart-table">
                   <div class="cart-table-row head-row">
                     <div>Items</div>
                     <div class="whishlist-table-row-right">
                     <div></div>
                     <div>Item Price</div>
                     </div>
                  </div>
             <!--Cart table row-->
              <?php foreach($wlist as $product): ?>
              <div class="cart-table-row">
                <!--left-->
                <div class="cart-table-row-left">
                    <a href="<?=PROOT.'products'.DS.'product'.DS.$product->id?>">
                        <div class="cart-table-img">
                            <img src="<?= $product->displayImage() ?>" alt="product">
                        </div>
                        <div class="cart-item-details ml-3">
                            <div class="cart-table-item">
                              <a href="<?=PROOT.'products'.DS.'product'.DS.$product->id?>" class="pname"><?=$product->product_name?></a>
                            </div>
                            <div class="cart-table-details">
                              <div>Product No. <?= $product->product_code?></div>
                              <div>Brand: <?= $product->product_brand ?></div>
                              <div>Material: <?= $product->product_material ?></div>
                              <div>Color: <?= $product->product_color ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <!--right-->
                <div class="whishlist-table-row-right">
                   <div class="cart-table-actions">
                        <a href="<?= PROOT.'whishlist'.DS.'remove'.DS.$product->id ?>">Remove Item</a>
                        <a href="<?= PROOT.'whishlist'.DS.'moveToCart'.DS.$product->id ?>" class="link-golden-minified move-to-cart">
                         Move to Cart</a>
                    </div>
                    <?php $itemPrice = ($product->product_price_discounted !== null) ? $product->product_price_discounted : $product->product_price?>
                    <div class="cart-item-price">
                        <span class="price-helper-txt">Item Price</span>
                        <span><?= Helpers::formatPrice($itemPrice) ?></span>
                    </div>
                </div>
            </div>
            <!--end cart table row-->
         <?php endforeach;?>
        </div>
        <!--end of cart table-->
<?php else: ?>
  <div class="no-items">You whishlist is empty</div>
  <div class="light-separator mb-5"></div>
<?php endif; ?> 
        <!--Cart Buttons-->
        <div class="cart-buttons">
            <a href="<?=PROOT."categories".DS?>" class="btn btn-golden"><i class="fi fi-diamond"></i>&nbsp;&nbsp;Continue Shopping</a>
            <a href="<?=PROOT.'cart'?>" class="btn btn-black"><i class="fi fi-credit-card"></i>&nbsp;&nbsp;Go to Cart</a>
        </div>
         <!--End Cart Buttons-->
</div>         
</div>
</div>
</section>
<?php $this->end(); ?>