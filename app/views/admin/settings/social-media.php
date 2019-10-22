<?php $this->setSiteTitle('Settings - Social Media'); ?>
<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<!-- Add Form-->
<div class="col-lg-6 offset-lg-3 mt-3">
<h1 class="text-center">Set Social Media</h1>
 <form class="form" action="<?=PROOT?>admin/settings/socialMedia" method="POST">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
     <?= FH::inputBlock('text','Facebook', 'facebook', (isset($this->settings->facebook)) ? $this->settings->facebook : "", ['class' => 'form-control'], ['class' => 'form-group']);?>

     <?= FH::inputBlock('text','Instagram', 'instagram', (isset($this->settings->instagram)) ? $this->settings->instagram : "", ['class' => 'form-control'], ['class' => 'form-group']);?>

     <?= FH::inputBlock('text','Twitter', 'twitter', (isset($this->settings->twitter)) ? $this->settings->twitter : "", ['class' => 'form-control'], ['class' => 'form-group']);?>

     <?= FH::inputBlock('text','Pinterest', 'pinterest', (isset($this->settings->pinterest)) ? $this->settings->pinterest : "", ['class' => 'form-control'], ['class' => 'form-group']);?>

     <?= FH::inputBlock('text','Google+', 'gplus', (isset($this->settings->gplus)) ? $this->settings->gplus : "", ['class' => 'form-control'], ['class' => 'form-group']);?>

     <?= FH::inputBlock('text','Youtube', 'youtube', (isset($this->settings->youtube)) ? $this->settings->youtube : "", ['class' => 'form-control'], ['class' => 'form-group']);?>

     <?= FH::inputBlock('text','Tumblr', 'tumblr', (isset($this->settings->tumblr)) ? $this->settings->tumblr : "", ['class' => 'form-control'], ['class' => 'form-group']);?>

 	<?= FH::submitBlock('Save Settings', ['class' => 'btn main-btn']) ?>	
 </form>
</div>	
<?php $this->end(); ?>