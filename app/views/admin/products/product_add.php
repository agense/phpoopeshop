<?php $this->setSiteTitle('Admin - Add Product'); ?>
<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<!-- Add Form-->
<div class="col-lg-10 offset-lg-1 mt-3">
<h1 class="text-center">Add A Product</h1>
 <form class="form" action="<?=PROOT?>admin/products/add" method="POST" enctype="multipart/form-data">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
     <?= FH::displayErrors($this->displayErrors); ?>
     <div class="row">
          <div class="col-lg-6">
               <?= FH::inputBlock('text','Code', 'product_code', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
               <?= FH::inputBlock('text','Name', 'product_name', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
               <?= FH::selectionBlock([
                    'name' => 'parent_category_id',
                    'label' => 'Top Category',
                    'options' => $this->topCategoryList,
                    'empty' => true,
                    'input_attrs' => ['class' => 'form-control'],
                    'div_attrs' => ['class' => 'form-group']
               ]);?>
               <?= FH::emptySelect('product_category_id', 'Category', false, ['class' => 'form-control'], ['class' => 'form-group'])?>
               <?= FH::selectionBlock([
                    'name' => 'product_brand_id',
                    'label' => 'Brand',
                    'options' => $this->brandList,
                    'empty' => true,
                    'input_attrs' => ['class' => 'form-control'],
                    'div_attrs' => ['class' => 'form-group']
               ]);?>
               <?= FH::selectionBlock([
                    'name' => 'product_material_id',
                    'label' => 'Material',
                    'options' => $this->materialList,
                    'empty' => true,
                    'input_attrs' => ['class' => 'form-control'],
                    'div_attrs' => ['class' => 'form-group']
               ]);?>
               <?= FH::selectionBlock([
                    'name' => 'product_color_id',
                    'label' => 'Color',
                    'options' => $this->colorList,
                    'empty' => true,
                    'input_attrs' => ['class' => 'form-control'],
                    'div_attrs' => ['class' => 'form-group']
               ]);?>
          </div>
          <div class="col-lg-6">
               <?= FH::uploadBlock('product_featured_image', 'Featured Image', ['class' => 'form-control'], ['class' => 'form-group']);?>
               <?= FH::uploadMultipleBlock('product_images', 'More Images', ['class' => 'form-control'], ['class' => 'form-group']);?>
               <?= FH::textAreaBlock('product_description', '', 'Description', ['class' => 'form-control'], ['class' => 'form-group']);?>
               <?= FH::inputBlock('text','Price', 'product_price', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
               <?= FH::inputBlock('number','Quantity', 'product_quantity', '', ['class' => 'form-control','min'=>'1'], ['class' => 'form-group']);?>
               <?= FH::selectionBlock([
                    'name' => 'featured',
                    'label' => 'Featured Product',
                    'options' => ['No'=>'0','Yes'=>'1'],
                    'preselect' => ['No'],
                    'input_attrs' => ['class' => 'form-control'],
                    'div_attrs' => ['class' => 'form-group']
               ]);?>
               <div class="text-right mt-4">
               <?= FH::submitBlock('Save Product', ['class' => 'btn main-btn']) ?>	
               </div>
          </div>
     </div>
 </form>
</div>	
<?php $this->end(); ?>