@extends('layouts.app')

@section('content')
<style>
  .dashboard-container {
    max-width: 1240px;
    margin: 0 auto;
    padding: 36px 24px;
    color: #e2e8f0;
    font-family: inherit;
    display: flex;
    flex-direction: column;
    gap: 32px;
  }

  .dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
  }

  .header-info h1 {
    font-size: 1.65rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 6px 0;
    letter-spacing: -0.02em;
  }

  .header-info p {
    margin: 0;
    font-size: 0.9rem;
    color: #9d9bb8;
  }

  .header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .btn-cta-primary {
    background: linear-gradient(135deg, #5f1587, #8b1ec4);
    border: none;
    color: #ffffff;
    padding: 11px 22px;
    border-radius: 12px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 18px rgba(95, 21, 135, 0.35);
    transition: transform 0.15s ease, opacity 0.15s ease;
  }

  .btn-cta-primary:hover {
    opacity: 0.92;
    transform: translateY(-1px);
  }

  .btn-cta-secondary {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
    padding: 11px 20px;
    border-radius: 12px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
  }

  .btn-cta-secondary:hover {
    background: rgba(95, 21, 135, 0.12);
    border-color: rgba(139, 30, 196, 0.35);
    color: #ffffff;
  }

  .metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
  }

  .metric-card {
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 18px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
  }

  .metric-card::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(139, 30, 196, 0.4), transparent);
  }

  .metric-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .metric-title {
    font-size: 0.85rem;
    color: #9d9bb8;
    font-weight: 500;
  }

  .metric-badge {
    background: rgba(95, 21, 135, 0.18);
    border: 1px solid rgba(139, 30, 196, 0.3);
    color: #d8b4fe;
    font-size: 0.75rem;
    padding: 3px 9px;
    border-radius: 6px;
    font-weight: 600;
  }

  .metric-badge-success {
    background: rgba(34, 197, 94, 0.12);
    border: 1px solid rgba(34, 197, 94, 0.25);
    color: #4ade80;
  }

  .metric-value {
    font-size: 1.65rem;
    font-weight: 700;
    color: #ffffff;
    letter-spacing: -0.02em;
    margin: 0;
  }

  .metric-value small {
    font-size: 0.95rem;
    font-weight: 500;
    color: #9d9bb8;
  }

  .metric-progress {
    height: 6px;
    background: rgba(255, 255, 255, 0.07);
    border-radius: 10px;
    overflow: hidden;
  }

  .metric-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #5f1587, #9333ea);
    border-radius: 10px;
  }

  .metric-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.78rem;
    color: #64748b;
  }

  .metric-footer a {
    color: #c084fc;
    text-decoration: none;
    font-weight: 500;
  }

  .metric-footer a:hover {
    text-decoration: underline;
  }

  .dashboard-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
  }

  @media (max-width: 900px) {
    .dashboard-layout {
      grid-template-columns: 1fr;
    }
  }

  .section-panel {
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 18px;
    padding: 26px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.35);
  }

  .panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .panel-header h3 {
    font-size: 1.05rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0;
  }

  .panel-header a {
    color: #c084fc;
    font-size: 0.82rem;
    text-decoration: none;
    font-weight: 500;
  }

  .panel-header a:hover {
    text-decoration: underline;
  }

  .files-stack {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .file-item-card {
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 13px 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.2s ease;
  }

  .file-item-card:hover {
    border-color: rgba(139, 30, 196, 0.35);
    background: #1a1b35;
  }

  .file-meta-group {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .file-icon-box {
    width: 38px;
    height: 38px;
    background: rgba(95, 21, 135, 0.16);
    border: 1px solid rgba(139, 30, 196, 0.25);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
  }

  .file-texts {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  .file-name-text {
    font-size: 0.88rem;
    font-weight: 600;
    color: #ffffff;
  }

  .file-info-text {
    font-size: 0.75rem;
    color: #9d9bb8;
  }

  .file-btn {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.09);
    color: #cbd5e1;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.78rem;
    text-decoration: none;
    transition: all 0.2s;
  }

  .file-btn:hover {
    background: rgba(95, 21, 135, 0.2);
    border-color: rgba(139, 30, 196, 0.4);
    color: #ffffff;
  }

  .no-data-box {
    text-align: center;
    padding: 38px 16px;
    color: #64748b;
    font-size: 0.85rem;
  }

  .actions-list {
    display: flex;
    flex-direction: column;
    gap: 9px;
  }

  .action-row {
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 13px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #cbd5e1;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s;
  }

  .action-row:hover {
    background: #1a1b35;
    color: #ffffff;
    border-color: rgba(139, 30, 196, 0.35);
  }
</style>

@php
  $user = Auth::user();
  $rawUsed = Auth::user()->storageUsed();
  $usedValue = (float) $rawUsed;
  $storageUsed = str_contains($rawUsed, 'GB') ? $usedValue * 1024 : $usedValue;


  $rawLimit = Auth::user()->plan?->storageLimit() ?? '0';
  $limitValue = (float) $rawLimit;
  $storageLimit = (float) str_contains($rawLimit, 'GB') ? $limitValue * 1024 : $limitValue;

  $projectUsed = Auth::user()->projectUsedValue() ?? 0;
  $projectLimit = Auth::user()->plan?->projectLimit() ?? 0;

  $projectPercent = $projectLimit > 0 ? ($projectUsed / $projectLimit) * 100 : 0;

  $storagePercent = $storageLimit > 0 ? ($storageUsed / $storageLimit) * 100 : 0;
@endphp

<div class="dashboard-container">

  <div class="dashboard-header">
    <div class="header-info">
      <h1>Hoş Geldin, {{ $user->name }} 👋</h1>
      <p>Projelerinin durumunu ve çalışma alanı kaynaklarını buradan yönetebilirsin.</p>
    </div>

    <div class="header-actions">
      <a href="{{ route('files.upload') }}" class="btn-cta-primary">
        <span>+</span> Dosya Yükle
      </a>
      <a href="{{ route('plans.index') }}" class="btn-cta-secondary">
        Planları İncele
      </a>
    </div>
  </div>

  <div class="metrics-grid">
    <div class="metric-card">
      <div class="metric-head">
        <span class="metric-title">Depolama Durumu</span>
        <span class="metric-badge">%{{ $storagePercent }} Dolu</span>
      </div>
      <p class="metric-value">{{ $rawUsed }} <small>/ {{ $storageLimit }} MB</small></p>
      <div class="metric-progress">
        <div class="metric-progress-fill" style="width: {{ $storagePercent }}%;"></div>
      </div>
      <div class="metric-footer">
        <span>Kalan: {{ max(0, $storageLimit - $storageUsed) }} MB</span>
        <a href="{{ route('plans.index') }}">Yükselt</a>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-head">
        <span class="metric-title">Aktif Projeler</span>
        <span class="metric-badge">{{ $projectUsed }}/{{ $projectLimit }}</span>
      </div>
      <p class="metric-value">{{ $projectUsed }} <small>Proje</small></p>
      <div class="metric-progress">
        <div class="metric-progress-fill" style="width: {{ $projectPercent }}%;"></div>
      </div>
      <div class="metric-footer">
        <span>Limit: {{ $projectLimit }} Proje</span>
        <span>Durum: {{ $projectLimit - $projectUsed > 0 ? 'Müsait' : 'Limit Doldu' }}</span>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-head">
        <span class="metric-title">Abonelik Planı</span>
        <span class="metric-badge metric-badge-success">
          {{ $user->subscription?->status === 'active' ? 'Aktif' : 'Standart' }}
        </span>
      </div>
      <p class="metric-value">{{ $user->plan?->name ?? 'Başlangıç' }}</p>
      <div class="metric-progress">
        <div class="metric-progress-fill" style="width: 100%; background: #4ade80;"></div>
      </div>
      <div class="metric-footer">
        <span>{{ $user->plan?->price ?? 0 }} ₺ / ay</span>
        <a href="{{ route('subscriptions.show') }}">Abonelik Detayı</a>
      </div>
    </div>
  </div>

  <div class="dashboard-layout">
    <div class="section-panel">
      <div class="panel-header">
        <h3>Son Yüklenen Dosyalar</h3>
        <a href="{{ route('files.upload') }}">+ Yeni Yükle</a>
      </div>

      <div class="files-stack">
        @if(isset($recentFiles) && $recentFiles->count() > 0)
          @foreach($recentFiles as $file)
            <div class="file-item-card">
              <div class="file-meta-group">
                <div class="file-icon-box">📄</div>
                <div class="file-texts">
                  <span class="file-name-text">{{ $file->name }}</span>
                  <span class="file-info-text">{{ $file->size_mb }} MB • {{ $file->created_at?->diffForHumans() }}</span>
                </div>
              </div>
              <a href="#" class="file-btn">İndir</a>
            </div>
          @endforeach
        @else
          <div class="no-data-box">
            Henüz yüklenmiş bir dosya bulunmuyor.
          </div>
        @endif
      </div>
    </div>

    <div class="section-panel">
      <div class="panel-header">
        <h3>Hızlı İşlemler</h3>
      </div>

      <div class="actions-list">
        <a href="{{ route('files.upload') }}" class="action-row">
          <span>📁 Yeni Dosya Yükle</span>
          <span>→</span>
        </a>
        <a href="{{ route('plans.index') }}" class="action-row">
          <span>📦 Planları Yönet & Yükselt</span>
          <span>→</span>
        </a>
        <a href="{{ route('subscriptions.show') }}" class="action-row">
          <span>💳 Fatura ve Abonelik</span>
          <span>→</span>
        </a>
      </div>
    </div>
  </div>

</div>
@endsection