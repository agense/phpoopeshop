<!--Header-->
    <header class="header" id="header">
        <nav class="nav">
                <div id="top-nav" class="d-flex justify-content-between align-items-center w-100">
                <!--Mobile Nav Btn-->
                <div class="toggler-btn" id="toggler">
                    <span class="bar bar-1"></span>
                    <span class="bar bar-2"></span>
                    <span class="bar bar-3"></span>
                </div>
                <!--End Nav Btn-->
                    <div class="nav-brand align-self-center">
                            <a href="<?=PROOT?>" class="navbar-brand text-uppercase">
                                <?= MenuHelpers::getLogo()?>
                                <span class="brand-desc"><?= SITE_TITLE ?></span>
                            </a>
                    </div>
                    <div class="nav-icons d-flex">   
                        <div class="nav-icon" id="login-icon">
                            <?php if(Users::currentUser()): ?>
                            <span class="top-icon">
                                <a href="<?= PROOT.DS.'users'.DS.'account'?>"><i class="far fa-user"></i></a>
                            </span>
                            <span class="top-icon-txt">Account</span> 
                            <?php else: ?>    
                            <span class="top-icon">
                                <a href="<?=PROOT.'register/login'?>"><i class="far fa-user"></i></a>
                            </span>
                            <span class="top-icon-txt">Login</span>
                            <?php endif; ?>
                            
                        <!--Login Slideout-->
                        <div class="nav-slider" id="nav-login-slideout">
                            <div class="triangle-up"></div>
                            <div class="nav-slider-inner">
                            <?php if(Users::currentUser()): ?> 
                               <div>
                                <span class="text-mini d-block">Welcome, <?=Users::currentUser()->username; ?></span>
                                <a href="<?= PROOT.DS.'users'.DS.'account'?>" class="link-minified">My Account</a><br/>
                                <a href="<?= PROOT.DS.'users'.DS.'orders'?>" class="link-minified">My Orders</a><br />
                                <a href="<?= PROOT.'whishlist'?>" class="link-minified"> My Whishlist</a>
                                <hr />
                                <a href="<?=PROOT.'register/logout'?>" class="btn btn-black w-100 mb-2">Logout</a>
                               </div>
                            <?php else: ?>  
                            <div>
                                <span class="text-mini d-block">Login/Register</span>
                                <a href="<?=PROOT.'register/login'?>" class="btn btn-black w-100 mb-2">Login</a>
                            </div>
                            <div>
                                <a href="<?=PROOT.'register/register'?>" class="btn btn-black w-100 mb-2">Register</a>
                            </div>
                            <?php endif;?>
                            </div>
                        </div>
                        <!---->
                        <span>|</span>
                        </div>
                        <div class="nav-icon" id="whishlist-icon">
                            <span class="top-icon"><a href="<?= PROOT.'whishlist'?>"><i class="fi fi-heart-line"></i></a></span>
                            <span class="top-icon-txt"><a href="<?= PROOT.'whishlist'?>">Wishlist</a></span>
                        <?php if(!Users::currentUser()): ?>
                        
                        <!--Wishlist Slideout-->
                        <div class="nav-slider" id="nav-whishlist-slideout">
                                <div class="triangle-up"></div>
                                <div class="nav-slider-inner">
                                <span class="text-mini d-block">Please login in to access your wishlist.</span>
                                <a href="<?=PROOT.'register/login'?>" class="btn btn-black w-100 mb-2">Login</a>
                                </div>
                        </div>
                        <!---->
                        <?php endif;?>
                        <span>|</span>
                        </div>
                        <div class="nav-icon">
                            <a href="<?=PROOT."cart".DS?>"><span class="top-icon"><i class="fi fi-shopping-bag"></i></span></a>
                            <span class="top-icon-txt">
                                <span id="items-in-cart"><?= Cart::countItems() ?></span></span>
                        </div>
                    </div>
                </div>
                <!--Navigation links-->
                <?php echo MenuHelpers::topMenu(); ?>
               <!--end of navigation links-->
        </nav>
    </header>
<!--End of header-->