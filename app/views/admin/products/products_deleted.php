<?php $this->setSiteTitle('Deleted Products'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="py-3 mb-3">
      <h1>Deleted Products</h1>
      <div class="alert hide mt-2" id="result-alert"></div>
</div>
      <?php if(count($this->products) > 0): ?>
      <div class="table-responsive">
        <table class="table table-sm table-hover">
           <thead>
            <tr>
              <th>Image</th>
              <th>Code</th>
              <th>Name</th>
              <th>Category</th>
              <th>Brand</th>
              <th>Material</th>
              <th>Color</th>
              <th class="text-center">Quantity</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          	<?php foreach($this->products as $product): ?>
            <tr>
              <td><div class="min-image-holder">
                <img src="<?= $product->displayImage() ?>" alt="">
                </div>
              </td>
              <td><?= $product->product_code; ?></td>
              <td><?= $product->product_name; ?></td>
              <td><?= $product->product_category; ?></td>
              <td><?= $product->product_brand; ?></td>
              <td><?= $product->product_material; ?></td>
              <td><?= $product->product_color; ?></td>
              <td class="text-center"><?= $product->product_quantity; ?></td>
              <td class="text-right d-flex">
              	<a href="#" class="mini-btn restore-deleted mr-2" data-target="<?= $product->id?>">Restore</a>
                <form action="<?=PROOT?>admin/products/finalDelete/" method="post">
                <input type="hidden" name="id" value="<?=$product->id?>">
                <button type="submit" class="mini-btn" onclick="if(!confirm('The product will be deleted permanently. Are you sure you want to delete?')){return false;}">Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <hr/>  
  <h2 class="text-center mt-5">There are no deleted products.</h2>    
  <?php endif;?>
<?php $this->end(); ?>