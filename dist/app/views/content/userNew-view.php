<style>
  .body-container {
    display: flex;
    padding: var(--8, 32px) var(--0, 0px);
    flex-direction: column;
    align-items: center;
    gap: var(--4, 16px);
  }

  .container {
    display: flex;
    width: 672px;
    padding: var(--4, 16px) var(--0, 0px);
    flex-direction: column;
    align-items: flex-start;
    gap: var(--8, 32px);
  }

  input[type="file"] {
    /* add a border and full weight */
    border: 1px solid #ccc;
    border-radius: .5rem;
    display: inline-block;
    line-height: .5rem;
    background-color: #f9fafb;
  }

  input::file-selector-button {
    background-color: #14171d;
    background-position-x: 0%;
    background-size: 100%;
    border: 0;
    border-radius: 0;
    color: #fff;
    padding: .8rem 1.25rem;
    margin-right: 1rem;
  }

  input::file-selector-button:hover {
    background-color: #384051;
  }

  .form-layout {
    display: flex;
    padding: var(--0, 0px);
    flex-direction: column;
    align-items: flex-start;
    gap: var(--4, 16px);
    align-self: stretch;
  }

  .form-title {
    display: flex;
    color: var(--gray-900, var(--gray-900, #0C192A));
    color: var(--gray-900, var(--gray-900, color(display-p3 0.0667 0.098 0.1569)));
    /* leading-none/text-xl/font-bold */
    font-family: Inter;
    font-size: 20px;
    font-style: normal;
    font-weight: 700;
    line-height: 20px;
    align-self: stretch;
    /* 100% */
  }

  .helper {
    align-self: stretch;
    color: var(--gray-500, var(--gray-500, #677283));
    color: var(--gray-500, var(--gray-500, color(display-p3 0.4196 0.4471 0.502)));
    font-family: Inter;
    font-size: 12px;
    font-style: normal;
    font-weight: 400;
    line-height: 12px;
    padding: 0;
  }

  .file-upload {
    display: flex;
    flex-direction: column;
    /* ancho del 100 */
    width: 100%;
    align-items: flex-start;
    gap: var(--2, .5rem);
    flex: 1 0 0;
  }

  .file-section {
    display: flex;
    padding: var(--0, 0px);
    align-items: center;
    gap: var(--4, 16px);
    align-self: stretch;
  }

  .general-information {
    display: flex;
    padding: var(--0, 0px);
    flex-direction: column;
    align-items: flex-start;
    gap: var(--4, 16px);
    align-self: stretch;
  }

  .file-label {
    align-self: stretch;
    color: var(--gray-900, var(--gray-900, #0C192A));
    color: var(--gray-900, var(--gray-900, color(display-p3 0.0667 0.098 0.1569)));

    /* text-sm/font-semibold */
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 600;
    line-height: 150%;
    /* 21px */
  }

  .form-information {
    display: flex;
    flex-direction: column;
    gap: .4rem;
  }

  .user-avatar {
    display: flex;
    width: 5rem;
    height: 5rem;
    padding: 0px 0px 28px 34px;
    background-image: url("<?php echo APP_URL ?>/app/views/fotos/avatar.jpg");
    background-position: 50%;
    background-size: cover;
    background-repeat: no-repeat;
    border-radius: 100px;
  }

  .upload-avatar {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    gap: var(--2, .7rem);
    align-self: stretch;
  }

  #file-input {
    width: 100%;
    color: var(--gray-900, var(--gray-900, #0C192A));
    color: var(--gray-900, var(--gray-900, color(display-p3 0.0667 0.098 0.1569)));
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 125%;
    color: #9da3ae;
  }

  .row-layout {
    display: flex;
    padding: var(--0, 0px);
    align-items: flex-start;
    gap: var(--4, 16px);
    align-self: stretch;
    height: 100%;
  }

  .input-field {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: var(--2, 8px);
    flex: 1 0 0;
  }

  .buttons-options {
    display: flex;
    flex-direction: row;
    gap: var(--4, .5rem);
  }

  .error-message {
    color: var(--red-600, var(--red-600, #F00));
    color: var(--red-600, var(--red-600, color(display-p3 0.8784 0.1412 0.1412)));
    /* text-sm/font-normal */
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 150%;
  }

  .error-input {
    border-radius: var(--rounded-lg, 8px) !important;
    border: 1px solid var(--red-500, #FF1C40) !important;
    border: 1px solid var(--red-500, color(display-p3 0.9412 0.3216 0.3216)) !important;
    background: var(--red-50, #FFF1F2) !important;
    background: var(--red-50, color(display-p3 0.9922 0.949 0.949)) !important;
  }

  .error-input:hover{
    border: 2px
  }
</style>
<div class="body-container">
  <div class="container">
    <div class="general-information">
      <div class="form-information">
        <h1 class="form-title">
          Crear nuevo usuario
        </h1>
        <p class="helper">Ingrese los datos del usuario que desea crear</p>
      </div>

      <!-- TODO: agregar patrones de expresiones regulares a los input con pattern y maxlength al tipo texto  -->
      <!--  -->
      <form action="<?php echo APP_URL ?>app/ajax/usuarioAjax.php" method="POST" class="form-layout form-ajax" enctype="multipart/form-data">

        <input type="hidden" name="modulo_usuario" value="registrar">

        <div class="upload-avatar">

          <label for="file-label" class="file-label">Escoge una imagen de perfil</label>
          <div class="file-section">
            <span class="user-avatar">
            </span>
            <!-- Foto de Perfil -->
            <div class="file-upload">
              <input id="file-input" type="file" name="avatar" accept="image/png, image/jpeg" class="input" />
              <p class="helper" id="file_input_help"> png, gif, jpg tamaño máximo 800KB</p>
            </div>
          </div>
        </div>

        <!-- Nombre & Apellido Paterno -->
        <div class="row-layout">
          <div class="input-field">
            <label for="nombre" class="file-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="input" placeholder="Nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,70}" maxlength="70">
          </div>
          <div class="input-field">
            <label for="apellidoPaterno" class="file-label">Apellido Paterno</label>
            <input type="text" name="apellidoPaterno" id="apellidoPaterno" class="input" placeholder="Apellido Paterno" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,70}" maxlength="70">
          </div>
        </div>

        <!-- Apellido Materno & Telefono -->
        <div class="row-layout">
          <div class="input-field">
            <label for="apellidoMaterno" class="file-label">Apellido Materno</label>
            <input type="text" name="apellidoMaterno" id="apellidoMaterno" class="input" placeholder="Apellido Materno" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,70}" maxlength="70">
          </div>
          <div class="input-field">
            <label for="telefono" class="file-label">Telefono</label>
            <input type="text" name="telefono" id="telefono" class="input" placeholder="Telefono" pattern="[0-9]{10}" maxlength="10">
          </div>
        </div>

        <!-- correo y rol -->
        <div class="row-layout">
          <div class="input-field">
            <label for="correo" class="file-label">Correo</label>
            <input type="email" name="correo" id="correo" class="input" placeholder="Correo" maxlength="100">
          </div>
          <div class="input-field">
            <label for="rol" class="file-label">Rol</label>
            <select name="rol" id="rol" class="input"  >
              <option value="" selected>Selecciona un rol</option>
              <option value="1">Administrador</option>
              <option value="2">Usuario</option>
            </select>
          </div>
        </div>

        <!-- Nombre de usuario -->
        <div class="row-layout">
          <div class="input-field">
            <label for="username" class="file-label">Nombre de Usuario</label>
            <input type="text" name="username" id="username" class="input" placeholder="Nombre de Usuario" pattern="[a-zA-Z0-9._@!#$%^&*+\-]{3,70}" maxlength="70">
          </div>
        </div>

        <!-- Contraseña & confirmar contraseña -->
        <div class="row-layout">
          <div class="input-field">
            <label for="password" class="file-label">Contraseña</label>
            <input type="password" name="password" id="password" class="input" placeholder="Contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{8,20}" maxlength="20">
          </div>
          <div class="input-field">
            <label for="password2" class="file-label
            ">Confirmar Contraseña</label>
            <input type="password" name="password2" id="password2" class="input" placeholder="Confirmar Contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{8,20}" maxlength="20">
          </div>
        </div>

        <!-- clear and submit -->
        <div class="buttons-options">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="reset" class="btn btn-secondary">Limpiar</button>
        </div>

      </form>
    </div>
  </div>
</div>