<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<div class="col-lg-6 offset-lg-3 mt-3">
<h1 class="text-center">Edit Material</h1>
 <form class="form" action="<?=PROOT?>admin/materials/edit/<?=$this->material->id?>" method="POST">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
  <?= FH::displayErrors($this->displayErrors); ?>
 	<?= FH::inputBlock('text','Material Name', 'material_name', $this->material->material_name, ['class' => 'form-control'], ['class' => 'form-group']);?>
 	<?= FH::submitBlock('Update Material', ['class' => 'btn main-btn']) ?>	
 </form>
</div>	
<?php $this->end(); ?>