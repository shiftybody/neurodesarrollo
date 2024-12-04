<?php

namespace app\controllers;

use app\models\mainModel;


class userController extends mainModel
{
  # controllador para registrar usuario
  public function registrarUsuarioControlador()
  {
    # almacenar datos #
    $datosUsuario = [
      "avatar" => $_FILES['avatar'],
      "nombre" => $_POST['nombre'],
      "apellidoPaterno" => $_POST['apellidoPaterno'],
      "apellidoMaterno" => $_POST['apellidoMaterno'],
      "telefono" => $_POST['telefono'],
      "correo" => $_POST['correo'],
      "username" => $_POST['username'],
      "rol" => $_POST['rol'],
      "pass" => $_POST['password'],
      "pass2" => $_POST['password2'],
      "key" => ""
    ];

    # limpiar datos #
    foreach ($datosUsuario as $campo => $value) {
      if ($campo !== 'avatar') {
        $datosUsuario[$campo] = $this->limpiarCadena($value);
      }
    }

    # validar que los campos enviados no esten vacios #
    if ($datosUsuario['nombre'] == "" || $datosUsuario['apellidoPaterno'] == "" || $datosUsuario['apellidoMaterno'] == "" || $datosUsuario['telefono'] == "" || $datosUsuario['correo'] == "" || $datosUsuario['rol'] == "" || $datosUsuario['pass'] == "" || $datosUsuario['pass2'] == "") {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Campos vacios",
        "texto" => "Debes de llenar todos los campos",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    # verificar integridad de los datos expresiones regulares #
    if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,70}", $datosUsuario['nombre'])) {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Error en el nombre",
        "texto" => "Solo se permiten letras y espacios en el nombre",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,70}", $datosUsuario['apellidoPaterno'])) {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Error en el apellido paterno",
        "texto" => "Solo se permiten letras y espacios en el apellido paterno",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,70}", $datosUsuario['apellidoMaterno'])) {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Error en el apellido materno",
        "texto" => "Solo se permiten letras y espacios en el apellido materno",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    if ($this->verificarDatos("[0-9]{10}", $datosUsuario['telefono'])) {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Error en el telefono",
        "texto" => "Solo se permiten numeros en el telefono",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    # nombre de usuario no se verifica correctamente por alguna razon
    // if ($this->verificarDatos("[a-zA-Z0-9._@!#$%^&*+\-]{3,70}", $datosUsuario['username'])) {
    //   $alerta = [
    //     "tipo" => "simple",
    //     "titulo" => "Error en el nombre de usuario",
    //     "texto" => "Solo se permiten letras, numeros y los caracteres especiales . _ @ ! # $ % ^ & * + - en el nombre de usuario",
    //     "icono" => "error"
    //   ];
    //   return json_encode($alerta);
    //   exit();
    // }

    if ($this->verificarDatos("(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{8,20}", $datosUsuario['pass'])) {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Error en la contraseña",
        "texto" => "La contraseña debe tener al menos una letra mayuscula, una letra minuscula, un numero, un caracter especial y tener una longitud de 8 a 20 caracteres",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    if ($datosUsuario['pass'] !== $datosUsuario['pass2']) {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Error en la contraseña",
        "texto" => "Las contraseñas no coinciden",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    } else {
      $datosUsuario['key'] = $this->hashPassword($datosUsuario['pass']);
    }

    # verificar que el correo no exista en la base de datos y el formato sea valido
    if (filter_var($datosUsuario['correo'], FILTER_VALIDATE_EMAIL)) {
      if ($this->correoExiste($datosUsuario['correo'])) {
        $alerta = [
          "tipo" => "simple",
          "titulo" => "Error en el correo",
          "texto" => "El correo ya existe",
          "icono" => "error"
        ];
        return json_encode($alerta);
        exit();
      }
    } else {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Error en el correo",
        "texto" => "El formato del correo no es válido",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    # verificar que un usuario no se repita
    $query = "SELECT usuario_usuario FROM usuario WHERE usuario_usuario = :username";
    $check_user = $this->ejecutarConsulta($query, [':username' => $datosUsuario['username']]);

    if ($check_user->rowCount() > 0) {
      $alerta = [
        "tipo" => "simple",
        "titulo" => "Error en el nombre de usuario",
        "texto" => "El nombre de usuario ya existe",
        "icono" => "error"
      ];
      return json_encode($alerta);
      exit();
    }

    # ------------------------ Validaciones de la image ------------------------ # 

    $directorio = "../views/fotos/";

    if ($_FILES['avatar']['name'] != "" && $_FILES['avatar']['size'] > 0) {

      // creando directorio 
      if (!file_exists($directorio)) {
        if (!mkdir($directorio, 0777)) {
          $alerta = [
            "tipo" => "simple",
            "titulo" => "Error en el directorio",
            "texto" => "No se pudo crear el directorio de imagenes",
            "icono" => "error"
          ];
          return json_encode($alerta);
          exit();
        }
      }

      // comprobar el formato de las imagenes permitido: jpg, png y gif
      if (
        mime_content_type($_FILES['avatar']['tmp_name']) != "image/jpeg"
        && mime_content_type($_FILES['avatar']['tmp_name']) != "image/png"
        && mime_content_type($_FILES['avatar']['tmp_name']) != "image/gif"
        && mime_content_type($_FILES['avatar']['tmp_name']) != "image/jpg"
      ) {
        $alerta = [
          "tipo" => "simple",
          "titulo" => "Error en la imagen",
          "texto" => "Solo se permiten imagenes jpg, png o gif",
          "icono" => "error"
        ];
        return json_encode($alerta);
        exit();
      }


      // verificar perso de la imagen
      if (($_FILES['avatar']['size'] / 1024) > 5120) {
        $alerta = [
          "tipo" => "simple",
          "titulo" => "Error en la imagen",
          "texto" => "La imagen es muy pesada",
          "icono" => "error"
        ];
        return json_encode($alerta);
        exit();
      }

      // darle normbre a la foto
      $foto = str_ireplace(" ", "_", $datosUsuario['nombre']);
      $foto = $foto . "_" . rand(0, 100);

      // colocar extension
      switch (mime_content_type($_FILES['avatar']['tmp_name'])) {
        case "image/jpeg":
          $foto = $foto . ".jpg";
          break;
        case "image/png":
          $foto = $foto . ".png";
          break;
        case "image/gif":
          $foto = $foto . ".gif";
          break;
      }

      // mover la imagen al directorio
      move_uploaded_file($_FILES['avatar']['tmp_name'], $directorio . "/" . $foto);
    } else {
      $foto = "";
    }

    $usuario_datos_reg = [
      [
        "campo_nombre" => "usuario_nombre",
        "campo_marcador" => ":nombre",
        "campo_valor" => $datosUsuario['nombre']
      ],
      [
        "campo_nombre" => "usuario_apellido_paterno",
        "campo_marcador" => ":apellidoPaterno",
        "campo_valor" => $datosUsuario['apellidoPaterno']
      ],
      [
        "campo_nombre" => "usuario_apellido_materno",
        "campo_marcador" => ":apellidoMaterno",
        "campo_valor" => $datosUsuario['apellidoMaterno']
      ],
      [
        "campo_nombre" => "usuario_telefono",
        "campo_marcador" => ":telefono",
        "campo_valor" => $datosUsuario['telefono']
      ],
      [
        "campo_nombre" => "usuario_email",
        "campo_marcador" => ":correo",
        "campo_valor" => $datosUsuario['correo']
      ],
      [
        "campo_nombre" => "usuario_usuario",
        "campo_marcador" => ":username",
        "campo_valor" => $datosUsuario['username']
      ],
      [
        "campo_nombre" => "usuario_password_hash",
        "campo_marcador" => ":clave",
        "campo_valor" => $datosUsuario['key']
      ],
      [
        "campo_nombre" => "usuario_foto",
        "campo_marcador" => ":foto",
        "campo_valor" => $foto
      ],
      [
        "campo_nombre" => "usuario_rol",
        "campo_marcador" => ":rol",
        "campo_valor" => $datosUsuario['rol']
      ],
      [
        "campo_nombre" => "usuario_estado",
        "campo_marcador" => ":estado",
        "campo_valor" => 1
      ],
      [
        "campo_nombre" => "usuario_fecha_creacion",
        "campo_marcador" => ":fechaCreacion",
        "campo_valor" => date("Y-m-d H:i:s")
      ],
      [
        "campo_nombre" => "usuario_ultima_modificacion",
        "campo_marcador" => ":ultimaModificacion",
        "campo_valor" => date("Y-m-d H:i:s")
      ]
    ];

    $registrar_usuario = $this->guardarDatos("usuario", $usuario_datos_reg);

    if ($registrar_usuario->rowCount() == 1) {
      $alerta = [
        "tipo" => "limpiar",
        "titulo" => "Exito",
        "texto" => "Usuario " . $datosUsuario['username'] . " registrado",
        "icono" => "success"
      ];
    } else {
      // si no se pudo registrar el usuario
      if (is_file($directorio . $foto)) {
        chmod($directorio . $foto, 0777);
        unlink($directorio . $foto);
      }

      $alerta = [
        "tipo" => "simple",
        "titulo" => "Error",
        "texto" => "No se pudo registrar el usuario",
        "icono" => "error"
      ];
    }
    return json_encode($alerta);
  }

  # controlador para listar usuarios devuelve
  # un json con los datos de los usuarios
  public function listarUsuarioControlador()
  {
    /* los campos de la tabla deben ser NO, NOMBRE COMPLETO, 
NOMBRE DE USUARIO, CORREO, ESTADO, ROL y ACCIONES */

    $query = "SELECT usuario_id, usuario_nombre, usuario_apellido_materno, usuario_apellido_paterno, usuario_usuario, usuario_email, usuario_estado, usuario_rol FROM usuario";
    $listar_usuarios = $this->ejecutarConsulta($query);

    return json_encode($listar_usuarios->fetchAll());
  }
}
