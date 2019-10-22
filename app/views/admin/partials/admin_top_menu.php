
  <nav class="navbar fixed-top flex-md-nowrap px-0 py-2 shadow navbar-dark bg-primary">
  <div class="side-flex-container">	
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><?= MenuHelpers::getLogo();?><?= SITE_TITLE ?></a>
  <div class="admin-top-nav-right">
  <ul>	
   <?php if(Administrators::currentAdminUser()): ?>
     <li class="nav-item dropdown show">
     	 <a class="nav-link dropdown-toggle white-link" data-toggle="dropdown" href="#" id="open" aria-expanded="true">
     	 Welcome, <?=Administrators::currentAdminUser()->username; ?>	
     	  <span class="caret"></span></a>
     	 <div class="dropdown-menu" aria-labelledby="open">
                <a class="dropdown-item" target="_blank" href="<?= PROOT ?>admin/access/logout">Log Out</a>
        </div>  
     </li>	
   <?php endif; ?>
  </ul> 
  </div>
  </div>
  </nav>
