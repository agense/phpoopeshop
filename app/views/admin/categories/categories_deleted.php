<?php $this->setSiteTitle('Deleted Categories'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="py-3 mb-3">
      <h1>Deleted Categories</h1>
      <hr/>
      <div class="alert hide mt-2" id="result-alert"></div>
</div>
      <?php if(count($this->categories) > 0): ?>
      <div class="table-responsive">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Parent Category</th>
              <th>Description</th>
              <th>Image</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          	<?php foreach($this->categories as $category): ?>
            <tr>
              <td><?= $category->category_name; ?></td>
              <td><?= $category->parent_category_name; ?></td>
              <td><?= $category->category_description; ?></td>
              <td>
                <div class="min-image-holder">
                    <img src="<?= $category->displayImage() ?>" alt="">
                </div>
              </td>
              <td class="text-right d-flex">
              	<a href="#" class="mini-btn restore-deleted mr-2" data-target="<?= $category->id?>">Restore</a>
                <form action="<?=PROOT?>admin/categories/finalDelete/" method="post">
                <input type="hidden" name="id" value="<?=$category->id?>">
                <button type="submit" class="mini-btn" onclick="if(!confirm('The category will be deleted permanently. Are you sure you want to delete?')){return false;}">Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <h2 class="text-center">There are no deleted categories.</h2>    
  <?php endif;?>
<?php $this->end(); ?>