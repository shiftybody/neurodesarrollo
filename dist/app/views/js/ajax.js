const formularios_ajax = document.querySelectorAll('.form-ajax');

formularios_ajax.forEach(formulario => {
  formulario.addEventListener('submit', e => {
    e.preventDefault();
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        let data = new FormData(this);
        let method = this.getAttribute('method');
        let action = this.getAttribute('action');

        let encabezados = new Headers();

        let config = {
          method: method,
          headers: encabezados,
          mode: 'cors',
          cache: 'default',
          body: data
        };

        fetch(action, config)
          .then(response => {
            return response.json();
          })
          .then(response => {
            return alertaAjax(response);
          })
      }
    });
  });
});

function alertaAjax(alerta) {
  if (alerta.tipo === 'simple') {
    Swal.fire({
      title: alerta.titulo,
      text: alerta.texto,
      icon: alerta.icono,
      confirmButtonText: 'Aceptar'
    });
  } else if (alerta.tipo === 'recargar') {
    Swal.fire({
      title: alerta.titulo,
      text: alerta.texto,
      icon: alerta.icono,
      confirmButtonText: 'Aceptar',
      showCancelButton: true,
      cancelButtonText: 'Cancelar'

    }).then((result) => {
      if (result.isConfirmed) {
        location.reload();
      }
    });
  } else if (alerta.tipo === 'limpiar') {
    Swal.fire({
      title: alerta.titulo,
      text: alerta.texto,
      icon: alerta.icono,
      confirmButtonText: 'Aceptar',
      showCancelButton: true,
      cancelButtonText: 'Cancelar'

    }).then((result) => {
      if (result.isConfirmed) {
        document.querySelector('.form-ajax').reset();
      }
    });
  } else if (alerta.tipo === 'redireccionar') {
    window.location.href = alerta.url;
  }
}