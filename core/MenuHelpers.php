<?php 
class MenuHelpers{
// DYNAMIC MENU BUILDER CLASS

  // CREATE THE FRONT END TOP MENU 
  // Returns full html code for front end top menu
  public static function topMenu(){
    $categoriesObj = new Categories();
    $collectionObj = new Collections();
    $categories = $categoriesObj->getFullCategories();
    $collections = $collectionObj->getAll();
    $menu = '<div class="nav-links">
              <ul class="nav-list">
                <li class="navLink d-block d-md-inline-flex justify-content-between align-items-center">
                    <a href="'.PROOT.'" class="d-flex w-100 justify-content-between d-md-inline-flex">
                    <span>Home</span>
                    </a>
                </li>';
    // Categories in top menu
    foreach($categories as $category){
      $menu .= '<li class="navLink d-block d-md-inline-flex justify-content-between align-items-center">
                              <a href="'.PROOT.'categories'.DS.'show'.DS.$category->category_slug.'" class="d-flex w-100 justify-content-between align-items-baseline d-md-inline-flex">
                              <span>'.$category->category_name.'</span>
                              <span class="arr"><i class="fas fa-plus"></i></span>
                              </a>';
      if(count($category->subcategories) > 0){
          $menu .= '<!--single links submenu-->
                    <div class="submenu">
                        <div class="submenu-section">
                            <!--single  column-->
                            <div class="submenu-column">
                              <div class="submenu-name">Categories</div>
                                  <ul>
                                  <li><a href="'.PROOT.'products'.DS.'show'.DS.$category->category_slug.'" class="submenu-link">All '.$category->category_name.'<span><i class="fi fi-angle-right"></i></span></a></li>';
                                  foreach ($category->subcategories as $subcategory) {
                                  $menu .= '<li><a href="'.PROOT.'products'.DS.'show'.DS.$category->category_slug.DS.$subcategory->category_slug.DS.'" class="submenu-link">'.$subcategory->category_name.'<span><i class="fi fi-angle-right"></i></span></a></li>';
                                  }    
          $menu .= '</ul></div><!-- end of single columns-->';      
          $menu.= '<!--single  column-->
                    <div class="submenu-column">
                        <div class="submenu-img d-none d-md-block">
                            <img src="'.PROOT.$category->uploadPath.DS.$category->category_image.'" alt="">
                            <div class="gradient-overlay"></div>
                            <div class="submenu-text">
                            <span class="submenu-img-heading">New In '.$category->category_name.'</span>
                              <a href="'.PROOT.'products'.DS.'new'.DS.$category->category_slug.DS.'" class="submenu-img-btn">Discover Now</a>
                            </div>
                        </div>
                        <div class="d-block d-md-none mt-4">
                            <a href="'.PROOT.'products'.DS.'new'.DS.$category->category_slug.DS.'" class="btn-dark text-center">New In '.$category->category_name.'</a>
                        </div>
                  </div>
                  <!-- end of single columns-->
                  </div>
                  </div>
                  <!--end of single link submenu-->
                  </li>';
      }                         
    }
  // Collections in top menu
  if(count($collections) > 0){
    $menu .= '<li class="navLink d-block d-md-inline-flex justify-content-between align-items-center">
                    <a href="'.PROOT.'collections'.DS.'" class="d-flex w-100 justify-content-between align-items-baseline d-md-inline-flex">
                        <span>Collections</span>
                        <span class="arr"><i class="fas fa-plus"></i></span>
                  </a>
                <div class="submenu">
                <div class="submenu-image-section">';
                foreach($collections as $collection){
                  $menu .= '<div class="submenu-column">
                        <div class="submenu-imgsection-img d-none d-md-block">
                            <img src="'.PROOT.$collection->uploadPath.DS.$collection->collection_image.'" alt="">
                        </div>    
                        <a href="'.PROOT.'collections'.DS.'show'.DS.$collection->collection_slug.DS.'" class="submenu-link">'
                        .$collection->collection_name.'<span><i class="fi fi-angle-right"></i></span></a>
                  </div>';
                }
    $menu .= '</div>
                </div>
              </li>';
  }  
  $menu .='</ul></div>';
  return $menu;
  }

  // CREATE THE FRONT END FOOTER MENU 
  // Returns full html code for front end footer menu
  public static function footerMenu(){
    $standardPages = Pages::getStandardPages(1);
    $termPages = Pages::getStandardPages(2);
    $settings = new Settings();
    $contactInfo = $settings->getContactSettings();

    $footer = '<div class="foo-middle">'. 
      '<div class="row">'.
      '<div class="col-sm-6 col-md-3 mb-3">'.
      '<h4 class="footer-heading">More Info</h4>'.
      '<ul class="footer-links">';
    foreach ($standardPages as $page) {
      $footer .= ' <li><a href="'.PROOT.'pages'.DS.'show'.DS.$page->slug.'">'.ucwords($page->title).'</a></li>';
    }   
    $footer .= '</ul></div>';
    $footer .= '<div class="col-sm-6 col-md-3 mb-3">'.
      '<h4 class="footer-heading">Terms & Conditions</h4>'.
      '<ul class="footer-links">';
    foreach ($termPages as $page) {
      $footer .= ' <li><a href="'.PROOT.'pages'.DS.'show'.DS.$page->slug.'">'.ucwords($page->title).'</a></li>';
    }   
    $footer .= '</ul></div>';
    $footer .= '<div class="col-sm-6 col-md-3 mb-3">'.
      '<h4 class="footer-heading">My Account</h4>'.
      '<ul class="footer-links">';
    if(Users::currentUser()):
    $footer .= '<li><a href="'.PROOT.'users'.DS.'account'.'">My Account</a></li>'.
      '<li><a href="'.PROOT.'users'.DS.'orders'.'">My Orders</a></li>'.
      '<li><a href="'.PROOT.'whishlist'.'">My Wishlist</a></li>'; 
    else:
      $footer .= '<li><a href="'.PROOT.'register'.DS.'login'.'">Login</a></li>'.
      '<li><a href="'.PROOT.'register'.DS.'register'.'">Register</a></li>';
    endif;  
    $footer .= '</ul></div>';
    $footer .= '<div class="col-sm-6 col-md-3 mb-3">'.
      '<h4 class="footer-heading">Customer Service</h4>'.
      '<ul class="footer-links">';

    if(isset($contactInfo->email)){
      $footer .= '<li><span class="footer-icon"><i class="fi fi-envelope"></i></span>'.
      '<a href="mailto:'.$contactInfo->email.'">'.$contactInfo->email.'</a></li>';
    }
    if(isset($contactInfo->second_email)){
      $footer .= '<li><span class="footer-icon"><i class="fi fi-envelope"></i></span>'.
      '<a href="mailto:'.$contactInfo->second_email.'">'.$contactInfo->second_email.'</a></li>';
    }  
    if(isset($contactInfo->phone)){
      $footer .= '<li><span class="footer-icon"><i class="fas fa-mobile-alt"></i></span>'.
      '<a href="tel:'.$contactInfo->phone.'">'.$contactInfo->phone.'</a></li>';
    }
    if(isset($contactInfo->second_phone)){
      $footer .= '<li><span class="footer-icon"><i class="fas fa-mobile-alt"></i></span>'.
      '<a href="tel:'.$contactInfo->second_phone.'">'.$contactInfo->second_phone.'</a></li>';
    }
    if(isset($contactInfo->address) && isset($contactInfo->city)){
      $footer .= '<li><span class="footer-icon"><i class="fas fa-map-marker-alt"></i></span><span>'.
      $contactInfo->address.', '.$contactInfo->city.'</span><br/>';
    }
    if(isset($contactInfo->country)){
      $footer .= '<span class="d-inline-block ml-4">'.$contactInfo->country.'</span>';
    }
    if(isset($contactInfo->postal_code)){
      $footer .= '<span> , '.$contactInfo->postal_code.'</span>';
    }
    $footer .= '</li></ul></div>';  
    $footer .='</div></div>';
    return $footer;      
  }

  // CREATE THE FRONT END SOCIAL MEDIA MENU 
  // Returns full html code for front end social media menu
  public static function socialMediaMenu(){
    $settings = new Settings();
    $socialMedia = $settings->getSocialMediaSettings();

    $mediaMenu = '<div class="social text-sm"><span>Follow Us</span></div>'.
    '<div class="social-icons">';
    foreach($socialMedia as $key => $val){
      $mediaMenu .= '<a href="http://'.$val.'" target="_blank"><i class="fab fa-'.$key.'"></i></a>';
    }
    $mediaMenu .= '</div>';
    return $mediaMenu;
  }

  // ACTIVE PAGE DISPLAY HELPER FOR MENUS
  // Returns a currently active page as string extracted from the request uri
  public static function currentPage(){
    $currentPage = $_SERVER['REQUEST_URI'];
    if($currentPage == PROOT || $currentPage == PROOT.'home/index'){
      $currentPage = PROOT.'home'; 
    }
    return $currentPage;
  }

  // RETURN LOGO IMAGE
  // Returns html
  public static function getLogo(){
    if(LOGO_PATH && LOGO_IMG  && file_exists(ROOT.DS.LOGO_PATH.LOGO_IMG)){
      return '<img src="'.PROOT.LOGO_PATH.LOGO_IMG.'" alt="logo" class="logo_image">';
    }else{
      return '<span class="brand-icon"><i class="fi fi-diamond"></i></span>';
    }
  }

}