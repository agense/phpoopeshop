<?php $this->setSiteTitle('Deleted Administrators'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="py-3 mb-3">
      <h1>Deleted Administrators</h1>
      <div class="alert hide mt-2" id="result-alert"></div>
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
              <td class="text-right d-flex justify-content-end">
              	<a href="#" class="mini-btn restore-deleted mr-2" data-target="<?= $admin->id?>">Restore</a>
                <form action="<?=PROOT?>admin/administrators/finalDelete/" method="post">
                <input type="hidden" name="id" value="<?=$admin->id?>">
                <button type="submit" class="mini-btn" onclick="if(!confirm('Administrator will be deleted permanently. Are you sure you want to delete?')){return false;}">Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <div class="border-bottom"></div>
  <h2 class="text-center mt-5">There are no deleted administrators.</h2>    
  <?php endif;?>
<?php $this->end(); ?>