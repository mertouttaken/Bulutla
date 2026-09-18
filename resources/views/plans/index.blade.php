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
  .plan-left {
    flex: 1 1 55%;
    min-width: 0;
    animation: slideInLeft 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    will-change: transform, opacity;
  }
  .pricing-page-wrapper {
    min-height: 85vh;
    padding: 70px 0 100px;
    background: #0b0c16 radial-gradient(circle at 50% 10%, rgba(139, 30, 196, 0.22) 0%, transparent 60%);
    color: #e2e8f0;
    font-family: inherit;
    width: 100%;
    box-sizing: border-box;
  }

  .pricing-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
    box-sizing: border-box;
  }

  /* Başlık Alanını Kesin Olarak Alt Alta Ortalar */
  .pricing-head {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    text-align: center !important;
    margin-bottom: 54px;
    gap: 12px;
  }

  .pricing-badge {
    display: inline-block;
    background: rgba(139, 30, 196, 0.15);
    border: 1px solid rgba(192, 132, 252, 0.35);
    color: #c084fc;
    font-size: 0.82rem;
    padding: 5px 16px;
    border-radius: 999px;
    font-weight: 600;
  }

  .pricing-title {
    font-size: clamp(2rem, 3.5vw, 2.6rem);
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.02em;
    margin: 0;
    line-height: 1.2;
  }

  .pricing-note {
    color: #94a3b8;
    font-size: 1rem;
    margin: 0;
    max-width: 500px;
    line-height: 1.5;
  }

  .pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(310px, 1fr));
    gap: 28px;
    align-items: stretch;
  }

  .plan-card {
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    padding: 36px 28px;
    display: flex;
    flex-direction: column;
    position: relative;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  }

  .plan-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    border-color: rgba(192, 132, 252, 0.35);
  }

  /* Mor Temalı Mevcut Plan Vurgusu */
  .plan-card.current {
    border-color: #a855f7;
    background: linear-gradient(180deg, rgba(168, 85, 247, 0.1) 0%, #111222 100%);
    box-shadow: 0 10px 30px rgba(139, 30, 196, 0.25);
  }

  .plan-badge-status {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    padding: 4px 16px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: linear-gradient(135deg, #5f1587, #9333ea);
    color: #ffffff;
    border: 1px solid rgba(216, 180, 254, 0.4);
    box-shadow: 0 4px 14px rgba(147, 51, 234, 0.45);
    white-space: nowrap;
  }

  .plan-name {
    font-size: 1.35rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 12px;
  }

  .plan-price {
    font-size: 2.5rem;
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
    min-height: 40px;
  }

  .plan-features {
    list-style: none;
    padding: 0;
    margin: 0 0 32px;
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
    color: #c084fc;
    font-weight: 800;
    background: rgba(192, 132, 252, 0.12);
    border-radius: 50%;
    width: 20px;
    height: 20px;
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
    padding: 13px 20px;
    border-radius: 12px;
    font-size: 0.92rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: block;
    border: none;
  }

  .btn-primary {
    background: linear-gradient(135deg, #5f1587, #8b1ec4);
    color: #ffffff;
    box-shadow: 0 6px 18px rgba(139, 30, 196, 0.35);
  }

  .btn-primary:hover {
    opacity: 0.93;
    transform: translateY(-2px);
  }

  .btn-current {
    background: rgba(168, 85, 247, 0.15);
    border: 1px solid rgba(192, 132, 252, 0.35);
    color: #d8b4fe;
    cursor: default;
  }
</style>

<div class="pricing-page-wrapper">
  <div class="pricing-container">
    <div class="pricing-head">
      <span class="pricing-badge">Şeffaf Fiyatlandırma</span>
      <h1 class="pricing-title">İhtiyacınıza Uygun Planı Seçin</h1>
      <p class="pricing-note">Aylık faturalandırma, dilediğiniz an tek tıkla iptal veya plan değişimi.</p>
    </div>
    <div class="plan-left">
      <div class="pricing-grid">
        @foreach($plans as $plan)
          @php
            $userCurrentPlanSlug = Auth::check() ? Auth::user()->loadMissing('subscription.plan')->subscription?->plan?->slug : null;
            $isCurrent = $userCurrentPlanSlug && $userCurrentPlanSlug === $plan->slug;

            $json = json_decode($plan->features, true);
            $features = is_array($json) ? $json : (is_array($plan->features) ? $plan->features : explode(',', (string) $plan->features));
          @endphp

          <div class="plan-card {{ $isCurrent ? 'current' : '' }}">
            @if($isCurrent)
              <span class="plan-badge-status">Mevcut Planınız</span>
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

            @guest
              <a href="{{ route('register') }}" class="btn-primary btn-block">Bu Planla Başla</a>
            @else
              @if($isCurrent)
                <button type="button" class="btn-current btn-block" disabled>Bu Planı Kullanıyorsunuz</button>
              @else
                <form action="{{ route('change-plan') }}" method="POST" style="margin: 0;">
                  @csrf
                  <input type="hidden" name="plan" value="{{ $plan->slug }}">
                  <button type="submit" class="btn-primary btn-block">Bu Plana Geç</button>
                </form>
              @endif
            @endguest
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection