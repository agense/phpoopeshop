<?php $this->setSiteTitle('Collections'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Collections</h1>
      </div>
      <div class="heading">
      <a href="<?=PROOT?>admin/collections/add" class="btn main-btn">Create A Collection</a>
      </div>
      <?php if(count($this->collections) > 0): ?>
      <div class="table-responsive">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th>Image</th>
              <th class="text-center">Products In</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          	<?php foreach($this->collections as $collection): ?>
            <tr>
              <td><?= $collection->collection_name; ?></td>
              <td><?= $collection->collection_description; ?></td>
              <td>
                <div class="min-image-holder">
                <img src="<?= $collection->displayImage() ?>" alt="">
                </div>
              </td>
              <td class="text-center">
              	<?= count($collection->collection_items); ?>
              </td>
              <td>
                <div class="table-btns">
              	<a href="<?=PROOT?>admin/collections/edit/<?=$collection->id?>" class="mini-btn">Edit</a>
              	<a href="<?=PROOT?>admin/collections/delete/<?=$collection->id?>" class="mini-btn">Delete</a>
                 </div>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <h2 class="text-center">There are no Collections.</h2>    
  <?php endif;?>
<?php $this->end(); ?>