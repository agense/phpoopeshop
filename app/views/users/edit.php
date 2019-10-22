<?php $this->setSiteTitle('Order'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<section class="section">
    <div class="row">
         <?php $this->partial('', 'user-sidebar', []); ?> 

        <div class="col-md-9 my-5 account-content-holder">
            <div class="white-headline-holder">
                <h1 class="white-headline-md">Edit My Account</h1>
             </div>
                <form class="form" action="<?=PROOT.'users'.DS.'edit'.DS.$this->user->id?>" method="POST">
               <!-- Hidden field for token-->
                <?= FH::csrfInput();?>
                <!-- Display errors-->
                <?= FH::displayErrors($this->displayErrors); ?>
                <div class="grid-split">
                <div>  
                <?= FH::inputBlock('text','First Name', 'fname', $this->user->fname, ['class' => 'form-control'], ['class' => 'form-group']);?>
                <?= FH::inputBlock('text','Last Name', 'lname', $this->user->lname, ['class' => 'form-control'], ['class' => 'form-group']);?>
                <?= FH::inputBlock('email','Email', 'email', $this->user->email, ['class' => 'form-control'], ['class' => 'form-group']);?>
                <?= FH::inputBlock('text','Username', 'username', $this->user->email, ['class' => 'form-control'], ['class' => 'form-group']);?>
                <span class="badge">* Leave the field empty to keep the current password</span>
                <?= FH::inputBlock('password','Password', 'password',"", ['class' => 'form-control'], ['class' => 'form-group']);?>
                 <?= FH::inputBlock('password','Confirm Password', 'confirm', "", ['class' => 'form-control'], ['class' => 'form-group']);?>
                 </div>
                 <div>
                 <?= FH::inputBlock('text','Phone', 'phone', (isset($this->user->phone)) ? $this->user->phone : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
                 <?= FH::inputBlock('text','Address', 'address', (isset($this->user->address)) ? $this->user->address : "" , ['class' => 'form-control'], ['class' => 'form-group']);?>
                 <?= FH::inputBlock('text','City', 'city', (isset($this->user->city)) ? $this->user->city : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
                 <?= FH::inputBlock('text','Region', 'region', (isset($this->user->region)) ? $this->user->region : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
                 <?= FH::inputBlock('text','Postal Code', 'postal_code', (isset($this->user->postal_code)) ? $this->user->postal_code : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
                 <?= FH::inputBlock('text','Country', 'country', (isset($this->user->country)) ? $this->user->country : "", ['class' => 'form-control'], ['class' => 'form-group']);?>
                 <?= FH::submitBlock('Save Changes', ['class' => 'btn btn-golden'], ['class' => 'text-right']) ?>  
               </div>
               </div>
             </form>   
        </div>
    </div>
</section>
<?php $this->end(); ?>