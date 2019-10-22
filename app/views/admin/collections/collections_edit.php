<?php $this->setSiteTitle('Brands'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="col-lg-8 offset-lg-2 mt-3 collection-form">
<h1 class="text-center">Edit Collection</h1>
 <form class="form" action="<?=PROOT?>admin/collections/edit/<?=$this->collection->id?>" method="POST" enctype="multipart/form-data">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
 	 <?= FH::displayErrors($this->displayErrors); ?>
 	        <?= FH::inputBlock('text','Collection Name', 'collection_name', $this->collection->collection_name, ['class' => 'form-control'], ['class' => 'form-group']);?>
 	        <?= FH::textAreaBlock('collection_description', $this->collection->collection_description, 'Description', ['class' => 'form-control'], ['class' => 'form-group']);?>
 	        <!--Image-->
 	         <?php if($this->collection->collection_image):?>
               <p>Collection Image</p>
               <div class="medium-image-holder">
               <img src="<?= $this->collection->displayImage() ?>" alt="">
               </div>
               <div class="img-uploader-block">
               <span>Change Image</span>
               <?php else: ?>
               <span>Upload Image</span>
              <?php endif; ?> 	
 	        <?= FH::uploadBlock('collection_image', '', ['class' => 'form-control'], ['class' => 'form-group']);?>  
              </div>     
            <!--Product Select Fields-->
 	        <p class="text-uppercase mt-3">Products In Collection:</p>
 	        <div class="px-3 py-3 mb-3 collection-product-select">
 	        <?= FH::groupedCheckboxBlock([
               'name' => 'collection_items',
               'checkboxes' => $this->productOptions,
               'multiple' => true,
               'checked' => $this->collectionItems,
               'input_attrs' => ['class' => 'checkbox-in-block'],
               'div_attrs' => ['class' => 'form-group'],
               'label_add_txt' => $this->optionInfo
            ]);?>
             </div>   
 	        <?= FH::submitBlock('Update Collection', ['class' => 'btn main-btn']) ?>	
 </form>
</div>
<?php $this->end(); ?>