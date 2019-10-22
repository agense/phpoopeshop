<?php $this->setSiteTitle('Settings - Contact Info'); ?>
<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<!-- Add Form-->
<div class="col-lg-6 offset-lg-3 mt-3">
<h1 class="text-center">Set Conatct Info</h1>
 <form class="form" action="<?=PROOT?>admin/settings/contactInfo" method="POST">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<?= FH::inputBlock('email','Customer Service Email', 'email', (isset($this->settings->email)) ? $this->settings->email : "" , ['class' => 'form-control'], ['class' => 'form-group']);?>
     <?= FH::inputBlock('email','Additional Email', 'second_email', (isset($this->settings->second_email)) ? $this->settings->second_email : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
     <?= FH::inputBlock('text','Phone', 'phone', (isset($this->settings->phone)) ? $this->settings->phone : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
     <?= FH::inputBlock('text','Additional Phone', 'second_phone', (isset($this->settings->second_phone)) ? $this->settings->second_phone : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
     <p><strong>Office Address</strong></p><hr/>
     <?= FH::inputBlock('text','Address', 'address', (isset($this->settings->address)) ? $this->settings->address : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
     <div class="side-flex">
     <?= FH::inputBlock('text','City', 'city', (isset($this->settings->city)) ? $this->settings->city : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
     <?= FH::inputBlock('text','Region', 'region', (isset($this->settings->region)) ? $this->settings->region : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
    </div>
     <div class="side-flex">
     <?= FH::inputBlock('text','Country', 'country', (isset($this->settings->country)) ? $this->settings->country : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
     <?= FH::inputBlock('text','Postal Code', 'postal_code', (isset($this->settings->postal_code)) ? $this->settings->postal_code : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
    </div>
 	<?= FH::submitBlock('Save Settings', ['class' => 'btn main-btn']) ?>	
 </form>
</div>	
<?php $this->end(); ?>