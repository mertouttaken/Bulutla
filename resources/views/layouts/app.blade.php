<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Bulutla — Dosyalarınızı ve projelerinizi güvenle yönetin' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
      :root{
        --bg:#FBFAF6;
        --bg-soft:#F3F1FB;
        --ink:#171B3D;
        --ink-muted:#6B6A82;
        --accent:#5f1587;
        --accent-deep:#3f0b5c;
        --accent-soft:#5b1185;
        --border:#ECE9F1;
        --shadow:0 1px 2px rgba(23,27,61,.05), 0 14px 32px -20px rgba(23,27,61,.22);
        --danger:#77339c;
        --radius:14px;
        --font-head:'Fraunces', Georgia, serif;
        --font-body:'IBM Plex Sans', system-ui, sans-serif;
      }
      @media (prefers-color-scheme: dark){
        :root:not([data-theme="light"]){
          --bg:#14152A;
          --bg-soft:#1C1D38;
          --ink:#F3F1FA;
          --ink-muted:#ADAAC4;
          --border:#2B2C4E;
          --accent-soft:#312341;
        }
      }
      :root[data-theme="dark"]{
        --bg:#14152A;
        --bg-soft:#1C1D38;
        --ink:#F3F1FA;
        --ink-muted:#ADAAC4;
        --border:#2B2C4E;
        --accent-soft:#3B2A26;
      }
      *{box-sizing:border-box;}
      html{scroll-behavior:smooth;}
      body{
        margin:0;
        background:var(--bg);
        color:var(--ink);
        font-family:var(--font-body);
        line-height:1.5;
        -webkit-font-smoothing:antialiased;
      }
      img{max-width:100%;display:block;}
      a{color:inherit; text-decoration:none;}
      button{font-family:inherit;}
      :focus-visible{outline:2px solid var(--accent); outline-offset:3px;}
      .wrap{max-width:1180px; margin:0 auto; padding:0 28px;}
      
      header.site{position:sticky; top:0; z-index:50; background:var(--bg); border-bottom:1px solid var(--border); backdrop-filter:blur(8px);}
      nav.wrap{display:flex; align-items:center; justify-content:space-between; height:72px;}
      .brand{display:flex; align-items:center; gap:10px; font-family:var(--font-head); font-weight:700; font-size:1.15rem; letter-spacing:-0.01em; color:var(--ink); transition:opacity .15s ease;}
      .brand:hover{opacity:0.85;}
      .brand svg{flex-shrink:0;}
      
      .nav-links{display:flex; align-items:center; gap:6px; list-style:none; margin:0; padding:0;}
      .nav-links a{color:var(--ink-muted); font-size:0.95rem; padding:10px 14px; border-radius:8px; position:relative; transition:all .18s ease;}
      .nav-links a:hover{color:var(--ink); background:var(--bg-soft);}
      .nav-links a.active{color:var(--ink); font-weight:600;}
      .nav-links a.active::after{content:""; position:absolute; left:14px; right:14px; bottom:2px; height:2px; background:var(--accent); border-radius:2px;}
      
      .nav-cta{display:flex; align-items:center; gap:10px;}
      .btn{display:inline-flex; align-items:center; justify-content:center; font-size:0.95rem; font-weight:500; padding:10px 22px; border-radius:10px; border:1px solid transparent; cursor:pointer; transition:all .18s cubic-bezier(0.16, 1, 0.3, 1);}
      .btn:active{transform:translateY(1px);}
      
      .btn-primary{background:var(--accent); color:#FFFFFF; border-color:var(--accent); box-shadow:0 2px 10px rgba(95,21,135,0.25);}
      .btn-primary:hover{background:var(--accent-deep); border-color:var(--accent-deep); transform:translateY(-1px); box-shadow:0 6px 20px rgba(95,21,135,0.38);}
      
      .btn-ghost{background:transparent; color:var(--ink); border-color:var(--border);}
      .btn-ghost:hover{border-color:var(--accent); color:var(--accent); background:rgba(95,21,135,0.06);}

      .btn-panel{background:linear-gradient(135deg, #5f1587, #7c1ba8); color:#FFFFFF; border-color:transparent; box-shadow:0 2px 12px rgba(95,21,135,0.35);}
      .btn-panel:hover{background:linear-gradient(135deg, #4b0e6d, #681491); transform:translateY(-1px); box-shadow:0 6px 18px rgba(95,21,135,0.48); color:#FFFFFF;}

      .btn-admin{background:#230a33; border-color:#5a2577; color:#e9d5ff;}
      .btn-admin:hover{background:#35114d; border-color:#8337ad; color:#ffffff; transform:translateY(-1px); box-shadow:0 4px 14px rgba(58,14,79,0.35);}

      .btn-block{width:100%;}
      .btn-sm{padding:8px 16px; font-size:0.875rem; border-radius:8px;}
      
      .hero{padding:88px 0 96px;}
      .hero .wrap{display:grid; grid-template-columns:1.05fr 0.95fr; gap:64px; align-items:center;}
      .eyebrow-label{font-size:0.875rem; color:var(--ink-muted); margin:0 0 18px;}
      .eyebrow-label strong{color:var(--ink); font-weight:600;}
      h1.display{font-family:var(--font-head); font-weight:600; font-size:clamp(2.5rem, 4.8vw, 4.1rem); line-height:1.08; letter-spacing:-0.01em; margin:0 0 24px;}
      .hero p.lede{font-size:1.15rem; color:var(--ink-muted); max-width:46ch; margin:0 0 34px;}
      .hero-actions{display:flex; gap:14px; flex-wrap:wrap;}
      
      .hero-panel{background:var(--accent-soft); border-radius:22px; padding:26px; position:relative; box-shadow:var(--shadow); transition:transform .25s ease, box-shadow .25s ease;}
      .hero-panel:hover{transform:translateY(-3px); box-shadow:0 18px 42px -16px rgba(95,21,135,0.35);}
      
      .mock-card{background:var(--bg); border-radius:14px; padding:22px; box-shadow:var(--shadow); border:1px solid var(--border); transition:border-color .2s ease;}
      .mock-card:hover{border-color:rgba(95,21,135,0.3);}
      .mock-row{display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--border); font-size:0.9rem;}
      .mock-row:last-child{border-bottom:none;}
      .mock-row .label{color:var(--ink-muted);}
      .mock-badge{font-size:0.75rem; font-weight:600; color:#FFFFFF; background:var(--accent); padding:3px 10px; border-radius:20px;}
      .mock-bar-track{height:6px; border-radius:6px; background:var(--bg-soft); overflow:hidden; margin-top:6px;}
      .mock-bar-fill{height:100%; background:linear-gradient(90deg, var(--accent-deep), var(--accent)); border-radius:6px;}
      
      section{padding:88px 0;}
      section.alt{background:var(--bg-soft);}
      .section-head{display:flex; justify-content:space-between; align-items:flex-end; gap:32px; margin-bottom:52px; border-bottom:1px solid var(--border); padding-bottom:28px;}
      h2.section-title{font-family:var(--font-head); font-weight:600; font-size:clamp(1.7rem, 2.6vw, 2.3rem); letter-spacing:-0.01em; margin:0; max-width:20ch;}
      .section-note{color:var(--ink-muted); margin:0; font-size:0.82rem; font-style:oblique;}
      
      .feature-grid{display:grid; grid-template-columns:1.1fr 1fr 1fr; gap:0; border:1px solid var(--border); border-radius:18px; overflow:hidden; box-shadow:var(--shadow);}
      .feature-cell{padding:36px 32px; border-left:1px solid var(--border); background:var(--bg); transition:background .2s ease;}
      .feature-cell:hover{background:var(--bg-soft);}
      .feature-cell:first-child{border-left:none;}
      .feature-cell.stat{background:#202134; color:#F3F1FA;}
      .feature-cell.stat:hover{background:#25273d;}
      .feature-cell.stat .num{font-family:var(--font-head); font-weight:600; font-size:3rem; color:#d8b4fe; line-height:1;}
      .feature-cell.stat p{color:#B7B5CC; margin-top:10px; font-size:0.95rem;}
      .feature-cell h3{font-family:var(--font-head); font-size:1.1rem; font-weight:600; margin:0 0 10px;}
      .feature-cell p{color:var(--ink-muted); margin:0; font-size:0.95rem;}

      .plans-grid{display:grid; grid-template-columns:repeat(3, 1fr); gap:20px; align-items:stretch;}
      .plan-card{border:1px solid var(--border); border-radius:18px; padding:32px 28px; display:flex; flex-direction:column; background:var(--bg); box-shadow:var(--shadow); transition:transform .2s ease, border-color .2s ease, box-shadow .2s ease;}
      .plan-card:hover{transform:translateY(-4px); border-color:rgba(95,21,135,0.4); box-shadow:0 18px 36px -12px rgba(95,21,135,0.22);}
      .plan-card.featured{border:1px solid var(--border); border-top:5px solid var(--accent); padding-top:28px; position:relative; background:var(--accent-soft);}
      .plan-tag{font-size:0.8rem; color:var(--ink-muted); margin:0 0 6px;}
      .plan-name{font-family:var(--font-head); font-weight:600; font-size:1.4rem; margin:0 0 14px;}
      .plan-price{font-family:var(--font-head); font-weight:700; font-size:2.4rem; margin:0;}
      .plan-price span{font-family:var(--font-body); font-weight:400; font-size:0.95rem; color:var(--ink-muted);}
      .plan-desc{color:var(--ink-muted); font-size:0.92rem; margin:10px 0 24px;}
      .plan-features{list-style:none; padding:0; margin:0 0 28px; flex:1;}
      .plan-features li{display:flex; gap:10px; padding:9px 0; border-top:1px solid var(--border); font-size:0.92rem;}
      .plan-features li:first-child{border-top:none;}
      .plan-features li .tick{color:var(--accent); font-weight:700;}
      
      .auth-shell{min-height:calc(100vh - 72px); display:grid; grid-template-columns:1fr 1fr;}
      .auth-visual{background:#221332; padding:64px; display:flex; flex-direction:column; justify-content:space-between;}
      .auth-visual .quote{font-family:var(--font-head); font-weight:600; font-size:clamp(1.5rem, 2.4vw, 2.1rem); line-height:1.25; max-width:22ch; color:var(--ink);}
      .auth-visual .who{font-size:0.9rem; color:var(--ink-muted);}
      .auth-form-side{display:flex; align-items:center; justify-content:center; padding:64px 40px;}
      .auth-box{width:100%; max-width:380px;}
      .auth-tabs{display:flex; gap:24px; border-bottom:1px solid var(--border); margin-bottom:32px;}
      .auth-tabs a{padding:0 0 14px; font-size:1rem; color:var(--ink-muted); position:relative; transition:color .15s ease;}
      .auth-tabs a:hover{color:var(--ink);}
      .auth-tabs a.active{color:var(--ink); font-weight:600;}
      .auth-tabs a.active::after{content:""; position:absolute; left:0; right:0; bottom:-1px; height:2px; background:var(--accent);}
      
      .field{margin-bottom:18px;}
      .field label{display:block; font-size:0.85rem; color:var(--ink-muted); margin-bottom:6px;}
      .field input{width:100%; padding:11px 13px; border:1px solid var(--border); border-radius:10px; background:var(--bg); color:var(--ink); font-size:0.95rem; font-family:inherit; transition:border-color .15s ease, box-shadow .15s ease;}
      .field input:focus{border-color:var(--accent); outline:none; box-shadow:0 0 0 3px rgba(95,21,135,0.12);}
      .field-row{display:flex; align-items:center; justify-content:space-between; font-size:0.85rem; margin-bottom:22px;}
      .field-row a{color:var(--ink-muted); text-decoration:underline;}
      .field-row a:hover{color:var(--accent);}
      .auth-alt{margin-top:22px; font-size:0.88rem; color:var(--ink-muted); text-align:center;}
      .auth-alt a{color:var(--ink); text-decoration:underline;}
      
      .dash-shell{padding:56px 0 96px;}
      .dash-head{display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:40px;}
      .dash-head h2{font-family:var(--font-head); font-weight:600; font-size:1.9rem; margin:0 0 6px;}
      .dash-head p{color:var(--ink-muted); margin:0;}
      .dash-grid{display:grid; grid-template-columns:1.3fr 1fr; gap:24px;}
      .dash-card{border:1px solid var(--border); border-radius:18px; padding:28px; box-shadow:var(--shadow); transition:border-color .2s ease, transform .2s ease;}
      .dash-card:hover{border-color:rgba(95,21,135,0.3); transform:translateY(-2px);}
      .dash-card h3{font-family:var(--font-head); font-size:1.05rem; font-weight:600; margin:0 0 18px;}
      .current-plan-row{display:flex; justify-content:space-between; align-items:center; padding:18px; background:var(--accent-soft); border-radius:12px; margin-bottom:20px;}
      .current-plan-row .plan-name-sm{font-family:var(--font-head); font-weight:600; font-size:1.15rem;}
      .current-plan-row .plan-price-sm{color:var(--ink-muted); font-size:0.9rem;}
      .usage-item{margin-bottom:16px;}
      .usage-item .usage-label{display:flex; justify-content:space-between; font-size:0.88rem; margin-bottom:6px; color:var(--ink-muted);}
      .usage-track{height:8px; border-radius:6px; background:var(--bg-soft); overflow:hidden;}
      .usage-fill{height:100%; background:linear-gradient(90deg, var(--accent-deep), var(--accent)); border-radius:6px;}
      .invoice-row{display:flex; justify-content:space-between; padding:12px 0; border-top:1px solid var(--border); font-size:0.9rem;}
      .invoice-row:first-child{border-top:none;}
      .status-pill{font-size:0.75rem; font-weight:600; padding:3px 10px; border-radius:20px; background:var(--bg-soft); color:var(--ink);}
      .danger-zone{margin-top:24px; padding-top:20px; border-top:1px solid var(--border);}
      .danger-zone p{color:var(--ink-muted); font-size:0.88rem; margin:0 0 12px;}
      .btn-danger{background:transparent; border:1px solid var(--danger); color:#a690b2;}
      .btn-danger:hover{background:var(--danger); color:#FFF;}
      
      footer{border-top:1px solid var(--border); padding:40px 0; color:var(--ink-muted); font-size:0.85rem;}
      
      @media (max-width: 880px){
        .nav-links{display:none;}
        .hero .wrap{grid-template-columns:1fr; gap:40px;}
        .feature-grid{grid-template-columns:1fr;}
        .feature-cell{border-left:none; border-top:1px solid var(--border);}
        .feature-cell:first-child{border-top:none;}
        .plans-grid{grid-template-columns:1fr;}
        .auth-shell{grid-template-columns:1fr;}
        .auth-visual{display:none;}
        .dash-grid{grid-template-columns:1fr;}
        .section-head{flex-direction:column; align-items:flex-start;}
      }
    </style>
    @livewireStyles
</head>
<body>

<header class="site">
  <nav class="wrap">
    <a href="{{ route('home') }}" class="brand">
      <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
        <rect x="1" y="1" width="24" height="24" rx="7" fill="#2d103f" stroke="#5f1587" stroke-width="1.2"/>
        <path d="M7 16a3.5 3.5 0 0 1-.5-6.96A5 5 0 0 1 16.1 7.2 4 4 0 0 1 19.5 12a3.5 3.5 0 0 1-.5 7H7z" stroke="#e2e8f0" stroke-width="1.5" stroke-linejoin="round"/>
      </svg>
      Bulutla
    </a>
    <ul class="nav-links">
      <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Ana Sayfa</a></li>
      <li><a href="{{ route('plans.index') }}" class="{{ request()->routeIs('plans.*') ? 'active' : '' }}">Planlar</a></li>
      @auth
        <li><a href="{{ route('subscriptions.show') }}" class="{{ request()->routeIs('subscriptions.*') ? 'active' : '' }}">Aboneliğim</a></li>
      @endauth
    </ul>
    <div class="nav-cta">
        @auth
            @php
                $user = Auth::user();
                $isAdmin = $user->is_admin;
            @endphp
            @if ($isAdmin)
                <a href="{{ route('admin.index') }}" class="btn btn-admin btn-sm">Admin Paneli</a>
            @endif
            <a href="{{ route('dashboard') }}" class="btn btn-panel btn-sm">Panel</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm">
                    Çıkış yap
                </button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Giriş yap</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Kayıt ol</a>
        @endguest
    </div>
  </nav>
</header>

<main>
    @yield('content')
    {{ $slot ?? '' }}
</main>

<footer>
  <div class="wrap" style="display:flex; justify-content:space-between; width:100%; flex-wrap:wrap; gap:12px;">
    <span>© 2026 Bulutla</span>
    <span>Bulutla</span>
  </div>
</footer>

@livewireScripts
</body>
</html>