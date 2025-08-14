<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="theme-color" content="#0F172A" />
  <title>TUXON | Préstamos inteligentes con QR</title>
  <meta name="description" content="Préstamos rápidos, seguros y confiables. Transacciones por QR, verificación instantánea y soporte humano. Desarrollado por TUXON." />

  <style>
    :root{
      --bg:#0b0e14;
      --bg-soft:#0f1420;
      --panel:#101623;
      --panel-2:#0f172a;
      --txt:#e6e6e6;
      --muted:#a5adba;
      --brand:#55d6be;
      --brand-2:#6ae7c3;
      --accent:#7aa2f7;
      --warning:#ffd166;
      --ok:#5eead4;
      --danger:#fe6a6a;
      --glass:rgba(255,255,255,.06);
      --glass-2:rgba(255,255,255,.08);
      --shadow:0 10px 30px rgba(0,0,0,.35),0 1px 0 rgba(255,255,255,.02) inset;
      --radius:14px;
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial;
      color:var(--txt);
      background:
        radial-gradient(1200px 800px at 80% -100px, rgba(122,162,247,.18), transparent 60%),
        radial-gradient(1200px 800px at 0% 0%, rgba(85,214,190,.18), transparent 50%),
        linear-gradient(180deg, #0b0e14, #0b0e14 30%, #0f1420 85%);
      background-attachment: fixed;
      overflow-x:hidden;
    }
    a{color:inherit;text-decoration:none}

    /* Navbar */
    .nav{
      position:sticky; top:0; z-index:50;
      backdrop-filter:saturate(140%) blur(12px);
      background:linear-gradient(180deg, rgba(10,12,18,.75), rgba(10,12,18,.35));
      border-bottom:1px solid rgba(255,255,255,.06);
    }
    .nav__wrap{
      max-width:1200px; margin:0 auto; padding:14px 20px;
      display:flex; align-items:center; justify-content:space-between; gap:16px;
    }
    .brand{
      display:flex; align-items:center; gap:12px; font-weight:800; letter-spacing:.4px;
    }
    .brand__logo{
      width:38px;height:38px;border-radius:10px;
      background: conic-gradient(from 200deg, var(--brand), var(--accent), var(--brand-2), var(--brand));
      box-shadow:0 8px 20px rgba(106,231,195,.25), inset 0 0 18px rgba(255,255,255,.06);
      position:relative; overflow:hidden;
    }
    .brand__logo::after{
      content:""; position:absolute; inset:2px; border-radius:8px;
      background: radial-gradient(200px 200px at 30% 10%, rgba(255,255,255,.14), transparent 40%);
    }
    .brand__name{
      font-size:1.05rem; line-height:1; display:flex; flex-direction:column;
    }
    .brand__name strong{font-size:1.05rem}
    .brand__tag{font-size:.72rem; color:var(--muted)}

    .nav__links{
      display:flex; align-items:center; gap:10px; flex-wrap:wrap;
    }
    .pill{
      padding:9px 14px; border-radius:999px; border:1px solid rgba(255,255,255,.08);
      background:rgba(255,255,255,.02);
      transition:.25s ease; box-shadow:var(--shadow);
      font-size:.92rem; color:var(--txt);
    }
    .pill:hover{border-color:rgba(255,255,255,.18); transform:translateY(-1px)}
    .cta{
      background:linear-gradient(90deg, var(--brand), var(--accent));
      color:#0a0d14; font-weight:700; border:none;
    }
    .cta:hover{filter:saturate(110%) brightness(1.05)}

    /* Hero */
    .hero{
      max-width:1200px; margin:0 auto; padding:58px 20px 36px;
      display:grid; grid-template-columns: 1.1fr .9fr; gap:36px; align-items:center;
    }
    @media (max-width:980px){ .hero{grid-template-columns:1fr} }
    .eyebrow{
      display:inline-flex; align-items:center; gap:8px; font-size:.85rem; color:var(--muted);
      background:rgba(122,162,247,.08); border:1px solid rgba(122,162,247,.22);
      padding:6px 10px; border-radius:999px;
    }
    .eyebrow b{color:#fff}
    .h1{
      font-size: clamp(2rem, 5vw, 3.2rem); margin:14px 0 12px; line-height:1.08; font-weight:900;
      letter-spacing:.2px;
      text-shadow:0 10px 30px rgba(0,0,0,.35);
    }
    .lead{
      color:#cfd6e6; font-size:1.05rem; line-height:1.6; margin-bottom:22px;
    }
    .hero__actions{display:flex; gap:12px; flex-wrap:wrap}
    .seals{display:flex; gap:12px; flex-wrap:wrap; margin-top:14px}
    .seal{
      display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:10px;
      border:1px solid rgba(255,255,255,.08); background:rgba(255,255,255,.02); color:var(--muted); font-size:.9rem;
    }

    /* Device mock */
    .device{
      position:relative; width:100%; aspect-ratio: 10/13; border-radius:30px;
      background:linear-gradient(180deg, #0f1524, #0b0f19);
      border:1px solid rgba(255,255,255,.12);
      box-shadow: 0 30px 80px rgba(0,0,0,.55), inset 0 0 0 1px rgba(255,255,255,.05);
      overflow:hidden;
      transform: perspective(1200px) rotateY(-8deg) rotateX(2deg);
      transition: transform .6s ease;
    }
    .device:hover{ transform: perspective(1200px) rotateY(-3deg) rotateX(0deg) translateY(-3px) }
    .statusbar{
      position:absolute; inset:10px 10px auto 10px; height:34px; border-radius:16px;
      background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08);
      display:flex; align-items:center; justify-content:space-between; padding:0 10px; color:#cbd5e1; font-size:.85rem;
    }
    .screen{
      position:absolute; inset:54px 14px 14px; border-radius:22px; background: rgba(255,255,255,.03);
      border:1px solid rgba(255,255,255,.06); padding:16px; display:flex; flex-direction:column; gap:12px;
    }
    .qr{
      margin:auto; width:220px; height:220px; border-radius:14px; background:#fff; position:relative; overflow:hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,.35);
    }
    .qr svg{width:100%; height:100%; display:block}
    .scanner{
      position:absolute; top:10%; left:0; right:0; height:3px; background:linear-gradient(90deg, transparent, var(--accent), transparent);
      box-shadow:0 0 18px var(--accent); animation: scan 2.8s linear infinite;
    }
    @keyframes scan{
      0%{transform: translateY(0)}
      100%{transform: translateY(160px)}
    }
    .paybtn{
      margin:0 auto; display:inline-flex; align-items:center; gap:10px;
      padding:12px 16px; border-radius:999px; border:1px solid rgba(255,255,255,.1);
      background:linear-gradient(90deg, var(--brand), var(--accent)); color:#0a0d14; font-weight:800;
      cursor:pointer; transition:.25s;
    }
    .paybtn:hover{filter:saturate(115%) brightness(1.06); transform:translateY(-1px)}

    /* Trust bar */
    .trust{
      max-width:1200px; margin:16px auto 0; padding:0 20px 10px; color:var(--muted);
      display:grid; grid-template-columns: repeat(4, 1fr); gap:12px;
    }
    @media (max-width:980px){ .trust{grid-template-columns: 1fr 1fr} }

    /* Features */
    .section{max-width:1200px; margin:22px auto; padding:6px 20px 20px}
    .sec-title{
      font-size: clamp(1.4rem, 3.4vw, 2.2rem); margin:0 0 10px; font-weight:900;
      background: linear-gradient(90deg, #fff, #9ec9ff 50%, #9affdd); -webkit-background-clip:text; color:transparent;
    }
    .sec-lead{color:#cfd6e6; margin:0 0 18px}
    .grid{
      display:grid; grid-template-columns: repeat(12, 1fr); gap:16px;
    }
    .card{
      grid-column: span 4; min-height: 170px; padding:18px; border-radius:16px;
      background: linear-gradient(180deg, rgba(255,255,255,.03), rgba(255,255,255,.01));
      border:1px solid rgba(255,255,255,.08); box-shadow: var(--shadow); position:relative; overflow:hidden;
      transition:.3s;
    }
    .card:hover{transform:translateY(-3px); border-color: rgba(255,255,255,.16)}
    @media (max-width:980px){ .card{grid-column: span 12} }
    .card h3{margin:4px 0 6px; font-size:1.05rem}
    .card p{margin:0; color:#c9d1e5}
    .badge{
      position:absolute; top:14px; right:14px; font-size:.75rem; color:#081017; font-weight:900;
      background:linear-gradient(90deg, var(--brand), var(--accent)); padding:6px 10px; border-radius:999px;
      border:1px solid rgba(255,255,255,.22)
    }

    /* How it works */
    .steps{display:grid; grid-template-columns: repeat(3,1fr); gap:16px}
    @media (max-width:980px){ .steps{grid-template-columns:1fr} }
    .step{
      padding:16px; border-radius:14px; border:1px solid rgba(255,255,255,.08);
      background:rgba(255,255,255,.02)
    }
    .step-num{
      width:34px; height:34px; border-radius:8px; display:inline-grid; place-items:center; font-weight:800;
      background:rgba(122,162,247,.16); color:#e8f0ff; border:1px solid rgba(122,162,247,.35);
      margin-bottom:8px
    }

    /* Stats */
    .stats{
      display:grid; grid-template-columns: repeat(4,1fr); gap:14px; margin-top:6px
    }
    @media (max-width:980px){ .stats{grid-template-columns:repeat(2,1fr)} }
    .stat{
      padding:16px; border-radius:16px; border:1px solid rgba(255,255,255,.08);
      background:linear-gradient(180deg, rgba(255,255,255,.03), rgba(255,255,255,.01));
      text-align:center
    }
    .stat .num{font-size:1.8rem; font-weight:900; letter-spacing:.4px}
    .stat .sub{color:var(--muted); font-size:.9rem}

    /* Testimonials */
    .carousel{
      position:relative; overflow:hidden; border-radius:16px; border:1px solid rgba(255,255,255,.08);
      background:rgba(255,255,255,.02)
    }
    .track{display:flex; transition: transform .6s ease}
    .tcard{
      min-width: 100%; padding:18px; display:grid; grid-template-columns:80px 1fr; gap:14px; align-items:center
    }
    .avatar{
      width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg, #d4fff2, #a3bfff);
      border:3px solid rgba(255,255,255,.25)
    }
    .quote{color:#e9eefb; font-size:1.02rem; line-height:1.5}
    .who{color:var(--muted); margin-top:6px; font-size:.92rem}

    /* CTA final */
    .cta-block{
      display:grid; grid-template-columns: 1.2fr .8fr; gap:16px; align-items:center;
      border:1px solid rgba(255,255,255,.1); border-radius:18px;
      background:linear-gradient(180deg, rgba(255,255,255,.04), rgba(255,255,255,.02));
      padding:18px;
    }
    @media (max-width:980px){ .cta-block{grid-template-columns:1fr} }
    .cta-big{font-size: clamp(1.3rem, 3vw, 1.8rem); margin:0 0 8px; font-weight:900}
    .list{
      display:grid; grid-template-columns:1fr 1fr; gap:8px 12px; color:#dbe6ff
    }
    @media (max-width:980px){ .list{grid-template-columns:1fr} }
    .list li{display:flex; gap:10px; align-items:flex-start}
    .dot{
      width:10px;height:10px;margin-top:8px;border-radius:50%;
      background:linear-gradient(90deg, var(--brand), var(--accent))
    }

    /* Footer */
    .footer{
      margin-top:28px; border-top:1px solid rgba(255,255,255,.08);
      background:linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01));
    }
    .footer__wrap{
      max-width:1200px; margin:0 auto; padding:16px 20px; display:flex; flex-wrap:wrap; gap:14px; align-items:center; justify-content:space-between;
      color:var(--muted)
    }
    .links{display:flex; gap:12px; flex-wrap:wrap}
    .links a{padding:8px 12px; border-radius:999px; border:1px solid rgba(255,255,255,.06)}
    .links a:hover{border-color:rgba(255,255,255,.16)}

    /* Reveal on scroll */
    .reveal{opacity:0; transform: translateY(10px); transition: .6s ease}
    .reveal.in{opacity:1; transform:none}

    /* Utility */
    .sr{position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0}
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="nav">
    <div class="nav__wrap">
      <a href="/tuxon" class="brand" aria-label="Ir al sitio de TUXON (placeholder)">
        <span class="brand__logo" aria-hidden="true"></span>
        <span class="brand__name"><strong>TUXON</strong><span class="brand__tag">Tecnología financiera</span></span>
      </a>

      <div class="nav__links">
        <a href="#caracteristicas" class="pill">Características</a>
        <a href="#como-funciona" class="pill">Cómo funciona</a>
        <a href="#seguridad" class="pill">Seguridad</a>
        <a href="#clientes" class="pill">Clientes</a>

        <!-- Tus rutas: LOGIN y REGISTER (tal cual las enviaste) -->
        <span aria-hidden="true" style="opacity:.3">|</span>
        <span>
          <a
            href="{{ route('login') }}"
            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
          >
            Log in
          </a>

          @if (Route::has('register'))
            <a
              href="{{ route('register') }}"
              class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
              Register
            </a>
          @endif
        </span>

        <a href="#empezar" class="pill cta">Empieza ahora</a>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <header class="hero">
    <div>
      <span class="eyebrow">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="#7aa2f7" aria-hidden="true"><path d="M12 1l3 5 5 3-5 3-3 5-3-5-5-3 5-3 3-5z"/></svg>
        <b>Préstamos inteligentes</b> con verificación instantánea
      </span>
      <h1 class="h1">Financia tus metas con transacciones QR seguras y sin fricción</h1>
      <p class="lead">
        Solicita, recibe y paga tus préstamos en minutos. Sin papeleo innecesario, sin filas. Seguridad de nivel bancario, experiencia humana.
      </p>

      <div class="hero__actions">
        <!-- CTA primario que también puede llevar al registro -->
        <a href="{{ route('register') }}" class="pill cta">Crear mi cuenta</a>
        <a href="{{ route('login') }}" class="pill" style="border-color:rgba(255,255,255,.16)">Ya tengo cuenta</a>
      </div>

      <div class="seals">
        <div class="seal">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="#5eead4" aria-hidden="true"><path d="M12 1l9 4v6c0 5-4 9-9 12-5-3-9-7-9-12V5l9-4zm-3 11l2 2 4-5-1.5-1-2.5 3-1-1-1.5 2z"/></svg>
          Cifrado extremo a extremo
        </div>
        <div class="seal">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="#ffd166" aria-hidden="true"><path d="M12 2a5 5 0 015 5v3h2a1 1 0 011 1v9a2 2 0 01-2 2H6a2 2 0 01-2-2v-9a1 1 0 011-1h2V7a5 5 0 015-5zm-3 8h6V7a3 3 0 10-6 0v3z"/></svg>
          Autenticación con QR
        </div>
        <div class="seal">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="#9affdd" aria-hidden="true"><path d="M3 6h18v12H3V6zm2 2v8h14V8H5zm3 1h3v3H8V9zm5 0h3v3h-3V9z"/></svg>
          Auditoría de transacciones
        </div>
      </div>
    </div>

    <!-- Dispositivo con QR animado -->
    <div class="device" aria-label="Demostración de pago con QR">
      <div class="statusbar">
        <span>TUXON Pay</span>
        <span>100%</span>
      </div>
      <div class="screen">
        <div class="qr" role="img" aria-label="Código QR">
          <!-- Simple QR SVG (placeholder) -->
          <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
            <rect width="120" height="120" fill="#fff"/>
            <rect x="8" y="8" width="30" height="30" fill="#000"/>
            <rect x="82" y="8" width="30" height="30" fill="#000"/>
            <rect x="8" y="82" width="30" height="30" fill="#000"/>
            <rect x="46" y="46" width="10" height="10" fill="#000"/>
            <rect x="60" y="46" width="6" height="6" fill="#000"/>
            <rect x="70" y="46" width="8" height="8" fill="#000"/>
            <rect x="46" y="60" width="8" height="8" fill="#000"/>
            <rect x="58" y="60" width="12" height="12" fill="#000"/>
            <rect x="74" y="62" width="6" height="6" fill="#000"/>
            <rect x="90" y="46" width="10" height="10" fill="#000"/>
            <rect x="46" y="78" width="6" height="6" fill="#000"/>
            <rect x="58" y="78" width="10" height="10" fill="#000"/>
            <rect x="74" y="78" width="8" height="8" fill="#000"/>
          </svg>
          <div class="scanner" aria-hidden="true"></div>
        </div>
        <button class="paybtn" id="mockPay">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="#0a0d14" aria-hidden="true"><path d="M3 7h18v10H3V7zm2 2v6h14V9H5zm2 1h3v2H7v-2zm9 0h3v2h-3v-2z"/></svg>
          Escanear y Pagar
        </button>
      </div>
    </div>
  </header>

  <!-- TRUST BAR -->
  <section class="trust">
    <div class="seal"><strong style="color:#eafbf6">99.99%</strong>&nbsp;uptime</div>
    <div class="seal">Monitoreo antifraude 24/7</div>
    <div class="seal">Respuesta en menos de 2 min</div>
    <div class="seal">Soporte humano y cercano</div>
  </section>

  <!-- FEATURES -->
  <section id="caracteristicas" class="section reveal">
    <h2 class="sec-title">Todo lo que necesitas para un préstamo sin fricciones</h2>
    <p class="sec-lead">Del onboarding al desembolso y pago por QR. Transparencia, velocidad y control en un solo lugar.</p>

    <div class="grid">
      <article class="card">
        <span class="badge">QR-first</span>
        <h3>Onboarding con QR</h3>
        <p>Regístrate y verifica identidad en minutos. Sin filas ni trámites interminables.</p>
      </article>
      <article class="card">
        <span class="badge">24/7</span>
        <h3>Desembolsos rápidos</h3>
        <p>Aprobaciones automatizadas y liberación inmediata cuando calificas.</p>
      </article>
      <article class="card">
        <span class="badge">Transparente</span>
        <h3>Cuotas claras</h3>
        <p>Simulador con tasas y fechas exactas. Sin letras pequeñas.</p>
      </article>

      <article class="card">
        <span class="badge">Escalable</span>
        <h3>Panel empresarial</h3>
        <p>Gestión de cartera, moras, reportes y auditoría a detalle.</p>
      </article>
      <article class="card">
        <span class="badge">Blindado</span>
        <h3>Seguridad avanzada</h3>
        <p>Cifrado E2E, tokenización y monitoreo activo de riesgos.</p>
      </article>
      <article class="card">
        <span class="badge">Local</span>
        <h3>Pagos en tu moneda</h3>
        <p>Integrado a tu realidad: QR interoperable y conciliación automática.</p>
      </article>
    </div>
  </section>

  <!-- HOW IT WORKS -->
  <section id="como-funciona" class="section reveal">
    <h2 class="sec-title">Cómo funciona</h2>
    <div class="steps">
      <div class="step">
        <div class="step-num">1</div>
        <h3>Regístrate</h3>
        <p>Crea tu cuenta, verifica tu identidad y configura tu método QR preferido.</p>
      </div>
      <div class="step">
        <div class="step-num">2</div>
        <h3>Solicita</h3>
        <p>Elige monto y plazo. Te mostramos la cuota real, sin sorpresas.</p>
      </div>
      <div class="step">
        <div class="step-num">3</div>
        <h3>Paga con QR</h3>
        <p>Escanea desde la app y listo. Notificación y recibo instantáneos.</p>
      </div>
    </div>
  </section>

  <!-- STATS -->
  <section class="section reveal" id="seguridad">
    <h2 class="sec-title">Confianza que se siente</h2>
    <p class="sec-lead">Diseñado con estándares de la industria y un toque humano. Tu tranquilidad es primero.</p>
    <div class="stats">
      <div class="stat">
        <div class="num" data-count="1200000">0</div>
        <div class="sub">Transacciones por QR</div>
      </div>
      <div class="stat">
        <div class="num" data-count="98">0</div>
        <div class="sub">% aprobaciones en 24h</div>
      </div>
      <div class="stat">
        <div class="num" data-count="2">0</div>
        <div class="sub">min respuesta promedio</div>
      </div>
      <div class="stat">
        <div class="num" data-count="99.99">0</div>
        <div class="sub">% disponibilidad</div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIOS -->
  <section id="clientes" class="section reveal">
    <h2 class="sec-title">Lo que dicen nuestros clientes</h2>
    <div class="carousel" aria-roledescription="carousel" aria-label="Testimonios">
      <div class="track" id="track">
        <div class="tcard">
          <div class="avatar" aria-hidden="true"></div>
          <div>
            <div class="quote">“Solicité un préstamo en la noche y al día siguiente ya estaba aprobado. El pago por QR es comodísimo.”</div>
            <div class="who">María — Emprendedora</div>
          </div>
        </div>
        <div class="tcard">
          <div class="avatar" aria-hidden="true"></div>
          <div>
            <div class="quote">“La app es clara y no hay letra chica. El simulador me ayudó a planificar mis pagos sin estrés.”</div>
            <div class="who">Jorge — Independiente</div>
          </div>
        </div>
        <div class="tcard">
          <div class="avatar" aria-hidden="true"></div>
          <div>
            <div class="quote">“Seguridad de primera y soporte real. Se siente que cuidan cada detalle.”</div>
            <div class="who">Lucía — Profesional</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA FINAL -->
  <section id="empezar" class="section reveal">
    <div class="cta-block">
      <div>
        <h3 class="cta-big">Listo para empezar en minutos</h3>
        <p class="sec-lead">Crea tu cuenta, verifica con QR y prepárate para financiar tus metas con claridad.</p>
        <ul class="list">
          <li><span class="dot"></span><span>Registro y verificación sin fricción</span></li>
          <li><span class="dot"></span><span>Tasas y cuotas transparentes</span></li>
          <li><span class="dot"></span><span>Pagos QR interoperables</span></li>
          <li><span class="dot"></span><span>Soporte humano cuando lo necesitas</span></li>
        </ul>
      </div>
      <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap">
        <a href="{{ route('register') }}" class="pill cta">Crear mi cuenta</a>
        <a href="{{ route('login') }}" class="pill" style="border-color:rgba(255,255,255,.16)">Ingresar</a>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer__wrap">
      <div>
        <strong style="color:#eafbf6">TUXON</strong> — tecnología para finanzas cotidianas
      </div>
      <div class="links">
        <a href="/tuxon">Desarrollado por TUXON</a>
        <a href="#seguridad">Seguridad</a>
        <a href="#caracteristicas">Características</a>
        <a href="#clientes">Clientes</a>
      </div>
    </div>
  </footer>

  <script>
    // Reveal on scroll
    const io = new IntersectionObserver((entries)=>{
      entries.forEach(e=>{
        if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target) }
      })
    },{threshold:.12});
    document.querySelectorAll('.reveal').forEach(el=>io.observe(el));

    // Counters
    const counterEls = document.querySelectorAll('.stat .num');
    const countersIO = new IntersectionObserver((entries)=>{
      entries.forEach(e=>{
        if(!e.isIntersecting) return;
        const el=e.target; const target=parseFloat(el.dataset.count);
        const duration=1200; const start=performance.now();
        const isFloat = String(target).includes('.');
        function tick(t){
          const p=Math.min(1,(t-start)/duration);
          const val = target * (0.2 + 0.8*Math.pow(p,0.85));
          el.textContent = isFloat ? val.toFixed(2) : Math.floor(val).toLocaleString();
          if(p<1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
        countersIO.unobserve(el);
      })
    },{threshold:.4});
    counterEls.forEach(el=>countersIO.observe(el));

    // Testimonials carousel
    const track = document.getElementById('track');
    let idx=0;
    setInterval(()=>{
      idx=(idx+1)%3;
      track.style.transform = `translateX(-${idx*100}%)`;
    }, 3800);

    // Mock pay button
    const mockPay=document.getElementById('mockPay');
    mockPay?.addEventListener('click', ()=>{
      mockPay.disabled=true;
      const original = mockPay.innerHTML;
      mockPay.innerHTML = `
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#0a0d14"><path d="M12 2a10 10 0 1010 10A10.011 10.011 0 0012 2zm1 5h-2v5.414l4.293 4.293 1.414-1.414L13 11.586z"/></svg>
        Procesando...
      `;
      setTimeout(()=>{
        mockPay.innerHTML = `
          <svg width="18" height="18" viewBox="0 0 24 24" fill="#0a0d14"><path d="M20.285 6.708l-11 11-5-5 1.414-1.414L9.285 15l9.586-9.586z"/></svg>
          Pago confirmado
        `;
        setTimeout(()=>{ mockPay.innerHTML = original; mockPay.disabled=false; }, 2200);
      }, 1200);
    });

    // Smooth anchors
    document.querySelectorAll('a[href^="#"]').forEach(a=>{
      a.addEventListener('click', (e)=>{
        const id = a.getAttribute('href').slice(1);
        const el = document.getElementById(id);
        if(el){
          e.preventDefault();
          window.scrollTo({top: el.getBoundingClientRect().top + window.scrollY - 70, behavior:'smooth'});
        }
      })
    });
  </script>
</body>
</html>
