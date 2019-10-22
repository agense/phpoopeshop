<?php $this->setSiteTitle('Order'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<?php $user = $this->user; ?>
<section class="section">
    <div class="row">
        <?php $this->partial('', 'user-sidebar', []); ?> 
        <div class="col-md-9 my-5 account-content-holder">   
            <div>
            <div class="white-headline-holder">
                <h1 class="white-headline-md">My Account</h1>
             </div>   
            <div class="row">
            <div class="col-lg-7">
                <div class="card border-secondary mb-3">
                   <div class="card-header">MY PROFILE</div>
                   <div class="card-body">
                       <p class="card-text"><i class="fi fi-male"></i> <?= $user->fname?> <?= $user->lname?></p>
                       <p class="card-text"><i class="fi fi-envelope"></i> <?=$user->email?></p>
                       <?php if(isset($user->phone) && $user->phone != null): ?>
                       <p class="card-text"><i class="fi fi-mobile"></i> <?= $user->phone ?></p>
                       <?php endif; ?>
                       <?php if(isset($user->address) && $user->address != null): ?>
                       <p class="card-text"><span>ADDRESS:</span></p>
                       <p class="card-text">
                           <span><?= $user->address ?></span><br/>
                            <?php if($user->city != null): ?>
                                <span><?= $user->city?>, </span>
                            <?php endif; ?>
                            <?php if($user->region != null): ?>
                                <span><?= $user->region ?></span><br/>
                            <?php endif;?>
                            <?php if($user->country != null): ?>
                                <span><?= $user->country ?>, </span>
                            <?php endif;?>
                            <?php if($user->postal_code != null): ?>
                                <span><?= $user->postal_code ?> </span>
                            <?php endif;?>
                       </p>
                       <?php endif; ?>
                       <div class="mt-4 w-100">
                            <a href="<?= PROOT.DS.'users'.DS.'edit'.DS.$user->id ?>" class="btn btn-golden btn-md">Edit Profile</a>
                       </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-secondary mb-3">
                   <div class="card-header">MY ORDERS</div>
                   <div class="card-body">
                        <div class="bs-component">
                                <ul class="list-group">
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Total Orders:</span>
                                    <span class="badge badge-secondary"><?= $this->totalOrders ?></span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Completed:</span>
                                    <span class="badge badge-success"><?= $this->completedOrders ?></span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                   <span>In Process:</span>
                                   <span class="badge badge-warning"><?= $this->inProcessOrders ?></span>
                                  </li>
                                </ul>
                                <div class="mt-4 w-100">
                                    <a href="" class="btn btn-golden btn-md">View Orders</a>
                                </div>
                  </div>
                </div>
            </div>
            </div>
            </div>
            </div>
        </div>
    </div>
</section>
<?php $this->end(); ?>