<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= SITE_TITLE ?></title>
        <!--Bootstrap Styles-->
        <link href="<?= PROOT ?>assets/css/bootstrap.4.min.css" rel="stylesheet">
        <!--Slick Slider-->
        <link rel="stylesheet" href="<?= PROOT ?>assets/slick/slick.css">
        <link rel="stylesheet" href="<?= PROOT ?>assets/slick/slick-theme.css">
        <!-- Main CSS-->
        <link href="<?= PROOT ?>assets/css/frontstyles.css" rel="stylesheet">
        <!-- UXWING Icons-->
        <link rel='stylesheet' href="<?= PROOT ?>assets/css/uxwing-iconsfont.min.css" />
        <!--Scripts-->
        <script src="<?= PROOT ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?= PROOT ?>assets/js/bootstrap.4.min.js"></script>
        <script src="<?= PROOT ?>assets/js/all.js"></script>
        <!--Custom head section for page -->
        <?= $this->content('head');?>
    </head>

    <body>
    <!--HEADER/NAVIGATION-->  
    <?php $this->partial('', 'main_menu');?>
    <!--MAIN CONTENT-->
    <div class="container-fluid">  
          <?= $this->content('body');?>
    </div>
    <!--FOOTER-->
     <?php $this->partial('', 'front_footer');?>
    <!--JS Scripts-->   
    <!--SET THE SITE DOMAIN NAME ON WINDOW OBJECT TO BE ACCESSABLE IN JS -->
    <script >
       window.siteDomain = <?= PROOT ?>; 
    </script>
    <script src="<?= PROOT ?>assets/slick/slick.min.js"></script>
    <script src="<?= PROOT ?>assets/js/sliders.js"></script>
    <script src="<?= PROOT ?>assets/js/app.js"></script>
    <script src="<?= PROOT ?>assets/js/filters.js"></script>
    <script src="<?= PROOT ?>assets/js/jquery.zoom.min.js"></script>
    <script src="<?= PROOT ?>assets/js/whishlist.js"></script>
    <script src="<?= PROOT ?>assets/js/cart.js"></script>
  </body>
</html>