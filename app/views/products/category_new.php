<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<?php $category= $this->category; ?>

<!--BANNER SECTION-->
<section class="section-slim">
        <div class="banner d-flex justify-content-center align-items-end text-center pt-2">
            <div class="banner-img">
                 <div class="img-holder">
                <?php $imgpath = ($category->category_image) ? $category->uploadPath.DS.$category->category_image :'';?>  
                     <img src="<?= PROOT.DS.$imgpath ?>" alt="">
                 </div>
                 <div class="dark-overlay"></div>
                 <div class="banner-text">
                    <h2 class="grid-img-title heading-white-lg">NEW IN <?= $category->category_name?></h2>
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
                <span class="bread-crumb"><a href="<?= PROOT.'categories'.DS.'show'.DS.$category->category_slug?>" class="link-minified"><?= $category->category_name?></a></span>
                <span class="f-slash">/</span>
                <span class="bread-crumb"><span class="link-minified">NEW IN <?= $category->category_name?></span></span>
        </div>
        <div class="light-separator"></div>
</section>
<!--END OF BANNER SECTION-->
   
<!--PRODUCT SECTION-->
<section class="section-top">
    <div class="new-products-container row products-container">
    <?php if(count($this->products) > 0):?>    
        <?php 
        $products = $this->products;
        $this->partial('', 'grid-products', ['classes' => 'col-sm-6 col-md-4 col-lg-3 grid-single-product', 'products' => $products]);
        ?>                    
    <?php else: ?>
    <div class="no-items">There are no items in <?= $category->category_name?>.</div>  
    <?php endif; ?>                  
    </div>
    <div class="text-center mt-2">
       <a href="<?= PROOT.'products'.DS.'show'.DS.$category->category_slug?>" class="btn btn-black-inverse"><span class="btn-icon"><i class="fi fi-diamond"></i></span><span>View All <?= $category->category_name?></span></a>
    </div>
</section>   

<!--END PRODUCT SECTION-->      
<?php $this->end(); ?>




