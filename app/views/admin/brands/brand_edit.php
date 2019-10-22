<?php $this->start('head');?>
<?php $this->end(); ?>
<?php $this->start('body');?>
<div class="col-lg-6 offset-lg-3 mt-3">
<h1 class="text-center">Edit Brand</h1>
 <form class="form" action="<?=PROOT?>admin/brands/edit/<?=$this->brand->id?>" method="POST" enctype="multipart/form-data">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
  <?= FH::displayErrors($this->displayErrors); ?>
 	<?= FH::inputBlock('text','Brand Name', 'brand_name', $this->brand->brand_name, ['class' => 'form-control'], ['class' => 'form-group']);?>
 	 	<?= FH::selectionBlock([
          'name' => 'featured',
          'label' => 'Featured Brand',
          'options' => ['No'=>'0','Yes'=>'1'],
          'preselect' => [$this->brand->featured],
          'input_attrs' => ['class' => 'form-control'],
          'div_attrs' => ['class' => 'form-group']
 		]);?>

 	    <?php if($this->brand->brand_image): ?>
        <p>Featured Brand Image</p>
        <div class="medium-image-holder">
          <img src="<?= $this->brand->displayImage() ?>" alt="">
        </div>
         <span>Change Image</span>
        <?php else: ?>
         <span>Upload Image</span>
        <?php endif; ?> 	
 	<?= FH::uploadBlock('brand_image', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	<?= FH::submitBlock('Update Brand', ['class' => 'btn main-btn']) ?>	
 </form>
</div>	
<?php $this->end(); ?>
