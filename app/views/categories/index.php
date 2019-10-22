<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
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
                    <p class="img-section-p my-3"><?= $category->category_description ?></p>
                    <a href="<?=PROOT?>categories/show/<?=$category->category_slug?>" class="btn-white category-btn">Discover More</a>    
                    <a href="<?=PROOT?>products/show/<?=$category->category_slug?>" class="btn btn-golden-inverse mt-2 category-btn">View Products</a>    
                  </div>
                </div>  
           </div>
        <!--END OF SPLIT SECTION SINGLE ITEM-->
            <?php endforeach;?>	
        <?php else: ?>
        <div class="no-items">There are no categories</div>    	
        <?php endif;?> 	
</section>        
<?php $this->end(); ?>
