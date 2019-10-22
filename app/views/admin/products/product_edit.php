<?php $this->setSiteTitle('Admin - Edit Product'); ?>
<?php $this->start('head');?>
<?php $this->end(); ?>

<?php $this->start('body');?>
<!-- Add Form-->
<div class="col-lg-10 offset-lg-1 mt-3">
<h1 class="text-center">Edit Product</h1>
 <form class="form" action="<?=PROOT?>admin/products/edit/<?=$this->product->id?>" method="POST" enctype="multipart/form-data">
 	<!-- Hidden field for token-->
 	<?= FH::csrfInput();?>
 	<!-- Display errors-->
     <?= FH::displayErrors($this->displayErrors);?>
     <div class="row">
          <div class="col-lg-6">
               <?= FH::inputBlock('text','Code', 'product_code', $this->product->product_code, ['class' => 'form-control'], ['class' => 'form-group']);?>
               <?= FH::inputBlock('text','Name', 'product_name', $this->product->product_name, ['class' => 'form-control'], ['class' => 'form-group']);?>
               <?=FH::selectionBlock([
                    'name' => 'parent_category_id',
                    'label' => 'Top Category',
                    'options' => $this->topCategoryList,
                    'preselect' => [$this->product->product_top_category_id],
                    'input_attrs' => ['class' => 'form-control'],
                    'div_attrs' => ['class' => 'form-group edit']
               ]);?>
               <?=FH::selectionBlock([
                    'name' => 'product_category_id',
                    'label' => 'Category',
                    'options' => $this->categoryList,
                    'preselect' => [$this->product->product_category_id],
                    'input_attrs' => ['class' => 'form-control'],
                    'div_attrs' => ['class' => 'form-group']
               ]);?>
                    <?= FH::selectionBlock([
                    'name' => 'product_brand_id',
                    'label' => 'Brand',
                    'options' => $this->brandList,
                    'preselect' => [$this->product->product_brand_id],
                    'input_attrs' => ['class' => 'form-control'],
                    'div_attrs' => ['class' => 'form-group']
               ]);?>
               <?= FH::selectionBlock([
                    'name' => 'product_material_id',
                    'label' => 'Material',
                    'options' => $this->materialList,
                    'preselect' => [$this->product->product_material_id],
                    'input_attrs' => ['class' => 'form-control'],
                    'div_attrs' => ['class' => 'form-group']
               ]);?>
               <?= FH::selectionBlock([
                    'name' => 'product_color_id',
                    'label' => 'Color',
                    'options' => $this->colorList,
                    'preselect' => [$this->product->product_color_id],
                    'input_attrs' => ['class' => 'form-control'],
                    'div_attrs' => ['class' => 'form-group']
               ]);?>
              
          </div>
          <div class="col-lg-6">
          <?= FH::textAreaBlock('product_description', $this->product->product_description, 'Description', ['class' => 'form-control'], ['class' => 'form-group']);?>
          <?php if($this->product->product_featured_image): ?>
                 <div class="medium-image-holder">
                 <img src="<?= $this->product->displayImage() ?>" alt="">
                 </div>
                 <div class="img-uploader-block">
                 <span>Update Featured Image</span>
                 <?php else: ?>
                 <span>Upload Image</span>
                 <?php endif; ?>  
                 <?= FH::uploadBlock('product_featured_image', '', ['class' => 'form-control'], ['class' => 'form-group']);?>
                 </div>
                 <div class="d-flex w-100 mb-3 mt-2 justify-content-end">
                  <a href="#" class="btn main-btn mr-2" id="img_updater" data-product_id ="<?=$this->product->id ?>">Update Images</a>
                  <?= FH::submitBlock('Save Product', ['class' => 'btn main-btn']) ?>	
                 </div>
          </div>
     </div>
 </form>
</div>	
<?php $this->partial('admin', 'images_modal');?>  
<?php $this->end(); ?>
