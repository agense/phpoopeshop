
<?php $this->setSiteTitle('Admin Dashboard'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Dashboard</h1>
    </div>
    <div class="row">
    <div class="col-lg-6">  
    <div class="card border-secondary mb-3">
      <div class="card-header">SITE STATISTICS</div>
      <div class="card-body">
              <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Pages <span class="badge badge-primary badge-pill"><?= $this->pageCount ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Brands <span class="badge badge-primary badge-pill"><?= $this->pageCount ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Products <span class="badge badge-primary badge-pill"><?= $this->productCount ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Collections <span class="badge badge-primary badge-pill"><?= $this->collectionCount ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Registered Users <span class="badge badge-primary badge-pill"><?= $this->userCount ?></span>
                </li>
              </ul>
      </div>
    </div>            
    </div>
    <div class="col-lg-6">  
    <div class="card border-secondary mb-3">
      <div class="card-header">ORDER STATISTICS</div>
      <div class="card-body">
              <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Total Orders <span class="badge badge-primary badge-pill"><?= $this->orderCount ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Completed Orders <span class="badge badge-primary badge-pill"><?= $this->completedOrderCount ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Pending Orders <span class="badge badge-primary badge-pill"><?= $this->pendingOrderCount ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Total Sales Amount <span class="badge badge-primary badge-pill"><?= $this->salesTotal ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Total Sales Paid <span class="badge badge-primary badge-pill"><?= $this->salesTotalPaid ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Total Sales Unpaid <span class="badge badge-primary badge-pill"><?= $this->salesTotalUnpaid ?></span>
                </li>
              </ul>
      </div>
    </div>            
    </div>
  </div>
<?php $this->end(); ?>

