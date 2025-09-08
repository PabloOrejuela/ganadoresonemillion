const selectMetodoPago = document.getElementById("metodo-pago")
let txtBilletera = document.getElementById("saldo-billetera")


selectMetodoPago.addEventListener('change', function(e) {
    //e.stopPropagation()

    if (selectMetodoPago.selectedIndex === 2) {
        $.ajax({
            method:"GET",
            dataType:"json",
            url: "get-saldo-billetera",
            data: {},
            beforeSend: function (f) {
                
            },
            success: function(result){
                
                let saldo = result.saldo
                if (saldo > 0) {
                    txtBilletera.style.visibility = "visible"
                    txtBilletera.value = saldo

                    alertaMensaje("Pago con saldo disponible de la billetera digital", 2000, 'success')
                }else{
                    alertaMensaje("No se puede realizar el pago con saldo disponible de la billetera digital debido a que no tiene fondos disponibles ", 4000, 'error')
                }
                
            }
        });
    }else{
        txtBilletera.style.visibility = "hidden"
        txtBilletera.value = "0"
        alertaMensaje("Efectivo / transferencia / Depósito (Red bancaria)", 2000, 'success')
    }
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