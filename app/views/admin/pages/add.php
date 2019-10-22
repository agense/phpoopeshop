<?php $this->setSiteTitle('Admin - Add A Page'); ?>
<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<!-- Add Form-->
<div class="col-lg-10 offset-lg-1 mt-3">
<h1 class="text-center">Add A Page</h1>
 <form class="form" action="<?=PROOT?>admin/pages/add" method="POST">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
     <?= FH::displayErrors($this->displayErrors); ?>
     <div class="flex-fields">
     <?= FH::selectionBlock([
          'name' => 'page_type',
          'label' => 'Type',
          'options' => $this->pageTypes,
          'input_attrs' => ['class' => 'form-control'],
          'div_attrs' => ['class' => 'form-group']
 	]);?>
 	<?= FH::selectionBlock([
          'name' => 'in_menu',
          'label' => 'Add to footer menu',
          'options' => ['No'=>'0','Yes'=>'1'],
          'preselect' => ['No'],
          'input_attrs' => ['class' => 'form-control'],
          'div_attrs' => ['class' => 'form-group']
 	]);?>
     </div>
     <?= FH::inputBlock('text','Title', 'title','', ['class' => 'form-control'], ['class' => 'form-group']);?>
     <?= FH::textAreaBlock('intro', '', 'Intro <span class="badge d-block">* Max 200 characters </span>', ['class' => 'form-control'], ['class' => 'form-group']);?>
     <label for="content">Content</label>
     <textarea id="summernote" name="content"></textarea>
     <br/>
 	<?= FH::submitBlock('Create Page', ['class' => 'btn main-btn']) ?>	
 </form>
</div>	
<?php $this->end(); ?>
