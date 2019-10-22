<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<section class="section">
        <div class="white-headline-holder">
                <h4 class="white-headline-md">Our Collections</h4>
        </div> 

<?php if(count($this->collections) > 0 ): ?> 
<?php foreach($this->collections as $collection): ?>
     <?php $splitType = (Helpers::checkOdd($collection->number)) ? 'section-txt-left': 'section-txt-right'; ?>   
   
     <!--Single Collection-->  
    <div class="section-image-holder hover-shadow">
        <div class="img-holder">
            <img src="<?= $collection->displayImage() ?>" alt="">
        </div>
        <div class="img-section-txt-holder d-flex align-items-center dark-overlay">
            <div class="img-section-txt <?= $splitType ?>">
                    <h2 class="grid-img-title heading-white-lg"><?= $collection->collection_name ?></h2>
                    <p class="img-section-p"><?= $collection->collection_description ?></p>
                    <a href="<?=PROOT.'collections'.DS.'show'.DS.$collection->id?>" class="btn-white">Discover</a>    
            </div>
        </div>
        <a href="<?=PROOT.'collections'.DS.'show'.DS.$collection->collection_slug?>" class="link-overlay"></a>
    </div>
    <!--End Single Collection-->
    
     <?php endforeach;?>		
    <?php else:?> 
    	<div class="no-items">There are no collections</div>
    <?php endif;?> 
</section>
<?php $this->end(); ?>