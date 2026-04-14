<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: signin.html');
    exit();
}
$usuarioNome = htmlspecialchars($_SESSION['usuario_nome']);
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Barber</title>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Oswald:wght@300;400;600;700&family=Inter:wght@300;400;500;600&display=swap');

      :root {
        --gold: rgb(171, 105, 13);
        --gold-light: rgb(233, 183, 118);
        --gold-dim: rgba(171, 105, 13, 0.25);
        --dark: #0d0d0d;
        --dark-2: #111;
        --dark-3: #161616;
      }

      * { margin: 0; padding: 0; box-sizing: border-box; }
      html { background: var(--dark); scroll-behavior: smooth; }

      .eyebrow {
        font-family: 'Inter', sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 7px;
        color: var(--gold);
        text-transform: uppercase;
        display: block;
      }

      .rule {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        max-width: 360px;
      }

      .rule::before,
      .rule::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(to right, transparent, var(--gold), transparent);
      }

      .diamond {
        width: 5px;
        height: 5px;
        background: var(--gold);
        transform: rotate(45deg);
        flex-shrink: 0;
      }

      .section-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        text-align: center;
        padding: 70px 20px 48px;
      }

      .section-header h2 {
        font-family: 'Oswald', sans-serif;
        font-size: 36px;
        font-weight: 600;
        letter-spacing: 6px;
        text-indent: 6px;
        color: var(--gold-light);
        text-transform: uppercase;
      }

      .section-header p {
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 300;
        color: rgba(233, 183, 118, 0.4);
        letter-spacing: 1px;
        margin-top: 4px;
      }

      /* HEADER */
      .header {
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 40px;
        height: 68px;
        background: rgba(10, 10, 10, 0.92);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--gold-dim);
      }

      .header-logo { height: 46px; width: 46px; object-fit: contain; display: block; }

      .submenu {
        display: none;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 4px;
      }

      .submenu img { width: 28px; }

      .nav { display: flex; align-items: center; }

      .close {
        display: none;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 4px;
        position: absolute;
        top: 18px;
        right: 16px;
        z-index: 201;
      }

      .close img { width: 26px; }

      .lista { display: flex; list-style: none; gap: 4px; align-items: center; }

      .lista a {
        font-family: 'Oswald', sans-serif;
        font-size: 11px;
        font-weight: 400;
        letter-spacing: 4px;
        text-transform: uppercase;
        text-decoration: none;
        color: rgba(233, 183, 118, 0.65);
        padding: 8px 14px;
        transition: color 0.2s;
        position: relative;
      }

      .lista a::after {
        content: '';
        position: absolute;
        bottom: 0; left: 14px; right: 14px;
        height: 1px;
        background: var(--gold);
        transform: scaleX(0);
        transition: transform 0.25s ease;
      }

      .lista a:hover { color: var(--gold-light); }
      .lista a:hover::after { transform: scaleX(1); }

      .nav-user {
        font-family: 'Inter', sans-serif;
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 3px;
        color: rgba(233, 183, 118, 0.45);
        text-transform: uppercase;
        padding: 8px 14px;
      }

      /* HERO */
      .hero {
        height: 100vh;
        background: url(../assets/barba.jpeg) center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
      }

      .hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
      }

      .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 16px;
        padding: 0 24px;
      }

      .hero-content h2 {
        font-family: 'Oswald', sans-serif;
        font-size: 80px;
        font-weight: 700;
        letter-spacing: 16px;
        text-indent: 16px;
        color: var(--gold-light);
        text-transform: uppercase;
        line-height: 1;
      }

      .hero-content p {
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        font-weight: 300;
        color: rgba(233, 183, 118, 0.7);
        max-width: 480px;
        line-height: 1.9;
        margin-top: 4px;
      }

      .btn-cta {
        font-family: 'Oswald', sans-serif;
        font-size: 11px;
        font-weight: 400;
        letter-spacing: 5px;
        text-transform: uppercase;
        color: #000;
        background: var(--gold);
        border: none;
        padding: 14px 48px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        margin-top: 12px;
        transition: background 0.25s;
      }

      .btn-cta:hover { background: var(--gold-light); }

      /* SERVICES */
      .services-section {
        display: grid;
        grid-template-columns: 1fr 1px 1fr 1px 1fr;
      }

      .service-card {
        position: relative;
        height: 400px;
        overflow: hidden;
        cursor: pointer;
      }

      .service-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
      }

      .service-card:hover img { transform: scale(1.06); }

      .service-label {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        padding: 60px 24px 22px;
        background: linear-gradient(to top, rgba(0,0,0,0.85), transparent);
      }

      .service-label h3 {
        font-family: 'Oswald', sans-serif;
        font-size: 20px;
        font-weight: 600;
        letter-spacing: 5px;
        text-indent: 5px;
        color: var(--gold-light);
        text-transform: uppercase;
      }

      .service-sep {
        width: 1px;
        background: rgba(171, 105, 13, 0.2);
      }

      /* ABOUT */
      .about-section {
        position: relative;
        display: grid;
        grid-template-columns: 1fr 400px;
        align-items: stretch;
        min-height: 580px;
        background: url(../assets/cabelo.webp) center/cover no-repeat;
        overflow: hidden;
      }

      .about-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.58);
      }

      .about-text {
        position: relative;
        z-index: 1;
        padding: 80px 60px;
        display: flex;
        flex-direction: column;
        gap: 20px;
      }

      .about-text h2 {
        font-family: 'Oswald', sans-serif;
        font-size: 44px;
        font-weight: 700;
        letter-spacing: 8px;
        color: var(--gold-light);
        text-transform: uppercase;
        line-height: 1;
      }

      .about-text p {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 300;
        color: rgba(233, 183, 118, 0.75);
        line-height: 2;
        max-width: 480px;
      }

      .about-img {
        position: relative;
        z-index: 1;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top;
        min-height: 580px;
      }

      .about-marquee-wrap {
        position: absolute;
        bottom: 24px;
        left: 0;
        width: 65%;
        overflow: hidden;
        z-index: 1;
        pointer-events: none;
      }

      .about-marquee {
        font-family: 'Oswald', sans-serif;
        font-size: 110px;
        font-weight: 700;
        color: rgba(255,255,255,0.04);
        white-space: nowrap;
        animation: marquee 12s linear infinite;
      }

      @keyframes marquee {
        from { transform: translateX(40%); }
        to   { transform: translateX(-100%); }
      }

      /* CORTES */
      .cortes-section { background: var(--dark-2); }

      .cortes-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1px;
        padding: 0 1px 60px;
        grid-auto-flow: column;
      }

      .corte-card {
        position: relative;
        height: 420px;
        overflow: hidden;
        cursor: pointer;
        border: 1px solid var(--gold-dim);
      }

      .corte-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        display: block;
        transition: transform 0.55s ease;
      }

      .corte-card:hover img { transform: scale(1.06); }

      .corte-card-label {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        padding: 60px 20px 18px;
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%);
        font-family: 'Oswald', sans-serif;
        font-size: 16px;
        font-weight: 600;
        letter-spacing: 5px;
        text-indent: 5px;
        text-transform: uppercase;
        color: var(--gold-light);
      }

      /* PRICE LIST */
      .price-section {
        background: var(--dark-3);
        border-top: 1px solid var(--gold-dim);
        border-bottom: 1px solid var(--gold-dim);
      }

      .jobs {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        list-style: none;
        max-width: 860px;
        margin: 0 auto;
        padding: 0 40px 70px;
      }

      .jobs li {
        padding: 18px 20px;
        border-bottom: 1px solid rgba(171, 105, 13, 0.1);
        color: rgba(233, 183, 118, 0.35);
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 300;
        transition: color 0.2s;
      }

      .jobs li:hover { color: rgba(233, 183, 118, 0.7); }

      .jobs li span {
        display: block;
        font-family: 'Oswald', sans-serif;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: rgba(233, 183, 118, 0.8);
        margin-bottom: 4px;
      }

      .jobs li:hover span { color: var(--gold); }

      /* BOOKING */
      .booking-section { background: var(--dark-2); }

      #form-agendamento {
        display: flex;
        flex-direction: column;
        width: min(420px, 90%);
        margin: 0 auto;
        padding: 40px;
        border: 1px solid var(--gold-dim);
        margin-bottom: 70px;
      }

      #form-agendamento label {
        font-family: 'Inter', sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold);
        margin-top: 24px;
        margin-bottom: 8px;
        display: block;
      }

      #form-agendamento label:first-child { margin-top: 0; }

      #form-agendamento input {
        width: 100%;
        height: 38px;
        background: transparent;
        border: none;
        border-bottom: 1px solid rgba(171, 105, 13, 0.35);
        color: var(--gold-light);
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 300;
        padding: 0 4px;
        outline: none;
        transition: border-color 0.2s;
        color-scheme: dark;
      }

      #form-agendamento input:focus { border-bottom-color: var(--gold); }

      #form-agendamento button {
        margin-top: 32px;
        height: 44px;
        width: 100%;
        background: var(--gold);
        border: none;
        color: #000;
        font-family: 'Oswald', sans-serif;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 5px;
        text-transform: uppercase;
        cursor: pointer;
        transition: background 0.25s;
      }

      #form-agendamento button:hover { background: var(--gold-light); }

      /* FOOTER */
      footer {
        background: #080808;
        border-top: 1px solid var(--gold-dim);
        padding: 60px 40px 40px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
      }

      .footer-brand h3 {
        font-family: 'Oswald', sans-serif;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 6px;
        color: var(--gold-light);
        text-transform: uppercase;
        margin-bottom: 8px;
      }

      .footer-brand p {
        font-family: 'Playfair Display', serif;
        font-style: italic;
        font-size: 12px;
        color: rgba(233, 183, 118, 0.3);
      }

      .footer-col h4 {
        font-family: 'Oswald', sans-serif;
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 5px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 16px;
      }

      .footer-col p {
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 300;
        color: rgba(233, 183, 118, 0.35);
        line-height: 2.4;
        cursor: pointer;
        transition: color 0.2s;
      }

      .footer-col p:hover { color: var(--gold-light); }

      .footer-copy {
        grid-column: 1 / -1;
        border-top: 1px solid rgba(171, 105, 13, 0.1);
        padding-top: 24px;
        text-align: center;
        font-family: 'Inter', sans-serif;
        font-size: 10px;
        font-weight: 300;
        letter-spacing: 3px;
        color: rgba(233, 183, 118, 0.18);
        text-transform: uppercase;
      }

      /* MOBILE */
      @media (max-width: 768px) {
        .header { padding: 0 20px; }
        .submenu { display: flex; }

        .nav {
          position: fixed;
          top: 0; right: -100%;
          width: 220px;
          height: 100vh;
          background: rgba(10,10,10,0.98);
          border-left: 1px solid var(--gold-dim);
          flex-direction: column;
          align-items: flex-start;
          padding: 70px 0 0;
          transition: right 0.3s ease;
          z-index: 200;
        }

        .nav.open { right: 0; }
        .close { display: flex; }

        .lista { flex-direction: column; width: 100%; gap: 0; }
        .lista a {
          display: block;
          padding: 16px 24px;
          border-bottom: 1px solid rgba(171,105,13,0.1);
          font-size: 12px;
        }

        .nav-user { padding: 16px 24px; display: block; }

        .hero-content h2 { font-size: 44px; letter-spacing: 8px; text-indent: 8px; }
        .hero-content p { font-size: 13px; }

        .services-section { grid-template-columns: 1fr; }
        .service-sep { display: none; }
        .service-card { height: 280px; }

        .about-section { grid-template-columns: 1fr; }
        .about-text { padding: 50px 24px; }
        .about-img { min-height: 300px; height: 300px; }
        .about-marquee { font-size: 60px; }

        .cortes-scroll-wrap { padding: 0 20px 50px; }

        .jobs { grid-template-columns: 1fr; padding: 0 24px 60px; }

        #form-agendamento { padding: 28px 20px; }

        footer {
          grid-template-columns: 1fr;
          padding: 40px 24px 32px;
          gap: 32px;
        }
      }

      @media (max-width: 768px) {
        .cortes-grid { grid-template-columns: 1fr; }
        .corte-card { height: 320px; }
      }
    </style>
  </head>
  <body>

    <!-- HEADER -->
    <header class="header">
      <img src="../assets/image 20.png" class="header-logo" alt="The Barber" />
      <button class="submenu" aria-label="Menu">
        <img src="../assets/menu_24dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.svg" alt="" />
      </button>
      <nav class="nav" id="main-nav">
        <button class="close" aria-label="Fechar">
          <img src="../assets/close_24dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.svg" alt="" />
        </button>
        <ul class="lista">
          <li><a href="#">Home</a></li>
          <li><a href="#form-agendamento">Horários</a></li>
          <li><a href="assinatura.html">Assinatura</a></li>
          <li><a href="#cortes">Cortes</a></li>
          <li class="nav-user">Olá, <?= $usuarioNome ?></li>
          <li><a href="logout.php">Sair</a></li>
        </ul>
      </nav>
    </header>

    <!-- HERO -->
    <section class="hero">
      <div class="hero-content">
        <span class="eyebrow">Bem-vindo ao</span>
        <div class="rule"><div class="diamond"></div></div>
        <h2>The Barber</h2>
        <div class="rule"><div class="diamond"></div></div>
        <p>Uma barbearia moderna com uma dose retrô, que se diferencia pela forma tradicional de atendimento e proporciona um local confortável e agradável.</p>
        <a href="#form-agendamento" class="btn-cta">Agendar Horário</a>
      </div>
    </section>

    <!-- SERVICES -->
    <section class="services-section">
      <div class="service-card">
        <img src="../assets/cabelo.webp" alt="Cabelo" />
        <div class="service-label"><h3>Cabelo</h3></div>
      </div>
      <div class="service-sep"></div>
      <div class="service-card">
        <img src="../assets/barba.jpeg" alt="Barba" />
        <div class="service-label"><h3>Barba</h3></div>
      </div>
      <div class="service-sep"></div>
      <div class="service-card">
        <img src="../assets/Kit-produtos-para-barba.jpg" alt="Produtos" />
        <div class="service-label"><h3>Produtos</h3></div>
      </div>
    </section>

    <!-- ABOUT -->
    <section class="about-section">
      <div class="about-text">
        <span class="eyebrow">Nossa Barbearia</span>
        <h2>Clube<br/>da Barba</h2>
        <p>
          Situado no bairro, o Clube da Barba destaca-se pela excelência com cortes
          e estilos premium. Ambiente acolhedor, bebidas para consumo no local,
          fliperama, jogos de tabuleiro, boas revistas e música — tudo pensado
          para a sua experiência.
        </p>
      </div>
      <img src="../assets/viking.png" class="about-img" alt="" />
      <div class="about-marquee-wrap">
        <div class="about-marquee">THE BARBER</div>
      </div>
    </section>

    <!-- CORTES -->
    <section id="cortes" class="cortes-section">
      <div class="section-header">
        <span class="eyebrow">Galeria</span>
        <div class="rule"><div class="diamond"></div></div>
        <h2>Estilos &amp; Cortes</h2>
        <p>Arraste para ver mais estilos</p>
      </div>
      <div class="cortes-grid">

          <div class="corte-card">
            <img src="../assets/low-fade-1.png" alt="Low Fade" />
            <div class="corte-card-label">Low Fade</div>
          </div>

          <div class="corte-card">
            <img src="../assets/high-fade-1.png" alt="High Fade" />
            <div class="corte-card-label">High Fade</div>
          </div>

          <div class="corte-card">
            <img src="../assets/buzz-cut.png" alt="Buzz Cut" />
            <div class="corte-card-label">Buzz Cut</div>
          </div>

          <div class="corte-card">
            <img src="../assets/visagismo.webp" alt="Visagismo" />
            <div class="corte-card-label">Visagismo</div>
          </div>

          <div class="corte-card">
            <img src="../assets/nevou-1.webp" alt="Nevou" />
            <div class="corte-card-label">Nevou</div>
          </div>

          <div class="corte-card">
            <img src="../assets/reflexo-1.webp" alt="Reflexo" />
            <div class="corte-card-label">Reflexo</div>
          </div>

      </div>
    </section>

    <!-- PRICE LIST -->
    <section class="price-section">
      <div class="section-header">
        <span class="eyebrow">Serviços</span>
        <div class="rule"><div class="diamond"></div></div>
        <h2>Nossos Serviços</h2>
      </div>
      <ul class="jobs">
        <li><span>Corte de Cabelo</span>Corte de todos os estilos</li>
        <li><span>Barba com Toalha Quente</span>Procedimento com massageador</li>
        <li><span>Corte + Barba</span>Combo completo</li>
        <li><span>Pezinho</span>Acabamento e alinhamento</li>
        <li><span>Barbaterapia</span>Limpeza, esfoliação e massageador</li>
        <li><span>Selagem Cabelo Curto</span>Recuperação de cabelo</li>
        <li><span>Tintura Cabelo Curto</span>&nbsp;</li>
        <li><span>Reconstrução Cabelo Curto</span>&nbsp;</li>
        <li><span>Tintura para Barba</span>&nbsp;</li>
        <li><span>Relaxamento</span>&nbsp;</li>
      </ul>
    </section>

    <!-- BOOKING -->
    <section class="booking-section">
      <div class="section-header">
        <span class="eyebrow">Funcionamento</span>
        <div class="rule"><div class="diamond"></div></div>
        <h2>Agendar Horário</h2>
        <p>Consulte nossos horários e agende seu atendimento</p>
      </div>
      <form id="form-agendamento">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= $usuarioNome ?>" required />
        <label>Data</label>
        <input type="date" name="data" required />
        <label>Hora</label>
        <input type="time" name="hora" required />
        <button type="submit">Confirmar Agendamento</button>
      </form>
    </section>

    <!-- FOOTER -->
    <footer>
      <div class="footer-brand">
        <h3>The Barber</h3>
        <p>Tradição que Transforma</p>
      </div>
      <div class="footer-col">
        <h4>Empresa</h4>
        <p>Trabalhe Conosco</p>
        <p>Sobre Nós</p>
        <p>Nossas Barbearias</p>
        <p>Baixe nosso App</p>
      </div>
      <div class="footer-col">
        <h4>Ajuda</h4>
        <p>Contate-nos</p>
        <p>Políticas e Privacidade</p>
        <p>Acessibilidade</p>
        <p>Central de Ajuda</p>
      </div>
      <p class="footer-copy">Todos os direitos reservados &copy; 2025 &nbsp;·&nbsp; The Barber</p>
    </footer>

    <script>
      /* Form */
      document.getElementById('form-agendamento').addEventListener('submit', function(e) {
        e.preventDefault();
        fetch('agendamento.php', { method: 'POST', body: new FormData(this) })
          .then(r => r.text())
          .then(msg => alert(msg))
          .catch(() => alert('Erro ao agendar!'));
      });

      /* Mobile nav */
      const nav = document.getElementById('main-nav');
      document.querySelector('.submenu').addEventListener('click', () => nav.classList.add('open'));
      document.querySelector('.close').addEventListener('click',   () => nav.classList.remove('open'));
    </script>
  </body>
</html>
