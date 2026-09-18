@extends('layouts.app')

@section('content')
<section class="hero">
  <div class="wrap">
    <div>
      <p class="eyebrow-label">Küçük ekipler için <strong>abonelik ve plan yönetimi</strong></p>
      <h1 class="display">Ekibinizin planını tek ekrandan yönetin.</h1>
      <p class="lede">Bulutla; kayıt olma, plan seçme ve abonelik takibini tek bir akışta toplar. Kurulumu 5 dakika, öğrenmesi bir kahve molası kadar sürer.</p>
      <div class="hero-actions">
        @guest
          <a href="{{ route('register') }}" class="btn btn-primary">Ücretsiz Başla</a>
          <a href="{{ route('plans.index') }}" class="btn btn-ghost">Planları İncele</a>
        @endguest
        @auth
          <a href="{{ route('dashboard') }}" class="btn btn-primary">Panele git</a>
          <a href="{{ route('subscriptions.show') }}" class="btn btn-ghost">Planını yönet</a>
        @endauth
      </div>
    </div>

    @auth
      <div class="hero-panel">
        <div class="mock-card">
          <div class="mock-row">
            <span class="label">Aktif plan</span>
            <span class="mock-badge">{!! Auth::user()->currentPlan()?->name ?? 'Plan Yok' !!}</span>
          </div>
          <div class="mock-row">
            <span class="label">Sonraki yenileme</span>
            <span>{{ Auth::user()->subscriptions()->latest()->first()?->nextBillingDate() ?? '-' }}</span>
          </div>
          <div style="padding-top:14px;">
            <div class="usage-item" style="margin-bottom:12px;">
              <div class="usage-label">
                <span>Depolama</span>
                <span>{{ Auth::user()->storageUsedFormatted() }} / {{ Auth::user()->plan?->storageLimit() ?? '100 MB' }}</span>
              </div>
              @php
                $rawUsed = (string) Auth::user()->storageUsedValue();
                $usedValue = (float) $rawUsed;
                $storageUsed = str_contains($rawUsed, 'GB') ? $usedValue * 1024 : $usedValue;

                $rawLimit = (string) (Auth::user()->plan?->storageLimit() ?? '0');
                $limitValue = (float) $rawLimit;
                $storageLimit = str_contains($rawLimit, 'GB') ? $limitValue * 1024 : $limitValue;

                $storagePercentage = $storageLimit > 0 ? min(round(($storageUsed / $storageLimit) * 100), 100) : 0;
              @endphp
              <div class="mock-bar-track">
                <div class="mock-bar-fill" style="width:{{ $storagePercentage }}%;"></div>
              </div>
            </div>

            <div class="usage-item" style="margin-bottom:0;">
              @php
                $rawUsedProject = (int) (Auth::user()->projectUsedValue() ?? 0);
                $projectLimit = (int) (Auth::user()->plan?->projectLimit() ?? 0);
                $projectPercentage = $projectLimit > 0 ? min(round(($rawUsedProject / $projectLimit) * 100), 100) : 0;
              @endphp
              <div class="usage-label">
                <span>Proje</span>
                <span>{{ $rawUsedProject }} / {{ $projectLimit > 0 ? $projectLimit : 'Sınırsız' }}</span>
              </div>
              <div class="mock-bar-track">
                <div class="mock-bar-fill" style="width:{{ $projectPercentage }}%;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endauth
  </div>
</section>

<section class="alt">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title">Neden ekipler Bulutla'ya geçiyor</h2>
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
      @foreach ($plans as $plan)
        @php
          $isPopular = isset($mostPopularPlan) && $mostPopularPlan?->id === $plan->id;
          $json = json_decode($plan->features, true);
          $features = is_array($json) ? $json : (is_array($plan->features) ? $plan->features : explode(',', (string) $plan->features));
        @endphp

        <div class="plan-card {{ $isPopular ? 'featured' : '' }}">
          @if($isPopular)
            <p class="plan-tag">En çok tercih edilen</p>
          @endif

          <h3 class="plan-name">{{ $plan->name }}</h3>
          
          <p class="plan-price">
            {{ $plan->price > 0 ? $plan->price . ' ₺' : 'Ücretsiz' }}
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

          <a href="{{ route('register') }}" class="btn {{ $isPopular ? 'btn-primary' : 'btn-ghost' }} btn-block">
            {{ $plan->price > 0 ? 'Hemen Başla' : 'Ücretsiz Başla' }}
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection