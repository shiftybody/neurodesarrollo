const formularios = document.querySelectorAll(".form-ajax");

const PATTERN_MSG = {
  '[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,70}': 'El campo solo puede contener letras y espacios',
  '[0-9]{10}': 'El campo solo puede contener diez digitos',
  '(?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{8,20}': 'Como mínimo una minúscula, mayuscula, número y caracter especial',
}

// TODO: escuchar cuando se suba una imagen al input file con id file-input y mostrarla en el elemento con clase .user-avatar es un span con un background image
document.querySelectorAll('.input-file').forEach(input => {

  console.log(document.querySelectorAll('.input-file'));
  console.log(document.querySelector('.user-avatar'));

  input.addEventListener('change', function () {
    const file = this.files[0];
    const reader = new FileReader();

    reader.onload = function () {
      document.querySelector('.user-avatar').style.backgroundImage = `url(${reader.result})`;
    }

    reader.readAsDataURL(file);
  });

});


// Para cada formulario en la pagina con la clase .form-ajax
formularios.forEach(formulario => {

  // TODO: escuchar el evento reset y limpiar los mensajes de error, estilos y valores de los inputs
  formulario.addEventListener("reset", function (e) {
    // limpiar los mensajes de error
    document.querySelectorAll('.error-message').forEach(errorMsg => errorMsg.remove());
    document.querySelectorAll('.error-input').forEach(errorInput => errorInput.classList.remove('error-input'));
  });

  // manejar como se lanza una alerta del input cuando no corresponde su patrón de validación

  // TODO: escuchar el evento submit validar los campos del formulario y enviar los datos
  formulario.addEventListener("submit", function (e) {

    e.preventDefault();

    let isValid = true;
    const data = new FormData(this);
    // imprimir los datos del formulario como un objeto
    console.log(Object.fromEntries(data));

    // Limpiar los mensajes de error previos
    document.querySelectorAll('.error-message').forEach(errorMsg => errorMsg.remove());
    document.querySelectorAll('.error-input').forEach(errorInput => errorInput.classList.remove('error-input'));

    // TODO: Validación de campos obligatorios estan vacios si lo estan mostrar mensaje de error con showError
    // Validación de campos obligatorios y patrón
    data.forEach((value, key) => {
      const input = formulario.querySelector(`[name="${key}"]`);

      // Validar campos obligatorios
      if (typeof value === "string" && value.trim() === "" && key !== "avatar") {
        let label = input.parentElement.querySelector("label").textContent;
        if (input.tagName === "select") {
          showError(input, `Selecciona un rol para el usuario`);
        } else {
          showError(input, `El campo ${label.toLowerCase()} no puede estar vacío`);
        }
        isValid = false;
        return; // Salir de la validación de este campo
      }

      // Validar patrón
      if (input.hasAttribute('pattern')) {
        const pattern = input.getAttribute('pattern');
        const regex = new RegExp(pattern);

        // Validar si el campo contraseña2 es igual a contraseña
        if (key === 'password2' && value !== data.get('password')) {
          showError(input, 'Las contraseñas no coinciden');
          isValid = false;
          return; // Salir de la validación de este campo
        }

        // Validar si el campo cumple con el patrón de validación
        if (!regex.test(value)) {
          const errorMessage = PATTERN_MSG[pattern] || "El valor no coincide con el patrón requerido";
          showError(input, errorMessage);
          isValid = false;
        }
      }
    });

    // si no es valido, no hacer la peticion
    if (!isValid) return;

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
        console.log(data);

        let config = {
          method: method,
          headers: encabezados,
          mode: 'cors',
          cache: 'no-cache',
          body: data
        };

        fetch(action, config)
          .then(respuesta => { console.log(respuesta); return respuesta.json() })
          .then(respuesta => {
            return alertas_ajax(respuesta);
          });
      }
    });
  });
});

// Mostrar mensaje de erro
function showError(input, message) {
  const error = document.createElement('p');
  error.classList.add('error-message');
  error.textContent = message;
  input.parentElement.appendChild(error);
  input.classList.add('error-input');
}

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
        // cambiar la imagen de la vista previa 
        document.querySelector('.user-avatar').style.backgroundImage = `url(../fotos/avatar.jpg)`;
      }
    });

  } else if (alerta.tipo == "redireccionar") {
    window.location.href = alerta.url;
  }
}

/* Boton cerrar sesion */
/* let btn_exit = document.getElementById("btn_exit");

btn_exit.addEventListener("click", function (e) {

  e.preventDefault();

  Swal.fire({
    title: '¿Quieres salir del sistema?',
    text: "La sesión actual se cerrará y saldrás del sistema",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, salir',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      let url = this.getAttribute("href");
      window.location.href = url;
    }
  });
});  */