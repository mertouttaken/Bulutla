<div>
  <style>
    :root {
      --bg-surface: #0e0f1d;
      --bg-card: rgba(17, 18, 34, 0.75);
      --bg-card-hover: rgba(23, 24, 46, 0.95);
      --border-subtle: rgba(255, 255, 255, 0.08);
      --border-accent: rgba(192, 132, 252, 0.4);
      --neon-purple: #c084fc;
      --neon-purple-glow: rgba(192, 132, 252, 0.25);
      --text-primary: #f8fafc;
      --text-muted: #94a3b8;
    }

    .projects-container {
      max-width: 1240px;
      margin: 0 auto;
      padding: 40px 24px 80px 24px;
      color: #e2e8f0;
      display: flex;
      flex-direction: column;
      gap: 32px;
    }

    .alert-box {
      background: linear-gradient(90deg, rgba(95, 21, 135, 0.25), rgba(17, 18, 34, 0.8));
      border: 1px solid var(--border-accent);
      box-shadow: 0 4px 20px rgba(95, 21, 135, 0.2);
      color: #f3e8ff;
      padding: 14px 20px;
      border-radius: 14px;
      font-size: 0.9rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      backdrop-filter: blur(8px);
    }

    .alert-error {
      background: rgba(239, 68, 68, 0.15);
      border-color: rgba(239, 68, 68, 0.35);
      color: #fca5a5;
    }

    .projects-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      flex-wrap: wrap;
      gap: 20px;
      border-bottom: 1px solid var(--border-subtle);
      padding-bottom: 28px;
    }

    .header-info h1 {
      font-size: 1.85rem;
      font-weight: 800;
      color: var(--text-primary);
      margin: 0 0 6px 0;
      letter-spacing: -0.03em;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .header-info p {
      margin: 0;
      font-size: 0.92rem;
      color: var(--text-muted);
    }

    .btn-cta-primary {
      background: linear-gradient(135deg, #7e22ce, #a855f7);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: #ffffff;
      padding: 12px 24px;
      border-radius: 12px;
      font-size: 0.88rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 20px rgba(168, 85, 247, 0.35);
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-cta-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 28px rgba(168, 85, 247, 0.5);
    }

    .btn-cta-secondary {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--border-subtle);
      color: #cbd5e1;
      padding: 10px 20px;
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
      background: rgba(168, 85, 247, 0.12);
      border-color: var(--border-accent);
      color: #ffffff;
    }

    .filter-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
      background: var(--bg-card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--border-subtle);
      border-radius: 16px;
      padding: 12px 20px;
    }

    .search-wrapper {
      position: relative;
      flex: 1;
      min-width: 260px;
      max-width: 440px;
    }

    .search-input {
      width: 100%;
      background: rgba(14, 15, 29, 0.85);
      border: 1px solid var(--border-subtle);
      border-radius: 10px;
      padding: 10px 14px 10px 38px;
      color: #ffffff;
      font-size: 0.88rem;
      outline: none;
      box-sizing: border-box;
      transition: all 0.2s ease;
    }

    .search-input:focus {
      border-color: var(--neon-purple);
      box-shadow: 0 0 0 3px var(--neon-purple-glow);
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
      color: var(--text-muted);
      font-size: 0.85rem;
      background: rgba(255, 255, 255, 0.03);
      padding: 6px 14px;
      border-radius: 99px;
      border: 1px solid var(--border-subtle);
    }

    .project-count-badge strong {
      color: var(--neon-purple);
    }

    .projects-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
      gap: 24px;
    }

    .project-card {
      background: var(--bg-card);
      backdrop-filter: blur(16px);
      border: 1px solid var(--border-subtle);
      border-radius: 20px;
      padding: 24px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      gap: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
      position: relative;
      overflow: hidden;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .project-card::before {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 20px;
      padding: 1px;
      background: linear-gradient(135deg, rgba(192, 132, 252, 0.4), transparent 60%);
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      pointer-events: none;
    }

    .project-card:hover {
      background: var(--bg-card-hover);
      transform: translateY(-4px);
      border-color: rgba(192, 132, 252, 0.5);
      box-shadow: 0 12px 35px rgba(95, 21, 135, 0.35);
    }

    .card-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .project-icon {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      background: linear-gradient(135deg, rgba(95, 21, 135, 0.3), rgba(139, 30, 196, 0.1));
      border: 1px solid rgba(192, 132, 252, 0.25);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--neon-purple);
    }

    .project-status {
      background: rgba(139, 30, 196, 0.15);
      border: 1px solid rgba(192, 132, 252, 0.25);
      color: #d8b4fe;
      font-size: 0.72rem;
      padding: 4px 10px;
      border-radius: 20px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      letter-spacing: 0.02em;
    }

    .status-dot {
      width: 6px;
      height: 6px;
      border-radius: 99px;
      background: #4ade80;
      box-shadow: 0 0 8px #4ade80;
    }

    .project-title {
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--text-primary);
      margin: 0;
      letter-spacing: -0.01em;
    }

    .project-desc {
      font-size: 0.85rem;
      color: var(--text-muted);
      margin: 6px 0 0 0;
      line-height: 1.6;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      min-height: 2.7em;
    }

    .card-metrics {
      background: rgba(14, 15, 29, 0.6);
      border: 1px solid var(--border-subtle);
      border-radius: 14px;
      padding: 12px 16px;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
    }

    .metric-item {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .metric-item-label {
      font-size: 0.68rem;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      font-weight: 700;
    }

    .metric-item-val {
      font-size: 0.88rem;
      color: #e2e8f0;
      font-weight: 600;
    }

    .card-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-top: 1px solid var(--border-subtle);
      padding-top: 14px;
    }

    .btn-enter {
      color: var(--neon-purple);
      text-decoration: none;
      font-size: 0.85rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.15s ease;
    }

    .btn-enter:hover {
      color: #ffffff;
      transform: translateX(3px);
    }

    .btn-delete {
      background: transparent;
      border: none;
      color: #f87171;
      font-size: 0.8rem;
      font-weight: 600;
      cursor: pointer;
      padding: 6px 10px;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      transition: all 0.2s;
    }

    .btn-delete:hover {
      background: rgba(239, 68, 68, 0.15);
      color: #ef4444;
    }

    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(3, 4, 10, 0.75);
      backdrop-filter: blur(8px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px;
      z-index: 999;
    }

    .modal-container {
      background: #111222;
      border: 1px solid var(--border-accent);
      border-radius: 22px;
      width: 100%;
      max-width: 480px;
      padding: 28px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid var(--border-subtle);
      padding-bottom: 14px;
    }

    .modal-header h3 {
      margin: 0;
      font-size: 1.18rem;
      font-weight: 700;
      color: #ffffff;
    }

    .modal-close-btn {
      background: transparent;
      border: none;
      color: var(--text-muted);
      font-size: 1.2rem;
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
      color: #cbd5e1;
      font-weight: 600;
    }

    .form-control {
      background: #17182e;
      border: 1px solid var(--border-subtle);
      border-radius: 10px;
      padding: 11px 14px;
      color: #ffffff;
      font-size: 0.88rem;
      outline: none;
      transition: all 0.2s;
    }

    .form-control:focus {
      border-color: var(--neon-purple);
      box-shadow: 0 0 0 3px var(--neon-purple-glow);
    }

    .empty-state {
      grid-column: 1 / -1;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 40px 0;
    }
  </style>

  <div class="projects-container">
    @if(session('success'))
      <div class="alert-box">
        <span>{{ session('success') }}</span>
      </div>
    @endif

    @if(session('error'))
      <div class="alert-box alert-error">
        <span>{{ session('error') }}</span>
      </div>
    @endif

    <div class="projects-header">
      <div class="header-info">
        <h1>Proje Yönetimi</h1>
        <p>Oyun haritalarını, eklenti paketlerini ve yapılandırmalarını kolayca organize et.</p>
      </div>

      @if($user->plan?->project_limit == -1 || ($user->plan?->project_limit > 0 && $user->plan?->project_limit > $user->projects()->count()))
        <div style="display: flex; gap: 10px;">
          <button type="button" wire:click="openModal" class="btn-cta-primary">
            <span>+</span> Hızlı Proje Aç
          </button>
          <a href="{{ route('projects.create') }}" class="btn-cta-secondary">
            Detaylı Ekle
          </a>
        </div>
      @endif
    </div>

    <div class="filter-bar">
      <div class="search-wrapper">
        <svg class="search-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" 
               wire:model.live.debounce.300ms="search" 
               class="search-input" 
               placeholder="Proje adıyla filtrele...">
      </div>

      <div class="project-count-badge">
        Toplam: <strong>{{ count($projects) }}</strong> Proje
      </div>
    </div>

    <div class="projects-grid">
      @forelse($projects as $project)
        <div class="project-card">
          <div style="display: flex; flex-direction: column; gap: 14px;">
            <div class="card-top">
              <div class="project-icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
              </div>
              <div class="project-status">
                <span class="status-dot"></span> Aktif
              </div>
            </div>

            <div>
              <h3 class="project-title">{{ $project->name }}</h3>
              <p class="project-desc">{{ $project->description ?? 'Bu proje için bir açıklama girilmemiş.' }}</p>
            </div>

            <div class="card-metrics">
              <div class="metric-item">
                <span class="metric-item-label">Dosyalar</span>
                <span class="metric-item-val">{{ $project->files_count }} Adet</span>
              </div>

              <div class="metric-item">
                <span class="metric-item-label">Boyut</span>
                <span class="metric-item-val" style="color: var(--neon-purple);">
                  {{ method_exists($user, 'projectUsedID') ? number_format($user->projectUsedID($project->id) / 1048576, 2) : '0' }} MB
                </span>
              </div>

              <div class="metric-item">
                <span class="metric-item-label">Oluşturan</span>
                <span class="metric-item-val" style="font-size: 0.82rem; color: #94a3b8;">
                  {{ $project->user->name ?? $user->name }}
                </span>
              </div>

              <div class="metric-item">
                <span class="metric-item-label">Tarih</span>
                <span class="metric-item-val" style="font-size: 0.82rem; color: #94a3b8;">
                  {{ $project->created_at->format('d.m.Y') }}
                </span>
              </div>
            </div>
          </div>

          <div class="card-actions">
            <a href="{{ route('projects.files', ['projectId' => $project->id]) }}" class="btn-enter">
              <span>Dosyaları Yönet</span>
              <span>→</span>
            </a>

            <button type="button" 
                    wire:click="deleteProject({{ $project->id }})" 
                    wire:confirm="Bu projeyi ve içerisindeki tüm dosyaları silmek istediğinize emin misiniz?" 
                    class="btn-delete">
              <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
              <span>Sil</span>
            </button>
          </div>
        </div>
      @empty
        <div class="empty-state">
          <svg width="46" height="46" fill="none" stroke="#64748b" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
          <h3 style="color:#fff; margin:10px 0 4px 0;">Henüz Kayıtlı Bir Proje Yok</h3>
          <p style="color:#64748b; margin:0;">Yukarıdaki butona basarak ilk projeni oluşturabilirsin.</p>
        </div>
      @endforelse
    </div>
  </div>

  @if($showModal)
    <div class="modal-overlay">
      <div class="modal-container">
        <div class="modal-header">
          <h3>Yeni Proje Oluştur</h3>
          <button type="button" wire:click="closeModal" class="modal-close-btn">✕</button>
        </div>

        <form wire:submit="createProject" style="display: flex; flex-direction: column; gap: 16px; margin: 0;">
          <div class="form-group">
            <label for="pName">Proje Adı</label>
            <input type="text" id="pName" wire:model="name" placeholder="Örn: Survival Paketi" class="form-control">
            @error('name') <span style="color: #f87171; font-size: 0.76rem;">{{ $message }}</span> @enderror
          </div>

          <div class="form-group">
            <label for="pDesc">Açıklama (İsteğe Bağlı)</label>
            <textarea id="pDesc" wire:model="description" rows="3" placeholder="Proje içeriği, sürümü veya notlar..." class="form-control" style="resize: vertical; font-family: inherit;"></textarea>
          </div>

          <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
            <button type="button" wire:click="closeModal" class="btn-cta-secondary" style="padding: 9px 16px;">Vazgeç</button>
            <button type="submit" class="btn-cta-primary" style="padding: 9px 20px;">
              <span wire:loading.remove wire:target="createProject">Oluştur</span>
              <span wire:loading wire:target="createProject">Oluşturuluyor...</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  @endif
</div>