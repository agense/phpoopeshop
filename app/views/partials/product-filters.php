            <div class="filters"> 
            <div id="filter-form">
                        <select class="main-categories" onchange="location = this.value;">
                            <?php foreach($this->categories as $category):
                            $selected = ($this->topCategory->id == $category->id) ? "selected" : "";
                             ?>
                            <option value="<?= PROOT.'products'.DS.'show'.DS.$category->category_slug?>" <?= $selected?>><?= $category->category_name?></option>
                            <?php endforeach; ?>
                        </select>

                        <!-- On sale items-->
                        <div class="filter" data-filter="sale_filter">
                        <div class="filter-content">    
                        <label class="checkbox-label"><?= $this->topCategory->category_name ?> On Sale
                                <input type="checkbox" name="sale_filter" value="1" class="filter-option">
                                <span class="checkmark"></span>
                        </label>
                        </div>
                        </div>

                        <!--Category Filter-->
                        <div class="filter" data-filter="product_category_id">
                        <div class="filter-name">
                            Category
                            <span class="filter-icon icon-minus"><i class="fi fi-round-arrow-top"></i></span>
                            <span class="filter-icon icon-plus"><i class="fi fi-round-arrow-bottom"></i></span>
                        </div>
                        
                        <div class="filter-content"> 
                        <?php $checked = (!$this->subCategory) ? "checked" : ""?>
                         <label class="checkbox-label">All <?= $this->topCategory->category_name ?>
                            <input type="checkbox" name="product_category_id" value="<?= $this->topCategory->subcategory_ids ?>" <?=$checked?> disabled="disabled" class="filter-option filter-topcategory" data-category="topcategory">
                            <span class="checkmark"></span>
                        </label>
                         <?php foreach($this->subcategories as $name => $id): ?> 
                         <?php $checked = ($this->subCategory && $this->subCategory->category_name == $name) ? "checked" : ""?> 
                         <label class="checkbox-label"><?= $name ?>
                                <input type="checkbox" name="product_category_id" value="<?=$id?>" <?=$checked?> class="filter-option filter-subcategory" data-category="topcategory">
                                <span class="checkmark"></span>
                         </label>
                         <?php endforeach;?>   
                        </div>
                        </div>
                        <!--End of category filter-->

                        <!--Material Filter-->
                        <div class="filter" data-filter="product_material_id">
                        <div class="filter-name">
                            Material
                            <span class="filter-icon icon-minus"><i class="fi fi-round-arrow-top"></i></span>
                            <span class="filter-icon icon-plus"><i class="fi fi-round-arrow-bottom"></i></span>
                        </div>
                        <div class="filter-content">
                        <?php foreach($this->materials as $name => $id): ?>  	
                        <label class="checkbox-label"><?= $name ?>
                                <input type="checkbox" name="product_material_id" value="<?=$id?>" class="filter-option">
                                <span class="checkmark"></span>
                        </label>
                       <?php endforeach;?>
                        </div>
                        </div>
                        <!--End of material filter-->
    
                        <!--Color Filter-->
                        <div class="filter" data-filter="product_color_id">
                        <div class="filter-name">
                            Color
                            <span class="filter-icon icon-minus"><i class="fi fi-round-arrow-top"></i></span>
                            <span class="filter-icon icon-plus"><i class="fi fi-round-arrow-bottom"></i></span>
                        </div>
                        <div class="filter-content">
                        <?php foreach($this->colors as $name => $id): ?> 	
                        <label class="checkbox-label"><?= $name?>
                                <input type="checkbox" name="product_color_id" value="<?=$id?>" class="filter-option">
                                <span class="checkmark"></span>
                        </label>
                        <?php endforeach;?>
                        </div>
                        </div>
                        <!--End of Color filter-->
    
                        <!--Brand Filter-->
                        <div class="filter" data-filter="product_brand_id">
                        <div class="filter-name">
                            Brand
                            <span class="filter-icon icon-minus"><i class="fi fi-round-arrow-top"></i></span>
                            <span class="filter-icon icon-plus"><i class="fi fi-round-arrow-bottom"></i></span>
                        </div>
                        <div class="filter-content">
                        <?php foreach($this->brands as $name => $id): ?> 
                        <label class="checkbox-label"><?=$name?>
                                <input type="checkbox" name="product_brand_id" value="<?=$id?>" class="filter-option">
                                <span class="checkmark"></span>
                        </label>
                        <?php endforeach;?>
                        </div>
                        </div>
                        <!--End of brand filter-->
                        
                </div>
            </div>