<?php $this->setSiteTitle('Order'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<section class="section-top">
    <div class="white-headline-holder">
            <h4 class="white-headline-md">Your Order</h4>
    </div>  
    	<form class="order-form" action="<?=PROOT?>order/index" method="POST">
    	<!-- Hidden field for token-->
 	    <?= FH::csrfInput();?>
 	    <!-- Display errors-->
 	    <?= FH::displayErrors($this->displayErrors); ?>	
    	<div class="order-holder">	
    	<div class="billing-details">
    	 <h1 class="grey-headline-md text-left mb-4">Billing Details</h1>
 	        <!-- Form Fields-->
 	        <?= FH::inputBlock('text','Full Name', 'customer_name', $this->customerName, ['class'=>'form-control input-sm'], ['class' => 'form-group'])?>
 	        <?= FH::inputBlock('text','Address', 'customer_address', '', ['class'=>'form-control input-sm'], ['class' => 'form-group'])?>
 	        <?= FH::inputBlock('text','City', 'customer_city', '', ['class'=>'form-control input-sm'], ['class' => 'form-group'])?>
 	        <?= FH::inputBlock('text','Country', 'customer_country', '', ['class'=>'form-control input-sm'], ['class' => 'form-group'])?>
 	        <?= FH::inputBlock('text','Postal Code', 'customer_postal_code', '', ['class'=>'form-control input-sm'], ['class' => 'form-group'])?>

         <h1 class="grey-headline-md text-left my-4">Payment/Delivary Details</h1>
         <p>You can receive your order in our customer service office:<br/>
            <span>98 Any Str. Any City</span>
         </p>
         <p>Payment must be made by cash or by cart upon receipt of the order.</p>
    	</div>

    	<div class="order-details">
    		<h2 class="grey-headline-md text-left mb-4">Order Details</h2>
    		<div class="order-table">
    			<div class="order-table-row order-head">
    				<div>Item</div>
    				<div>Item No.</div>
    				<div class="text-center">Quantity</div>
    				<div class="text-right">Price</div>
    			</div>
    			<?php foreach($this->cartProducts as $product):?>
    			<div class="order-table-row">
    				<div><?= $product->product_name ?></div>
    				<div><?= $product->product_code ?></div>
    				<div class="text-center"><?= $product->cart_quantity ?></div>
    				<div class="text-right"><?= Helpers::formatPrice($product->cart_product_subtotal) ?></div>
    			</div>
    		    <?php endforeach;?>
    			<div class="order-table-row-totals order-totals">
    				<div>
    				  <span><strong>Subtotal</strong></span>
    				  <span><strong>Tax(<?= TAX_RATE_PERCENTAGE?>%)</strong></span>
    				  <span><strong>Total</strong></span>
    			    </div>
    				<div class="text-right">
    					<span><?= $this->cartTotals['beforeTax'] ?></span>
    					<span><?= $this->cartTotals['tax'] ?></span>
    					<span><strong><?= $this->cartTotals['total'] ?></strong></span>
    				</div>
    			</div>
    		</div>
    		<?= FH::submitBlock('Confirm Order', ['class' => 'btn btn-golden order-form-submit mt-5']) ?>
    	</div>
    </div>	
    </form>  
</section>    
<?php $this->end(); ?>