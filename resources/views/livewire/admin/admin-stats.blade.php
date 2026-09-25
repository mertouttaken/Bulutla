<div>
  <style>
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 22px;
      margin-top: 20px;
    }

    .stat-card {
      background: rgba(17, 18, 34, 0.85);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.07);
      border-radius: 20px;
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .stat-card:hover {
      transform: translateY(-3px);
      border-color: rgba(192, 132, 252, 0.35);
      box-shadow: 0 12px 35px rgba(95, 21, 135, 0.25);
    }

    .stat-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .stat-title {
      font-size: 0.85rem;
      color: #8f9bba;
      font-weight: 600;
    }

    .stat-icon {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      background: rgba(139, 30, 196, 0.16);
      border: 1px solid rgba(192, 132, 252, 0.25);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #c084fc;
    }

    .stat-value {
      font-size: 1.85rem;
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.03em;
      display: flex;
      align-items: baseline;
      gap: 6px;
    }

    .stat-value small {
      font-size: 0.88rem;
      font-weight: 500;
      color: #64748b;
    }

    .storage-progress-bg {
      width: 100%;
      height: 6px;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 99px;
      overflow: hidden;
    }

    .storage-progress-fill {
      height: 100%;
      background: linear-gradient(90deg, #7e22ce, #c084fc);
      border-radius: 99px;
      box-shadow: 0 0 10px rgba(192, 132, 252, 0.25);
    }

    .stat-footer {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .stat-badge {
      font-size: 0.72rem;
      font-weight: 600;
      padding: 3px 9px;
      border-radius: 6px;
    }

    .stat-badge.positive {
      background: rgba(34, 197, 94, 0.12);
      border: 1px solid rgba(34, 197, 94, 0.25);
      color: #4ade80;
    }

    .stat-badge.neutral {
      background: rgba(139, 30, 196, 0.18);
      border: 1px solid rgba(192, 132, 252, 0.3);
      color: #d8b4fe;
    }

    .stat-badge.highlight {
      background: rgba(139, 30, 196, 0.22);
      border: 1px solid rgba(192, 132, 252, 0.35);
      color: #c084fc;
    }

    .stat-subtext {
      font-size: 0.78rem;
      color: #64748b;
    }
  </style>

  <div class="stats-grid">
    <!-- Aktif Abone -->
    <div class="stat-card">
      <div class="stat-header">
        <span class="stat-title">Aktif Abone</span>
        <div class="stat-icon">
          <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
        </div>
      </div>
      <div class="stat-value">{{ $activeSubscribers ?? 0 }}</div>
      <div class="stat-footer">
        <span class="stat-badge positive">+%8</span>
        <span class="stat-subtext">geçen aya göre</span>
      </div>
    </div>

    <!-- Aylık Gelir -->
    <div class="stat-card">
      <div class="stat-header">
        <span class="stat-title">Aylık Tahmini Gelir</span>
        <div class="stat-icon">
          <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
      </div>
      <div class="stat-value">{{ number_format($monthlyIncome ?? 0, 2, ',', '.') }} ₺</div>
      <div class="stat-footer">
        <span class="stat-badge positive">+%12</span>
        <span class="stat-subtext">geçen aya göre</span>
      </div>
    </div>

    <!-- Depolama -->
    @php
      $safeMaxLimit = max((float) ($totalStorage ?? 0), 1);
      $safeUsed = (float) ($usedStorage ?? 0);
      $storagePercentage = min(100, round(($safeUsed / $safeMaxLimit) * 100, 1));
      $usedFormatted = $safeUsed >= 1024 ? round($safeUsed / 1024, 2) . ' TB' : round($safeUsed, 2) . ' GB';
      $limitFormatted = $safeMaxLimit >= 1024 ? round($safeMaxLimit / 1024, 2) . ' TB' : round($safeMaxLimit, 2) . ' GB';
    @endphp
    <div class="stat-card">
      <div class="stat-header">
        <span class="stat-title">Depolama Doluluğu</span>
        <div class="stat-icon">
          <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
          </svg>
        </div>
      </div>
      <div class="stat-value">
        {{ $usedFormatted }} <small>/ {{ $limitFormatted }}</small>
      </div>
      <div class="storage-progress-bg">
        <div class="storage-progress-fill" style="width: {{ $storagePercentage }}%;"></div>
      </div>
      <div class="stat-footer">
        <span class="stat-badge neutral">%{{ $storagePercentage }} Dolu</span>
      </div>
    </div>

    <!-- En Popüler Paket -->
    <div class="stat-card">
      <div class="stat-header">
        <span class="stat-title">En Popüler Paket</span>
        <div class="stat-icon">
          <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
      </div>
      <div class="stat-value">{{ $popularPlan->name }}</div>
      <div class="stat-footer">
        <span class="stat-badge highlight">{{ $popularPlan?->subscriptions_count ?? 0 }} Aktif Abone</span>
      </div>
    </div>
  </div>
</div>