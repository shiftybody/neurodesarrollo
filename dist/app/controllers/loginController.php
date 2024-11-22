<?php

namespace app\controllers;

use app\models\mainModel;

class loginController extends mainModel
{
  # controllador iniciar sesión
  public function iniciarSesionControlador()
  {
    $inputDeUsuario = [
      "usuario" => $_POST['username'],
      "password" => $_POST['password'],
      "recordar" => $_POST['recordar']
    ];

    #limpiar datos
    foreach ($inputDeUsuario as $key => $value) {
      $inputDeUsuario[$key] = $this->limpiarCadena($value);
    }

    # verificar que los campos no esten vacios
    if ($inputDeUsuario['usuario'] == "" || $inputDeUsuario['password'] == "") {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Ocurrió un error inesperado",
        "texto" => "No has llenado todos los campos",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    # verificar integridad de los datos expresiones regulares
    if ($this->verificarDatos("^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{8,20}|[a-zA-Z0-9._@!#$%^&*+\-]{3,70})$", $inputDeUsuario['usuario'])) {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Ocurrió un error inesperado",
        "texto" => "El usuario no coincide con el formato solicitado",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    if ($this->verificarDatos("(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{8,20}", $inputDeUsuario['password'])) {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Ocurrió un error inesperado",
        "texto" => "La contraseña no coincide con el formato solicitado",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    # verificar si el usuario existe en la base de datos
    $check_usuario = $this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_email = '$inputDeUsuario[usuario]' OR usuario_usuario = '$inputDeUsuario[usuario]'");

    if ($check_usuario->rowCount() <= 0) {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Ocurrió un error inesperado",
        "texto" => "El usuario no existe en la base de datos",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    # verificar que el usuario esta activo 
    $datosRecuperados = $check_usuario->fetch();

    if ($datosRecuperados['usuario_estado'] == "0") {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Ocurrió un error inesperado",
        "texto" => "El usuario no esta activo en el sistema",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    # verificar la contraseña que esta guardada utilizando password_verify
    $contraseñaVerificada = $this->verify_password($inputDeUsuario['password'], $datosRecuperados['usuario_password_hash']);

    # si el password con su hash no coinciden
    if (!$contraseñaVerificada) {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Ocurrió un error inesperado",
        "texto" => "La contraseña es incorrecta",
        "icono" => "error"
      ];

      exit();
    }

    # crear variables de sesión
    $_SESSION['id'] = $datosRecuperados['usuario_id'];
    $_SESSION['usuario'] = $datosRecuperados['usuario_usuario'];
    $_SESSION['nombre'] = $datosRecuperados['usuario_nombre'];
    $_SESSION['apellido_paterno'] = $datosRecuperados['usuario_apellido_paterno'];
    $_SESSION['apellido_materno'] = $datosRecuperados['usuario_apellido_materno'];
    $_SESSION['foto'] = $datosRecuperados['usuario_foto'];
    $_SESSION['rol'] = $datosRecuperados['usuario_rol'];

    # si todo lo anterior se cumple, se redirecciona al dashboard
    $alerta = [
      "tipo" => "redireccionar",
      "url" => APP_URL . "dashboard/"
    ];

    return json_encode($alerta);
  }

  public function cerrarSesionControlador()
  {
    session_destroy();
    if (headers_sent()) {
      echo "<script>window.location.href='" . APP_URL . "login/'</script>";
    } else {
      header("Location: " . APP_URL . "login/");
    }
  }
}
