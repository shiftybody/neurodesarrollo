<style>
  header#app-header {
    position: fixed;
    top: 0;
    width: 100%;
    height: 4rem;
    background-color: red;
    border: 1px solid #D2D2D2;
    border: 1px solid color(display-p3 0.825 0.825 0.825);
    background: #F2F2F2;
    background: color(display-p3 0.95 0.95 0.95);
  }

  header #container {
    display: flex;
    height: 100%;
    width: 100%;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 0 3rem;
  }

  header #container #left-side {
    display: flex;
    align-items: center;
    gap: 1.35rem;
  }

  header #container #left-side #logo {
    width: 3.125rem;
    height: auto;
  }

  header #container #left-side #page-name {
    color: #1F2329;
    color: color(display-p3 0.1255 0.1373 0.1569);
    text-align: center;
    font-family: Geist;
    font-size: 16px;
    font-style: normal;
    font-weight: 600;
    line-height: 150%;
    letter-spacing: -0.64px;
  }

  header #container #left-side #info-container {
    display: flex;
    align-items: center;
    gap: .25rem;
  }

  header #container #right-side #search-container {
    display: flex;
    gap: 0.625rem;
  }

  header #container #right-side {
    display: flex;
    gap: 0.75rem;
  }

  input.search {
    display: flex;
    padding: var(--3, 12px) var(--4, 16px);
    align-items: center;
    gap: var(--25, 10px);
    align-self: stretch;
    border-radius: var(--rounded-lg, 8px);
    border: 1px solid var(--gray-300, #CFD5DD);
    border: 1px solid var(--gray-300, color(display-p3 0.8196 0.8353 0.8588));
    background: #F2F2F2;
    background: color(display-p3 0.95 0.95 0.95);
    color: var(--gray-500, var(--gray-500, #677283));
    color: var(--gray-500, var(--gray-500, color(display-p3 0.4196 0.4471 0.502)));

    /* leading-tight/text-sm/font-normal */
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 125%;
    /* 17.5px */
  }

  #avatar {
    display: flex;
    width: 2.75rem;
    width: 2.75rem;
    padding: 0px 0px 28px 34px;
    /* justify-content: flex-end; */
    /* align-items: center; */
    border-radius: 100px;
    border: 1px solid var(--white, #FFF);
    border: 1px solid var(--white, color(display-p3 1 1 1));
    background: url(<path-to-image>) lightgray 50% / cover no-repeat;
  }

  #avatar-status {
    position: absolute;
    width: 1rem;
    height: 1rem;
    border-radius: var(--rounded-lg, 8px);
    border: 2px solid var(--white, #FFF);
    border: 2px solid var(--white, color(display-p3 1 1 1));
    background: var(--green-400, #00CB84);
    background: var(--green-400, color(display-p3 0.1922 0.7686 0.5529));
  }
</style>
<header id="app-header">
  <section id="container">
    <div id="left-side">
      <button type="button" id="menu">
        <img src="./app/views/icons/menu-2.svg" alt="">
      </button>
      <div id="info-container">
        <img src="./app/views/img/logotipo-neurodesarrollo.png" alt="" id="logo">
        <span id="page-name"> Panel Principal </span>
      </div>
    </div>
    <div id="right-side">
      <div id="search-container">
        <input type="text" class="search" placeholder="Escribe / para buscar">
        <button type="button" id="uwu">
          <img src="./app/views/icons/search-outline.svg" alt="">
        </button>
        <img src="./app/views/icons/linea1.svg" alt="">
        <button type="button" id="uwu">
          <img src="./app/views/icons/bell.svg" alt="">
        </button>
      </div>
      <div id="avatar">
        <span id="avatar-status"></span>
      </div>
    </div>
  </section>
</header>