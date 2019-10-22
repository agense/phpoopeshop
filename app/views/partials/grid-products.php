                  
                    <?php foreach($products as $product): ?>
                    <div class="<?= $classes ?>">    
                        <div class="single-product hoverable">
                            <div class="product-addons">
                            <?php if(Helpers::checkNew($product->product_upload_date)): ?>
                            <div class="new-item">New In</div>
                             <?php endif;?> 
                                <div class="product-icons">
                                    <div class="heart-icon-group">
                                        <span class="product-icon icon-heart-initial add-to-whishlist" data-id="<?= $product->id ?>" data-product="<?= $product->product_name ?>">
                                          <i class="fi fi-heart-line"></i>
                                        </span>
                                        <span class="product-icon icon-heart-changed"><i class="fi fi-heart-black"></i></span>
                                     </div>
                                     <div class="cart-icon-group">
                                        <span class="product-icon icon-cart-initial add-to-cart" data-id="<?= $product->id ?>">
                                            <i class="fi fi-shopping-bag"></i>
                                        </span>
                                        <span class="product-icon icon-cart-changed"><i class="fi fi-shopping-bag-option"></i></span>
                                     </div>
                                </div>
                            </div>  
                            <div class="errorMsg"></div>  
                            <?php if($product->product_price_discounted != null): ?>
                            <span class="sale sale-btn sale-positioned"><span class="btn-icon"><i class="fi fi-forward-all-arrow"></i></span>On Sale</span>
                            <?php endif;?>
                            <div class="product-image">
                                <img src="<?= $product->displayImage() ?>" alt="">
                            </div>
                            <div class="product-info">
                              <div class="product-info-box">
                                <div class="product-brand">
                                <span class="cat-brand"><?=$product->brand_name?></span>
                                </div>  
                                <div class="product-title"><?=$product->product_name?></div>
                                <div class="product-price">
                                <?php if($product->product_price_discounted != null): ?>
                                <span class="product-price-amount golden"><?= Helpers::formatPrice($product->product_price_discounted) ?></span>
                                <?php else: ?>
                                  <span class="product-price-amount"><?= Helpers::formatPrice($product->product_price) ?></span>
                                <?php endif;?>  
                                </div>
                              </div> 
                                <div class="more-link-holder">
                                    <a href="<?=PROOT?>products/product/<?= $product->id?>" class="more-link">Details</a>
                                </div>
                            </div> 
                              <!--Single Product Overlay-->
                               <div class="single-product-overlay"></div>
                            <!--End of Single Product Overlay-->
                        </div> 
                     </div>
                     <!-- end of single product-->
                   <?php endforeach;?>   