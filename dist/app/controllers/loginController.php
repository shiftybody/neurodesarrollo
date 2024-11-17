<?php

namespace app\controllers;

use app\models\mainModel;

class loginController extends mainModel
{
  // controllador iniciar sesión

  public function iniciarSesionControlador()
  {
    $usuario = $this->limpiarCadena($_POST['username']);
    $password = $this->limpiarCadena($_POST['password']);

    // verificar que los campos no esten vacios
    if ($usuario == "" || $password == "") {
      echo "
         <script>
    Swal.fire({
      icon:'error',
      title: 'Ocurrio un error inesperado',
      text: 'No has llenado todos los campos que son obligatorios',
      confirmButtonText: 'Aceptar'
    })
  </script>";
    } else {
    }
  }
}
