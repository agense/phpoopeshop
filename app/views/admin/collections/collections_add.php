<?php $this->setSiteTitle('Brands'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="col-lg-8 offset-lg-2 mt-3 collection-form">
<h1 class="text-center">Create A Collection</h1>
 <form class="form" action="<?=PROOT?>admin/collections/add" method="POST" enctype="multipart/form-data">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
 	 <?= FH::displayErrors($this->displayErrors); ?>
 	        <?= FH::inputBlock('text','Collection Name', 'collection_name', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	        <?= FH::textAreaBlock('collection_description', '', 'Description', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	        <?= FH::uploadBlock('collection_image', 'Collection Image', ['class' => 'form-control'], ['class' => 'form-group']);?>       
 	        <p class="text-uppercase mt-3">Add Products To Collection:</p>
 	        <div class="px-3 py-3 mb-3 collection-product-select">
 	        <?= FH::groupedCheckboxBlock([
               'name' => 'collection_items',
               'checkboxes' => $this->productOptions,
               'multiple' => true,
               'input_attrs' => ['class' => 'checkbox-in-block'],
               'div_attrs' => ['class' => 'form-group'],
               'label_add_txt' => $this->optionInfo
            ]);?>
             </div>   
 	        <?= FH::submitBlock('Save Collection', ['class' => 'btn main-btn']) ?>	   
 </form>
</div>
<?php $this->end(); ?>