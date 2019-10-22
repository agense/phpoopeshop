<?php $this->setSiteTitle('Order Details'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
      <div class="single-order-holder">
      <h1 class="border-bottom pt-3 pb-2 mb-3">Order</h1>
      <div class="heading">
      <?php if($this->order->order_status != 3): ?>  
      <a href="<?=PROOT.'admin'.DS.'orders'.DS.'process'.DS.$this->order->id ?>" class="btn main-btn">Process Order</a>
      <?php else:?>
        <span class="badge badge-success">Order Completed</span>
      <?php endif;?>  
      </div>
      <!--Single Order-->
      <div class="card border-light my-3 single-order-card">
            <div class="card-header side-flex">
               <div>
                  <span>Order# <?= $this->order->order_nr?> |</span>
                  <span>Order Date: <?= Helpers::formatDate($this->order->order_create_date) ?></span> 
              </div>
              <div>
                  <span>Status: <span class="badge"><?= $this->order->displayOrderStatus(); ?></span></span>
              </div>     
            </div>
                <div class="card-body">
                   <div class="order-details-holder">
                     <div class="customer-info">
                        <div class="">
                            <h2 class="headline-sm">Payment Details</h2>
                            <?= $this->order->displayPaymentDetails()?>
                       </div>
                       <div>
                           <h2 class="headline-sm">Billing Details</h2>
                           <div class="billing-info"><?=  $this->billingInfo; ?></div>
                       </div>
                     </div>
                     <hr />
                     <div class="order-info">
                           <h2 class="headline-sm">Order Details</h2>
                           <div class="order-table">
                              <div class="order-table-row order-head">
                                    <div>Item</div>
                                    <div>Item No.</div>
                                    <div class="text-center">Quantity</div>
                                    <div class="text-right">Item Price</div>
                                    <div class="text-right">Subtotal</div>
                              </div>
                              <?php foreach($this->order->products as $product):?>
                              <div class="order-table-row">
                                    <div class="d-flex">
                                      <div class="order-table-img-md">
                                           <img src="<?= $product->displayImage();?>" alt="product">
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
                                          <span><?= Helpers::formatPrice($this->order->order_before_tax) ?></span>
                                          <span><?= Helpers::formatPrice($this->order->order_tax) ?></span>
                                          <span><strong><?= Helpers::formatPrice($this->order->order_payment_amount) ?></strong></span>
                                    </div>
                              </div>
                             </div>
                      </div><!--end of order info-->
                      <hr />  
                   </div><!--end of order details holder-->
                  </div><!--end of cart body-->
      </div>
</div>
<?php $this->end(); ?>