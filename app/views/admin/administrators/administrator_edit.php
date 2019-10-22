<?php $this->start('head');?>
<?php $this->end(); ?>
<?php $this->start('body');?>
<div class="col-lg-6 offset-lg-3 mt-3">
<h1 class="text-center">Edit Administrator</h1>
 <form class="form" action="<?=PROOT?>admin/administrators/edit/<?=$this->admin->id?>" method="POST">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
    <?= FH::displayErrors($this->displayErrors); ?>
    <?= FH::inputBlock('text','First Name', 'fname', $this->admin->fname, ['class' => 'form-control'], ['class' => 'form-group']);?>
    <?= FH::inputBlock('text','Last Name', 'lname', $this->admin->lname, ['class' => 'form-control'], ['class' => 'form-group']);?>
    <?= FH::inputBlock('text','Email', 'email', $this->admin->email, ['class' => 'form-control'], ['class' => 'form-group']);?>
    <?= FH::inputBlock('text','Username', 'username', $this->admin->username, ['class' => 'form-control'], ['class' => 'form-group']);?>
    <?= FH::inputBlock('password','Password', 'password', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
    <p class="mt-3">Roles:</p>
    <?= FH::groupedCheckboxBlock([
      'name' => 'acl',
      'checkboxes' => $this->adminRoles,
      'checked' => $this->admin->roles,
      'multiple' => true,
      'input_attrs' => ['class' => 'd-block'],
      'div_attrs' => ['class' => 'form-group'],
      ]); 
     ?>
 	<?= FH::submitBlock('Edit Administrator', ['class' => 'btn main-btn']) ?>	
 </form>
</div>	
<?php $this->end(); ?>
