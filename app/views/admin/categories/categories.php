
<?php $this->setSiteTitle('Categories'); ?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Categories</h1>
      </div>
      <div class="heading">
      <a href="<?=PROOT?>admin/categories/add" class="btn main-btn">Add a category</a>
      </div>
      <?php if(count($this->categories) > 0): ?>
      <div class="table-responsive">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th>Category Name</th>
              <th>Parent Category</th>
              <th>Category Image</th>
              <th class="text-center">Featured</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          	<?php foreach($this->categories as $category): ?>
            <tr>
              <td><a href="#" data-toggle="modal" onclick='detailsModal(<?= $this->objtoJson($category)?>);'><?= $category->category_name;?></a></td>
              <td>Top Category</td>
              <td>
                <div class="min-image-holder">
                <img src="<?= $category->displayImage() ?>" alt="">
                </div>
              </td>
              <td class="text-center">
                <?php $featured = ($category->featured == 1) ? TRUE : FALSE;?>
                <?= FH::checkboxBlock('','featured',$featured, ['class' => 'featured-checkbox', 'data-id' => $category->id], ['class' => 'form-group']);?> 
              </td>
              <td class="buttons text-right">
              	<a href="<?=PROOT?>admin/categories/edit/<?=$category->id?>" class="mini-btn">Edit</a>
              	<a href="<?=PROOT?>admin/categories/delete/<?=$category->id?>" class="mini-btn" onclick="if(!confirm('Delete this category?')){return false;}">Delete</a>
              </td>
            </tr>
             <?php if($category->subcategories): ?>
             <?php foreach($category->subcategories as $subcategory): ?> 
              <tr>
               <?php $this->objtoJson($subcategory)?>  
              <td><a href="#" data-toggle="modal" onclick='detailsModal(<?= $this->objtoJson($subcategory)?>);'><?= $subcategory->category_name; ?></a></td>
              <td><?= $category->category_name;?></td>
              <td><div class="min-image-holder">
                <img src="<?= $subcategory->displayImage() ?>" alt="">
                </div>
              </td>
              <td class="text-center">
                <?php $featured = ($subcategory->featured == 1) ? TRUE : FALSE;?>
                <?= FH::checkboxBlock('','featured',$featured, ['class' => 'featured-checkbox', 'data-id' => $subcategory->id], ['class' => 'form-group']);?> 
              </td>
              <td class="text-right">
                <a href="<?=PROOT?>admin/categories/edit/<?=$subcategory->id?>" class="mini-btn">Edit</a>
                <a href="<?=PROOT?>admin/categories/delete/<?=$subcategory->id?>" class="mini-btn" onclick="if(!confirm('Delete this category?')){return false;}">Delete</a>
              </td>
            </tr>
             <?php endforeach;?>
             <?php endif;?>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <h2 class="text-center">There are no categories.</h2>    
  <?php endif;?>
<?php $this->partial('admin', 'category_modal');?>
<?php $this->end(); ?>
