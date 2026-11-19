<div>

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
      <div class="stat-value"><span data-tick>{{ $activeSubscribers ?? 0 }}</span></div>
      <div class="stat-footer">
        <span class="stat-badge positive">+%8</span>
        <span class="stat-subtext">geçen aya göre</span>
      </div>
    </div>

    <!-- Aylık Gelir -->
    <div class="stat-card">
      <div class="stat-header">
        <span class="stat-title">Aylık Gelir</span>
        <div class="stat-icon">
          <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
      </div>
      <div class="stat-value"><span data-tick>{{ number_format($monthlyIncome ?? 0, 2, ',', '.') }}</span> ₺</div>
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