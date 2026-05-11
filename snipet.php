add_action('template_redirect', 'nidoum_custom_front_page');

function nidoum_custom_front_page() {
    if ( is_front_page() ) {

        // Limpiamos la cabeza pero dejamos el footer intacto
        remove_all_actions('wp_head');
        while ( ob_get_level() ) ob_end_clean();

        header('Content-Type: text/html; charset=UTF-8');

        // HTML principal (sin cerrar body/html aún)
        $mi_html = <<<HTML
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <title>NIDOUM – Conscious Habitat</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500&family=Roboto+Serif:ital,wght@0,300;0,400;1,300&display=swap"
    rel="stylesheet" />
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --sandlight: #e6d6c7;
      --sandlight60: rgba(248, 243, 238, 0.6);
      --sandlight30: rgba(248, 243, 238, 0.3);
      --sanddark: #7c6454;
      --sandob: #514946;
      --white: #ffffff;
      --black: #000000;
      --header-h: 100vh;
    }

    body {
      background: var(--sanddark);
      font-family: 'Albert Sans', sans-serif;
      color: var(--sandlight60);
    }

    /* HEADER */
    .nidoum-header {
      position: relative;
      width: 100%;
      height: var(--header-h);
      overflow: hidden;
    }

    .layer-fondo {
      position: absolute;
      inset: -25% 0;
      background-image: url('https://nidoum.com/wp-content/uploads/2026/03/Nidoum-Header-fondo-scaled.jpg');
      background-size: cover;
      background-position: center;
      will-change: transform;
    }

    .layer-logo {
      position: absolute;
      inset: -5% 0;
      background-image: url('https://nidoum.com/wp-content/uploads/2026/03/03.1B_9-Logo-Icon_Inv-Core@2x-1.png');
      background-size: 40%;
      background-repeat: no-repeat;
      background-position: center 15%;
      will-change: transform;
      z-index: 5;
      display: none;
    }

    .layer-casa {
      position: absolute;
      inset: -5% 0;
      background-image: url('https://nidoum.com/wp-content/uploads/2026/05/Nidoum-Headercasa-scaled.png');
      background-size: cover;
      background-position: center bottom;
      will-change: transform;
      z-index: 10;
    }

    @media (max-width: 768px) {
      .layer-fondo {
        background-image: url('https://nidoum.com/wp-content/uploads/2026/03/Nidoum-Header-fondo-scaled.jpg');
      }

      .layer-casa {
        background-image: url('https://nidoum.com/wp-content/uploads/2026/04/Nidoum-Headercasamovi.png');
      }

      .layer-logo {
        display: none;
      }
    }

    @media (min-width: 769px) {
      .layer-logo {
        display: block;
      }
    }

    .layer-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom,
          rgba(81, 73, 70, 0.08) 0%,
          rgba(81, 73, 70, 0.22) 100%);
      pointer-events: none;
    }

    .header-icon {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      text-align: center;
      z-index: 5;
      pointer-events: none;
    }

    .header-icon img {
      width: 70%;
      max-width: 750px;
      height: auto;
      display: inline-block;
      filter: drop-shadow(0 2px 12px rgba(0, 0, 0, 0.15));
    }

    /* LOGO PEQUEÑO ESQUINA SUPERIOR IZQUIERDA (solo móvil) */
    .site-logo {
      position: absolute;
      top: 13px;
      left: 30px;
      z-index: 31;
      display: none;
      line-height: 0;
    }

    .site-logo img {
      height: 75px;
      width: auto;
      display: block;
      filter: drop-shadow(0 1px 6px rgba(0, 0, 0, 0.2));
    }

    @media (max-width: 768px) {
      .site-logo {
        display: block;
        position: absolute;        /* se mueve con el scroll */
        top: 5%;
        left: 20px;
        z-index: 9999;
      }

      .site-logo img {
        height: 110px;
      }

      .header-icon img {
        width: 100%;
        max-width: 400px;
        padding-top: 40px;
      }
    }

    .nav-item {
      position: relative;
      display: block;
      padding: 10px 22px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 15px;
      font-family: 'Albert Sans', sans-serif;
      font-weight: 400;
      font-size: 13px;
      color: var(--white);
      text-decoration: none;
      letter-spacing: 0.04em;
      overflow: hidden;
      cursor: pointer;
      text-align: center;
      white-space: nowrap;
      background: rgba(255, 255, 255, 0.01);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      transition: color 0.4s ease, border-color 0.4s ease, background 0.4s ease;
    }

    .nav-item::before {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(124, 100, 84, 0.75);
      transform: translateX(-101%);
      transition: transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
      border-radius: 15px;
      z-index: 0;
    }

    .nav-item span {
      position: relative;
      z-index: 1;
      font-family: 'Albert Sans', sans-serif;
      font-weight: 400;
      transition: font-weight 0.35s, color 0.35s;
    }

    .nav-item:hover::before {
      transform: translateX(0);
    }

    .nav-item:hover span {
      font-weight: 500;
      color: var(--white);
    }

    /* MENÚ ESCRITORIO */
    .header-menu {
      position: absolute;
      top: 30px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 30;
      pointer-events: auto;
      width: auto;
    }

    .nav-wrap {
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 16px;
    }

    /* MENÚ MÓVIL */
    .mobile-menu-container {
      display: none;
    }

    @media (max-width: 768px) {
      .menu-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        z-index: 48;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.35s ease, visibility 0.35s ease;
        pointer-events: none;
      }

      .menu-overlay.active {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
      }

      .header-menu {
        display: none;
      }

      .mobile-menu-container {
        display: block;
        position: absolute;        /* se mueve con el scroll */
        top: 10%;
        right: 20px;
        z-index: 9999;
        pointer-events: auto;
      }

      .hamburger {
        position: relative;
        z-index: 51;
        width: 48px;
        height: 48px;
        border-radius: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .hamburger span {
        display: block;
        width: 24px;
        height: 2px;
        background: var(--white);
        transition: 0.3s;
        border-radius: 2px;
      }

      .hamburger.active span:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
      }

      .hamburger.active span:nth-child(2) {
        opacity: 0;
      }

      .hamburger.active span:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
      }

      .mobile-nav {
        position: fixed;
        left: 50%;
        top: 42%;
        transform: translate(-50%, -50%) translateX(120vw);
        transition: transform 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border-radius: 20px;
        padding: 24px 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        width: 260px;
        z-index: 49;
        pointer-events: none;
      }

      .mobile-nav.open {
        transform: translate(-50%, -50%) translateX(0);
        pointer-events: auto;
      }

      .mobile-nav {
        z-index: 9999;
      }

      .mobile-nav .nav-item {
        font-size: 15px;
        padding: 13px 20px;
        width: 100%;
        border: none;
        background: transparent;
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
      }

      .mobile-nav .nav-item::before {
        inset: auto;
        top: auto;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--white);
        border-radius: 0;
        transform: translateX(-101%);
        transition: transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
      }

      .mobile-nav .nav-item:hover::before {
        transform: translateX(0);
      }

      .demo-section {
        padding-top: 6rem;
      }
    }

    /* SCROLL HINT */
    .scroll-hint {
      position: absolute;
      bottom: 2rem;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.4rem;
      opacity: 0;
      animation: fadeIn 1s 1.4s ease forwards;
      z-index: 15;
      pointer-events: none;
    }

    .scroll-hint span {
      font-family: 'Albert Sans', sans-serif;
      font-size: 0.62rem;
      letter-spacing: 0.35em;
      color: var(--sandlight60);
      text-transform: uppercase;
    }

    .scroll-line {
      width: 1px;
      height: 44px;
      background: var(--sandlight60);
      opacity: 0.7;
      animation: scrollPulse 2s 1.8s ease-in-out infinite;
      transform-origin: top;
    }

    @keyframes fadeIn {
      to { opacity: 1; }
    }

    @keyframes scrollPulse {
      0% { transform: scaleY(1); opacity: 0.7; }
      50% { transform: scaleY(0.4); opacity: 0.3; }
      100% { transform: scaleY(1); opacity: 0.7; }
    }

    /* DEMO SECTION */
    .demo-section {
      max-width: 760px;
      margin: 0 auto;
      padding: 7rem 2rem;
      text-align: center;
    }

    .demo-section h2 {
      font-family: 'Roboto Serif', serif;
      font-weight: 300;
      font-size: clamp(1.5rem, 3vw, 2.2rem);
      color: var(--sandlight60);
      letter-spacing: 0.08em;
      margin-bottom: 1.2rem;
    }

    .demo-section p {
      font-size: 1rem;
      line-height: 1.85;
      color: var(--sandlight60);
      font-weight: 300;
    }

    .divider {
      width: 48px;
      height: 1px;
      background: var(--sanddark);
      margin: 2rem auto;
      opacity: 0.5;
    }

    /* ---------- ESTILOS DEL FOOTER (integrado) ---------- */
    .nidoum-footer {
      background-color: #514946;
      color: #e6d6c7;
      font-family: 'Albert Sans', sans-serif;
      padding: 1.5rem 2rem 1rem 2rem;
      border-top: 0.5px solid rgba(230, 214, 199, 0.15);
    }
    .footer-container {
      max-width: 1280px;
      margin: 0 auto;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 1.5rem;
      margin-bottom: 1rem;
    }
    .footer-brand { flex: 1 1 240px; }
    .footer-logo {
      width: 180px;
      height: auto;
      margin-bottom: 1rem;
      opacity: 0.92;
      transition: opacity 0.2s;
    }
    .footer-tagline {
      font-family: 'Roboto Serif', serif;
      font-size: 0.85rem;
      font-weight: 300;
      letter-spacing: 0.03em;
      color: #d4c0ae;
      line-height: 1.5;
      max-width: 260px;
      margin-top: 0.5rem;
    }
    .footer-contact { flex: 0 0 auto; margin-left: auto; text-align: left; }
    .contact-title {
      font-size: 0.6rem;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: #b8a898;
      margin-bottom: 1rem;
      font-weight: 400;
      text-align: left;
    }
    .contact-icons { display: flex; flex-direction: column; gap: 0.8rem; }
    .contact-item {
      display: grid;
      grid-template-columns: 18px auto;
      gap: 12px;
      align-items: center;
      font-family: 'Albert Sans', sans-serif;
      font-size: 0.75rem;
      font-weight: 300;
      color: #e0cfbf;
      text-decoration: none;
      transition: color 0.2s;
      text-align: left;
    }
    .contact-item span {
      text-transform: none !important;
      text-align: left;
    }
    .contact-icon-img {
      width: 100%;
      height: auto;
      max-height: 18px;
      object-fit: contain;
      filter: brightness(0) saturate(100%) invert(87%) sepia(10%) saturate(440%) hue-rotate(340deg) brightness(92%) contrast(88%);
      transition: filter 0.2s;
      display: block;
    }
    .contact-icon-img.mail-icon {
      transform: scale(0.9);
      transform-origin: center;
    }
    .contact-item:hover .contact-icon-img {
      filter: brightness(0) saturate(100%) invert(100%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%);
    }
    .privacy-row {
      max-width: 1280px;
      margin: 0.5rem auto 1.2rem auto;
      text-align: right;
    }
    .privacy-link-footer {
      color: #c8b8a8;
      text-decoration: none;
      font-size: 0.65rem;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      border-bottom: 0.5px solid rgba(230, 214, 199, 0.3);
      padding-bottom: 3px;
      transition: color 0.2s, border-color 0.2s;
      display: inline-block;
    }
    .privacy-link-footer:hover { color: #e6d6c7; border-bottom-color: #e6d6c7; }
    .footer-bottom {
      max-width: 1280px;
      margin: 0.8rem auto 0 auto;
      padding-top: 0.8rem;
      border-top: 0.5px solid rgba(230, 214, 199, 0.18);
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
      font-size: 0.65rem;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      color: #b0a094;
    }
    .copyright { font-family: 'Albert Sans', sans-serif; font-weight: 300; }
    .bottom-right { display: flex; gap: 1.5rem; align-items: center; flex-wrap: wrap; }
    .powered-link {
      color: #c8b8a8;
      text-decoration: none;
      transition: color 0.2s;
      font-size: 0.65rem;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      border-bottom: 0.5px solid rgba(230, 214, 199, 0.3);
      padding-bottom: 2px;
    }
    .powered-link:hover { color: #e6d6c7; }
    .partner-logo {
      height: 45px; width: auto; max-height: 45px;
      opacity: 0.9;
      transition: opacity 0.2s, transform 0.2s;
      vertical-align: middle;
      margin-left: 4px;
      display: inline-block;
    }
    .partner-logo:hover { opacity: 1; transform: scale(1.02); }
    @media (max-width: 780px) {
      .footer-container { flex-direction: column; align-items: stretch; gap: 2rem; }
      .footer-contact { margin-left: 0; width: 100%; }
      .privacy-row { text-align: left; margin-top: 0.75rem; margin-bottom: 1.2rem; }
      .footer-bottom { flex-direction: column; align-items: flex-start; }
      .bottom-right { margin-top: 0.5rem; justify-content: flex-start; }
    }
  </style>
</head>

<body>

  <header class="nidoum-header">
    <div class="layer-fondo" id="layerFondo"></div>
    <div class="layer-logo" id="layerLogo"></div>
    <div class="layer-casa" id="layerCasa"></div>
    <div class="layer-overlay"></div>

    <a href="https://nidoum.com" class="site-logo" aria-label="Nidoum inicio">
      <img src="https://nidoum.com/wp-content/uploads/2026/03/03.1_5-MG-Icon_Inv@2x-1.png" alt="Nidoum" />
    </a>

    <div class="header-menu">
      <div class="nav-wrap">
        <a href="https://nidoum.com/nosotros/" class="nav-item"><span>Nosotros</span></a>
        <a href="https://nidoum.com/portafolio/" class="nav-item"><span>Portafolio</span></a>
        <a href="https://nidoum.com/construccion-modular/" class="nav-item"><span>Construcción Modular</span></a>
        <a href="https://nidoum.com/ciclos-de-desarrollo/" class="nav-item"><span>Ciclos de Desarrollo</span></a>
      </div>
    </div>

    <div class="mobile-menu-container">
      <div class="hamburger" id="hamburgerBtn">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="menu-overlay" id="menuOverlay"></div>
      <div class="mobile-nav" id="mobileNav">
        <a href="https://nidoum.com/nosotros/" class="nav-item"><span>Nosotros</span></a>
        <a href="https://nidoum.com/portafolio/" class="nav-item"><span>Portafolio</span></a>
        <a href="https://nidoum.com/construccion-modular/" class="nav-item"><span>Construcción Modular</span></a>
        <a href="https://nidoum.com/ciclos-de-desarrollo/" class="nav-item"><span>Ciclos de Desarrollo</span></a>
      </div>
    </div>

    <div class="header-icon"></div>

    <div class="scroll-hint">
      <span>Desliza</span>
      <div class="scroll-line"></div>
    </div>
  </header>

  <section class="demo-section">
    <h2>Habitat Consciente</h2>
    <div class="divider"></div>
    <p>
      Espacios diseñados con intención, donde cada detalle convive en armonía
      con el entorno natural. Nidoum nace de la convicción de que vivir bien
      es vivir consciente.
    </p>
  </section>
  <section class="demo-section">
    <h2>Diseño con Propósito</h2>
    <div class="divider"></div>
    <p>
      Arquitectura que respira. Materiales que perduran. Comunidades que
      florecen. Cada proyecto es una invitación a reconectar con lo esencial.
    </p>
  </section>

  <!-- ========== FOOTER INTEGRADO ========== -->
  <footer class="nidoum-footer">
    <div class="footer-container">
      <div class="footer-brand">
        <img class="footer-logo"
          src="https://nidoum.com/wp-content/uploads/2026/03/03.1B_8-Logo-Alt_Inv-Core@2x-1.png"
          alt="NIDOUM">
        <div class="footer-tagline">Hábitat consciente · desarrollo con propósito</div>
      </div>
      <div class="footer-contact">
        <div class="contact-title">Contáctanos</div>
        <div class="contact-icons">
          <a href="mailto:pablo@nidoum.com" class="contact-item">
            <img class="contact-icon-img mail-icon"
                 src="https://nidoum.com/wp-content/uploads/2026/04/mail-claro-nidoum.png"
                 alt="Email">
            <span>pablo@nidoum.com</span>
          </a>
          <a href="tel:+524771918521" class="contact-item">
            <img class="contact-icon-img"
                 src="https://nidoum.com/wp-content/uploads/2026/04/telefono-claro-nidoum.png"
                 alt="Teléfono">
            <span>477 191 8521</span>
          </a>
        </div>
      </div>
    </div>

    <div class="privacy-row">
      <a href="https://www.nidoum.com/aviso-de-privacidad" id="privacyLinkFooter" class="privacy-link-footer">Aviso de privacidad</a>
    </div>

    <div class="footer-bottom">
      <div class="copyright">
        © <span id="nidoumYear"></span> NIDOUM — Conscious Habitat
      </div>
      <div class="bottom-right">
        <a href="https://www.huntersolutions.com.mx/" target="_blank" rel="noopener noreferrer" class="powered-link">designed by Hunter Solutions</a>
        <img class="partner-logo"
          src="https://nidoum.com/wp-content/uploads/2026/03/03.1B_10-Arco-Icon_Inv-Core@2x-1.png"
          alt="arcompany · aliados de NIDOUM"
          title="arcompany — aliados NIDOUM">
      </div>
    </div>
  </footer>

  <script>
    /* Parallax - corregido (sin errores PHP) */
    const fondo = document.getElementById('layerFondo');
    const logo = document.getElementById('layerLogo');
    const casa = document.getElementById('layerCasa');
    const SPEED_FONDO = 0.2;
    const SPEED_LOGO = 0.12;
    const SPEED_CASA = -0.05;
    let ticking = false;

    function updateParallax() {
      const scrollY = window.scrollY;
      fondo.style.transform = 'translateY(' + (scrollY * SPEED_FONDO) + 'px)';
      if (logo) {
        logo.style.transform = 'translateY(' + (scrollY * SPEED_LOGO) + 'px)';
      }
      casa.style.transform = 'translateY(' + (scrollY * SPEED_CASA) + 'px)';
      ticking = false;
    }

    window.addEventListener('scroll', () => {
      if (!ticking) { requestAnimationFrame(updateParallax); ticking = true; }
    }, { passive: true });

    /* Menú hamburguesa */
    const hamburger = document.getElementById('hamburgerBtn');
    const mobileNav = document.getElementById('mobileNav');
    const menuOverlay = document.getElementById('menuOverlay');

    if (hamburger && mobileNav && menuOverlay) {
      hamburger.addEventListener('click', (e) => {
        e.stopPropagation();
        hamburger.classList.toggle('active');
        mobileNav.classList.toggle('open');
        menuOverlay.classList.toggle('active');
      });

      mobileNav.querySelectorAll('.nav-item').forEach(link => {
        link.addEventListener('click', () => {
          hamburger.classList.remove('active');
          mobileNav.classList.remove('open');
          menuOverlay.classList.remove('active');
        });
      });

      document.addEventListener('click', (e) => {
        if (mobileNav.classList.contains('open') &&
            !hamburger.contains(e.target) &&
            !mobileNav.contains(e.target)) {
          hamburger.classList.remove('active');
          mobileNav.classList.remove('open');
          menuOverlay.classList.remove('active');
        }
      });
    }

    /* Footer: año actual */
    document.getElementById('nidoumYear').innerText = new Date().getFullYear();
  </script>

HTML;

        echo $mi_html;

        // Aquí se ejecuta cualquier snippet enganchado a wp_footer (incluye tu footer si lo hubieras puesto ahí, pero ya está integrado)
        wp_footer();

        // Cierre de body y html
        echo '</body></html>';

        exit;
    }
}