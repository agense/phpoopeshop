<?php $this->setSiteTitle('Products'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Products</h1>
      </div>
      <div class="heading">
      <a href="<?=PROOT?>admin/products/add" class="btn main-btn">Add a Product</a>
      <a href="<?=PROOT?>admin/products/quantities" class="btn main-btn">Update Quantities</a>
      <a href="<?=PROOT?>admin/products/prices" class="btn main-btn">Manage Prices</a>
      <a href="<?=PROOT?>admin/products/deleted" class="btn main-btn">Deleted Products</a>
      </div>
      <?php if(count($this->products) > 0): ?>
      <div class="error-display"></div>  
      <div class="table-responsive">
        <table class="table table-sm table-min table-hover">
          <thead>
            <tr>
              <th>Image</th>
              <th>Code</th>
              <th>Name</th>
              <th>Category</th>
              <th>Brand</th>
              <th>Material</th>
              <th>Color</th>
              <th class="text-center">QTY</th>
              <th >Featured</th>
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
              <td><a href="#" onclick='productModal(<?= $this->objtoJson($product)?>);'>
                <?= $product->product_name; ?></a>
              </td>
              <td><?= $product->product_category; ?></td>
              <td><?= $product->product_brand; ?></td>
              <td><?= $product->product_material; ?></td>
              <td><?= $product->product_color; ?></td>
              <td class="text-center"><?= $product->product_quantity; ?></td>
              <td class="text-center">
                <?php $featured = ($product->featured == 1) ? TRUE : FALSE;?>
                <?= FH::checkboxBlock('','featured',$featured, ['class' => 'featured-checkbox', 'data-id' => $product->id], ['class' => 'form-group']);?> 
                </td>
              <td class="control-btns">
              	<a href="<?=PROOT?>admin/products/edit/<?=$product->id?>" class="mini-btn">Edit</a>
              	<a href="<?=PROOT?>admin/products/delete/<?=$product->id?>" class="mini-btn" onclick="if(!confirm(' Are you sure you want to delete the product?')){return false;}">Delete
                </a>
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