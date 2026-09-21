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
  @keyframes loadBar {
    0% { width: 0%; }
    100% { width: var(--bar-fill); }
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
    background: rgba(139, 30, 196, 0.22);
    border: 1px solid rgba(192, 132, 252, 0.35);
    color: #c084fc;
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

  .file-card-btn {
    color: #c084fc;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .file-card-btn:hover {
    color: #e9d5ff;
  }

  .file-download-btn {
    color: #c084fc;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    padding: 4px 10px;
    border-radius: 8px;
    transition: all 0.2s ease;
    display: inline-block;
  }

  .file-download-btn:hover {
    color: #ffffff;
    background: rgba(192, 132, 252, 0.15);
    transform: translateY(-1px);
  }

  .file-destroy-btn {
    background: transparent;
    border: none;
    color: #ef4444;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 8px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    line-height: 1;
  }

  .file-destroy-btn:hover {
    color: #ffffff;
    background: rgba(239, 68, 68, 0.18);
    transform: translateY(-1px);
  }

  .file-card-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .file-item {
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    transition: all 0.2s ease;
  }

  .file-item:hover {
    border-color: rgba(139, 30, 196, 0.35);
    background: #1a1b35;
  }

  .file-name {
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
    min-width: 0;
  }

  .file-actions-group {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-shrink: 0;
  }

  .file-size {
    color: #94a3b8;
    font-size: 0.82rem;
    min-width: 75px;
    text-align: right;
  }

  .file-card-empty {
    padding: 50px 16px;
    text-align: center;
    color: #64748b;
    font-size: 0.85rem;
  }

  .file-card-empty p {
    margin: 0;
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
    cursor: pointer;
    width: 100%;
    box-sizing: border-box;
  }
  .fill-bar {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #5f1587, #c084fc);
    border-radius: 99px;
    animation: loadBar 1.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }
  .action-row:hover {
    background: #1a1b35;
    color: #ffffff;
    border-color: rgba(139, 30, 196, 0.35);
  }
</style>

@php
  $user = Auth::user();

  $storageUsed = $user->storageUsedValue();

  $rawLimit = (string) ($user->plan?->storageLimit() ?? $user->plan?->storage_limit ?? '0');
  preg_match('/([\d.]+)\s*([a-zA-Z]*)/', $rawLimit, $matches);

  $limitValue = isset($matches[1]) ? (float) $matches[1] : 0;
  $limitUnit = isset($matches[2]) ? strtoupper(trim($matches[2])) : 'MB';

  $storageLimit = ($limitUnit === 'GB') ? ($limitValue * 1024) : $limitValue;
  $storagePercent = $storageLimit > 0 ? min(100, round(($storageUsed / $storageLimit) * 100)) : 0;

  $projectUsed = $user->projectUsedValue();
  $projectLimit = (int) ($user->plan?->projectLimit() ?? $user->plan?->project_limit ?? 0);
  $projectPercent = $projectLimit > 0 ? min(100, round(($projectUsed / $projectLimit) * 100)) : 0;
@endphp

<div class="dashboard-container">

  <div class="dashboard-header">
    <div class="header-info">
      <h1>Hoş Geldin, {{ $user->name }} 👋</h1>
      <p>Projelerinin durumunu ve çalışma alanı kaynaklarını buradan yönetebilirsin.</p>
    </div>

    <div class="header-actions">
        <a href="{{  route('projects.show') }}" class="btn-cta-primary"> <span>+</span> Dosya Yükle </a>
    </div>
  </div>

  <div class="metrics-grid">
    <div class="metric-card">
      <div class="metric-head">
        <span class="metric-title">Depolama Durumu</span>
        <span class="metric-badge">%{{ $storagePercent }} Dolu</span>
      </div>
      <p class="metric-value">{{ $storageUsed }} <small>/ {{ $storageLimit }} MB</small></p>
      <div class="metric-progress">
         <div class="fill-bar" style="--bar-fill: {{ $storagePercent }}%;"></div>
      </div>
      <div class="metric-footer">
        <span>Kalan: {{ max(0, $storageLimit - $storageUsed) }} MB</span>
        <a href="{{ route('plans.index') }}">Yükselt</a>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-head">
        <span class="metric-title">Aktif Projeler</span>
        <a href="{{ route('projects.show') }}" class="metric-badge metric-badge-success">Projeleri Görüntüle</a>
        <span class="metric-badge">{{ $projectUsed }}/{{ $projectLimit }}</span>
      </div>
      <p class="metric-value">{{ $projectUsed }} <small>Proje</small></p>
      <div class="metric-progress">
        <div class="fill-bar" style="--bar-fill: {{ $projectPercent }}%;"></div>
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
          {{ $user->subscription?->status === 'active' ? 'Aktif' : 'Pasif' }}
        </span>
      </div>
      @php
        $user = Auth::user();
        $end_at = $user->subscription?->ends_at;
        $diff = $end_at ? now()->diffInDays($end_at) : 0;
        $percent = $diff/30*100;
      @endphp
      <p class="metric-value">{{ $user->plan?->name ?? 'Default' }}</p>
      <div class="metric-progress">
        <div class="metric-progress-fill" style="width: {{ $percent }}%;"></div>
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
      </div>

      @if(isset($files) && count($files) > 0)
        <div class="file-card-list">
          @foreach($files as $file)
            <div class="file-item">
              <span class="file-name" title="{{ $file->original_name }}">
                {{ $file->original_name }}
                <span class="file-size">({{ App\Models\Project::find($file->project_id)->name ?? 'Bilinmeyen Proje' }})</span>
              </span>
              <div class="file-actions-group">
                <span class="file-size">{{ $file->formattedSize() }}</span>
                <a href="{{ route('files.download', $file->id) }}" class="file-download-btn">+ İndir</a>
                
                <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu dosyayı silmek istediğine emin misin?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="file-destroy-btn">- Sil</button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="file-card-empty">
          <p>Henüz yüklenmiş bir dosya bulunmuyor.</p>
        </div>
      @endif
    </div>

    <div class="section-panel">
      <div class="panel-header">
        <h3>Hızlı İşlemler</h3>
      </div>

      <div class="actions-list">
        <form action="{{ route('files.upload') }}" method="post" enctype="multipart/form-data" id="quickActionForm" style="margin: 0;">
          @csrf
          <a href="{{ route('projects.show') }}" class="action-row">
            <span>📁 Yeni Dosya Yükle</span>
            <span>→</span>
          </label>
        </form>

        <a href="{{ route('plans.index') }}" class="action-row">
          <span>📦 Planını Yükselt</span>
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