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
.shelf-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,285px),1fr));gap:28px}
.shelf-project{min-width:0;--cover:#cbb0dd;--edge:#866b96;--letter:#34273e}
.shelf-project:nth-child(3n+2){--cover:#aab9a6;--edge:#778674;--letter:#273629}
.shelf-project:nth-child(3n){--cover:#d9b79c;--edge:#96765f;--letter:#382920}
.shelf-object{height:250px;position:relative;perspective:1800px;isolation:isolate}
.shelf-back{position:absolute;inset:20% 2% 2%;background:var(--edge);border-radius:6px}
.shelf-back:before{content:"";position:absolute;bottom:99%;left:0;width:40%;height:14px;background:var(--edge);clip-path:polygon(0 0,85% 0,100% 100%,0 100%)}
.shelf-pages{position:absolute;inset:3% 6% 33%;z-index:1;overflow:auto;overscroll-behavior:contain;scrollbar-width:thin;scrollbar-color:#9f8d78 #eae3cc;background:#f4eedb;color:#36302a;border-radius:3px;border:1px solid #c7baa3;box-shadow:0 3px 0 #bfaf9f,0 5px 0 #e1d3bb,0 8px 15px #120e1844;transform:translateY(51%) scale(.97);transition:transform .6s cubic-bezier(.2,.7,.2,1)}
.is-open .shelf-pages{transform:translateY(0) scale(1)}
.shelf-file,.shelf-upload{display:flex;align-items:center;gap:9px;padding:12px 10px;border-bottom:1px solid #cfc5ae;font-size:.88rem}.shelf-file span{overflow-wrap:anywhere;flex:1}.shelf-file small,.shelf-meta,.shelf-imprint,.shelf-foot{font:600 .68rem/1.4 var(--font-mono);letter-spacing:.035em}
.shelf-file small{padding:3px;background:#e2d6bf;border-radius:2px}.shelf-file:hover,.shelf-file:focus-visible,.shelf-upload:hover{background:#e7d9c3}.shelf-empty{padding:15px 12px 0;margin:0}.shelf-upload{text-decoration:underline}
.shelf-cover{cursor:pointer;text-align:left;color:var(--letter);position:absolute;z-index:2;inset:30% 0 0;width:100%;border-radius:7px;border:1px solid color-mix(in srgb,var(--cover),white 28%);background:linear-gradient(122deg,color-mix(in srgb,var(--cover),white 12%),var(--cover) 70%,color-mix(in srgb,var(--cover),black 8%));box-shadow:0 8px 16px #08060a40;display:flex;flex-direction:column;justify-content:space-between;padding:14px 18px;transform-origin:center bottom;transition:transform .55s cubic-bezier(.2,.7,.2,1)}
.is-open .shelf-cover{transform:rotateX(-63deg) scaleX(.96)}.shelf-cover strong{font:italic 500 clamp(1.8rem,3.5vw,3.2rem)/1 var(--font-head);letter-spacing:-.02em;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:100%}
.shelf-imprint,.shelf-foot,.shelf-actions{display:flex;align-items:center;justify-content:space-between}.shelf-imprint{border-bottom:1px solid #392c373f;padding-bottom:7px}
.shelf-description{color:var(--ink);margin:14px 0 4px;overflow-wrap:anywhere}.shelf-meta{display:block;margin:8px 0;color:var(--ink-muted)}.shelf-actions{border-top:1px solid var(--border);padding:12px 0;font-size:.9rem}.shelf-actions a{color:#dbc3eb}.shelf-actions button{background:none;border:0;color:#deaeb1;cursor:pointer}
.archive-site .projects-container .header-info h1{display:block;font:500 var(--t-title)/1 var(--font-head);letter-spacing:-.02em;margin:0}
.shelf-motion{display:none !important}
.archive-site .projects-container .projects-header,.archive-site .projects-container .filter-bar{background:transparent;box-shadow:none;border-color:var(--border)}
.shelf-motion{display:none}
@media(prefers-reduced-motion:reduce){
  .shelf-motion{display:inline-flex;align-items:center;gap:8px;font-size:.88rem;cursor:pointer}
  .projects-container:not(:has(.shelf-motion input:checked)) :is(.shelf-cover,.shelf-pages){transition:none}
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
        <p class="desk-kicker">KİŞİSEL ARŞİV</p><h1 class="motion-title">Projelerim<span class="lilac-num">.</span></h1>
        <p>Dosyalarını görmek için bir klasör aç.</p>
      </div>

      @if($user->plan?->project_limit == -1 || ($user->plan?->project_limit > 0 && $user->plan?->project_limit > $user->projects()->count()))
        <button type="button" wire:click="openModal" class="btn-cta-secondary">
          <span aria-hidden="true">+</span> Proje Ekle
        </button>
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

      <label class="shelf-motion"><input type="checkbox" checked> Klasör animasyonunu göster</label>
      <div class="project-count-badge">
        Toplam: <strong data-tick>{{ count($projects) }}</strong> Proje
      </div>
    </div>

    <div class="shelf-grid">
      @forelse($projects as $project)
        <article class="shelf-project" wire:key="folder-{{ $project->id }}" x-data="{ open: false }" :class="{ 'is-open': open }">
          <div class="shelf-object">
            <div class="shelf-back" aria-hidden="true"></div>
            <div id="contents-{{ $project->id }}" class="shelf-pages" inert :inert="!open" aria-label="{{ $project->name }} dosyaları" role="region">
              @forelse($project->files as $file)
                <a class="shelf-file" href="{{ route('files.download', $file->id) }}" title="{{ $file->original_name }} dosyasını indir">
                  <small>{{ strtoupper(substr(pathinfo($file->original_name, PATHINFO_EXTENSION), 0, 6)) ?: 'DOSYA' }}</small>
                  <span>{{ $file->original_name }}</span><b aria-hidden="true">↓</b>
                </a>
              @empty
                <p class="shelf-empty">Bu klasör boş.</p>
                <a class="shelf-upload" href="{{ route('projects.files', $project->id) }}">İlk dosyayı yükle ↗</a>
              @endforelse
            </div>
            <button class="shelf-cover" type="button" @click="open = !open" aria-controls="contents-{{ $project->id }}" :aria-expanded="open.toString()" aria-label="{{ $project->name }} klasörü">
              <span class="shelf-imprint"><span>BULUTLA</span><span>{{ $project->created_at->format('d.m.Y') }}</span></span>
              <strong>{{ $project->name }}</strong>
              <span class="shelf-foot"><span>{{ $project->files->count() }} dosya</span><span x-text="open ? 'Kapat ↙' : 'Aç ↗'">Aç ↗</span></span>
            </button>
          </div>
          @if($project->description)<p class="shelf-description">{{ $project->description }}</p>@endif
          <small class="shelf-meta">{{ $user->name }} · {{ number_format($project->files->sum('size') / 1048576, 2) }} MB</small>
          <div class="shelf-actions"><a href="{{ route('projects.files', $project->id) }}">Dosyaları yönet ↗</a>
            <button type="button" wire:click="deleteProject({{ $project->id }})" wire:confirm="Bu projeyi ve içerisindeki tüm dosyaları silmek istediğinize emin misiniz?">Sil</button>
          </div>
        </article>
      @empty
        @if($search)
          <p class="shelf-none">Aramana uygun proje bulunamadı.</p>
        @else
          @if($user->plan?->project_limit == -1 || ($user->plan?->project_limit > 0 && $user->plan?->project_limit > $user->projects()->count()))
            <button type="button" wire:click="openModal" class="shelf-slot">
              <span class="shelf-slot__plus" aria-hidden="true">+</span>
              <span class="shelf-slot__title">İlk projeni aç</span>
              <small>Henüz klasörün yok.</small>
            </button>
          @else
            <a href="{{ route('plans.index') }}" class="shelf-slot">
              <span class="shelf-slot__plus" aria-hidden="true">↗</span>
              <span class="shelf-slot__title">Plan seç</span>
              <small>Proje açmak için bir plan gerekiyor.</small>
            </a>
          @endif
        @endif
      @endforelse
    </div>

  </div>

  @if($showModal)
    <div class="modal-overlay fm-overlay" wire:keydown.escape.window="closeModal">
      <form wire:submit="createProject" class="fm" role="dialog" aria-modal="true" aria-labelledby="fm-title">
        <div class="fm-sheet">
          <label for="pDesc" class="fm-label">Notlar <span>isteğe bağlı</span></label>
          <textarea id="pDesc" wire:model="description" rows="3" placeholder="Proje içeriği, sürümü veya notlar…"></textarea>
        </div>
        <div class="fm-cover">
          <div class="fm-rule">
            <span>BULUTLA</span>
            <span id="fm-title">YENİ KLASÖR</span>
            <button type="button" wire:click="closeModal" class="fm-close" aria-label="Kapat">✕</button>
          </div>
          <label for="pName" class="fm-sr">Proje adı</label>
          <input type="text" id="pName" wire:model="name" class="fm-name" placeholder="Proje adı" autocomplete="off" maxlength="255" autofocus>
          @error('name') <span class="fm-error">{{ $message }}</span> @enderror
          <div class="fm-foot">
            <span class="fm-meta">{{ now()->format('d.m.Y') }} · {{ $user->name }}</span>
            <div class="fm-actions">
              <button type="button" wire:click="closeModal" class="fm-cancel">Vazgeç</button>
              <button type="submit" class="fm-submit" wire:loading.attr="disabled" wire:target="createProject">
                <span wire:loading.remove wire:target="createProject">Klasörü oluştur</span>
                <span wire:loading wire:target="createProject">Oluşturuluyor…</span>
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  @endif
</div>



