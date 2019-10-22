<?php $this->setSiteTitle('Admin - Edit Page'); ?>
<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<!-- Add Form-->
<div class="col-lg-10 offset-lg-1 mt-3">
<h1 class="text-center">Edit Page</h1>
 <form class="form" action="<?=PROOT?>admin/pages/edit/<?=$this->page->id?>" method="POST">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
     <?= FH::displayErrors($this->displayErrors); ?>
     <div class="flex-fields"> 
     <?= FH::selectionBlock([
          'name' => 'page_type',
          'label' => 'Type',
          'options' => $this->pageTypes,
          'preselect' => [$this->page->page_type],
          'input_attrs' => ['class' => 'form-control'],
          'div_attrs' => ['class' => 'form-group']
 	]);?>
 	<?= FH::selectionBlock([
          'name' => 'in_menu',
          'label' => 'Add to footer menu',
          'options' => ['No'=>'0','Yes'=>'1'],
          'preselect' => [$this->page->in_menu],
          'input_attrs' => ['class' => 'form-control'],
          'div_attrs' => ['class' => 'form-group']
     ]);?>
     </div>
 	<?= FH::inputBlock('text','Title', 'title',$this->page->title, ['class' => 'form-control'], ['class' => 'form-group']);?>
    <?= FH::textAreaBlock('intro', ($this->page->intro !== null) ? $this->page->intro : "", 'Intro <span class="badge d-block">* Max 200 characters </span>', ['class' => 'form-control'], ['class' => 'form-group']);?>
    <label for="content">Content</label>
     <textarea id="summernote" name="content"><?= $this->page->content?></textarea>
     <br/>
    <?= FH::submitBlock('Update Page', ['class' => 'btn main-btn']) ?>	
 </form>
</div>	
<?php $this->end(); ?>
