<?php

namespace app\controllers;

use app\models\mainModel;

class userController extends mainModel
{
  # controllador para registrar usuario #
  public function registrarUsuarioControlador()
  {
    # almacenar datos #
    $datos = [
      "nombre" => $_POST['nombre'],
      "apellidoPaterno" => $_POST['apellidoPaterno'],
      "apellidoMaterno" => $_POST['apellidoMaterno'],
      "telefono" => $_POST['telefono'],
      "correo" => $_POST['correo'],
      "rol" => $_POST['rol'],
      "pass" => $_POST['password'],
      "pass2" => $_POST['password2'],
      "avatar" => $_FILES['avatar']
    ];

    # limpiar datos #
    foreach ($datos as $key => $value) {
      if ($key !== 'avatar') {  // Evitar limpiar el campo del archivo
        $datos[$key] = $this->limpiarCadena($value);
      }
    }

    # validar que los campos enviados no esten vacios #
    if ($datos['nombre'] == "" || $datos['apellidoPaterno'] == "" || $datos['apellidoMaterno'] == "" || $datos['telefono'] == "" || $datos['correo'] == "" || $datos['rol'] == "" || $datos['pass'] == "" || $datos['pass2'] == "") {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Campos vacios",
        "texto" => "Debes de llenar todos los campos",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    // TODO: verificar integridad de los datos expresiones regulares de los input de texto
    # verificar integridad de los datos expresiones regulares #
    if ($this->verificarDatos("[a-za]{3,40}", $datos['nombre'])) {
      
    }

    // TODO: verificar que el usuario ingresado no exista en la base de datos
    // basado en el correo y el nombre de usuario 

    // TODO: verificar que el correo ingresado no exista en la base de datos

    // TODO: verificar que las contraseñas sean iguales 

  }
}
