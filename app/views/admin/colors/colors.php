<?php $this->setSiteTitle('Product Colors'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="col-lg-6 offset-lg-3 mt-3">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Product Colors</h1>
      </div>
      <div class="heading">
      <a href="<?=PROOT?>admin/colors/add" class="btn main-btn">Add a color</a>
      </div>
      <?php if(count($this->colors) > 0): ?>
      <div class="table-responsive">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th>Color</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          	<?php foreach($this->colors as $color): ?>
            <tr>
              <td><?= $color->color_name; ?></td>
              <td class="text-right">
              	<a href="<?=PROOT?>admin/colors/edit/<?=$color->id?>" class="mini-btn">Edit</a>
              	<a href="<?=PROOT?>admin/colors/delete/<?=$color->id?>" class="mini-btn" onclick="if(!confirm('The color will be deleted permanently. Are you sure you want to delete?')){return false;}">Delete</a>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>  
  <h2 class="text-center">There are no colors.</h2>    
  <?php endif;?>
<div class="col-md-6 offset-md-3 mt-3">  
<?php $this->end(); ?>