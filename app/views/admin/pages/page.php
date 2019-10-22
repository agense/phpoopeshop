<?php $this->setSiteTitle('Page'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<section class="single-item-holder my-5">
<h1><?= $this->page->title?></h1>
<div class="content-holder mt-5">    
<?php if($this->page->intro != "" || $this->page->intro != null): ?>
  <p class="lead"><?= $this->page->intro ?></p> 
  <div class="dark-separator my-4"></div> 
<?php endif;?>    
<div class="description"><?= $this->page->content ?></div>
<div class="d-flex justify-content-between align-items-center  mt-5">
<div><a href="<?=PROOT?>admin/pages?>" class="btn main-btn-dark">Back</a></div>	
<div class="buttons text-right">
    <a href="<?=PROOT?>admin/pages/edit/<?=$this->page->id?>" class="btn main-btn">Edit</a>
    <a href="<?=PROOT?>admin/pages/delete/<?=$this->page->id?>" class="btn main-btn-dark" onclick="if(!confirm('Are you sure you want to delete this page?')){return false;}">Delete</a>
</div>
</div>
</div>
</section>    
<?php $this->end(); ?>