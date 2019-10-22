<?php $this->setSiteTitle('Administrators'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Administrators</h1>
      </div>
      <div class="heading">
      <a href="<?=PROOT?>admin/administrators/add" class="btn main-btn">Add Administrator</a>
      </div>
      <?php if(count($this->admins) > 0): ?>
      <div class="table-responsive">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Userame</th>
              <th>Email</th>
              <th>Roles</th>
              <th class="text-right"></th>
            </tr>
          </thead>
          <tbody>
          	<?php foreach($this->admins as $admin): ?>
            <tr>
              <td><?= $admin->name; ?></td>
              <td><?= $admin->username; ?></td>
              <td><?= $admin->email; ?></td>
              <td>
                  <?php foreach($admin->roles as $role): ?>
                  <?= $role ?> | 
                  <?php endforeach ?>
              </td>
              <td class="text-right">
              	<a href="<?=PROOT?>admin/administrators/edit/<?=$admin->id?>" class="mini-btn">Edit</a>
              	<a href="<?=PROOT?>admin/administrators/delete/<?=$admin->id?>" class="mini-btn" onclick="if(!confirm('Delete this administrator?')){return false;}">Delete</a>
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