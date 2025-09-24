let botonesPosicion = document.querySelectorAll('[data-bs-target="#selectPosition"]');
let btnActualizarPosicion = document.getElementById('btn-actualizar-posicion');
const selectPosicionModal = document.getElementById('select-posicion')
let selectPiernasModal = document.getElementById('select-piernas')

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.abrir-modal-posicion').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const socioId = this.getAttribute('data-id');

            document.getElementById('input-id').value = socioId;

        });
    });
});


//Con esta función capturo la acción de click en el link y ubico al socio
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.link-posicion').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const id = document.getElementById('input-id').value; //Este es el id del socio que vamos a ubicar
            const nodopadre = this.getAttribute('data-nodopadre'); //Este es el id del nodo padre
            const posicion = this.getAttribute('data-posicion');
            const patrocinador = this.getAttribute('data-patrocinador');

            //Petición AJAX
            fetch('setPosition?id='+id+'&posicion='+nodopadre+'&piernas='+posicion, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json()
                
            })
            .then(data => {
                //Hago uso de los valores devueltos por la petición
                alertaMensaje('El socio ha sido ubicado', 2000, 'success');
                setTimeout(function(){
                    location.replace('tanque-reserva');
                }, 3000);
            })
            .catch(error => {
                alertaMensaje('Ha habido un error y no se ha podido registrar', 2000, 'error');
                //console.error(error);
            });
            
            //console.log('Socio:', socioId, 'Posición:', posicion);
        });
    });
});


$(document).ready(function () {
    $.fn.DataTable.ext.classes.sFilterInput = "form-control form-control-sm search-input";
    $('#datatablesSimple').DataTable({
        "responsive": true, 
        "order": [[1, 'asc']],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'Todos']
        ],
        language: {
            processing: 'Procesando...',
            lengthMenu: 'Mostrando _MENU_ registros por página',
            zeroRecords: 'No hay registros',
            info: 'Mostrando _START_ a _END_ de _MAX_',
            infoEmpty: 'No hay registros disponibles',
            emptyTable: "No hay datos disponibles en esta tabla",
            infoFiltered: '(filtrando de _MAX_ total registros)',
            search: 'Buscar',
            paginate: {
            first:      "Primero",
            previous:   "Anterior",
            next:       "Siguiente",
            last:       "Último"
                },
                aria: {
                    sortAscending:  ": activar para ordenar ascendentemente",
                    sortDescending: ": activar para ordenar descendentemente"
                }
        },
        //"lengthChange": false, 
        "autoWidth": false,
        "dom": "<'row'<'col-sm-12 col-md-8'l><'col-md-12 col-md-2'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>"
    });
});

$(document).ready(function () {
    $.fn.DataTable.ext.classes.sFilterInput = "form-control form-control-sm search-input";
    $('#datatableEquipo').DataTable({
        "responsive": true, 
        "order": [[1, 'asc']],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'Todos']
        ],
        language: {
            processing: 'Procesando...',
            lengthMenu: 'Mostrando _MENU_ registros por página',
            zeroRecords: 'No hay registros',
            info: 'Mostrando _START_ a _END_ de _MAX_',
            infoEmpty: 'No hay registros disponibles',
            emptyTable: "No hay datos disponibles en esta tabla",
            infoFiltered: '(filtrando de _MAX_ total registros)',
            search: 'Buscar',
            paginate: {
            first:      "Primero",
            previous:   "Anterior",
            next:       "Siguiente",
            last:       "Último"
                },
                aria: {
                    sortAscending:  ": activar para ordenar ascendentemente",
                    sortDescending: ": activar para ordenar descendentemente"
                }
        },
        //"lengthChange": false, 
        "autoWidth": false,
        "dom": "<'row'<'col-sm-12 col-md-8'l><'col-md-12 col-md-2'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-8'p>>"
    });
});

const alertaMensaje = (msg, time, icon) => {
    const toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: time,
        //timerProgressBar: true,
        //height: '200rem',
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
        customClass: {
            // container: '...',
            popup: 'popup-class',
        }
    });
    toast.fire({
        position: "top-end",
        icon: icon,
        title: msg,
    });
}