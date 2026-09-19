@extends('layouts.app')

@section('content')
<style>
  @keyframes slideInLeft {
    0% {
      opacity: 0;
      transform: translateX(-40px);
    }
    100% {
      opacity: 1;
      transform: translateX(0);
    }
  }

  @keyframes slideInRight {
    0% {
      opacity: 0;
      transform: translateX(40px);
    }
    100% {
      opacity: 1;
      transform: translateX(0);
    }
  }

  @keyframes loadBar {
    0% { width: 0%; }
    100% { width: var(--bar-fill); }
  }

  .landing-page {
    background: #0b0c16;
    color: #e2e8f0;
    font-family: inherit;
    width: 100%;
    overflow-x: hidden;
  }

  .landing-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
    box-sizing: border-box;
  }

  /* Hero */
  .landing-hero {
    padding: 70px 0 80px;
    background: radial-gradient(circle at 65% 15%, rgba(139, 30, 196, 0.2) 0%, transparent 60%);
  }

  .hero-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 50px;
  }

  @media (max-width: 900px) {
    .hero-flex {
      flex-direction: column;
      text-align: center;
    }
  }

  .hero-left {
    flex: 1 1 55%;
    min-width: 0;
    animation: slideInLeft 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    will-change: transform, opacity;
  }

  .badge-tag {
    display: inline-block;
    background: rgba(139, 30, 196, 0.15);
    border: 1px solid rgba(192, 132, 252, 0.35);
    color: #c084fc;
    font-size: 0.85rem;
    padding: 6px 16px;
    border-radius: 999px;
    margin-bottom: 22px;
    font-weight: 500;
  }

  .hero-title {
    font-size: clamp(2.2rem, 3.8vw, 3.2rem);
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -0.02em;
    color: #ffffff;
    margin: 0 0 18px 0;
  }

  .hero-desc {
    font-size: 1.05rem;
    line-height: 1.6;
    color: #94a3b8;
    margin: 0 0 30px 0;
    max-width: 520px;
  }

  @media (max-width: 900px) {
    .hero-desc {
      margin-left: auto;
      margin-right: auto;
    }
  }

  .hero-buttons {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  @media (max-width: 900px) {
    .hero-buttons {
      justify-content: center;
    }
  }

  .btn-purple {
    background: linear-gradient(135deg, #5f1587, #8b1ec4);
    color: #ffffff;
    padding: 12px 26px;
    border-radius: 12px;
    font-size: 0.92rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 6px 20px rgba(139, 30, 196, 0.35);
    transition: all 0.2s ease;
  }

  .btn-purple:hover {
    transform: translateY(-2px);
    opacity: 0.95;
  }

  .btn-outline {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #e2e8f0;
    padding: 12px 24px;
    border-radius: 12px;
    font-size: 0.92rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-outline:hover {
    background: rgba(139, 30, 196, 0.15);
    border-color: rgba(192, 132, 252, 0.35);
    color: #ffffff;
  }

  /* Preview Card */
  .hero-right {
    flex: 0 0 390px;
    width: 390px;
    max-width: 100%;
    animation: slideInRight 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    will-change: transform, opacity;
  }

  .preview-box {
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    padding: 26px;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.4);
    position: relative;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .preview-box::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, #c084fc, transparent);
  }

  .preview-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.88rem;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
  }

  .preview-line .line-label {
    color: #94a3b8;
  }

  .plan-pill {
    background: rgba(139, 30, 196, 0.25);
    border: 1px solid rgba(192, 132, 252, 0.4);
    color: #d8b4fe;
    padding: 4px 12px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.78rem;
  }

  .progress-group {
    display: flex;
    flex-direction: column;
    gap: 14px;
    padding-top: 4px;
  }

  .progress-title {
    display: flex;
    justify-content: space-between;
    font-size: 0.82rem;
    margin-bottom: 6px;
    color: #cbd5e1;
  }

  .track-bar {
    height: 8px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 99px;
    overflow: hidden;
  }

  .fill-bar {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #5f1587, #c084fc);
    border-radius: 99px;
    animation: loadBar 1.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }

  /* Features */
  .section-features {
    padding: 60px 0 80px;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
  }

  .section-head {
    text-align: center;
    margin-bottom: 46px;
  }

  .section-head h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 8px;
  }

  .section-head p {
    color: #94a3b8;
    font-size: 0.95rem;
    margin: 0;
  }

  .feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
  }

  .feature-card {
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    padding: 26px;
    transition: transform 0.25s ease, border-color 0.25s ease;
  }

  .feature-card:hover {
    transform: translateY(-4px);
    border-color: rgba(192, 132, 252, 0.35);
  }

  .feature-card.stat .stat-num {
    font-size: 2.8rem;
    font-weight: 800;
    color: #c084fc;
    line-height: 1;
    margin-bottom: 12px;
  }

  .feature-card h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 10px;
  }

  .feature-card p {
    color: #94a3b8;
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 0;
  }

  /* Pricing */
  .section-plans {
    padding: 60px 0 100px;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
  }

  .plans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 28px;
    align-items: stretch;
  }

  .plan-card {
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    padding: 34px 28px;
    display: flex;
    flex-direction: column;
    position: relative;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
  }

  .plan-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.45);
    border-color: rgba(192, 132, 252, 0.4);
  }

  .plan-card.featured {
    border-color: rgba(192, 132, 252, 0.5);
    background: linear-gradient(180deg, #181935 0%, #111222 100%);
    box-shadow: 0 8px 30px rgba(139, 30, 196, 0.25);
  }

  .plan-badge-top {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #5f1587, #8b1ec4);
    color: #ffffff;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 999px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .plan-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 10px;
  }

  .plan-price {
    font-size: 2.3rem;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.02em;
    margin: 0 0 12px;
  }

  .plan-price span {
    font-size: 0.95rem;
    font-weight: 500;
    color: #94a3b8;
  }

  .plan-desc {
    color: #94a3b8;
    font-size: 0.88rem;
    line-height: 1.5;
    margin: 0 0 24px;
    min-height: 42px;
  }

  .plan-features {
    list-style: none;
    padding: 0;
    margin: 0 0 26px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
  }

  .plan-features li {
    font-size: 0.88rem;
    color: #cbd5e1;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .tick {
    color: #4ade80;
    font-weight: 800;
    background: rgba(74, 222, 128, 0.12);
    border-radius: 50%;
    width: 18px;
    height: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    flex-shrink: 0;
  }

  .btn-block {
    width: 100%;
    text-align: center;
    box-sizing: border-box;
  }
</style>

<div class="landing-page">
  <section class="landing-hero">
    <div class="landing-wrap">
      <div class="hero-flex">
        <div class="hero-left">
          <span class="badge-tag">✨ Küçük ekipler için modern dosya yönetimi</span>
          <h1 class="hero-title">Ekibinizin bulutunu ve planını tek ekrandan yönetin.</h1>
          <p class="hero-desc">Bulutla; güvenli dosya saklama, dinamik plan seçimi ve anlık kota takibini tek bir panelde birleştirir. Sıfır karmaşa, yüksek hız.</p>
          
          <div class="hero-buttons">
            @guest
              <a href="{{ route('register') }}" class="btn-purple">Ücretsiz Başla</a>
              <a href="{{ route('plans.index') }}" class="btn-outline">Planları İncele</a>
            @endguest
            @auth
              <a href="{{ route('dashboard') }}" class="btn-purple">Panele Git →</a>
              <a href="{{ route('subscriptions.show') }}" class="btn-outline">Planını Yönet</a>
            @endauth
          </div>
        </div>

        @auth
          <div class="hero-right">
            <div class="preview-box">
              <div class="preview-line">
                <span class="line-label">Aktif Plan</span>
                <span class="plan-pill">{{ Auth::user()->plan?->name ?? 'Plan Yok' }}</span>
              </div>

              <div class="preview-line">
                <span class="line-label">Sonraki Yenileme</span>
                <span class="file-size">{{ Auth::user()->subscription?->ends_at?->translatedFormat('d F Y') ?? 'Süresiz' }}</span>
              </div>

              @php
                $usedMB = (float) Auth::user()->storageUsedValue();
                $rawLimit = (string) (Auth::user()->plan?->storageLimit() ?? Auth::user()->plan?->storage_limit ?? '0');
                preg_match('/([\d.]+)\s*([a-zA-Z]*)/', $rawLimit, $matches);
                $limitVal = isset($matches[1]) ? (float) $matches[1] : 0;
                $limitUnit = isset($matches[2]) ? strtoupper(trim($matches[2])) : 'MB';
                $storageLimitMB = ($limitUnit === 'GB') ? ($limitVal * 1024) : $limitVal;
                $storagePct = $storageLimitMB > 0 ? min(round(($usedMB / $storageLimitMB) * 100), 100) : 0;

                $usedProj = (int) Auth::user()->projectUsedValue();
                $projLimit = (int) (Auth::user()->plan?->projectLimit() ?? Auth::user()->plan?->project_limit ?? 0);
                $projPct = $projLimit > 0 ? min(round(($usedProj / $projLimit) * 100), 100) : 0;
              @endphp

              <div class="progress-group">
                <div>
                  <div class="progress-title">
                    <span>Depolama</span>
                    <span><strong>{{ $usedMB }} MB</strong> / {{ $storageLimitMB }} MB</span>
                  </div>
                  <div class="track-bar">
                    <div class="fill-bar" style="--bar-fill: {{ $storagePct }}%;"></div>
                  </div>
                </div>

                <div>
                  <div class="progress-title">
                    <span>Aktif Proje</span>
                    <span><strong>{{ $usedProj }}</strong> / {{ $projLimit > 0 ? $projLimit : 'Sınırsız' }}</span>
                  </div>
                  <div class="track-bar">
                    <div class="fill-bar" style="--bar-fill: {{ $projPct }}%;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endauth
      </div>
    </div>
  </section>

  <!-- Özellikler -->
  <section class="section-features">
    <div class="landing-wrap">
      <div class="section-head">
        <h2>Neden ekipler Bulutla'ya geçiyor?</h2>
        <p>Abonelik ve dosya yönetimini ayrı araçlarda değil, tek merkezde toplayın.</p>
      </div>

      <div class="feature-grid">
        <div class="feature-card stat">
          <div class="stat-num">4 dk</div>
          <p>Ortalama kurulum süresi — kredi kartı gerektirmeden hemen başlayın.</p>
        </div>
        <div class="feature-card">
          <h3>Anlık Plan Esnekliği</h3>
          <p>Kullanıcılar tek tıkla planlarını yükseltip düşürebilir, destek talebi açmaya gerek kalmaz.</p>
        </div>
        <div class="feature-card">
          <h3>Şeffaf Kota Takibi</h3>
          <p>Kullanılan depolama alanı, projeler ve faturalandırma tek ekranda; sürpriz ücretler yok.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Planlar -->
  <section class="section-plans">
    <div class="landing-wrap">
      <div class="section-head">
        <h2>Ekibinize uygun planı seçin</h2>
        <p>İstediğiniz zaman geçiş yapın, gizli ücret veya taahhüt yok.</p>
      </div>

      <div class="plans-grid">
        @foreach ($plans as $plan)
          @php
            $isPopular = isset($mostPopularPlan) && $mostPopularPlan?->id === $plan->id;
            $json = json_decode($plan->features, true);
            $features = is_array($json) ? $json : (is_array($plan->features) ? $plan->features : explode(',', (string) $plan->features));
          @endphp

          <div class="plan-card {{ $isPopular ? 'featured' : '' }}">
            @if($isPopular)
              <span class="plan-badge-top">En Çok Tercih Edilen</span>
            @endif

            <h3 class="plan-name">{{ $plan->name }}</h3>
            
            <p class="plan-price">
              {{ !$plan->is_default ? $plan->price . ' ₺' : 'Ücretsiz' }}
              @if($plan->price > 0)
                <span>/ ay</span>
              @endif
            </p>

            <p class="plan-desc">{{ $plan->description }}</p>

            <ul class="plan-features">
              @foreach($features as $feature)
                @if(trim($feature))
                  <li><span class="tick">✓</span> {{ trim($feature) }}</li>
                @endif
              @endforeach
            </ul>

            <a href="{{ route('register') }}" class="btn-purple btn-block">
              {{ !$plan->is_default ? 'Hemen Başla' : 'Ücretsiz Başla' }}
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </section>
</div>
@endsection