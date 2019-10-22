<?php $this->setSiteTitle('Subcategories'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<section class="section-top">
    <div class="white-headline-holder">
        <h4 class="white-headline-md">Your Cart</h4>
    </div>  
    <?php if(Cart::countItems() > 0): ?>
    <div class="cart-holder">
    <div class="cart-header d-flex justify-content-between align-items-end">
    	<div class="grey-headline-md mb-0">There are <?= Cart::countItems() ?> items in cart</div>
    	<a href="<?= PROOT.'cart'.DS.'clearCart'.DS ?>" class="link-golden-minified cart-clear"><i class="fi fi-close-square"></i>&nbsp;Clear Cart</a>
    </div>
    <div class="error-notice"></div>
         <!--Cart table-->
        <div class="cart-table">
        	<div class="cart-table-row head-row">
        		<div>Items</div>
        		<div class="cart-table-row-right">
        			<div></div>
        			<div>Quantity</div>
        			<div>Item Price</div>
        			<div>Subtotal</div>
        		</div>
        		
        	</div>
             <!--Cart table row-->
            <?php foreach($this->cartProducts as $product): ?>
            <div class="cart-table-row">
                <!--left-->
                <div class="cart-table-row-left">
                    <a href="<?=PROOT.'products'.DS.'product'.DS.$product->id?>">
                        <div class="cart-table-img">
                            <img src="<?= $product->displayImage() ?>" alt="product">
                        </div>
                        <div class="cart-item-details">
                            <div class="cart-table-item">
                            	<a href="<?=PROOT.'products'.DS.'product'.DS.$product->id?>" class="pname"><?=$product->product_name?></a>
                            </div>
                            <div class="cart-table-details">
                            	<div>Product No. <?= $product->product_code?></div>
                            	<div>Brand: <?= $product->product_brand?></div>
                            	<div>Material: <?= $product->product_material?></div>
                            	<div>Color: <?= $product->product_color?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <!--right-->
                <div class="cart-table-row-right">
                	 <div class="cart-table-actions">
                        <a href="#" class="link-black-minified remove-item" data-id="<?=$product->id?>">Remove Item</a>
                        <a href="#" class="link-golden-minified move-to-whishlist" data-id="<?=$product->id?>"><i class="fi fi-heart-black"></i> Move to Whishlist</a>
                    </div>
                    <div class="cart-product-quantity">
                       <select name="quantity" id="quantity" class="quantity quantity-select" data-id="<?=$product->id?>">
                        <?php for($i = 1; $i <= $product->product_quantity; $i++):?>
                           <option value="<?=$i?>" <?= ($i == $product->cart_quantity) ? 'selected="selected"': '' ;?>><?=$i?></option>
                        <?php endfor;?>   
                       </select>
                    </div>
                    <?php $itemPrice = ($product->product_price_discounted !== null) ? $product->product_price_discounted : $product->product_price?>
                    <div class="cart-item-price">
                        <span class="price-helper-txt">Item Price</span>
                        <span><?= Helpers::formatPrice($itemPrice) ?></span>
                    </div>
                    <div class="cart-item-subtotal">
                        <span class="price-helper-txt">Product Subtotal</span>
                        <span><?=  Helpers::formatPrice($product->cart_product_subtotal) ?></span>
                    </div>
                </div>
            </div>
            <!--end cart table row-->
         <?php endforeach;?>
        </div>
        <!--end of cart table-->

        <!--Totals Section-->
        <div class="cart-totals">
            <!--left-->
            <div class="cart-totals-left"> Shipping is free!</div>
            <!--Right-->
            <div class="cart-totals-right">
            	<div class="total-items"></div>

                <div class="cart-subtotals">
                    <span>Total Before Tax</span><br/>
                    <span>Tax (<?= TAX_RATE_PERCENTAGE ?>%)</span><br/>
                    <span class="cart-totals-total">Total</span>
                </div>
                <div class="cart-totals-subtotal">
                    <span id="subtotal"><?= $this->cartTotals['beforeTax'] ?></span>
                    <span id="tax"><?=  $this->cartTotals['tax'] ?></span>
                    <span id="total" class="cart-totals-total"><?= $this->cartTotals['total'] ?></span>
                </div>
            </div>
        </div>
        <!--End Totals Section-->

        <!--Cart Buttons-->
        <div class="cart-buttons">
            <a href="<?=PROOT."categories".DS?>" class="btn btn-golden"><i class="fi fi-diamond"></i>&nbsp;&nbsp;Continue Shopping</a>
            <a href="<?=PROOT.'order/'?>" class="btn btn-black"><i class="fi fi-credit-card"></i>&nbsp;&nbsp;Proceed To Checkout</a>
        </div>
         <!--End Cart Buttons-->
    </div>
<?php else: ?>
    <div style="min-height: 30vh">
	<div class="no-items">You cart is empty</div>
    <div class="text-center">
    <a href="<?=PROOT."categories".DS?>" class="btn btn-golden"><i class="fi fi-diamond"></i>&nbsp;&nbsp;Continue Shopping</a></div>
    </div>
<?php endif;?>	
</section>    	
<?php $this->end(); ?>