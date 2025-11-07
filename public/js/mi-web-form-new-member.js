const selectProvincia = document.getElementById("provincias");
let inputPais = document.getElementById("pais");
const form = document.getElementById('form-registro');


form.addEventListener('submit', function(e) {
    const paisId = document.getElementById('idpais').value;
    if (!paisId) {
        e.preventDefault(); 
        Swal.fire({
            icon: 'error',
            title: 'País no válido',
            text: 'Por favor selecciona un país de la lista dando click en su nombre cuando luego de escribir aparece en la lista'
        });
        return false;
    }
});

selectProvincia.addEventListener("change", function (e) {
  //e.stopPropagation()
  let idprovincia = selectProvincia.selectedIndex;

  $.ajax({
    method: "GET",
    dataType: "json",
    url: "../../select-ciudades",
    data: {
      idprovincia: idprovincia,
    },
    beforeSend: function (f) {},
    success: function (resultado) {
      alertaMensaje("Provincia seleccionada", 1000, "success");
      //let res = JSON.parse(resultado)
      let selectCiudades = document.getElementById("idciudad");

      selectCiudades.innerHTML = "";
      selectCiudades.disabled = false;

      resultado.ciudades.forEach((element) => {
        const opcion = document.createElement("option");
        opcion.value = element.id;
        opcion.text = element.ciudad;
        selectCiudades.appendChild(opcion);
      });
    },
  });
});

function autollenarFormulario() {
    const setValue = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.value = value;
    };

    // const divEcuador = document.getElementById('div-ecuador');
    // if (divEcuador && document.getElementById('pais').value.trim().toUpperCase() === 'ECUADOR') {
    // divEcuador.style.display = 'flex';
    // } else if (divEcuador) {
    // divEcuador.style.display = 'none';
    // }

    let cedula = Math.floor(1700000000 + Math.random() * 9000000000).toString();

    setValue('nombre', nombreRandom());
    setValue('user', userRandom());
    setValue('password', passRandom());
    setValue('cedula', cedula);
    setValue('telefono', Math.floor(1700000000 + Math.random() * 9000000000).toString());
    setValue('telefono_2', Math.floor(1700000000 + Math.random() * 9000000000).toString());
    setValue('email', userRandom()+'@correo.com');
    //setValue('pais', 'Ecuador');
    setValue('direccion', 'Av. Principal 123');
    setValue('suscripción', '150.00');

    const check = document.getElementById('invalidCheck');
    if (check) check.checked = true;

    // Provincia
    const provinciaSelect = document.getElementById('provincias');
    if (provinciaSelect && provinciaSelect.options.length > 1) {
        provinciaSelect.selectedIndex = 1;
        provinciaSelect.dispatchEvent(new Event('change'));
    }

    // Ciudad (espera a que se cargue por AJAX)
    setTimeout(() => {
        const ciudadSelect = document.getElementById('idciudad');
        if (ciudadSelect && ciudadSelect.options.length > 0) {
            ciudadSelect.selectedIndex = 0;
        }
    }, 500);
}

function nombreRandom() {
  const nombres = [
    "Juan",
    "Ana",
    "Luis",
    "María",
    "Pedro",
    "Sofía",
    "Carlos",
    "Lucía",
  ];
  const apellidos = [
    "Pérez",
    "Gómez",
    "Rodríguez",
    "López",
    "Martínez",
    "Fernández",
    "Torres",
    "Ramírez",
  ];
  const nombre = nombres[Math.floor(Math.random() * nombres.length)];
  const apellido = apellidos[Math.floor(Math.random() * apellidos.length)];
  return nombre + " " + apellido;
}

function userRandom() {
  const nombres = ["gato", "perro", "perico", "rata"];
  const nombre = nombres[Math.floor(Math.random() * nombres.length)];
  return nombre;
}

function passRandom() {
  const pass = ["123", "456", "789", "147", "258"];
  const password = pass[Math.floor(Math.random() * pass.length)];
  return password;
}

document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("pais");
  const contenedor = document.getElementById("sugerencias-pais");
  const divEcuador = document.getElementById("div-ecuador");
  let timeout = null;

  // Función auxiliar: mostrar/ocultar el div-ecuador
  function actualizarDivEcuador(nombrePais) {
    const country = (nombrePais || "").trim().toUpperCase();
    if (country === "ECUADOR") {
      divEcuador.classList.add("visible");
    } else {
      divEcuador.classList.remove("visible");
    }
  }

  // Siempre permitir escribir
  function habilitarInput() {
    input.removeAttribute("readonly");
    input.removeAttribute("disabled");
  }

  // Detectar cuando el usuario escribe
  input.addEventListener("input", function () {
    clearTimeout(timeout);
    habilitarInput();

    const termino = this.value.trim();
    if (termino.length < 2) {
      contenedor.innerHTML = "";
      actualizarDivEcuador("");
      return;
    }

    timeout = setTimeout(() => {
      fetch("../../buscar?q=" + encodeURIComponent(termino), {
        method: "GET",
        headers: { "Content-Type": "application/json" },
      })
        .then((res) => res.json())
        .then((data) => {
          contenedor.innerHTML = "";
          if (data.success && data.res.length > 0) {
            data.res.forEach((pais) => {
              const item = document.createElement("div");
              item.className = "list-group-item list-group-item-action";
              item.textContent = pais.nombre;
              item.style.cursor = "pointer";
              item.onclick = () => {
                input.value = pais.nombre;
                document.getElementById('idpais').value = pais.id;
                habilitarInput(); 
                contenedor.innerHTML = "";
                actualizarDivEcuador(pais.nombre);
              };
              contenedor.appendChild(item);
            });
          }
        })
        .catch(() => {
          contenedor.innerHTML = "";
        });
    }, 300);
  });

  // Cerrar sugerencias si se hace clic fuera
  document.addEventListener("click", (e) => {
    if (!contenedor.contains(e.target) && e.target !== input) {
      contenedor.innerHTML = "";
      actualizarDivEcuador(input.value);
    }
  });

  // Asegurar que nunca se quede bloqueado
  input.addEventListener("focus", habilitarInput);
  input.addEventListener("keyup", function () {
    actualizarDivEcuador(this.value);
  });

  // Refuerzo: evitar que quede bloqueado por scripts externos
  const observer = new MutationObserver(() => {
    habilitarInput();
  });
  observer.observe(input, {
    attributes: true,
    attributeFilter: ["readonly", "disabled"],
  });

  actualizarDivEcuador(input.value);
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
      popup: "popup-class",
    },
  });
  toast.fire({
    position: "top-end",
    icon: icon,
    title: msg,
  });
};
