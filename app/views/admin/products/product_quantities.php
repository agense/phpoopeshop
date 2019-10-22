<?php $this->setSiteTitle('Products'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Set Quantities</h1>
      </div>
      <?php if(count($this->products) > 0): ?>
      <div class="table-responsive">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th>Code</th>
              <th>Name</th>
              <th>Category</th>
              <th>Brand</th>
              <th class="text-center">Quantity</th>
              <th>Update Quantity</th>
            </tr>
          </thead>
          <tbody id="quantity-updater">
          	<?php foreach($this->products as $product): ?>
            <tr>
              <td><?= $product->product_code; ?></td>
              <td><?= $product->product_name; ?></td>
              <td><?= $product->product_category; ?></td>
              <td><?= $product->product_brand; ?></td>
              <td class="text-center">
                <span class="quantity-display"><?= $product->product_quantity; ?></span>
                <span class="quantity-message"></span>  
                </td>
              <td>
                <form action="#" method="POST" class="mini-form d-flex align-items-baseline justify-content-start">
                  <!-- Hidden field for token-->  
                  <?= FH::csrfInput();?>
                  <?= FH::inputBlock('number','', 'product_quantity', '', ['class' => 'form-control','min'=>'1', 'placeholder' => 'Quantity', 'data-id' => $product->id], ['class' => 'form-group']);?>
                    <?= FH::inputBlock('hidden','','id', $product->id);?>
                  <?= FH::submitBlock('Save', ['class' => 'mini-btn']) ?>
                </form>  
                </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <h2 class="text-center">There are no products.</h2>    
  <?php endif;?>
<?php $this->partial('admin', 'product_modal');?>  
<?php $this->end(); ?>