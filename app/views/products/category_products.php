<?php $this->setSiteTitle('Category Products'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>  
<!-- BREADCRUMBS-->
<section class="section-slim">
        <div class="light-separator"></div>
        <div class="bread-crumbs">
            <span class="bread-crumb back-link">
                <a href="<?=PROOT?>categories/show/<?= $this->topCategory->category_slug?>" class="link-minified"><span><i class="fi fi-line-angle-left"></i></span>Back</a>   
            </span>   
            <span class="bread-crumb"><a href="<?=PROOT?>" class="link-minified">Home</a></span>
            <span class="f-slash">/</span>
            <span class="bread-crumb"><a href="<?=PROOT?>products/show/<?= $this->topCategory->category_slug?>" class="link-minified">
            	<?= $this->topCategory->category_name ?></a></span>
            <span class="f-slash">/</span>
            <?php if($this->subCategory): ?>
            <span class="bread-crumb"><span class="link-minified"><?=$this->subCategory->category_name; ?> </span></span>
            <?php elseif($this->sales): ?>
                <span class="bread-crumb"><span class="link-minified"><?= $this->topCategory->category_name ?> On Sale</span></span>
            <?php endif; ?>
        </div>
        <div class="light-separator"></div>
    </section>
<!-- END BREADCRUMBS-->


<section class="section-top">
	<!--ROW NAVIGATORS-->
	    <div class="row navigators">
        <div class="col d-flex justify-content-between align-items-baseline">
            <button type="button" id="filter-btn" class="btn d-flex justify-content-between align-items-baseline">
                Filter
                <span><i class="fas fa-plus"></i></span>
            </button>  
        </div>     
    </div>
    <div class="row">
            <div class="col-md-4 col-lg-3">
                <!--Include filters-->
                <?php $this->partial('', 'product-filters', [
                    'subcategory' =>$this->subCategory,
                    'topCategory' =>$this->topCategory,
                    'subCategories' => $this->subcategories,
                    'categories' => $this->categories,
                    'materials' => $this->materials,
                    'colors' => $this->colors,
                    'brands' =>$this->brands
                    ]);?>
    </div>
    <div class="col-md-8 col-lg-9 content-holder">
                <!--Top Content Row-->
                <div class="content-options d-md-flex justify-content-between align-items-baseline">
                    <!-- Results Info-->
                    <div class="result-holder">
                       <div class="category-results">
                           <span class="results-text">Products: </span>  
                           <span id="results-number"><?= count($this->products); ?></span>    
                       </div>
                    </div>
                    <!--Results info-->
                    <!--Sort Items -->
                    <div class="sort-field sort-full-view">
                        <form action="">
                            <div class="sort-holder">   
                                <select name="sort" id="sort">
                                        <option value="" selected>Sort By</option>
                                        <option value="product_upload_date" data-direction="DESC">Newest Items First</option>
                                        <option value="product_price" data-direction="ASC">Price Low to High</option>
                                        <option value="product_price" data-direction="DESC">Price High to Low</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <!--End of sort items-->
                    <!-- Results Info-->
                    <div class="result-holder-mobile">
                       <div class="category-results">
                           <span class="results-text">Products: </span>  
                           <span id="results-number"><?= count($this->products); ?></span>    
                       </div>
                    </div>
                    <!--Results info-->
                </div>
                <!--end of top content row-->
                <!--PRODUCTS-->
                <div class="category-content products-container row">
                    <!--single product-->
                    <?php if(count($this->products) > 0): ?>
                         <?php $this->partial('', 'grid-products', ['classes' => 'col-sm-6 col-md-6 col-lg-4 grid-single-product', 'products' => $this->products ]);?>
                     <?php else: ?>
                     <?php $noItemsText = ($this->sales) ? "There are no ".$this->category->category_name." on sale at the moment" : "Sorry, there are no ".$this->category->category_name." for sale at the moment"  ?>   
                  	 <div class="no-items"><?= $noItemsText ?></div>  
                  <?php endif;?>
                   
                </div>
                <!--END OF PRODUCTS-->
            </div>
        </div>
</section>	
<?php $this->end(); ?>