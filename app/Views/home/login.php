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
        <p class="login-box-msg">Ingreso al sistema</p>
        <?php 
          //session()->getFlashdata('error'); 
        ?>
        <form action="<?= base_url(); ?>validate_login" method="post" class="form">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="user" placeholder="usuario" value="">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <p id="error-message"><?= session('errors.user');?> </p>
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <p id="error-message"><?= session('errors.password');?> </p>
          <div class="row mb-4">
            <!-- /.col -->
            <div class="col-12">
              <a class="link-opacity-20" href="#" id="verPassword"><span class="fas fa-eye"> Ver password</span></a>
            </div>
            <!-- /.col -->
          </div>
          <p id="error-message"><?= session('errors.password');?> </p>
          <div class="row">
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            </div>
            <!-- /.col -->
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <?php
                
                if (session('mensaje1') && session('mensaje1') != '3') {
                  echo'<div class="alert alert-danger mt-2" role="alert">'.session('mensaje').'</div>';
                }
              ?>
              
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-1 mt-2">
          <a href="<?= site_url(); ?>forgot-password" id="link-forgot">Olvidé mi password, click aquí para recuperarlo</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/login.js"></script>