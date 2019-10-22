<?php $this->setSiteTitle('Deleted Collections'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="py-3 mb-3">
      <h1>Deleted Collections</h1>
      <div class="alert hide mt-2" id="result-alert"></div>
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
              <th class="text-right"></th>
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
                <?php 
                $items = $collection->collection_items  ? count(explode(',', $collection->collection_items)) : 0; ?>
                <?=  $items ?>
              </td>
              <td class="text-right d-flex">
              	<a href="#" class="mini-btn restore-deleted mr-2" data-target="<?= $collection->id?>">Restore</a>
                <form action="<?=PROOT?>admin/collections/finalDelete/" method="post">
                <input type="hidden" name="id" value="<?=$collection->id?>">
                <button type="submit" class="mini-btn" onclick="if(!confirm('The collection will be deleted permanently. Are you sure you want to delete?')){return false;}">Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <div class="border-bottom"></div>
  <h2 class="text-center mt-5">There are no deleted collections.</h2>    
  <?php endif;?>
<?php $this->end(); ?>