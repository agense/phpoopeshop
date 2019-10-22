<?php $this->start('head');?>
<?php $this->end(); ?>
<?php $this->start('body');?>
<section class="background-section">
<div class="left-col col-lg-4 col-md-7 col-sm-12">	
<div class="form-holder d-flex justify-content-center align-items-center">	
<div class="access-form">
<h1 class="heading-white-lg mb-5">Login</h1>	
 <form class="form" action="<?=PROOT?>register/login" method="POST">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
    <?= FH::displayErrors($this->displayErrors); ?>
 	<?= FH::inputBlock('text','Username', 'username', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
    <?= FH::inputBlock('password','Password', 'password', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
    <?= FH::checkboxBlock('Remember Me','remember','', [], ['class' => 'form-group']);?>
 	<?= FH::submitBlock('Login', ['class' => 'btn btn-golden w-100 mt-2']) ?>
 </form>
  	<div class="text-right">
 		<a href="<?=PROOT?>register/register" class="btn btn-golden-inverse w-100 mt-3">Register</a>
 	</div>
</div>
</div>
</div>
</section>
<?php $this->end(); ?>
