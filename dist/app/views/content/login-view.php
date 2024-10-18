  <style>
    body {
      overflow: hidden;
      background-color: #F7F7F7;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      width: 100%;
      height: 6.25rem;
    }

    main {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      height: calc(100vh - 12rem);
      /* Resta la altura del header */
    }

    header #imagotipo {
      width: 14rem;
      margin-left: 10%;
    }

    header #escudo {
      width: 4rem;
      margin-right: 10%;
    }

    main #section-container {
      display: flex;
      position: absolute;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      gap: 1rem;
      width: 28rem;
      height: 30rem;
    }

    main #section-container #login-form {
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: stretch;
      width: 100%;
      height: 100%;
      background-color: #ffffff;
      border-radius: .5rem;
      padding: 2rem;
      gap: 1.25rem;
      box-shadow: 0px 4px 6px -1px rgba(0, 0, 0, 0.10), 0px 2px 4px -2px rgba(0, 0, 0, 0.05);
      box-shadow: 0px 4px 6px -1px color(display-p3 0 0 0 / 0.10), 0px 2px 4px -2px color(display-p3 0 0 0 / 0.05);
    }

    main #section-container #logotipo {
      width: 4.5rem;
      filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.25));
    }

    main #section-container #login-form #inputs {
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      align-items: center;
      gap: var(--2, 8px);
      align-self: stretch;
    }

    main #section-container #login-form #inputs #username-input,
    #password-input {
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      align-items: center;
      gap: var(--2, 8px);
      align-self: stretch;
    }

    div#check {
      display: flex;
      flex-direction: row-reverse;
      justify-content: flex-end;
      gap: 0.5rem;
    }


    @media (max-height: 800px) {
      main #section-container #logotipo {
        display: none;
      }

      main {
        height: calc(100vh - 6.25rem);
      }
    }

    @media (max-width: 500px) {
      main #section-container {
        width: 100%;
        padding: 0 5%;
        /* height: 26rem; */
      }

      header #imagotipo {
        width: 14rem;
        margin-left: 5%;
      }

      header #escudo {
        width: 4rem;
        margin-right: 5%;
      }
    }
  </style>
  <header>
    <img src="app/views/img/imagotipo-neurodesarrollo.png" alt="imagotipo neurodesarrollo" id="imagotipo">
    <img src="app/views/img/logo-unam.svg" alt="escudo UNAM" id="escudo">
  </header>
  <main>
    <section id="section-container">
      <img src="app/views/img/logotipo-neurodesarrollo.png" alt="logitipo neurodesarrollo" id="logotipo">

      <form action="" id="login-form">

        <div id="login-info">
          <h1>Iniciar Sesión</h1>
          <p>Ingresa tu usuario & contraseña para acceder a tu cuenta</p>
        </div>

        <div id="inputs">
          <div id="username-input">
            <label for="username">Correo o Nombre de Usuario</label>
            <input type="text" name="username" id="username" placeholder="usuario@dominio.com" required>
          </div>
          <div id="password-input">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" placeholder="•••••••••••" required>
          </div>

        </div>
        <div id="check">
          <label for="recordar">Recordar Sesión</label>
          <input type="checkbox" name="recordar" id="recordar">
        </div>

        <button type="submit">Iniciar Sesión</button>
      </form>
    </section>
  </main>