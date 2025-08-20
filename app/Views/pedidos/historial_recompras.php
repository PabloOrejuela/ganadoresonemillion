<link rel="stylesheet" href="<?= site_url(); ?>public/css/form-reg-new-member.css">
<!--begin::Form Validation-->
<div class="card card-gtk card-outline mb-4">
    <!--begin::Header-->
    <div class="card-header"><div class="card-title"><?= $title; ?></div></div>
    <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body">
            <table class="table table-striped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th style="width: 10px">No.</th>
                        <th>Fecha de compra</th>
                        <th>Descripción</th>
                        <th>Paquete</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num = 1;
                    if ($pedidos) {
                        
                        foreach ($pedidos as $key => $pedido) {
                        echo '<tr class="align-middle">
                                <td>'.$num.'</td>
                                <td>'.$pedido->fecha_compra.'</td>
                                <td>'.$pedido->descripcion.'</td>
                                <td>'.$pedido->paquete.' | '.$pedido->pvp.'</td>
                                <td>'.$pedido->cantidad.'</td>
                                <td>'.$pedido->total.'</td>';
                                if ($pedido->estado == 1) {
                                    echo '<td>Pagado</td>';
                                } else {
                                    echo '<td>Por pagar</td>';
                                }
                            
                        echo '</tr>';
                            $num++;
                        }
                    }else{
                        
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!--end::Body-->
    </form>
    <!--end::Form-->
</div>
<!--end::Form Validation-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/historial-pedidos.js"></script>