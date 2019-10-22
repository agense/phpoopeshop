<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title><?= $this->siteTitle(); ?></title>
  
    <!--CSS-->
    <link href="<?= PROOT ?>assets/css/bootstrap.4.min.css" rel="stylesheet">
    <link href="<?= PROOT ?>assets/css/Bootswatch_Lux_Theme.css" rel="stylesheet" />
    <link href="<?= PROOT ?>assets/css/admin_lux_customized.css" rel="stylesheet" />
    
    <!--JS-->
    <script src="<?= PROOT ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= PROOT ?>assets/js/bootstrap.4.min.js"></script>
    <!--Font Awesome 4.7-->
    <script src="<?= PROOT ?>assets/js/all.js"></script>
    <!--Custom head section for page -->
    <?= $this->content('head');?>
  </head>

  <body>
    <?php $this->partial('admin', 'admin_top_menu');?>
    <div class="container-fluid">
    <div class="row">
    <main role="main" class="col-md-12">
          <?= Session::displayMsg(); ?>   
          <?= $this->content('body');?>
    </main>
    </div> 
    </div>
  </body>
</html>