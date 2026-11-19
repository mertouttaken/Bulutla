@extends('layouts.app')

@section('content')


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
      <p class="desk-kicker">KİŞİSEL ARŞİV / {{ $user->name }}</p>
      <h1 class="motion-title">Çalışma <em>masası.</em></h1>
      <p>Projelerin, son dosyaların ve kalan depolama alanın.</p>
    </div>

    <div class="header-actions">
        <a href="{{  route('projects.show') }}" class="btn-cta-primary"> <span>+</span> Dosya Yükle </a>
    </div>
  </div>

  <div class="metrics-grid">
    <div class="metric-card" data-sc-tilt="4">
      <div class="metric-head">
        <span class="metric-title">Depolama Durumu</span>
        <span class="metric-badge">%{{ $storagePercent }} Dolu</span>
      </div>
      <p class="metric-value"><span data-tick>{{ $storageUsed }}</span> <small>/ {{ $storageLimit }} MB</small></p>
      <div class="metric-progress">
         <div class="fill-bar" style="--bar-fill: {{ $storagePercent }}%;"></div>
      </div>
      <div class="metric-footer">
        <span>Kalan: {{ max(0, $storageLimit - $storageUsed) }} MB</span>
        <a href="{{ route('plans.index') }}">Yükselt</a>
      </div>
    </div>

    <div class="metric-card" data-sc-tilt="4">
      <div class="metric-head">
        <span class="metric-title">Aktif Projeler</span>
        <a href="{{ route('projects.show') }}" class="metric-badge metric-badge-success">Projeleri Görüntüle</a>
        <span class="metric-badge">{{ $projectUsed }}/{{ $projectLimit }}</span>
      </div>
      <p class="metric-value"><span data-tick>{{ $projectUsed }}</span> <small>Proje</small></p>
      <div class="metric-progress">
        <div class="fill-bar" style="--bar-fill: {{ $projectPercent }}%;"></div>
      </div>
      <div class="metric-footer">
        <span>Limit: {{ $projectLimit }} Proje</span>
        <span>Durum: {{ $projectLimit - $projectUsed > 0 ? 'Müsait' : 'Doldu' }}</span>
      </div>
    </div>

    <div class="metric-card" data-sc-tilt="4">
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
      <p class="metric-value">{{ $user->plan?->name ?? 'Varsayılan' }}</p>
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
        <div class="file-card-list" data-sc-in data-sc-stagger="55">
          @foreach($files as $file)
            <div class="file-item">
              <span class="file-name" title="{{ $file->original_name }}">
                {{ $file->original_name }}
                <span class="file-size">({{ App\Models\Project::find($file->project_id)->name ?? 'Bilinmeyen Proje' }})</span>
              </span>
              <div class="file-actions-group">
                <span class="file-size">{{ $file->formattedSize() }}</span>
                <a href="{{ route('files.download', $file->id) }}" class="file-download-btn">İndir ↓</a>
                
                <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu dosyayı silmek istediğine emin misin?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="file-destroy-btn">Sil</button>
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
        <h3>Proje arşivi</h3>
      </div>

      <div class="actions-list" data-sc-in data-sc-stagger="55">
        @foreach($projects->take(4) as $project)
          <a class="action-row" href="{{ route('projects.files', $project->id) }}"><span>{{ $project->name }}</span><small>{{ $project->files_count }} dosya ↗</small></a>
        @endforeach
        <a href="{{ route('projects.show') }}" class="action-row"><span>Tüm projeler</span><span>↗</span></a>
        <a href="{{ route('plans.index') }}" class="action-row">
          <span>Planını Yükselt</span>
          <span>→</span>
        </a>
        <a href="{{ route('subscriptions.show') }}" class="action-row">
          <span>Fatura ve Abonelik</span>
          <span>→</span>
        </a>
      </div>
    </div>
  </div>

</div>
@endsection