<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title><?= SITE_TITLE ?> | <?= $this->siteTitle(); ?></title>

    <!--CSS-->
    <link href="<?= PROOT ?>assets/css/bootstrap.4.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <link href="<?= PROOT ?>assets/css/Bootswatch_Lux_Theme.css" rel="stylesheet" />
    <link href="<?= PROOT ?>assets/css/admin_lux_customized.css" rel="stylesheet" />
    <link href="<?= PROOT ?>assets/css/uxwing-iconsfont.min.css" rel="stylesheet" />
    <link href="<?= PROOT ?>assets/css/toastr-2.1.3.min.css" rel="stylesheet" />
    <link href="<?= PROOT ?>assets/summernote-0.8.12/dist/summernote-bs4.css" rel="stylesheet" />



    <!--JS-->
    <script src="<?= PROOT ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= PROOT ?>assets/js/bootstrap.4.min.js"></script>
    <script src="<?= PROOT ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= PROOT ?>assets/js/summernote_editor.js"></script>
    <script src="<?= PROOT ?>assets/summernote-0.8.12/dist/summernote-bs4.js"></script>
    <script src="<?= PROOT ?>assets/js/toastr-2.1.3.min.js"></script>
    <script src="<?= PROOT ?>assets/js/admin.js"></script>
    <!--Font Awesome 4.7 JS-->
    <script src="<?= PROOT ?>assets/js/all.js"></script>
    
    <!--SET THE SITE DOMAIN NAME ON WINDOW OBJECT TO BE ACCESSABLE IN JS -->
    <script >
    window.siteDomain = <?= PROOT ?>; 
    toastr.options.closeButton = true;
    toastr.options.closeMethod = 'fadeOut';
    toastr.options.closeDuration = 600;
    toastr.options.timeOut = 1200;
    </script>

    <!--Custom head section for page -->
    <?= $this->content('head');?>
  </head>

  <body>
    <?php $this->partial('admin', 'admin_top_menu');?>
    <div class="container-fluid">
    <div class="row">
    <?php $this->partial('admin', 'admin_left_menu');?>
    <div class="main-content px-4">
          <div class="mt-4">
            <?= Session::displayMsg(); ?>
          </div>     
          <?= $this->content('body');?>
    </div>
    </div>
    </div>
    <footer class="footer">
      <span class="footer_txt"><?= SITE_TITLE ?> &copy; 2019 </span>
    </footer>
  </body>
</html>