const formularios = document.querySelectorAll(".form-ajax");

// Para cada formulario en la pagina con la clase .form-ajax
formularios.forEach(formulario => {

  // escuchar el evento reset
  formulario.addEventListener("reset", function (e) {
    // limpiar los mensajes de error
    document.querySelectorAll('.error-message').forEach(errorMsg => errorMsg.remove());
    document.querySelectorAll('.error-input').forEach(errorInput => errorInput.classList.remove('error-input'));

  });

  // escuchar el evento submit
  formulario.addEventListener("submit", function (e) {

    e.preventDefault();

    let isValid = true;
    const data = new FormData(this);
    // imrpimir los datos del formulario como un objeto
    console.log(Object.fromEntries(data));

    // Limpiar los mensajes de error previos
    document.querySelectorAll('.error-message').forEach(errorMsg => errorMsg.remove());
    document.querySelectorAll('.error-input').forEach(errorInput => errorInput.classList.remove('error-input'));

    // Validación de campos vacíos
    data.forEach((value, key) => {

      const input = formulario.querySelector(`[name="${key}"]`);

      // Solo hacer trim si el valor es una cadena de texto
      if (typeof value === "string" && value.trim() === "" && key !== "avatar") {
        // obtenter el label del input
        let label = input.parentElement.querySelector("label").textContent;

        // si el input es un select, y value = '' entonces el campo esta vacio
        if (input.tagName === "select") {
          showError(input, `Selecciona un rol para el usuario`);
        } else {
          showError(input, `el campo ${label.toLowerCase()} no puede estar vacío`);
        }
        isValid = false;
      }

    });


    if (!isValid) return; // No enviar si hay errores

    Swal.fire({
      title: '¿Estás seguro?',
      text: "Quieres realizar la acción solicitada",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");
        let encabezados = new Headers();

        let config = {
          method: method,
          headers: encabezados,
          mode: 'cors',
          cache: 'no-cache',
          body: data
        };

        fetch(action, config)
          .then(respuesta => respuesta.json())
          .then(respuesta => {
            return alertas_ajax(respuesta);
          });
      }
    });
  });
});

// Mostrar mensaje de error
function showError(input, message) {
  const error = document.createElement('p');
  error.classList.add('error-message');
  error.textContent = message;
  input.parentElement.appendChild(error);
  input.classList.add('error-input');
}



// el mensaje de que un campo no debe estar vacio debe aparecer despues de realizar
// el submit y no antes de hacerlo

// el mensaje de que un input ha sido llenado incorrectamente debe aparecer despues de
// cambiar de input y no antes de hacerlo

// los mensajes de error de que un campo no debe estar vacio deben desaparecer despues de
// llenar el campo correctamente y no antes de hacerlo

// los mensajes de error de que un campo ha sido llenado incorrectamente deben desaparece despues de
// llenar el campo correctamente y no antes de hacerlo




// const formularios_ajax = document.querySelectorAll(".form-ajax");

// formularios_ajax.forEach(formularios => {

//   formularios.addEventListener("submit", function (e) {

//     e.preventDefault();

//     Swal.fire({
//       title: '¿Estás seguro?',
//       text: "Quieres realizar la acción solicitada",
//       icon: 'question',
//       showCancelButton: true,
//       confirmButtonColor: '#3085d6',
//       cancelButtonColor: '#d33',
//       confirmButtonText: 'Si, realizar',
//       cancelButtonText: 'No, cancelar'
//     }).then((result) => {
//       if (result.isConfirmed) {

//         let data = new FormData(this);
//         let method = this.getAttribute("method");
//         let action = this.getAttribute("action");

//         let encabezados = new Headers();

//         let config = {
//           method: method,
//           headers: encabezados,
//           mode: 'cors',
//           cache: 'no-cache',
//           body: data
//         };

//         fetch(action, config)
//           .then(respuesta => respuesta.json())
//           .then(respuesta => {
//             return alertas_ajax(respuesta);
//           });
//       }
//     });

//   });

// });



function alertas_ajax(alerta) {
  if (alerta.tipo == "simple") {

    Swal.fire({
      icon: alerta.icono,
      title: alerta.titulo,
      text: alerta.texto,
      confirmButtonText: 'Aceptar'
    });

  } else if (alerta.tipo == "recargar") {

    Swal.fire({
      icon: alerta.icono,
      title: alerta.titulo,
      text: alerta.texto,
      confirmButtonText: 'Aceptar'
    }).then((result) => {
      if (result.isConfirmed) {
        location.reload();
      }
    });

  } else if (alerta.tipo == "limpiar") {

    Swal.fire({
      icon: alerta.icono,
      title: alerta.titulo,
      text: alerta.texto,
      confirmButtonText: 'Aceptar'
    }).then((result) => {
      if (result.isConfirmed) {
        document.querySelector(".form-ajax").reset();
      }
    });

  } else if (alerta.tipo == "redireccionar") {
    window.location.href = alerta.url;
  }
}

// /* Boton cerrar sesion */
// let btn_exit = document.getElementById("btn_exit");

// btn_exit.addEventListener("click", function (e) {

//   e.preventDefault();

//   Swal.fire({
//     title: '¿Quieres salir del sistema?',
//     text: "La sesión actual se cerrará y saldrás del sistema",
//     icon: 'question',
//     showCancelButton: true,
//     confirmButtonColor: '#3085d6',
//     cancelButtonColor: '#d33',
//     confirmButtonText: 'Si, salir',
//     cancelButtonText: 'Cancelar'
//   }).then((result) => {
//     if (result.isConfirmed) {
//       let url = this.getAttribute("href");
//       window.location.href = url;
//     }
//   });
// });