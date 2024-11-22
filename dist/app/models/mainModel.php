<?php

namespace app\models;

use \PDO;
use \PDOException;
use \Exception;

if (file_exists(__DIR__ . "/../../config/server.php")) {
  require_once __DIR__ . "/../../config/server.php";
}

class mainModel
{

  private $server = DB_SERVER;
  private $port = DB_PORT;
  private $db = DB_NAME;
  private $user = DB_USER;
  private $pass = DB_PASS;

  /*----------  Funcion conectar a BD  ----------*/
  protected function conectar()
  {
    try {
      $conexion = new PDO(
        "mysql:host=" . $this->server . ";port=" . $this->port . ";dbname=" . $this->db,
        $this->user,
        $this->pass
      );
      $conexion->exec("SET CHARACTER SET utf8");
      return $conexion;
    } catch (PDOException $e) {
      echo "Error de conexión: " . $e->getMessage();
      exit;
    }
  }

  public function correoExiste($correo)
  {
    $query = "SELECT COUNT(*) as total FROM usuario WHERE usuario_email = :correo";
    $result = $this->ejecutarConsulta($query, [':correo' => $correo]);
    $data = $result->fetch(PDO::FETCH_ASSOC);
    return $data['total'] > 0;
  }

  /*----------  Funcion ejecutar consultas  ----------*/
  protected function ejecutarConsulta($consulta, $parametros = [])
  {
    try {
      $conexion = $this->conectar();
      $sql = $conexion->prepare($consulta);

      // Asociar parámetros, si los hay
      foreach ($parametros as $clave => $valor) {
        $sql->bindValue($clave, $valor);
      }

      $sql->execute();
      return $sql;
    } catch (Exception $e) {
      error_log("Error en ejecutarConsulta: " . $e->getMessage());
      throw new Exception("Error al ejecutar la consulta");
    }
  }

  /*----------  Funcion limpiar cadenas  ----------*/
  public function limpiarCadena($cadena)
  {

    $palabras = ["<script>", "</script>", "<script src", "<script type=", "SELECT * FROM", "SELECT ", " SELECT ", "DELETE FROM", "INSERT INTO", "DROP TABLE", "DROP DATABASE", "TRUNCATE TABLE", "SHOW TABLES", "SHOW DATABASES", "<?php", "?>", "--", "^", "<", ">", "==", "=", ";", "::"];

    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);

    foreach ($palabras as $palabra) {
      $cadena = str_ireplace($palabra, "", $cadena);
    }

    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);

    return $cadena;
  }


  /*---------- Funcion verificar datos (expresion regular) ----------*/
  protected function verificarDatos($filtro, $cadena)
  {
    if (preg_match("/^" . $filtro . "$/", $cadena)) {
      return false; // si preg match devuelve falso es que es valido
    } else {
      return true; // si preg match devuelve verdadero es que no es valido
    }
  }


  /*----------  Funcion para ejecutar una consulta INSERT preparada  ----------*/
  protected function guardarDatos($tabla, $datos)
  {
    try {
      // Construcción de la consulta
      $query = "INSERT INTO $tabla (";

      $C = 0;
      foreach ($datos as $clave) {
        if ($C >= 1) {
          $query .= ",";
        }
        $query .= $clave["campo_nombre"];
        $C++;
      }

      $query .= ") VALUES(";

      $C = 0;
      foreach ($datos as $clave) {
        if ($C >= 1) {
          $query .= ",";
        }
        $query .= $clave["campo_marcador"];
        $C++;
      }

      $query .= ")";

      // Preparar la consulta
      $sql = $this->conectar()->prepare($query);
      if (!$sql) {
        die("Error al preparar la consulta: " . print_r($this->conectar()->errorInfo(), true));
      }

      // Bindear los valores
      foreach ($datos as $clave) {
        $sql->bindValue($clave["campo_marcador"], $clave["campo_valor"]);
      }

      // Ejecutar la consulta
      if (!$sql->execute()) {
        die("Error al ejecutar la consulta: " . print_r($sql->errorInfo(), true));
      }

      return $sql;
    } catch (PDOException $e) {
      die("Excepción capturada: " . $e->getMessage());
    }
  }

  /*---  Funcion para convertir un input de tipo contraseña a un hash -------*/
  protected function hashPassword($password)
  {
    $salt = bin2hex(openssl_random_pseudo_bytes(22));
    $salt = sprintf('$2y$12$%s$', $salt);
    return crypt($password, $salt);
  }

  /*---  Funcion para verificar la contraseña ingresada con el hash -------*/
  function verify_password($password, $hashed_password)
  {
    return crypt($password, $hashed_password) === $hashed_password;
  }

  /*---------- Funcion seleccionar datos ----------*/
  public function seleccionarDatos($tipo, $tabla, $campo, $id)
  {
    $tipo = $this->limpiarCadena($tipo);
    $tabla = $this->limpiarCadena($tabla);
    $campo = $this->limpiarCadena($campo);
    $id = $this->limpiarCadena($id);

    if ($tipo == "Unico") {
      $sql = $this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
      $sql->bindParam(":ID", $id);
    } elseif ($tipo == "Normal") {
      $sql = $this->conectar()->prepare("SELECT $campo FROM $tabla");
    }
    $sql->execute();

    return $sql;
  }


  /*----------  Funcion para ejecutar una consulta UPDATE preparada  ----------*/
  protected function actualizarDatos($tabla, $datos, $condicion)
  {

    $query = "UPDATE $tabla SET ";

    $C = 0;
    foreach ($datos as $clave) {
      if ($C >= 1) {
        $query .= ",";
      }
      $query .= $clave["campo_nombre"] . "=" . $clave["campo_marcador"];
      $C++;
    }

    $query .= " WHERE " . $condicion["condicion_campo"] . "=" . $condicion["condicion_marcador"];

    $sql = $this->conectar()->prepare($query);

    foreach ($datos as $clave) {
      $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
    }

    $sql->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);

    $sql->execute();

    return $sql;
  }


  /*---------- Funcion eliminar registro ----------*/
  protected function eliminarRegistro($tabla, $campo, $id)
  {
    $sql = $this->conectar()->prepare("DELETE FROM $tabla WHERE $campo=:id");
    $sql->bindParam(":id", $id);
    $sql->execute();

    return $sql;
  }


  /*---------- Paginador de tablas ----------*/
  protected function paginadorTablas($pagina, $numeroPaginas, $url, $botones)
  {
    $tabla = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

    if ($pagina <= 1) {
      $tabla .= '
	            <a class="pagination-previous is-disabled" disabled >Anterior</a>
	            <ul class="pagination-list">
	            ';
    } else {
      $tabla .= '
	            <a class="pagination-previous" href="' . $url . ($pagina - 1) . '/">Anterior</a>
	            <ul class="pagination-list">
	                <li><a class="pagination-link" href="' . $url . '1/">1</a></li>
	                <li><span class="pagination-ellipsis">&hellip;</span></li>
	            ';
    }


    $ci = 0;
    for ($i = $pagina; $i <= $numeroPaginas; $i++) {

      if ($ci >= $botones) {
        break;
      }

      if ($pagina == $i) {
        $tabla .= '<li><a class="pagination-link is-current" href="' . $url . $i . '/">' . $i . '</a></li>';
      } else {
        $tabla .= '<li><a class="pagination-link" href="' . $url . $i . '/">' . $i . '</a></li>';
      }

      $ci++;
    }


    if ($pagina == $numeroPaginas) {
      $tabla .= '
	            </ul>
	            <a class="pagination-next is-disabled" disabled >Siguiente</a>
	            ';
    } else {
      $tabla .= '
	                <li><span class="pagination-ellipsis">&hellip;</span></li>
	                <li><a class="pagination-link" href="' . $url . $numeroPaginas . '/">' . $numeroPaginas . '</a></li>
	            </ul>
	            <a class="pagination-next" href="' . $url . ($pagina + 1) . '/">Siguiente</a>
	            ';
    }

    $tabla .= '</nav>';
    return $tabla;
  }
}
