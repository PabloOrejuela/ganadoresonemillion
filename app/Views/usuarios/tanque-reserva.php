<link rel="stylesheet" href="<?= site_url(); ?>public/css/tanque-reserva.css">
<!--begin::Form Validation-->
<div class="card card-gtk card-outline mb-4">
    <!--begin::Header-->
    <div class="card-header"><div class="card-title"><?= $subtitle; ?></div></div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body">
        <!--begin::Row-->
        <div class="row g-3">
            <table id="datatablesSimple" class="table table-bordered table-striped mt-2 table-responsive">
                <thead>
                    <th class="col-md-1">Id</th>
                    <th class="col-md-4">Nombre</th>
                    <th class="col-md-1">Documento</th>
                    <th class="col-md-1">Seleccionar posición</th>
                    <th class="col-md-1">Fecha de registro</th>
                </thead>
                <tbody id="table-datos">
                    <?php
                        if ($sociosReserva) {
                            foreach ($sociosReserva as $socio) {
                                echo '<tr>
                                        <td>'.$socio->id.'</td>
                                        <td>'.$socio->nombre.'</td>
                                        <td>'.$socio->cedula.'</td>';
                                        
                                echo    '<td id="div-center">
                                            <a type="button" 
                                                id="selectPosition_'.$socio->id.'" 
                                                href="?id='.$socio->id.'" 
                                                data-id="'.$socio->id.'"
                                                data-patrocinador="'.$socio->patrocinador.'"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#selectPosition"
                                                class="btn btn-outline-success abrir-modal-posicion"
                                            >Seleccionar posición</a>
                                        </td>';
                                echo    '<td>'.date('Y-m-d', strtotime($socio->fecha_inscripcion)).'</td>';
                                        
                                echo '</tr>';
                            }
                        } else {
                            
                        }
                        
                    ?>
                </tbody>
            </table>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Body-->
    <!--begin::Footer-->
    <div class="card-footer">
        
    </div>
    <!--end::Footer-->


<!-- Modal Select Posición-->
<div class="modal fade" id="selectPosition" tabindex="-1" aria-labelledby="selectPosition" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectPosition">Seleccionar posición para ubicar al socio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="get" action="<?= site_url().'setPosition';?>">
                <div class="modal-body" id="modal-body">
                    <h5 class="modal-title" id="staticBackdropLabel">Mi equipo</h5>
                    <input class="form-control" type="hidden" name="id" id="input-id">
                    <input class="form-control" type="hidden" name="patrocinador" id="patrocinador">
                    <input class="form-control" type="hidden" name="nombrepatrocinador" id="nombrepatrocinador" value="<?= $patrocinador ?>">

                    <table class="table tabla-responsive table-bordered table-striped" id="datatableEquipo">
                        <thead>
                            <th>ID</th>
                            <th>Cod</th>
                            <th>Nombre</th>
                            <th>Pierna Izq</th>
                            <th>Pierna Der</th>
                        </thead>
                        <tbody>
                            <?php
                                $id_excluir = isset($_GET['id']) ? $_GET['id'] : null;
                                
                                if ($miEquipo) {
                                    foreach ($miEquipo as $key => $socio) {
                                        // Verfifico si es el mismo socio, entonces lo salto
                                        if ($socio->id != $id_excluir) {
                                            
                                            // Verifica si tiene hijo a la izquierda
                                            $hijoIzq = model('SocioModel')
                                                ->where('nodopadre', $socio->id)
                                                ->where('posicion', '1')
                                                ->first();
                                            $izq = $hijoIzq 
                                                ? '<img src="'.site_url().'public/images/person.png" alt="ocupado" id="sitio-ocupado">' 
                                                : '<a href="#" class="link-posicion" data-id="'.$socio->id.'" data-posicion="1" data-patrocinador="'.$patrocinador.'" data-nodopadre="'.$socio->id.'">
                                                    <img src="'.site_url().'public/images/free_icon.png" alt="ocupado" id="sitio-ocupado"></a>';

                                            // Verifica si tiene hijo a la derecha
                                            $hijoDer = model('SocioModel')
                                                ->where('nodopadre', $socio->id)
                                                ->where('posicion', '2')
                                                ->first();
                                            $der = $hijoDer 
                                                ? '<img src="'.site_url().'public/images/person.png" alt="ocupado" id="sitio-ocupado">' 
                                                : '<a href="#" class="link-posicion" data-id="'.$socio->id.'" data-posicion="2" data-patrocinador="'.$patrocinador.'" data-nodopadre="'.$socio->id.'"><img src="'.site_url().'public/images/free_icon.png" alt="ocupado" id="sitio-ocupado"></a>';

                                            echo '<tr>';
                                            echo '<td>'.$socio->id.'</td>';
                                            echo '<td>'.$socio->codigo_socio.'</td>';
                                            echo '<td>'.$socio->nombre.'</td>';
                                            echo '<td>'.$izq.'</td>';
                                            echo '<td>'.$der.'</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/tanque-reserva.js"></script>