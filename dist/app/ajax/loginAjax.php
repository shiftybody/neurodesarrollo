<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\loginController;

if (isset($_POST['modulo_login'])) {

  $insLogin = new loginController();

  if ($_POST['modulo_login'] == "login") {
    echo $insLogin->iniciarSesionControlador();
  }
} else {
  session_destroy();
  header("Location: " . APP_URL . "login/");
}
