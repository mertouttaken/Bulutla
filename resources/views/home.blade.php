@extends('layouts.app')

@section('content')
<section class="hero">
  <div class="wrap">
    <div>
      <p class="eyebrow-label">Küçük ekipler için <strong>abonelik ve plan yönetimi</strong></p>
      <h1 class="display">Ekibinizin planını tek ekrandan yönetin.</h1>
      <p class="lede">Planla; kayıt olma, plan seçme ve abonelik takibini tek bir akışta toplar. Kurulumu 5 dakika, öğrenmesi bir kahve molası kadar sürer.</p>
      <div class="hero-actions">
        @guest
          <a href="{{ route('register') }}" class="btn btn-primary">Ücretsiz Başla</a>
          <a href="{{ route('plans.index') }}" class="btn btn-ghost">Planları İncele</a>
        @endguest
        @auth
          <a href="{{ route('subscriptions.show') }}" class="btn btn-primary">Panele git</a>
          <a href="{{ route('subscriptions.show') }}" class="btn btn-ghost">Planını yönet</a>
        @endauth
      </div>
    </div>
    @auth
    @if(Auth::check())  
    <div class="hero-panel">
      <div class="mock-card">
        <div class="mock-row">
          <span class="label">Aktif plan</span>
          <span class="mock-badge">{!! Auth::user()->currentPlan()->name !!}</span>
        </div>
        <div class="mock-row">
          <span class="label">Sonraki yenileme</span>
          <span>{{ Auth::user()->subscriptions()->latest()->first()?->nextBillingDate() }}</span>
        </div>
        <div style="padding-top:14px;">
          <div class="usage-item" style="margin-bottom:12px;">
            <div class="usage-label"><span>Depolama</span><span>{{ Auth::user()->storageUsedFormatted() }} / {{ Auth::user()->plan?->storageLimit() }}</span></div>
            @php
                $rawUsed = Auth::user()->storageUsed();
                $usedValue = (float) $rawUsed;
                $storageUsed = str_contains($rawUsed, 'GB') ? $usedValue * 1024 : $usedValue;

                $rawLimit = Auth::user()->plan?->storageLimit() ?? '0';
                $limitValue = (float) $rawLimit;
                $storageLimit = str_contains($rawLimit, 'GB') ? $limitValue * 1024 : $limitValue;

                $storagePercentage = $storageLimit > 0 ? ($storageUsed / $storageLimit) * 100 : 0;

            @endphp
            <div class="mock-bar-track"><div class="mock-bar-fill" style="width:{{ $storagePercentage }}%;"></div></div>
          </div>
          <div class="usage-item" style="margin-bottom:0;">
            @php
                $rawUsed = Auth::user()->projectUsedValue();
                $projectLimit = Auth::user()->plan?->projectLimit() ?? 0;
                $projectPercentage = $projectLimit > 0 ? ($rawUsed / $projectLimit) * 100 : 0;            
            @endphp
            <div class="usage-label"><span>Proje</span><span>{{ Auth::user()->projectUsedValue() }} / {{ Auth::user()->plan?->projectLimit() > 0 ? Auth::user()->plan?->projectLimit() : 'Sınırsız' }}</span></div>
            <div class="mock-bar-track"><div class="mock-bar-fill" style="width:{{ $projectPercentage }}%;"></div></div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  @endauth
</section>

<section class="alt">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title">Neden ekipler Planla'ya geçiyor</h2>
      <p class="section-note">Abonelik yönetimini ayrı bir tabloda değil, ürünün içinde tutun.</p>
    </div>
    <div class="feature-grid">
      <div class="feature-cell stat">
        <div class="num">4dk</div>
        <p>ortalama kurulum süresi — kredi kartı bilgisi olmadan deneme başlatılır.</p>
      </div>
      <div class="feature-cell">
        <h3>Anlık plan değişimi</h3>
        <p>Kullanıcılar planlarını kendileri yükseltir ya da düşürür, destek talebi açmaya gerek kalmaz.</p>
      </div>
      <div class="feature-cell">
        <h3>Tek ekranda görünürlük</h3>
        <p>Kullanım, fatura ve yenileme tarihi aynı panelde; e-posta arasında kaybolmaz.</p>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title">Ekibinize uygun planı seçin</h2>
      <p class="section-note">İstediğiniz zaman değiştirin, gizli ücret yok.</p>
    </div>
    <div class="plans-grid">
      <div class="plan-card">
        <p class="plan-tag">Bireysel</p>
        <h3 class="plan-name">Free</h3>
        <p class="plan-price">Ücretsiz</p>
        <p class="plan-desc">Tek  başına çalışan kullanıcılar için başlangıç planı.</p>
        <ul class="plan-features">
          <li><span class="tick">✓</span>1 proje</li>
          <li><span class="tick">✓</span>100 MB depolama</li>
          <li><span class="tick">✓</span>Topluluk desteği</li>
        </ul>
        <a href="{{ route('register') }}" class="btn btn-ghost btn-block">Ücretsiz başla</a>
      </div>

      <div class="plan-card featured">
        <p class="plan-tag">En çok tercih edilen</p>
        <h3 class="plan-name">Pro</h3>
        <p class="plan-price">199,00 ₺<span>/ ay</span></p>
        <p class="plan-desc">Büyüyen ekipler için gelişmiş özellikler.</p>
        <ul class="plan-features">
          <li><span class="tick">✓</span>10 proje</li>
          <li><span class="tick">✓</span>10 GB depolama</li>
          <li><span class="tick">✓</span>E-posta desteği</li>
          <li><span class="tick">✓</span>Gelişmiş raporlar</li>
        </ul>
        <a href="{{ route('register') }}" class="btn btn-primary btn-block">Bu planı seç</a>
      </div>

      <div class="plan-card">
        <p class="plan-tag">Kurumsal</p>
        <h3 class="plan-name">Enterprise</h3>
        <p class="plan-price">999,00 ₺<span>/ ay</span></p>
        <p class="plan-desc">Büyük ölçekli kullanım için sınırsız plan.</p>
        <ul class="plan-features">
          <li><span class="tick">✓</span>Sınırsız proje</li>
          <li><span class="tick">✓</span>100 GB depolama</li>
          <li><span class="tick">✓</span>Öncelikli destek</li>
          <li><span class="tick">✓</span>Özel entegrasyonlar</li>
        </ul>
        <a href="{{ route('register') }}" class="btn btn-ghost btn-block">Bu planı seç</a>
      </div>
    </div>
  </div>
</section>
@endsection