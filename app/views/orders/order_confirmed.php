<?php $this->setSiteTitle('Order Confirmation'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="d-flex justify-content-center align-items-center text-center thank-you-msg-holder">
	<div>
		<h1 class="main-headline">Thank you!</h1>
		<p>Your order has been confirmed. Order number is: <?= $this->orderNr ?></p>
		<p>You can check your order status at your account here:</p>
			<a href="#" class="link-minified">My Orders</a>
	</div>
</div>
<?php $this->end(); ?>