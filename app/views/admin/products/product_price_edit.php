<?php $this->setSiteTitle('Admin - Edit Product Price'); ?>
<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<!-- Add Form-->
<div class="col-lg-10 offset-lg-1 mt-3">
<h1 class="text-center">Modify Price </h1>
<div class="row">
  <div class="col-lg-6 offset-lg-3 mt-3">
  <h2><?= $this->product->product_name; ?></h2> 
  <p>Code: <?= $this->product->product_code; ?></p>
 <form class="form" action="<?=PROOT?>admin/products/editPrice/<?=$this->product->id?>" method="POST" id="price-change-form">
              <!-- Hidden field for token-->
              <?= FH::csrfInput();?>
              <!-- Display errors-->
              <?= FH::displayErrors($this->displayErrors);?>
               <?= FH::inputBlock('text', 'Initial Price', 'product_price', $this->product->product_price, ['class' => 'form-control'], ['class' => 'form-group']);?> 
               <?=FH::selectionBlock([
                    'name' => 'product_discount_type',
                    'label' => 'Discount Type',
                    'options' => $this->dicountTypes,
                    'preselect' =>  [$this->product->product_discount_type],
                    'input_attrs' => ['class' => 'form-control'],
                    'div_attrs' => ['class' => 'form-group edit']
               ]);?>
               <?php 
               $discountValue = ($this->product->product_discount_type == 1) ? $this->product->discount_amount : 
               $this->product->discount_percentage;
               ?>
               <?= FH::inputBlock('text', 'Discount', 'discount_amount', $discountValue, ['class' => 'form-control'], ['class' => 'form-group']);?> 
               <span class="form-comment">
                * Set discount exact amount or percentage (positive value).<br>
                * To remove a discount, set value to 0.
               </span>
               <?= FH::inputBlock('text', 'Discounted Price', 'discounted_price', $this->product->product_price_discounted, ['class' => 'form-control', 'disabled' => 'disabled'], ['class' => 'form-group']);?> 
 	            <?= FH::submitBlock('Save Changes', ['class' => 'btn main-btn']) ?>	
 </form>
   </div>
 </div>
</div>	
<?php $this->end(); ?>
