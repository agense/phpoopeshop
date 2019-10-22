<?php $this->setSiteTitle('Admin - Add Category'); ?>
<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<!-- Add Form-->
<div class="col-lg-6 offset-lg-3 mt-3">
<h1 class="text-center">Add A Category</h1>
 <form class="form" action="<?=PROOT?>admin/categories/add" method="POST" enctype="multipart/form-data">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
     <?= FH::displayErrors($this->displayErrors); ?>
 	<?= FH::inputBlock('text','Category Name', 'category_name', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	<?= FH::selectionBlock([
          'name' => 'parent_category_id',
          'label' => 'Parent Category',
          'options' => $this->catparentoptions,
          'empty' => true,
          'input_attrs' => ['class' => 'form-control'],
          'div_attrs' => ['class' => 'form-group']
 	]);?>
 	<?= FH::textAreaBlock('category_description', '', 'Category Description', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	<?= FH::selectionBlock([
          'name' => 'featured',
          'label' => 'Featured Category',
          'options' => ['No'=>'0','Yes'=>'1'],
          'preselect' => ['No'],
          'input_attrs' => ['class' => 'form-control'],
          'div_attrs' => ['class' => 'form-group']
 	]);?>
 	<?= FH::uploadBlock('category_image', 'Category Image', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	<?= FH::submitBlock('Add Category', ['class' => 'btn main-btn']) ?>	
 </form>
</div>	
<?php $this->end(); ?>
