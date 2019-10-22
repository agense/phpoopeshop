<?php $this->start('head');?>
<?php $this->end(); ?>
<?php $this->start('body');?>
<div class="col-lg-6 offset-lg-3 mt-3">
<h1 class="text-center">Add A Brand</h1>
 <form class="form" action="<?=PROOT?>admin/brands/add" method="POST" enctype="multipart/form-data">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
    <?= FH::displayErrors($this->displayErrors); ?>
 	<?= FH::inputBlock('text','Brand Name', 'brand_name', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	 	<?= FH::selectionBlock([
          'name' => 'featured',
          'label' => 'Featured Brand',
          'options' => ['No'=>'0','Yes'=>'1'],
          'preselect' => ['No'],
          'input_attrs' => ['class' => 'form-control'],
          'div_attrs' => ['class' => 'form-group']
 		]);?>
 	<?= FH::uploadBlock('brand_image', 'Brand Image', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	<?= FH::submitBlock('Add Brand', ['class' => 'btn main-btn']) ?>	
 </form>
</div>	
<?php $this->end(); ?>
