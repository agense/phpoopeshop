<?php $this->setSiteTitle('Page'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<section class="section-narrow">
<div class="white-headline-holder">
   <h1 class="white-headline-md"><?= $this->page->title?></h1>
</div>

<div class="content-holder">    
<?php if($this->page->intro != "" || $this->page->intro != null): ?>
  <p class="lead mt-5"><?= $this->page->intro ?></p> 
  <div class="light-separator my-3"></div> 
<?php endif;?>    
<div class="description"><?= $this->page->content?></div>
</div>
</section>    
<?php $this->end(); ?>