<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\userController;

if (isset($_POST['modulo_usuario'])) {

  $insUsuario = new userController();

  if ($_POST['modulo_usuario'] == "registrar") {
    echo $insUsuario->registrarUsuarioControlador();
  }

  if ($_POST['modulo_usuario'] == "leer") {
    echo $insUsuario->listarUsuarioControlador();
  }

  if ($_POST['modulo_usuario'] == "remover") {
    echo $insUsuario->removerUsuarioControlador(); 
  }

  if ($_POST['modulo_usuario'] == "obtener_roles") {
    echo $insUsuario->obtenerRoles();
  }

} else {
  session_destroy();
  header("Location: " . APP_URL . "login");
}
