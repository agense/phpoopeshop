<?php $this->start('head');?>
<?php $this->end(); ?>
<?php $this->start('body');?>
<section class="background-section">
<div class="left-col col-lg-4 col-md-7 col-sm-12">	
<div class="form-holder d-flex justify-content-center align-items-center py-5">	
<div class="access-form">
<h1 class="heading-white-lg mb-5">Register</h1>	
 <form class="form" action="<?=PROOT?>register/register" method="POST">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
 	<?= FH::displayErrors($this->displayErrors); ?>
 	<!-- Form Fields-->
 	<?= FH::inputBlock('text','First Name', 'fname', $this->newUser->fname, ['class'=>'form-control input-sm'], ['class' => 'form-group'])?>
 	<?= FH::inputBlock('text','Last Name', 'lname', $this->newUser->lname, ['class'=>'form-control input-sm'], ['class' => 'form-group'])?>
 	<?= FH::inputBlock('text','Email', 'email', $this->newUser->email, ['class'=>'form-control input-sm'], ['class' => 'form-group'])?>
 	<?= FH::inputBlock('text','Username', 'username', $this->newUser->username, ['class'=>'form-control input-sm'], ['class' => 'form-group'])?>
 	<?= FH::inputBlock('password','Password', 'password', $this->newUser->password, ['class'=>'form-control input-sm'], ['class' => 'form-group'])?>
 	<?= FH::inputBlock('password','Confirm Password', 'confirm', $this->newUser->getConfirm(), ['class'=>'form-control input-sm'], ['class' => 'form-group'])?>
 	<?= FH::submitBlock('Register', ['class' => 'btn btn-golden w-100 mt-3']) ?>
 </form>
</div>
</div>
</div>
</section>
<?php $this->end(); ?>