<?php $this->setSiteTitle('Admin - Order Process'); ?>
<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<!-- Add Form-->
<div class="col-lg-6 offset-lg-3 mt-3">
<h1 class="text-center">Order#: <?= $this->order->order_nr?></h1>
 <form class="form" action="<?= PROOT.'admin'.DS.'orders'.DS.'process'.DS.$this->order->id ?>" method="POST">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
  <?= FH::displayErrors($this->displayErrors);?>
     <?=FH::selectionBlock([
       'name' => 'order_status',
       'label' => 'Order Status',
       'options' => $this->order->getOrderStatuses(),
       'preselect' => [$this->order->order_status],
       'input_attrs' => ['class' => 'form-control'],
       'div_attrs' => ['class' => 'form-group edit']
    ]);?>
    <br/>
    <?php if($this->order->order_payment_status !== 1): ?>
    <p class="text-uppercase">Payment</p>
    <p>Amount Payable: <?= Helpers::formatPrice($this->order->order_payment_amount) ?></p>
    <hr/>
   <?=FH::selectionBlock([
       'name' => 'order_payment_status',
       'label' => 'Payment Status',
       'options' => $this->order->getPaymentStatuses(),
       'preselect' => [$this->order->order_payment_status],
       'input_attrs' => ['class' => 'form-control'],
       'div_attrs' => ['class' => 'form-group edit']
    ]);?>
    <?=FH::selectionBlock([
       'name' => 'order_payment_method',
       'label' => 'Payment Method',
       'options' => $this->order->getPaymentMethods(),
       'preselect' => [$this->order->order_payment_method],
       'empty' => true,
       'input_attrs' => ['class' => 'form-control'],
       'div_attrs' => ['class' => 'form-group edit']
    ]);?>
    <div class="form-group edit">
      <label for="order_payment_date">Payment Date</label>
      <input type="date" name="order_payment_date" id="order_payment_date" class="form-control">
    </div>
    <?php else: ?>
    <div>
      <hr/>
      <p>Order Payment Status: Paid</p>
      <p>Order Payment Method: <?= $this->order->displayPaymentMethod()?></p>
      <p>Order Payment Date: <?= Helpers::formatDate($this->order->order_payment_date) ?></p>
    </div> 
    <?php endif;?> 
 	<?= FH::submitBlock('Save', ['class' => 'btn main-btn mt-3']) ?>	
 </form>
</div>	
<?php $this->end(); ?>
