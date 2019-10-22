<?php $this->setSiteTitle('Subcategories'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<?php 
//SET THE GRID TEMPLATE
$icount = count($this->subcategories);
$counter = 1;
if($icount <= 7){
	$counter = $icount;
}elseif(Helpers::setGrid($icount, 6)){
    $counter = 6;
}elseif(Helpers::setGrid($icount, 5)){
    $counter = 5;
}elseif(Helpers::setGrid($icount, 4)){
    $counter = 4;
}elseif(Helpers::setGrid($icount, 3)){
    $counter = 3;
}
else{
   $counter = 2;
}
//SET TOP CATEGORY
$topCategory = $this->topCategory;
?>

<!--NEW SECTION-->
<section class="section-top">
        <div class="cat-new">
                <div class="cat-img">
                        <img src="<?= $this->topCategory->displayImage() ?>" alt="">
                </div>
                <div class="gradient-overlay d-flex justify-content-center align-items-end">
                        <div class="cat-img-info">
                                <h2 class="cat-img-title heading-white-lg">New In <?= $this->topCategory->category_name;?></h2>
                                <a href="<?=PROOT?>products/new/<?=$this->topCategory->category_slug?>" class="btn-white">Discover More</a>
                        </div>
                </div>
        </div>
    </section>
<!--END OF NEW SECTION--> 

<!--GRID SECTION -->
<section class="section-top">
 <?php if($icount > 0): 
	$grid = '<div class="grid-holder grid-'.$counter.'">';
    $i = 1; 
		foreach($this->subcategories as $category){
          $grid .= '<div class="item'.$i.' grid-item">
                <div class="grid-content">
                    <div class="grid-img">';
            $grid .= '<img src="'.$category->displayImage().'" alt="">';
            $grid .= '</div>
                     <div class="gradient-overlay d-flex justify-content-center align-items-end">
                        <div class="grid-img-info">
                                <h2 class="grid-img-title heading-white-lg">'.$category->category_name.'</h2>
                                <a href="'.PROOT.'products/show/'.$topCategory->category_slug.'/'.$category->category_slug.'" class="btn-white">View Products</a>
                        </div>
                     </div>
                </div>
            </div>';// end of grid item
         $i ++;
         // if more items than grid template columns exist, close the gird and start a new grid
         if($i > $counter && $counter != count($this->subcategories)){
            $i = 1;
            $grid .= '</div> <div class="grid-separator"></div> <div class="grid-holder grid-'.$counter.'">';
         }
		}
    $grid .= '</div>';//end of grid holder
    echo $grid;
    endif; 
    ?>		
</section>	
<!--END OF GRID SECTION-->

<?php $this->end(); ?>