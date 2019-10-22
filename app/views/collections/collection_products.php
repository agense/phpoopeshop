<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<?php $collection = $this->collection; ?>

<!--BANNER SECTION-->
<section class="section-slim">
        <div class="banner d-flex justify-content-center align-items-end text-center pt-2">
            <div class="banner-img">
                 <div class="img-holder">
                     <img src="<?= $collection->displayImage() ?>" alt="">
                 </div>
                 <div class="dark-overlay"></div>
                 <div class="banner-text">
                    <h2 class="grid-img-title heading-white-lg"><?= $collection->collection_name?></h2>
                    <span class="link-white"><i class="fi fi-angle-bottom"></i></span>
                </div>
            </div>
        </div>
        <div class="bread-crumbs">
                <span class="bread-crumb back-link">
                        <a href="#" class="link-minified"><span><i class="fi fi-line-angle-left"></i></span>Back</a>   
                </span>    
                <span class="bread-crumb"><a href="<?= PROOT ?>" class="link-minified">Home</a></span>
                <span class="f-slash">/</span>
                <span class="bread-crumb"><a href="<?= PROOT.'Collections'.DS?>" class="link-minified">Collections</a></span>
                <span class="f-slash">/</span>
                <span class="bread-crumb"><span class="link-minified">Collection One</span></span>
        </div>
        <div class="light-separator"></div>
</section>
<!--END OF BANNER SECTION-->
   
<!--PRODUCT SECTION-->
<section class="section-top">
    <div class="category-content row products-container">
    <?php if(count($this->collectionProducts) > 0):?>    
        <?php 
        $products = $this->collectionProducts;
        $this->partial('', 'grid-products', ['classes' => 'col-sm-6 col-md-4 col-lg-3 grid-single-product', 'products' => $products]);
        ?>                    
    <?php else: ?>
    <div class="no-items">There are no items in this collection.</div>  
    <?php endif; ?>                  
    </div>
</section>    	
<!--END PRODUCT SECTION-->    	
<?php $this->end(); ?>