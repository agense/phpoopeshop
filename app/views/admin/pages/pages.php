
<?php $this->setSiteTitle('Pages'); ?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Pages</h1>
      </div>
      <div class="heading">
      <a href="<?=PROOT?>admin/pages/add" class="btn main-btn">Add a page</a>
      </div>
      <div class="error-display"></div> 
      <?php if(count($this->pages) > 0): ?>
      <div class="table-responsive">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th>Title</th>
              <th>Slug</th>
              <th>Type</th>
              <th class="text-center">Menu Page</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          	<?php foreach($this->pages as $page): ?>
            <tr>
              <td><a href="#"><?= $page->title;?></a></td>
              <td><?= $page->slug;?></td>
              <td><?= $page->getPageType(); ?></td>
              <td class="text-center">
                <?php $inMenu = ($page->in_menu == 1) ? TRUE : FALSE;?>
                <?= FH::checkboxBlock('', 'in_menu', $inMenu, ['class' => 'in-menu-checkbox', 'data-id' => $page->id], ['class' => 'form-group']);?> 
              </td>
              <td class="buttons text-right">
                <a href="<?=PROOT?>admin/pages/show/<?=$page->id?>" class="mini-btn success-btn">View Page</a>
              	<a href="<?=PROOT?>admin/pages/edit/<?=$page->id?>" class="mini-btn">Edit</a>
              	<a href="<?=PROOT?>admin/pages/delete/<?=$page->id?>" class="mini-btn" onclick="if(!confirm('Are you sure you want to delete this page?')){return false;}">Delete</a>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <h2 class="text-center">There are no pages.</h2>    
  <?php endif;?>
<?php $this->end(); ?>
