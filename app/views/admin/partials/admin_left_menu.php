    <div class="bg-light sidebar admin-sidebar">  
    <nav>
      <div class="sidebar-sticky">
        <div><span id="side-nav-closer">&#8594;</span></div>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="<?=PROOT?>admin/dashboard">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only"></span>
            </a>
          </li>
          <li>
             <a class="nav-link non-expanding" href="<?=PROOT?>admin/categories/">Categories</a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navitem01">
              <span><i class="fas fa-sort-down"></i></span></button>
               <div class="collapse navbar-collapse" id="navitem01">
                    <a class="nav-link sublink" href="<?=PROOT?>admin/categories/add">Add A Category</a> 
                    <a class="nav-link sublink" href="<?=PROOT?>admin/categories/deleted">Deleted Categories</a>   
                </div>
          </li>
          <li>
             <a class="nav-link non-expanding" href="<?=PROOT?>admin/brands/">Brands</a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navitem02">
              <span><i class="fas fa-sort-down"></i></span></button>
               <div class="collapse navbar-collapse" id="navitem02">
                    <a class="nav-link sublink" href="<?=PROOT?>admin/brands/add">Add A Brand</a>  
                </div>
          </li>
          <li>
             <a class="nav-link non-expanding" href="<?=PROOT?>admin/materials/">Materials</a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navitem03">
              <span><i class="fas fa-sort-down"></i></span></button>
               <div class="collapse navbar-collapse" id="navitem03">
                    <a class="nav-link sublink" href="<?=PROOT?>admin/materials/add">Add A Material</a>  
                </div>
          </li>
          <li>
             <a class="nav-link non-expanding" href="<?=PROOT?>admin/colors/">Colors</a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navitem04">
              <span><i class="fas fa-sort-down"></i></span></button>
               <div class="collapse navbar-collapse" id="navitem04">
                    <a class="nav-link sublink" href="<?=PROOT?>admin/colors/add">Add A Color</a>  
                </div>
          </li>
           <li>
             <a class="nav-link non-expanding" href="<?=PROOT?>admin/collections/">Collections</a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navitem05">
              <span><i class="fas fa-sort-down"></i></span></button>
               <div class="collapse navbar-collapse" id="navitem05">
                    <a class="nav-link sublink" href="<?=PROOT?>admin/collections/add">Add Collection</a> 
                    <a class="nav-link sublink" href="<?=PROOT?>admin/collections/deleted">Deleted Collections</a>  </div>
          </li>
          <li>
             <a class="nav-link non-expanding" href="<?=PROOT?>admin/products/">Products</a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navitem06">
              <span><i class="fas fa-sort-down"></i></span></button>
               <div class="collapse navbar-collapse" id="navitem06">
                    <a class="nav-link sublink" href="<?=PROOT?>admin/products/add">Add Product</a> 
                    <a class="nav-link sublink" href="<?=PROOT?>admin/products/quantities">Manage Quantities</a> 
                    <a class="nav-link sublink" href="<?=PROOT?>admin/products/prices">Manage Prices</a> 
                    <a class="nav-link sublink" href="<?=PROOT?>admin/products/deleted">Deleted Products</a>   
                </div>
          </li>
           <li>
             <a class="nav-link non-expanding" href="<?=PROOT?>admin/orders/">Orders</a>
          </li>
          <?php if(Administrators::isSuperAdmin() || Administrators::isAdmin() ):?>
          <li>
             <a class="nav-link non-expanding" href="<?=PROOT?>admin/pages/">Pages</a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navitem07">
              <span><i class="fas fa-sort-down"></i></span></button>
               <div class="collapse navbar-collapse" id="navitem07">
                    <a class="nav-link sublink" href="<?=PROOT?>admin/pages/add">Add A Page</a> 
                </div>
          </li>
          <?php endif; ?>
          <?php if(Administrators::isSuperAdmin()):?>
          <li>
             <a class="nav-link non-expanding" href="<?=PROOT?>admin/administrators/">Administrators</a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navitem08">
              <span><i class="fas fa-sort-down"></i></span></button>
               <div class="collapse navbar-collapse" id="navitem08">
                    <a class="nav-link sublink" href="<?=PROOT?>admin/administrators/add">Add Administrator</a> 
                    <a class="nav-link sublink" href="<?=PROOT?>admin/administrators/deleted">Deleted Administrators</a>  </div>
          </li>
          <?php endif; ?>
          <?php if(Administrators::isSuperAdmin()):?>
          <li>
             <a class="nav-link non-expanding" href="#">Settings</a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navitem09">
              <span><i class="fas fa-sort-down"></i></span></button>
               <div class="collapse navbar-collapse" id="navitem09">
                    <a class="nav-link sublink" href="<?=PROOT?>admin/settings/contactInfo">Contact Settings</a> 
               </div>
               <div class="collapse navbar-collapse" id="navitem09">
                    <a class="nav-link sublink" href="<?=PROOT?>admin/settings/socialMedia">Social Media Settings</a> 
               </div>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </nav> 
</div>    