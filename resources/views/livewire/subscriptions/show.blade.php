<div>
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

    .fill-bar {
      height: 100%;
      width: 0%;
      background: linear-gradient(90deg, #5f1587, #c084fc);
      border-radius: 99px;
      animation: loadBar 1.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .subscription-wrapper {
      min-height: 85vh;
      padding: 60px 0 100px;
      background: #0b0c16 radial-gradient(circle at 50% 10%, rgba(139, 30, 196, 0.18) 0%, transparent 60%);
      color: #e2e8f0;
      font-family: inherit;
      width: 100%;
      box-sizing: border-box;
    }

    .sub-container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 24px;
      display: flex;
      flex-direction: column;
      gap: 32px;
    }

    .sub-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
      padding-bottom: 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    .sub-head h2 {
      font-size: 1.85rem;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.02em;
      margin: 0 0 6px 0;
    }

    .sub-head p {
      color: #94a3b8;
      font-size: 0.95rem;
      margin: 0;
    }

    .btn-change-plan {
      background: rgba(139, 30, 196, 0.15);
      border: 1px solid rgba(192, 132, 252, 0.35);
      color: #c084fc;
      padding: 10px 20px;
      border-radius: 12px;
      font-size: 0.88rem;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
    }

    .btn-change-plan:hover {
      background: rgba(139, 30, 196, 0.3);
      color: #ffffff;
      transform: translateY(-1px);
    }

    .sub-grid {
      display: grid;
      grid-template-columns: 1.2fr 0.8fr;
      gap: 28px;
      align-items: start;
    }

    @media (max-width: 900px) {
      .sub-grid {
        grid-template-columns: 1fr;
      }
    }

    .sub-card {
      background: #111222;
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 20px;
      padding: 28px;
      box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
      position: relative;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .sub-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(192, 132, 252, 0.4), transparent);
    }

    .sub-card h3 {
      font-size: 1.15rem;
      font-weight: 700;
      color: #ffffff;
      margin: 0;
    }

    .current-plan-box {
      background: #17182e;
      border: 1px solid rgba(255, 255, 255, 0.05);
      border-radius: 14px;
      padding: 16px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .plan-name-txt {
      font-size: 1.1rem;
      font-weight: 700;
      color: #ffffff;
      margin-bottom: 2px;
    }

    .plan-price-txt {
      font-size: 0.88rem;
      color: #94a3b8;
    }

    .status-pill {
      background: rgba(139, 30, 196, 0.25);
      border: 1px solid rgba(192, 132, 252, 0.4);
      color: #d8b4fe;
      font-size: 0.78rem;
      font-weight: 600;
      padding: 4px 12px;
      border-radius: 999px;
    }

    .usage-block {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .usage-item {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .usage-info {
      display: flex;
      justify-content: space-between;
      font-size: 0.85rem;
      color: #cbd5e1;
    }

    .usage-info strong {
      color: #ffffff;
    }

    .usage-track {
      height: 8px;
      background: rgba(255, 255, 255, 0.07);
      border-radius: 999px;
      overflow: hidden;
    }

    .usage-fill {
      height: 100%;
      background: linear-gradient(90deg, #5f1587, #c084fc);
      border-radius: 999px;
    }

    .danger-box {
      margin-top: 10px;
      padding: 18px 20px;
      border-radius: 14px;
      background: rgba(239, 68, 68, 0.06);
      border: 1px solid rgba(239, 68, 68, 0.2);
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .danger-box p {
      color: #fca5a5;
      font-size: 0.84rem;
      line-height: 1.4;
      margin: 0;
    }

    .btn-cancel {
      background: transparent;
      border: 1px solid rgba(239, 68, 68, 0.4);
      color: #ef4444;
      padding: 8px 16px;
      border-radius: 10px;
      font-size: 0.82rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      align-self: flex-start;
    }

    .btn-cancel:hover {
      background: #ef4444;
      color: #ffffff;
    }

    .invoice-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .invoice-item {
      background: #17182e;
      border: 1px solid rgba(255, 255, 255, 0.05);
      border-radius: 12px;
      padding: 14px 18px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.88rem;
      color: #cbd5e1;
      transition: all 0.2s ease;
    }

    .invoice-item:hover {
      border-color: rgba(192, 132, 252, 0.3);
      background: #1a1b35;
    }

    .invoice-left {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .invoice-title {
      font-weight: 600;
      color: #ffffff;
      font-size: 0.92rem;
    }

    .invoice-meta {
      font-size: 0.78rem;
      color: #94a3b8;
    }

    .invoice-right {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 4px;
    }

    .invoice-amount {
      font-weight: 600;
      color: #ffffff;
    }

    .invoice-status {
      font-size: 0.72rem;
      font-weight: 600;
      padding: 2px 9px;
      border-radius: 999px;
    }

    .status-paid {
      background: rgba(34, 197, 94, 0.15);
      border: 1px solid rgba(34, 197, 94, 0.35);
      color: #4ade80;
    }

    .status-pending {
      background: rgba(234, 179, 8, 0.15);
      border: 1px solid rgba(234, 179, 8, 0.35);
      color: #facc15;
    }

    .status-failed {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.35);
      color: #f87171;
    }

    .hero-left {
      flex: 1 1 55%;
      min-width: 0;
      animation: slideInLeft 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
      will-change: transform, opacity;
    }
  </style>

  <div class="subscription-wrapper">
    <div class="sub-container">
      <div class="sub-head">
        <div>
          <h2>Aboneliğim</h2>
          <p>Mevcut planınızı, kullanım durumunuzu ve faturalarınızı buradan yönetin.</p>
        </div>
        <a href="{{ route('plans.index') }}" class="btn-change-plan">Planı Değiştir →</a>
      </div>

      <div class="hero-left">
        <div class="sub-grid">
          <div class="sub-card">
            <h3>Plan & Kullanım</h3>

            <div class="current-plan-box">
              <div>
                <div class="plan-name-txt">{{ $plan?->name ?? 'Default' }}</div>
                <div class="plan-price-txt">{{ number_format($plan?->price ?? 0, 2, ',', '.') }} ₺ / ay</div>
              </div>
              <span class="status-pill">{{ $subscription?->status === 'active' ? 'Aktif' : 'Standart' }}</span>
            </div>

            <div class="usage-block">
              <div class="usage-item">
                <div class="usage-info">
                  <span>Depolama Alanı</span>
                  <span><strong>{{ $storageUsed }} MB</strong> / {{ $storageLimit }} MB</span>
                </div>
                <div class="usage-track">
                  <div class="fill-bar" style="--bar-fill: {{ $storagePercent }}%;"></div>
                </div>
              </div>

              <div class="usage-item">
                <div class="usage-info">
                  <span>Aktif Projeler</span>
                  <span><strong>{{ $projectUsed }}</strong> / {{ $projectLimit > 0 ? $projectLimit : 'Sınırsız' }}</span>
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
                <p>Fatura geçmişi bulunmamaktadır.</p>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>