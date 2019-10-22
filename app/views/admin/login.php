<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<div class="col-lg-6 offset-lg-3 mt-3">
<h1 class="text-center">Admin Login</h1>
 <form class="form" action="<?=PROOT?>admin/access/login" method="POST">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
    <?= FH::displayErrors($this->displayErrors); ?>
 	<?= FH::inputBlock('text','Username', 'username', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
    <?= FH::inputBlock('password','Password', 'password', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	<?= FH::submitBlock('Login', ['class' => 'btn btn-primary btn-large']) ?>
 </form>
</div>	
<?php $this->end(); ?>
