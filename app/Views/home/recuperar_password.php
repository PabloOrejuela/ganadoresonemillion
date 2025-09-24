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
        <h3>Recuperar password</h3>
        <?php 
          //session()->getFlashdata('error'); 
        ?>
        <form action="<?= base_url(); ?>recupera-password" method="post" class="form">
          <div class="mb-3">
            <label for="email">Ingrese el email con el que está registrado</label>
            <input type="email" class="form-control" name="email" placeholder="Ingrese su email" value="">
          </div>
          <p id="error-message"><?= session('errors.email');?> </p>
          <div class="row">
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Enviar</button>
            </div>
            <!-- /.col -->
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <?php
                if (session('mensaje') && session('mensaje') != '3') {
                  echo'<div class="alert alert-danger mt-2" role="alert">'.session('mensaje').'</div>';
                }
              ?>
              
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- <div class="social-auth-links text-center mb-3">
          <p> o tal vés...</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Ingresar usando Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Ingresar usando Google+
          </a>
        </div> -->
        <!-- /.social-auth-links -->

        <p class="mb-1 mt-2">
          <a href="<?= site_url(); ?>" id="link-forgot">Regersar al login</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/login.js"></script>