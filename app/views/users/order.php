<?php $this->setSiteTitle('Order'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<?php $order = $this->order?>
<section class="section">
    <div class="row">
      <?php $this->partial('', 'user-sidebar', []); ?> 
        <div class="col-md-9 my-5 account-content-holder">
            <div class="white-headline-holder">
                <h1 class="white-headline-md">Order</h1>
             </div>   
            <div class="card order-card my-3">
                <div class="card-header side-flex order-header">
                     <div>
                     	<span>Order# <?= $order->order_nr?> |</span>
                        <span>Order Date: <?= Helpers::formatDate($order->order_create_date) ?></span> 
                     </div>
                     <div>
                        <span>Status: <span class="badge"><?= $order->displayOrderStatus(); ?></span></span>
                     </div>
                </div>
                <div class="card-body">
                   <div class="order-details-holder">
                     <div class="side-flex">
                     <div class="payment-info">
                            <h2 class="headline-sm">Payment Details</h2>
                            <?= $order->displayPaymentDetails()?>
                            
                      </div>	
                       <div>
                           <h2 class="headline-sm">Billing Details</h2>
                           <div class="billing-info"><?=  $this->billingInfo; ?></div>
                       </div>
                     </div>
                     <hr />
                     <div class="order-info">
                           <h2 class="headline-sm">Order Products</h2>
                           <div class="single-order-table">
                              <div class="order-table-row order-table-head-row">
                                    <div>Item</div>
                                    <div>Item No.</div>
                                    <div class="text-center">Quantity</div>
                                    <div class="text-right">Item Price</div>
                                    <div class="text-right">Item Subtotal</div>
                              </div>
                              <?php foreach($order->order_products as $product):?>
                              <div class="order-table-row">
                                    <div class="d-flex cart-table-details">
                                       <div class="order-table-img-md">
                                       
                                           <img src="<?= $product->displayImage(); ?>" alt="product">
                                       </div>
                                       <div class="order-details">
                                       <div class="pname"><a href="<?= PROOT.'products'.DS.'product'.DS.$product->id?>"><?= $product->product_name ?></a></div>
                                       <div>Brand: <?= $product->product_brand ?></div> 
                                       <div>Material: <?= $product->product_material ?></div>  
                                       <div>Color: <?= $product->product_color ?></div>   
                                       </div>       
                                    </div>
                                    <div><?= $product->product_code ?></div>
                                    <div class="text-center"><?= $product->sale_quantity ?></div>
                                    <div class="text-right"><?= Helpers::formatPrice($product->item_sale_price) ?></div>
                                    <div class="text-right"><?= Helpers::formatPrice($product->product_subtotal) ?></div>
                              </div>
                              <?php endforeach;?>
                              <hr />
                              <div class="order-totals">
                                    <div>
                                          <span>Total Before Tax</span>
                                          <span>Tax(<?= TAX_RATE_PERCENTAGE?>%)
                                                <span class="badge badge-secondary d-inline">*Included in item price</span>
                                          </span>
                                          <span><strong>Total</strong></span>
                                    </div>
                                    <div class="text-right">
                                          <span><?= Helpers::formatPrice($order->orderBeforeTax()) ?></span>
                                          <span><?= Helpers::formatPrice($order->order_tax) ?></span>
                                          <span><strong><?= Helpers::formatPrice($order->order_payment_amount) ?></strong></span>
                                    </div>
                              </div>
                             </div>
                      </div><!--end of order info-->
                      <hr />
                   </div><!--end of order details holder-->
                  </div><!--end of cart body-->
            </div>
      </div>
    </div>
</section>
<?php $this->end(); ?>
