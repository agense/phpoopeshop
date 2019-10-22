<?php $this->setSiteTitle('Order'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<section class="section">
    <div class="row">
        <?php $this->partial('', 'user-sidebar', []); ?> 
        <div class="col-md-9 my-5 account-content-holder">
            <div class="white-headline-holder">
                <h1 class="white-headline-md">My Orders</h1>
             </div> 
    <?php if($this->orders): ?>           
        <?php foreach($this->orders as $order):?>    
        	 <div class="card order-card mb-3">
                <div class="card-header side-flex order-header">
                     <div>
                        <span>Order Date: <?= Helpers::formatDate($order->order_create_date) ?> |</span> 
                        <span>Order #<?= $order->order_nr?> </span>
                     </div>
                     <div>
                        <span>Status: <span class="badge"><?= $order->displayOrderStatus(); ?></span></span>
                     </div>
                </div>
                <div class="card-body">
                    <div class="order-grid-flex">
                        <div class="order-product-list">
                            <h2 class="headline-sm">Order Products</h2>
                            <?php foreach($order->order_products as $product): ?>
                                <div class="d-flex justify-content-between align-items-center">
                                  <div class="d-flex">
                                  <div class="order-table-img">
                                     <img src="<?= $product->displayImage();?>" alt="product">
                                  </div>
                                    <div>
                                        <a href="<?= PROOT.'products'.DS.'product'.DS.$product->id?>" class="text-uppercase"><?= $product->product_name?></a><br/>
                                        <span><?= $product->product_brand?></span>
                                    </div>
                                   </div>
                                    <div><span class="bordered-qty"><?= $product->sale_quantity?></span></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div>
                        <div class="order-summary">
                            <h2 class="headline-sm">Order Summary</h2> 
                            <div>Total: <?= Helpers::formatPrice($order->order_payment_amount) ?></div>
                            <div>Payment: <?= $order->displayPaymentStatus()?></div>
                        </div>
                        <span><a href="<?= PROOT.DS.'users'.DS.'order'.DS.$order->id?>" class="mt-3 d-block btn btn-golden-inverse btn-md">Order Details</a></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>    
        <?php else:?>   
            <div class="no-items">You have no orders yet.</div> 
        <?php endif; ?> 
        </div>
    </div>
</section>
<?php $this->end(); ?>