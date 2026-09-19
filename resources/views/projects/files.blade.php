@extends('layouts.app')

@section('title', $project->name . ' - Dosya Yönetimi')

@section('content')
<style>
  .files-container {
    max-width: 1240px;
    margin: 0 auto;
    padding: 36px 24px;
    color: #e2e8f0;
    display: flex;
    flex-direction: column;
    gap: 28px;
    font-family: inherit;
  }

  .files-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    padding-bottom: 24px;
  }

  .header-left {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .back-btn {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9d9bb8;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .back-btn:hover {
    color: #ffffff;
    border-color: rgba(139, 30, 196, 0.45);
    background: #17182e;
  }

  .header-info h1 {
    font-size: 1.6rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 4px 0;
    letter-spacing: -0.02em;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .project-badge-pill {
    background: rgba(139, 30, 196, 0.18);
    border: 1px solid rgba(192, 132, 252, 0.3);
    color: #d8b4fe;
    font-size: 0.72rem;
    padding: 3px 9px;
    border-radius: 20px;
    font-weight: 600;
  }

  .header-info p {
    margin: 0;
    font-size: 0.88rem;
    color: #9d9bb8;
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

  .upload-box-label {
    background: #111222;
    border: 2px dashed rgba(139, 30, 196, 0.35);
    border-radius: 18px;
    padding: 36px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    width: 100%;
    box-sizing: border-box;
  }

  .upload-box-label:hover {
    border-color: #c084fc;
    background: #15162b;
    box-shadow: 0 4px 24px rgba(95, 21, 135, 0.15);
  }

  .upload-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: rgba(95, 21, 135, 0.2);
    border: 1px solid rgba(139, 30, 196, 0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #c084fc;
  }

  .upload-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0;
  }

  .upload-title span {
    color: #c084fc;
    text-decoration: underline;
  }

  .upload-sub {
    font-size: 0.78rem;
    color: #64748b;
    margin: 0;
  }

  .stats-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 14px;
    padding: 14px 20px;
    font-size: 0.85rem;
    color: #9d9bb8;
  }

  .stats-bar strong {
    color: #ffffff;
  }

  .files-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .file-item {
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 14px;
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    transition: all 0.2s ease;
  }

  .file-item:hover {
    border-color: rgba(139, 30, 196, 0.35);
    background: #141529;
    transform: translateY(-1px);
  }

  .file-left {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
    flex: 1;
  }

  .file-ext-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #c084fc;
    flex-shrink: 0;
  }

  .file-meta-col {
    display: flex;
    flex-direction: column;
    gap: 3px;
    min-width: 0;
  }

  .file-name {
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .file-date {
    font-size: 0.75rem;
    color: #64748b;
  }

  .file-actions {
    display: flex;
    align-items: center;
    gap: 18px;
    flex-shrink: 0;
  }

  .file-size-pill {
    color: #c084fc;
    font-size: 0.82rem;
    font-weight: 600;
    min-width: 75px;
    text-align: right;
  }

  .file-download-btn {
    color: #c084fc;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 8px;
    background: rgba(192, 132, 252, 0.08);
    border: 1px solid rgba(192, 132, 252, 0.2);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .file-download-btn:hover {
    color: #ffffff;
    background: rgba(192, 132, 252, 0.2);
    border-color: #c084fc;
  }

  .file-destroy-btn {
    background: transparent;
    border: none;
    color: #ef4444;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    padding: 6px 10px;
    border-radius: 8px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  .file-destroy-btn:hover {
    color: #ffffff;
    background: rgba(239, 68, 68, 0.18);
  }

  .empty-state {
    background: #111222;
    border: 1px dashed rgba(255, 255, 255, 0.1);
    border-radius: 18px;
    padding: 64px 20px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
  }

  .empty-state h3 {
    margin: 0;
    color: #ffffff;
    font-size: 1.15rem;
  }

  .empty-state p {
    margin: 0;
    color: #64748b;
    font-size: 0.88rem;
  }
</style>

<div class="files-container">

  @if(session('success'))
    <div style="background: rgba(139, 30, 196, 0.15); border: 1px solid rgba(192, 132, 252, 0.35); color: #d8b4fe; padding: 14px 20px; border-radius: 12px; font-size: 0.88rem;">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); color: #fca5a5; padding: 14px 20px; border-radius: 12px; font-size: 0.88rem;">
      {{ session('error') }}
    </div>
  @endif

  <div class="files-header">
    <div class="header-left">
      <a href="{{ route('projects.show') }}" class="back-btn" title="Projelere Dön">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </a>
      <div class="header-info">
        <h1>
          {{ $project->name }}
          <span class="project-badge-pill">Proje #{{ $project->id }}</span>
        </h1>
        <p>{{ $project->description ?? 'Bu projeye ait dosyalar ve eklenti paketleri.' }}</p>
      </div>
    </div>

    <label for="projectFileInput" class="btn-cta-primary" style="cursor: pointer;">
      <span>+</span> Dosya Seç & Yükle
    </label>
  </div>

  <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" style="margin: 0;">
    @csrf
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    
    <label for="projectFileInput" class="upload-box-label">
      <div class="upload-icon">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
        </svg>
      </div>
      <p class="upload-title">Dosya yüklemek için buraya <span>tıklayın</span></p>
      <p class="upload-sub">ZIP, SCHEMATIC, YML, JSON, MAP, JAR paketleri desteklenir</p>
      <input type="file" name="file" id="projectFileInput" style="display: none;" onchange="this.form.submit()">
    </label>
  </form>

  <div class="stats-bar">
    <div>
      Kayıtlı Dosya: <strong>{{ count($files) }} Adet</strong>
    </div>
    <div>
      Toplam Boyut: <strong style="color: #c084fc;">{{ number_format($files->sum('size') / 1048576, 2) }} MB</strong>
    </div>
  </div>

  <div class="files-list">
    @forelse($files as $file)
      <div class="file-item">
        <div class="file-left">
          <div class="file-ext-icon">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
          <div class="file-meta-col">
            <span class="file-name" title="{{ $file->original_name }}">{{ $file->original_name }}</span>
            <span class="file-date">Yüklendi: {{ $file->created_at ? $file->created_at->diffForHumans() : 'Bilinmiyor' }}</span>
          </div>
        </div>

        <div class="file-actions">
          <span class="file-size-pill">
            {{ number_format($file->size / 1048576, 2) }} MB
          </span>

          <a href="{{ route('files.download', $file->id) }}" class="file-download-btn">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            İndir
          </a>

          <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu dosyayı projeden silmek istediğinize emin misiniz?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="file-destroy-btn">
              <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
              Sil
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="empty-state">
        <svg width="44" height="44" fill="none" stroke="#64748b" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
        </svg>
        <h3>Bu Projede Henüz Dosya Yok</h3>
        <p>Yukarıdaki alana tıklayarak projeye dosya ekleyebilirsiniz.</p>
      </div>
    @endforelse
  </div>

</div>
@endsection