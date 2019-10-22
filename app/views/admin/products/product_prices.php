<?php $this->setSiteTitle('Products'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Manage Product Prices</h1>
      </div>
      <?php if(count($this->products) > 0): ?>
      <div class="table-responsive">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th>Code</th>
              <th>Name</th>
              <th>Brand</th>
              <th class="text-center">Price</th>
              <th class="text-center">Discount Price</th>
              <th class="text-center">Discount (<?= CURRENCY ?>)</th>
              <th class="text-center">Discount (%)</th>
              <th class="text-right">Update Price</th>
            </tr>
          </thead>
          <tbody id="quantity-updater">
          	<?php foreach($this->products as $product): ?>
            <tr>
              <td><?= $product->product_code; ?></td>
              <td><?= $product->product_name; ?></td>
              <td><?= $product->product_brand; ?></td>
              <td class="text-center"><?= Helpers::formatPrice($product->product_price); ?></td>
              <td class="text-center">
                <?php 
                $dicounted_price = ($product->product_price_discounted) ? Helpers::formatPrice($product->product_price_discounted) : '-'; 
                ?>
                <?= $dicounted_price; ?>
                </td>
              <td class="text-center">
                <?php 
                $discount_amount = ($product->discount_amount) ? Helpers::formatPrice($product->discount_amount) : '-'; 
                ?>
                <?= $discount_amount; ?></td>
              <td class="text-center">
                <?php
                $discount_percentage = ($product->discount_percentage) ? round($product->discount_percentage, 2, PHP_ROUND_HALF_UP).'%' : '-'; 
                ?>
                 <?= $discount_percentage; ?></td> 
                </td>
              <td class="text-right"><a href="<?=PROOT?>admin/products/editPrice/<?=$product->id?>" class="mini-btn">Update</a></td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <h2 class="text-center">There are no products.</h2>    
  <?php endif;?>
<?php $this->end(); ?>