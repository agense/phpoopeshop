<?php $this->setSiteTitle('Product Materials'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
      <div class="col-lg-6 offset-lg-3 mt-3">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Product Materials</h1>
      </div>
      <div class="heading">
      <a href="<?=PROOT?>admin/materials/add" class="btn main-btn">Add a material</a>
      </div>
      <?php if(count($this->materials) > 0): ?>
      <div class="table-responsive">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th>Material</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          	<?php foreach($this->materials as $material): ?>
            <tr>
              <td><?= $material->material_name; ?></td>
              <td class="text-right">
              	<a href="<?=PROOT?>admin/materials/edit/<?=$material->id?>" class="mini-btn">Edit</a>
              	<a href="<?=PROOT?>admin/materials/delete/<?=$material->id?>" class="mini-btn" onclick="if(!confirm('The material will be deleted permanently. Are you sure you want to delete?')){return false;}">Delete</a>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <h2 class="text-center">There are no materials.</h2>    
  <?php endif;?>
</div>
<?php $this->end(); ?>