<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\loginController;

if (isset($_POST['modulo_usuario'])) {
  
  $insLogin = new loginController();

  if($_POST['modulo_usuario'] == "registrar"){
    echo $insUsuario -> ();
  }
} else {
  session_destroy();
  header("Location: ". APP_URL."login/");
}
