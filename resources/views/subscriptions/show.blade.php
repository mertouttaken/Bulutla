@extends('layouts.app')

@section('content')
<div class="wrap dash-shell">
  <div class="dash-head">
    <div>
      <h2>Aboneliğim</h2>
      <p>Mevcut planınızı, kullanımınızı ve fatura geçmişinizi buradan takip edin.</p>
    </div>
    <a href="{{ route('plans.index') }}" class="btn btn-ghost btn-sm">Planı değiştir</a>
  </div>

  <div class="dash-grid">
    <div class="dash-card">
      <h3>Kullanım</h3>
      <div class="current-plan-row">
        <div>
          <div class="plan-name-sm">{{ Auth::user()->subscription->plan->name }} planı</div>
          <div class="plan-price-sm">{{ number_format(Auth::user()->subscription->plan->price, 2, ',', '.') }} ₺ / ay</div>
        </div>
        <span class="status-pill">Aktif</span>
      </div>

        @php
            $rawUsed = Auth::user()->storageUsed();
            $usedValue = (float) $rawUsed;
            $storageUsed = str_contains($rawUsed, 'GB') ? $usedValue * 1024 : $usedValue;


            $rawLimit = Auth::user()->plan?->storageLimit() ?? '0';
            $limitValue = (float) $rawLimit;
            $storageLimit = str_contains($rawLimit, 'GB') ? $limitValue * 1024 : $limitValue;

            $storagePercentage = $storageLimit > 0 ? ($storageUsed / $storageLimit) * 100 : 0;
        @endphp

      <div class="usage-item">
        <div class="usage-label"><span>Depolama</span><span>{{ Auth::user()->storageUsedFormatted() }} / {{ Auth::user()->plan?->storageLimit() }}</span></div>
        <div class="usage-track"><div class="usage-fill" style="width:{{ $storagePercentage}}%;"></div></div>
      </div>

        @php
            $rawUsed = Auth::user()->projectUsed();
            $projectLimit = Auth::user()->subscription?->p ?? 0;
            $projectPercentage = $projectLimit > 0 ? ($rawUsed / $projectLimit) * 100 : 0;            
        @endphp
      <div class="usage-item">
        <div class="usage-label"><span>Proje sayısı</span><span>{{ Auth::user()->projectUsed() }} / {{ Auth::user()->plan?->projectLimit() > 0 ? Auth::user()->plan?->projectLimit() : 'Sınırsız' }}</span></div>
        <div class="usage-track"><div class="usage-fill" style="width:{{ $projectPercentage }}%;"></div></div>
      </div>

      <div class="danger-zone">
        <p>Aboneliğinizi iptal ederseniz mevcut dönem sonunda Free plana geçersiniz.</p>
        <form method="POST" action="{{ route('subscriptions.cancel') }}">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm">Aboneliği iptal et</button>
        </form>
      </div>
    </div>

    <div class="dash-card">
      <h3>Fatura geçmişi</h3>
      <div class="invoice-row"><span>14 Eylül 2026</span><span>199,00 ₺</span></div>
      <div class="invoice-row"><span>14 Ağustos 2026</span><span>199,00 ₺</span></div>
      <div class="invoice-row"><span>14 Temmuz 2026</span><span>199,00 ₺</span></div>
      <div class="invoice-row"><span>14 Haziran 2026</span><span>0,00 ₺ (deneme)</span></div>
    </div>
  </div>
</div>
@endsection