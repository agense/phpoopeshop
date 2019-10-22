<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<!--SLIDER-->
<section class="full-section">
    <div class="main-slider-holder">
        <div class="main-slider" class="main-slider">
            <!--single slide-->
            <div class="slide">
                <div class="slider-img">
                    <img src="<?= SLIDER_PATH ?><?= FIRST_SLIDE_IMG ?>" alt="">
                </div>
                <div class="slider-txt-holder">
                    <div class="slider-txt">
                    <h1 class="slide-heading"><?= FIRST_SLIDE_TITLE ?></h1>
                    <a href="<?= FIRST_SLIDE_LINK ?>" class="btn-white"><?= FIRST_SLIDE_BUTTON_TEXT ?></a>
                </div>
              </div>
            </div>
            <!--end of single slide-->
            <!--single slide-->
            <div class="slide">
                    <div class="slider-img">
                        <img src="<?= SLIDER_PATH ?><?= SECOND_SLIDE_IMG ?>" alt="">
                    </div>
                    <div class="slider-txt-holder">
                    <div class="slider-txt">
                            <h1 class="slide-heading"><?= SECOND_SLIDE_TITLE ?></h1>
                            <a href="<?= SECOND_SLIDE_LINK ?>" class="btn-white"><?= SECOND_SLIDE_BUTTON_TEXT ?></a>
                        </div>
                    </div>
            </div>
            <!--end of single slide-->
            <!--single slide-->
            <div class="slide">
                    <div class="slider-img">
                        <img src="<?= SLIDER_PATH ?><?= THIRD_SLIDE_IMG ?>" alt="">
                    </div>
                    <div class="slider-txt-holder">
                    <div class="slider-txt">
                            <h1 class="slide-heading"><?= THIRD_SLIDE_TITLE ?></h1>
                            <a href="<?= THIRD_SLIDE_LINK ?>" class="btn-white"><?= THIRD_SLIDE_BUTTON_TEXT ?></a>
                        </div>
                    </div>
            </div>
            <!--end of single slide-->
        </div>
    </div>
</section>
<!--END OF SLIDER-->

<!--CATEGORY DISPLAY SECTION-->
<section class="section">
        <div class="white-headline-holder">
            <h4 class="white-headline-md">Shop By Category</h4>
        </div> 
        <?php if(count($this->categories) > 0 ): ?>
        	<?php foreach($this->categories as $category): ?>
            <!--SINGLE SPLIT ITEM-->
            <?php 
               $splitType = (Helpers::checkOdd($category->number)) ? 'split-left': 'split-right';
            ?>
            <div class="split-section <?= $splitType ?>">
                <div class="split-8">   
                  <div class="img-holder">
                      <img src="<?= $category->displayImage() ?>" alt="" class="split-img">
                  </div>
                </div>     
                <div class="split-4">  
                  <div class="split-txt-holder">
                    <h2 class="grid-img-title heading-white-lg"><?= $category->category_name ?></h2>
                    <p class="img-section-p"><?= $category->category_description ?></p>
                    <a href="<?=PROOT?>categories/show/<?=$category->category_slug?>" class="btn-white">Discover</a>     
                  </div>
                </div>  
           </div>
        <!--END OF SPLIT SECTION SINGLE ITEM-->
            <?php endforeach;?>		
        <?php endif;?> 	
</section>
<!--END OF CATEGORY DISPLAY SECTION -->

<!--NEW PRODUCTS SECTION-->
 <?php if(count($this->newItems) > 0 ): ?>
    <section class="section">  
    <div class="white-headline-holder">
        <h4 class="white-headline-md">The newest items</h4>
    </div> 
    <div class="row">
        <div class="col slider-col">
            <div class="suggestion-slider-holder">
            <div class="suggestion-slider products-container">
            <?php 
            $products = $this->newItems;
            $this->partial('', 'grid-products', ['classes' => 'suggestions-slider-item', 'products' => $products]);
            ?>
            </div>
            </div>
        </div>
     </div>
</section>
 <?php endif;?>         
<!-- END OF NEW PRODUCTS SECTION-->

<!--COLLECTION DISPLAY SECTION -->
<?php if(count($this->collections) > 0):?>
<section class="section">
        <div class="white-headline-holder">
                <h4 class="white-headline-md">Our Collections</h4>
        </div>
    <?php if(count($this->collections) == 1):
      $collection = $this->collections[0];
    ?>    
      <!--single collection-->  
        <div class="section-image-holder">
            <div class="img-holder">
                <img src="<?= $collection->displayImage() ?>" alt="">
            </div>
            <div class="img-section-txt-holder d-flex align-items-center dark-overlay">
                <div class="img-section-txt section-txt-left">
                        <h2 class="grid-img-title heading-white-lg"><?= $collection->collection_name?></h2>
                        <p class="img-section-p"><?= $collection->collection_description?></p>
                        <a href="<?=PROOT?>collections/show/<?=$collection->id?>" class="btn-white">Discover</a>    
                </div>
            </div>
            <a href="<?=PROOT?>collections/show/<?=$collection->id?>" class="link-overlay"></a>
        </div>
        <!--end of single collection-->
    <?php else :?> 
        <div class="collections-slider-holder">
           <div class="collections-slider">  
            <?php foreach($this->collections as $collection):?>
            <div class="section-image-holder">
                <div class="img-holder">
                <img src="<?= $collection->displayImage() ?>" alt="">
                </div>
                <div class="img-section-txt-holder d-flex align-items-center dark-overlay">
                    <div class="img-section-txt section-txt-left">
                        <h2 class="grid-img-title heading-white-lg"><?= $collection->collection_name?></h2>
                        <p class="img-section-p"><?= $collection->collection_description?></p>
                        <a href="<?=PROOT?>collections/show/<?=$collection->collection_slug?>" class="btn-white">Discover</a>    
                    </div>
                </div>
            <a href="<?=PROOT?>collections/show/<?=$collection->collection_slug?>" class="link-overlay"></a>
        </div>
            <?php endforeach;?>    
           </div>
        </div> 
    <?php endif;?>      
</section> 
<?php endif;?>       
<!--END OF COLLECTION DISPLAY SECTION -->

<!--FEATURED ITEMS DISPLAY SECTION -->
<?php if(count($this->featuredItems) > 0):?>
<section class="section">
        <div class="white-headline-holder">
                <h4 class="white-headline-md">Our Top Picks</h4>
        </div>
        <div class="split-section slider-split">   
                <div class="split-4">  
                  <div class="split-txt-holder">
                    <h2 class="grid-img-title heading-white-lg">Top Items</h2>
                    <p class="img-section-p">Discover our hand selected items of this season!Nam convallis nec dui nec convallis. Integer pulvinar, justo sed cursus imperdiet, lorem nulla dictum nisi, in sagittis magna felis sed lacus.</p>    
                  </div>
                </div>  
                <div class="split-8">   
                  <div class="featured-slider-holder">
                    <div class="featured-items-slider products-container">
                    <?php 
                     $products = $this->featuredItems;
                     $this->partial('', 'grid-products', ['classes' => 'featured-slider-item', 'products' => $products]);
                     ?>
                    </div>
                  </div>
                </div>  
           </div>
</section>
<?php endif;?>
<!--END FEATURED ITEMS DISPLAY SECTION -->

<?php $this->end(); ?>



