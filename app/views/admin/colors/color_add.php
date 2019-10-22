<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<div class="col-lg-6 offset-lg-3 mt-3">
<h1 class="text-center">Add A Color</h1>
 <form class="form" action="<?=PROOT?>admin/colors/add" method="POST">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
    <?= FH::displayErrors($this->displayErrors); ?>
 	<?= FH::inputBlock('text','Color Name', 'color_name', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	<?= FH::submitBlock('Add Color', ['class' => 'btn main-btn']) ?>	
 </form>
</div>	
<?php $this->end(); ?>