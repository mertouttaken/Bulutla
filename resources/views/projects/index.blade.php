@extends('layouts.app')

@section('content')
<style>
  .projects-container {
    max-width: 1240px;
    margin: 0 auto;
    padding: 36px 24px;
    color: #e2e8f0;
    display: flex;
    flex-direction: column;
    gap: 28px;
  }

  .projects-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    padding-bottom: 24px;
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

  .filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 14px;
    padding: 12px 18px;
  }

  .search-wrapper {
    position: relative;
    flex: 1;
    min-width: 260px;
    max-width: 420px;
  }

  .search-input {
    width: 100%;
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 10px;
    padding: 10px 14px 10px 38px;
    color: #ffffff;
    font-size: 0.85rem;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.2s ease;
  }

  .search-input:focus {
    border-color: #c084fc;
  }

  .search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    pointer-events: none;
  }

  .project-count-badge {
    color: #9d9bb8;
    font-size: 0.82rem;
  }

  .project-count-badge strong {
    color: #ffffff;
  }

  .projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 22px;
  }

  .project-card {
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 18px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 18px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
    transition: all 0.25s ease;
  }

  .project-card:hover {
    border-color: rgba(139, 30, 196, 0.45);
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(95, 21, 135, 0.25);
  }

  .project-card::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(139, 30, 196, 0.3), transparent);
  }

  .card-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .project-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(95, 21, 135, 0.2);
    border: 1px solid rgba(139, 30, 196, 0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #c084fc;
  }

  .project-status {
    background: rgba(139, 30, 196, 0.18);
    border: 1px solid rgba(192, 132, 252, 0.3);
    color: #d8b4fe;
    font-size: 0.72rem;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .status-dot {
    width: 6px;
    height: 6px;
    border-radius: 99px;
    background: #c084fc;
  }

  .project-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
    line-height: 1.3;
  }

  .project-desc {
    font-size: 0.85rem;
    color: #9d9bb8;
    margin: 6px 0 0 0;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .card-metrics {
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 12px 14px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .metric-item {
    display: flex;
    flex-direction: column;
    gap: 3px;
  }

  .metric-item-label {
    font-size: 0.72rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-weight: 600;
  }

  .metric-item-val {
    font-size: 0.88rem;
    color: #cbd5e1;
    font-weight: 600;
  }

  .card-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid rgba(255, 255, 255, 0.06);
    padding-top: 14px;
  }

  .btn-enter {
    color: #c084fc;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: color 0.15s ease;
  }

  .btn-enter:hover {
    color: #ffffff;
  }

  .btn-delete {
    background: transparent;
    border: none;
    color: #ef4444;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    padding: 6px 10px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s;
  }

  .btn-delete:hover {
    background: rgba(239, 68, 68, 0.18);
    color: #ffffff;
  }

  .empty-state {
    grid-column: 1 / -1;
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

  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(4, 4, 12, 0.8);
    backdrop-filter: blur(6px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    z-index: 999;
  }

  .modal-container {
    background: #111222;
    border: 1px solid rgba(139, 30, 196, 0.35);
    border-radius: 20px;
    width: 100%;
    max-width: 480px;
    padding: 28px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    padding-bottom: 14px;
  }

  .modal-header h3 {
    margin: 0;
    font-size: 1.15rem;
    font-weight: 600;
    color: #ffffff;
  }

  .modal-close-btn {
    background: transparent;
    border: none;
    color: #9d9bb8;
    font-size: 1.25rem;
    cursor: pointer;
  }

  .modal-close-btn:hover {
    color: #ffffff;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .form-group label {
    font-size: 0.8rem;
    color: #9d9bb8;
    font-weight: 500;
  }

  .form-control {
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    padding: 11px 14px;
    color: #ffffff;
    font-size: 0.88rem;
    outline: none;
  }

  .form-control:focus {
    border-color: #c084fc;
  }
</style>

<div class="projects-container">

  @if(session('success'))
    <div style="background: rgba(139, 30, 196, 0.15); border: 1px solid rgba(192, 132, 252, 0.35); color: #d8b4fe; padding: 14px 20px; border-radius: 12px; font-size: 0.88rem; display: flex; justify-content: space-between; align-items: center;">
      <span>{{ session('success') }}</span>
      <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:#d8b4fe; cursor:pointer;">✕</button>
    </div>
  @endif

  <div class="projects-header">
    <div class="header-info">
      <h1>Proje Yönetimi</h1>
      <p>Oyun haritaların, eklenti paketlerin ve yapılandırmalarını organize et.</p>
    </div>

    <button type="button" onclick="document.getElementById('newProjectModal').style.display = 'flex'" class="btn-cta-primary">
      <span>+</span> Yeni Proje Oluştur
      <a href="{{ route('projects.create') }}" style="display: none;"></a>
    </button>
  </div>

  <div class="filter-bar">
    <div class="search-wrapper">
      <svg class="search-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
      </svg>
      <input type="text" id="projectSearch" class="search-input" placeholder="Proje adıyla filtrele..." onkeyup="filterProjects()">
    </div>

    <div class="project-count-badge">
      Toplam: <strong>{{ count($projects) }}</strong> Proje
    </div>
  </div>

  <div class="projects-grid" id="projectsList">
    @php
        $user = Auth::user();
    @endphp
    @forelse($projects as $project)
      <div class="project-card" data-title="{{ strtolower($project->name) }}">
        <div style="display: flex; flex-direction: column; gap: 14px;">
          <div class="card-top">
            <div class="project-icon">
              <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
              </svg>
            </div>
            <div class="project-status">
              <span class="status-dot"></span> Hazır
            </div>
          </div>

          <div>
            <h3 class="project-title">{{ $project->name }}</h3>
            <p class="project-desc">{{ $project->description ?? 'Bu proje için bir açıklama girilmemiş.' }}</p>
          </div>

          <div class="card-metrics">
            <div class="metric-item">
              <span class="metric-item-label">Dosyalar</span>
              <span class="metric-item-val">{{ $project->files_count ?? $project->files->count() }} Adet</span>
            </div>
            <div class="metric-item">
            <span class="metric-item-label">Boyut</span>
            <span class="metric-item-val" style="color: #c084fc;">
                {{ number_format($user->projectUsedID($project->id) / 1048576, 2) }} MB
            </span>
            </div>
          </div>
        </div>

        <div class="card-actions">
          <a href="{{ route('dashboard', ['project_id' => $project->id]) }}" class="btn-enter">
            <span>Dosyaları Yönet</span>
            <span>→</span>
          </a>

          <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Bu projeyi ve içerisindeki tüm dosyaları silmek istediğinize emin misiniz?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">
              <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
              <span>Sil</span>
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="empty-state">
        <svg width="46" height="46" fill="none" stroke="#64748b" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        <h3>Henüz Kayıtlı Bir Proje Yok</h3>
        <p>Yukarıdaki "+ Yeni Proje Oluştur" butonuna basarak ilk oyun paketini ekleyebilirsin.</p>
      </div>
    @endforelse
  </div>

</div>

<div id="newProjectModal" class="modal-overlay" style="display: none;">
  <div class="modal-container">
    <div class="modal-header">
      <h3>Yeni Proje Oluştur</h3>
      <button type="button" onclick="document.getElementById('newProjectModal').style.display = 'none'" class="modal-close-btn">✕</button>
    </div>

    <form action="{{ route('projects.show') }}" method="POST" style="display: flex; flex-direction: column; gap: 16px; margin: 0;">
      @csrf
      <div class="form-group">
        <label for="pName">Proje Adı</label>
        <input type="text" name="name" id="pName" required placeholder="Örn: Survival Sezon 3 Haritası" class="form-control">
      </div>

      <div class="form-group">
        <label for="pDesc">Açıklama (İsteğe Bağlı)</label>
        <textarea name="description" id="pDesc" rows="3" placeholder="Proje içeriği, sürümü veya notlar..." class="form-control" style="resize: vertical; font-family: inherit;"></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
        <button type="button" onclick="document.getElementById('newProjectModal').style.display = 'none'" class="btn-cta-secondary" style="padding: 9px 16px;">Vazgeç</button>
        <button type="submit" class="btn-cta-primary" style="padding: 9px 20px;">Oluştur</button>
      </div>
    </form>
  </div>
</div>

<script>
  function filterProjects() {
    const query = document.getElementById('projectSearch').value.toLowerCase().trim();
    const cards = document.querySelectorAll('#projectsList .project-card');

    cards.forEach(card => {
      const title = card.getAttribute('data-title') || '';
      card.style.display = title.includes(query) ? 'flex' : 'none';
    });
  }
</script>
@endsection