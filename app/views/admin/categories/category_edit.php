
<?php $this->setSiteTitle('Admin - Edit Category'); ?>
<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<!-- Add Form-->
<div class="col-lg-6 offset-lg-3 mt-3">
<h1 class="text-center">Edit Category</h1>
 <form class="form" action="<?=PROOT?>admin/categories/edit/<?=$this->category->id?>" method="POST" enctype="multipart/form-data">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
  <?= FH::displayErrors($this->displayErrors); ?>
 	<?= FH::inputBlock('text','Category Name', 'category_name', $this->category->category_name, ['class' => 'form-control'], ['class' => 'form-group']);?>
 	<?= FH::selectionBlock([
          'name' => 'parent_category_id',
          'label' => 'Parent Category',
          'options' => $this->catparentoptions,
          'preselect' => [$this->category->parent_category_id],
          'input_attrs' => ['class' => 'form-control'],
          'div_attrs' => ['class' => 'form-group']
 	]);?>
 	<?= FH::textAreaBlock('category_description', $this->category->category_description, 'Category Description', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	<?= FH::selectionBlock([
          'name' => 'featured',
          'label' => 'Featured Category',
          'options' => ['No'=>'0','Yes'=>'1'],
          'preselect' => [$this->category->featured],
          'input_attrs' => ['class' => 'form-control'],
          'div_attrs' => ['class' => 'form-group']
 	]);?>
 	    <?php if($this->category->category_image): ?>
        <p>Featured Category Image</p>
        <div class="medium-image-holder">
          <img src="<?= $this->category->displayImage() ?>" alt="">
        </div>
        <div class="img-uploader-block">
         <span>Change Image</span>
        <?php else: ?>
         <span>Upload Image</span>
        <?php endif; ?> 	
 	      <?= FH::uploadBlock('category_image', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
        </div>
 	<?= FH::submitBlock('Update Category', ['class' => 'btn main-btn']) ?>	
 </form>
</div>	
<?php $this->end(); ?>

