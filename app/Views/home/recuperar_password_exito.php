<link rel="stylesheet" href="<?= site_url(); ?>public/css/login-style.css">
<div class="col-md-12 mt-5" id="wrap">
  <div class="login-box">
    <div class="login-logo">
      <a href="#">
        <img src="<?= base_url(); ?>public/images/logo-gom-negro.png" alt="logo" class="img-size-50 mr-3 img-circle" id="logo-gom">
      </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <h3><?= $subtitle; ?></h3>
        <?php 
          //session()->getFlashdata('error'); 
        ?>
        <p class="mb-1 mt-2">
          <a href="<?= site_url(); ?>" id="link-forgot">Regresar al login para poder ingresar al backoffice</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
</div>