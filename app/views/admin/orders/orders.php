<?php $this->setSiteTitle('Orders'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>Orders</h1>
      </div>
      <?php if(count($this->orders) > 0): ?>
      <div class="error-display"></div>  
      <div class="table-responsive">
        <table class="table table-sm table-min table-hover">
          <thead>
            <tr>
              <th>Id</th>
              <th>Order Number</th>
              <th>Customer Name</th>
              <th>Amount</th>
              <th>Order Status</th>
              <th>Payment Status</th>
              <th>Order Date</th>
              <th>Order Details</th>
            </tr>
          </thead>
          <tbody>
          	<?php foreach($this->orders as $order): ?>
            <tr class="<?= ($order->order_status == 3) ? "completed-order-row": ""?>">
              <td><?= $order->id ?></td>
              <td><?= $order->order_nr ?></td>
              <td><?= $order->customer_name ?></td>
              <td><?= Helpers::formatPrice($order->order_payment_amount) ?></td>
              <td><?= $order->order_status_display ?></td>
              <td><?= $order->order_payment_status_display ?></td>
              <td><?= $order->order_date ?></td>
              <td><a href="<?= PROOT.'admin/orders/details/'.$order->id ?>" class="mini-btn">View &amp; Manage</a></td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
  <?php else: ?>
  <h2 class="text-center">There are no orders.</h2>    
  <?php endif;?>
<?php $this->end(); ?>