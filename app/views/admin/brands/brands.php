<?php $this->setSiteTitle('Brands'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Brands</h1>
      </div>
      <div class="heading">
      <a href="<?=PROOT?>admin/brands/add" class="btn main-btn">Add a brand</a>
      </div>
      <?php if(count($this->brands) > 0): ?>
      <div class="table-responsive">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th>Brand Name</th>
              <th>Brand Image</th>
              <th class="text-center">Featured</th>
              <th class="text-right"></th>
            </tr>
          </thead>
          <tbody>
          	<?php foreach($this->brands as $brand): ?>
            <tr>
              <td><?= $brand->brand_name; ?></td>
              <td>
                <div class="min-image-holder">
                <img src="<?= $brand->displayImage() ?>" alt="">
                </div>
              </td>
              <td class="text-center">
              <?php $featured = ($brand->featured == 1) ? TRUE : FALSE;?>
                <?= FH::checkboxBlock('','featured',$featured, ['class' => 'featured-checkbox', 'data-id' => $brand->id], ['class' => 'form-group']);?> 
              </td>
              <td class="text-right">
              	<a href="<?=PROOT?>admin/brands/edit/<?=$brand->id?>" class="mini-btn">Edit</a>
              	<a href="<?=PROOT?>admin/brands/delete/<?=$brand->id?>" class="mini-btn" onclick="if(!confirm('The brand will be deleted permanently. Are you sure you want to delete?')){return false;}">Delete</a>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <h2 class="text-center">There are no brands.</h2>    
  <?php endif;?>
<?php $this->end(); ?>