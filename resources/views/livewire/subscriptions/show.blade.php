<div>

  <div class="subscription-wrapper">
    <div class="sub-container">
      <div class="sub-head">
        <div class="header-info">
          <p class="desk-kicker">HESAP / ABONELİK</p>
          <h1 class="motion-title">Abonelik <em>alanı.</em></h1>
          <p>Planın, kullandığın alan ve faturaların tek yerde.</p>
        </div>
        <a href="{{ route('plans.index') }}" class="btn-change-plan">Planı değiştir ↗</a>
      </div>

      <div class="hero-left">
        <div class="sub-grid">
          <div class="sub-card">
            <h3>Plan & Kullanım</h3>

            <div class="current-plan-box" data-sc-tilt="4">
              <span class="current-plan-box__tab">{{ strtoupper($plan?->slug ?? 'plan') }}</span>
              <div>
                <div class="plan-name-txt">{{ $plan?->name ?? 'Default' }}</div>
                <div class="plan-price-txt">{{ ($plan?->price ?? 0) > 0 ? number_format($plan->price, 2, ',', '.').' ₺ / ay' : 'Ücretsiz' }}</div>
              </div>
              <span class="status-pill">{{ $subscription?->status === 'active' ? 'Aktif' : 'Standart' }}</span>
            </div>

            <div class="usage-block">
              <div class="usage-item">
                <div class="usage-info">
                  <span>Depolama Alanı</span>
                  <span><strong><span data-tick>{{ $storageUsed }}</span> MB</strong> / {{ $storageLimit }} MB</span>
                </div>
                <div class="usage-track">
                  <div class="fill-bar" style="--bar-fill: {{ $storagePercent }}%;"></div>
                </div>
              </div>

              <div class="usage-item">
                <div class="usage-info">
                  <span>Aktif Projeler</span>
                  <span><strong data-tick>{{ $projectUsed }}</strong> / {{ $projectLimit > 0 ? $projectLimit : 'Sınırsız' }}</span>
                </div>
                <div class="usage-track">
                  <div class="fill-bar" style="--bar-fill: {{ $projectPercentage }}%;"></div>
                </div>
              </div>
            </div>

            @if($canCancel)
              <div class="danger-box">
                <p>Aboneliğinizi iptal ettiğinizde mevcut fatura dönemi bitiminde hesabınız otomatik olarak {{ $defaultPlanName }} plana geçirilir.</p>
                <form method="POST" action="{{ route('subscriptions.cancel') }}" onsubmit="return confirm('Aboneliğinizi iptal etmek istediğinize emin misiniz?');">
                  @csrf
                  <button type="submit" class="btn-cancel">Aboneliği İptal Et</button>
                </form>
              </div>
            @endif
          </div>

          <div class="sub-card">
            <h3>Fatura Geçmişi</h3>
            <div class="invoice-list">
              @forelse($bills as $bill)
                @php
                  $statusMap = [
                    'paid' => ['label' => 'Ödendi', 'class' => 'status-paid'],
                    'pending' => ['label' => 'Bekliyor', 'class' => 'status-pending'],
                    'failed' => ['label' => 'Başarısız', 'class' => 'status-failed'],
                  ];
                  $methodMap = [
                    'credit_card' => 'Kredi Kartı',
                    'bank_transfer' => 'Havale / EFT',
                    'iyzico' => 'iyzico',
                    'stripe' => 'Stripe',
                  ];
                  $statusInfo = $statusMap[$bill->status] ?? ['label' => $bill->status, 'class' => 'status-pending'];
                  $methodLabel = $methodMap[$bill->payment_method] ?? $bill->payment_method;
                  $dateText = $bill->paid_at
                    ? $bill->paid_at->format('d.m.Y')
                    : ($bill->created_at ? $bill->created_at->format('d.m.Y') : 'Bilinmiyor');
                @endphp

                <div class="invoice-item">
                  <div class="invoice-left">
                    <span class="invoice-title" title="{{ $bill->plan?->name }}">{{ $bill->plan?->name ?? 'Plan' }}</span>
                    <span class="invoice-meta">{{ $dateText }} · {{ $methodLabel }}</span>
                  </div>

                  <div class="invoice-right">
                    <span class="invoice-amount">{{ number_format($bill->amount, 2, ',', '.') }} ₺</span>
                    <span class="invoice-status {{ $statusInfo['class'] }}">{{ $statusInfo['label'] }}</span>
                  </div>
                </div>
              @empty
                <p class="invoice-empty">Henüz fatura yok. Ücretli bir plana geçtiğinde faturaların burada listelenir.</p>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>