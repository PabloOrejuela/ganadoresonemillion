<link rel="stylesheet" href="<?= site_url(); ?>public/css/recursos.css">
<!--begin::Form Validation-->
<div class="card card-gtk card-outline mb-4">
    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">Recursos descargables</div>
    </div>
    <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body">
            <div class="row">
                <div class="col-auto" id="div-logo">
                    <img src="<?= base_url(); ?>public/images/logo-gom.png" alt="logo" class="img-size-100 mr-3 img-circle" id="logo-gom">
                    <h3>Aquí pueden encontrar algunos recursos descargables</h3>
                </div>
            </div>
            <!--begin::Row-->
            <div class="row col-md-6">
                <table class="table table-hover mt-1">
                    <tbody>
                        <tr>
                            <th>Manual para Trading: </th><td><a href="<?= site_url(); ?>/public/recursos/manual.pdf" class="text-primary link-descarga" target="_blank">Descargar el manual</a></td>
                        </tr>
                        <tr>
                            <th>PDF desafío: </th><td><a href="<?= site_url(); ?>/public/recursos/desafio.pdf" class="text-primary link-descarga" target="_blank">Descargar el pdf con el desafío</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Body-->
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/lista-miembros.js"></script>
