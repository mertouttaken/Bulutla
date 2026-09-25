<div>
  <style>
    :root {
      --bg-surface: #0b0d14;
      --bg-sidebar: #111420;
      --bg-card: rgba(17, 20, 34, 0.85);
      --border-subtle: rgba(255, 255, 255, 0.07);
      --border-accent: rgba(192, 132, 252, 0.35);
      --neon-purple: #c084fc;
      --neon-purple-glow: rgba(192, 132, 252, 0.25);
      --text-primary: #f8fafc;
      --text-muted: #8f9bba;
    }

    .admin-layout {
      display: flex;
      min-height: calc(100vh - 70px);
      background: var(--bg-surface);
      color: #e2e8f0;
      width: 100%;
    }

    .admin-sidebar {
      width: 260px;
      flex-shrink: 0;
      background: var(--bg-sidebar);
      border-right: 1px solid var(--border-subtle);
      padding: 28px 20px;
      display: flex;
      flex-direction: column;
      gap: 32px;
    }

    .sidebar-brand h2 {
      font-size: 1.15rem;
      font-weight: 700;
      letter-spacing: -0.02em;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 0;
    }

    .sidebar-brand span.dot {
      width: 8px;
      height: 8px;
      background: #6366f1;
      border-radius: 50%;
      box-shadow: 0 0 12px #6366f1;
    }

    .sidebar-nav ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .sidebar-nav a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 14px;
      border-radius: 10px;
      color: var(--text-muted);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .sidebar-nav a:hover {
      background: rgba(255, 255, 255, 0.04);
      color: #fff;
    }

    .sidebar-nav a.active {
      background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(168, 85, 247, 0.15));
      color: #a5b4fc;
      border: 1px solid rgba(99, 102, 241, 0.25);
    }

    .submenu {
      list-style: none;
      padding-left: 28px;
      margin-top: 6px;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .submenu a {
      font-size: 0.82rem;
      padding: 8px 12px;
      color: #64748b;
    }

    .submenu a.sub-active {
      color: #fff;
      background: rgba(255, 255, 255, 0.05);
      font-weight: 600;
    }

    .admin-main {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    .admin-topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 36px;
      border-bottom: 1px solid var(--border-subtle);
      background: #0e111a;
    }

    .topbar-title h1 {
      font-size: 1.3rem;
      font-weight: 700;
      margin: 0;
      color: #fff;
    }

    .topbar-user {
      display: flex;
      align-items: center;
      gap: 10px;
      background: rgba(255, 255, 255, 0.03);
      padding: 6px 14px;
      border-radius: 20px;
      border: 1px solid var(--border-subtle);
      font-size: 0.85rem;
      color: #cbd5e1;
    }

    .admin-content {
      padding: 36px;
      display: flex;
      flex-direction: column;
      gap: 28px;
    }

    .content-grid {
      display: grid;
      grid-template-columns: 1.25fr 1fr;
      gap: 28px;
      align-items: start;
    }

    @media (max-width: 960px) {
      .content-grid {
        grid-template-columns: 1fr;
      }
    }

    .action-card {
      background: var(--bg-card);
      backdrop-filter: blur(16px);
      border: 1px solid var(--border-subtle);
      border-radius: 20px;
      padding: 28px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      position: relative;
      overflow: hidden;
    }

    .action-card::before {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 20px;
      padding: 1px;
      background: linear-gradient(135deg, rgba(192, 132, 252, 0.35), transparent 60%);
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      pointer-events: none;
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 22px;
      padding-bottom: 14px;
      border-bottom: 1px solid var(--border-subtle);
    }

    .card-header h3 {
      font-size: 1.15rem;
      font-weight: 700;
      color: #fff;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .form-group.full {
      grid-column: span 2;
    }

    .form-group label {
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--text-muted);
    }

    .form-control {
      background: rgba(14, 15, 29, 0.85);
      border: 1px solid var(--border-subtle);
      border-radius: 12px;
      padding: 11px 14px;
      font-size: 0.88rem;
      color: #fff;
      outline: none;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      box-sizing: border-box;
      width: 100%;
    }

    .form-control:focus {
      border-color: var(--neon-purple);
      box-shadow: 0 0 0 3px var(--neon-purple-glow);
      background: #15162b;
    }

    textarea.form-control {
      resize: vertical;
      min-height: 80px;
      font-family: inherit;
    }

    .toggle-container {
      background: rgba(14, 15, 29, 0.7);
      border: 1px solid var(--border-subtle);
      border-radius: 14px;
      padding: 14px 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      transition: border-color 0.2s ease;
    }

    .toggle-container:hover {
      border-color: rgba(192, 132, 252, 0.3);
    }

    .toggle-text {
      display: flex;
      flex-direction: column;
      gap: 3px;
    }

    .toggle-title {
      font-size: 0.88rem;
      font-weight: 600;
      color: var(--text-primary);
    }

    .toggle-subtitle {
      font-size: 0.76rem;
      color: var(--text-muted);
      line-height: 1.4;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 48px;
      height: 26px;
      flex-shrink: 0;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      inset: 0;
      background-color: #1e1f38;
      transition: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      border-radius: 34px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 3px;
      bottom: 3px;
      background-color: #94a3b8;
      transition: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      border-radius: 50%;
    }

    .switch input:checked + .slider {
      background: linear-gradient(135deg, #7e22ce, #a855f7);
      border-color: rgba(192, 132, 252, 0.6);
      box-shadow: 0 0 14px rgba(168, 85, 247, 0.4);
    }

    .switch input:checked + .slider:before {
      transform: translateX(22px);
      background-color: #ffffff;
    }

    .btn-submit {
      background: linear-gradient(135deg, #7e22ce, #a855f7);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: #fff;
      padding: 12px 24px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 0.9rem;
      cursor: pointer;
      width: 100%;
      margin-top: 6px;
      box-shadow: 0 4px 20px rgba(168, 85, 247, 0.35);
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 26px rgba(168, 85, 247, 0.5);
    }

    .quick-list {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .quick-item {
      background: rgba(14, 15, 29, 0.65);
      border: 1px solid var(--border-subtle);
      border-radius: 14px;
      padding: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .quick-item:hover {
      border-color: var(--border-accent);
      background: rgba(23, 24, 46, 0.85);
      transform: translateY(-1px);
    }

    .quick-info h4 {
      margin: 0 0 4px 0;
      font-size: 0.95rem;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }

    .plan-default-badge {
      background: rgba(74, 222, 128, 0.12);
      border: 1px solid rgba(74, 222, 128, 0.3);
      color: #4ade80;
      font-size: 0.68rem;
      padding: 2px 8px;
      border-radius: 12px;
      font-weight: 600;
      letter-spacing: 0.02em;
    }

    .quick-info span {
      font-size: 0.8rem;
      color: var(--text-muted);
    }

    .quick-actions {
      display: flex;
      gap: 8px;
      flex-shrink: 0;
    }

    .btn-action {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--border-subtle);
      color: #cbd5e1;
      padding: 7px 13px;
      border-radius: 8px;
      font-size: 0.8rem;
      font-weight: 500;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s;
      display: inline-flex;
      align-items: center;
    }

    .btn-action:hover {
      background: rgba(168, 85, 247, 0.15);
      border-color: var(--border-accent);
      color: #fff;
    }

    .btn-danger {
      color: #f87171;
      border-color: rgba(239, 68, 68, 0.25);
    }

    .btn-danger:hover {
      background: rgba(239, 68, 68, 0.2);
      border-color: #ef4444;
      color: #ffffff;
    }
  </style>

  <div class="admin-layout">
    <aside class="admin-sidebar">
      <div class="sidebar-brand">
        <span class="dot"></span>
        <h2>Bulutla Admin</h2>
      </div>
      <nav class="sidebar-nav">
        <ul>
          <li><a href="{{ route('admin.index') }}">📊 Genel Bakış</a></li>
          <li>
            <a href="#" class="active">📦 Planlar</a>
            <ul class="submenu">
              <li><a href="{{ route('admin.plans.index') }}">📋 Mevcut Plan Listesi</a></li>
              <li><a href="{{ route('admin.plans.actions') }}" class="sub-active">⚡ Hızlı İşlemler & Ekleme</a></li>
            </ul>
          </li>
          <li><a href="{{ route('admin.subscriptions.index') }}">💳 Abonelikler</a></li>
          <li><a href="{{ route('admin.users.index') }}">👥 Kullanıcılar</a></li>
        </ul>
      </nav>
    </aside>

    <div class="admin-main">
      <header class="admin-topbar">
        <div class="topbar-title">
          <h1>Hızlı İşlemler & Yeni Plan</h1>
        </div>
        <div class="topbar-user">
          <span>👤 {{ Auth::user()->name ?? 'Yönetici' }}</span>
        </div>
      </header>

      <main class="admin-content">
        @if(session('success'))
          <div style="background: linear-gradient(90deg, rgba(95, 21, 135, 0.25), rgba(17, 18, 34, 0.8)); border: 1px solid var(--border-accent); color: #f3e8ff; padding: 14px 20px; border-radius: 14px; font-size: 0.88rem;">
            {{ session('success') }}
          </div>
        @endif

        <div class="content-grid">
          <div class="action-card">
            <div class="card-header">
              <h3>Yeni Plan Tanımla</h3>
            </div>
            <form wire:submit="save">
              <div class="form-grid">
                <div class="form-group">
                  <label>Plan Adı</label>
                  <input type="text" wire:model.live.debounce.300ms="name" class="form-control" placeholder="Örn: Pro">
                  @error('name') <span style="color: #f87171; font-size: 0.76rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                  <label>Slug</label>
                  <input type="text" wire:model="slug" class="form-control" placeholder="pro">
                  @error('slug') <span style="color: #f87171; font-size: 0.76rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                  <label>Aylık Ücret (₺)</label>
                  <input type="number" step="0.01" wire:model="price" class="form-control" placeholder="149.00">
                  @error('price') <span style="color: #f87171; font-size: 0.76rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                  <label>Görüntülenme Sırası</label>
                  <input type="number" wire:model="sort_order" class="form-control" placeholder="0">
                </div>

                <div class="form-group">
                  <label>Depolama Limiti</label>
                  <input type="text" wire:model="storage_limit" class="form-control" placeholder="Örn: 5 GB">
                </div>

                <div class="form-group">
                  <label>Proje Limiti</label>
                  <input type="number" wire:model="project_limit" class="form-control" placeholder="5">
                </div>

                <div class="form-group full">
                  <label>Açıklama</label>
                  <textarea wire:model="description" class="form-control" placeholder="Plan hakkında kısa bilgilendirme..."></textarea>
                </div>

                <div class="form-group full">
                  <label>Özellikler (Virgülle ayırın)</label>
                  <input type="text" wire:model="features" class="form-control" placeholder="5 proje, 5 GB alan, Canlı destek">
                </div>

                <div class="form-group full">
                  <div class="toggle-container">
                    <div class="toggle-text">
                      <span class="toggle-title">Varsayılan Plan</span>
                      <span class="toggle-subtitle">Yeni kayıt olan kullanıcılara otomatik olarak bu plan atanır.</span>
                    </div>

                    <label class="switch">
                      <input type="checkbox" wire:model="is_default">
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>

                <div class="form-group full">
                  <button type="submit" class="btn-submit" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Planı Kaydet ve Yayınla</span>
                    <span wire:loading wire:target="save">Kaydediliyor...</span>
                  </button>
                </div>
              </div>
            </form>
          </div>

          <div class="action-card">
            <div class="card-header">
              <h3>Hızlı Yönetim</h3>
            </div>
            <div class="quick-list">
              @forelse ($plans as $plan)
                <div class="quick-item">
                  <div class="quick-info">
                    <h4>
                      {{ $plan->name }}
                      <span style="font-size: 0.75rem; color: #726d75;">(#{{ $plan->sort_order ?? 0 }})</span>
                      @if($plan->is_default)
                        <span class="plan-default-badge">Varsayılan</span>
                      @endif
                    </h4>
                    <span>{{ number_format($plan->price, 2) }} ₺ / ay • {{ $plan->storage_limit ?? 'Sınırsız' }} • {{ $plan->project_limit ?? 0 }} Proje</span>
                  </div>
                  <div class="quick-actions">
                    <a href="{{ route('admin.plans.edit', $plan) }}" class="btn-action">Düzenle</a>
                    @if(!$plan->is_default)
                      <button type="button" wire:click="deletePlan({{ $plan->id }})" wire:confirm="Bu planı silmek istediğinize emin misiniz?" class="btn-action btn-danger">
                        Sil
                      </button>
                    @endif
                  </div>
                </div>
              @empty
                <div style="text-align: center; color: var(--text-muted); padding: 24px;">
                  Henüz kayıtlı bir plan bulunmuyor.
                </div>
              @endforelse
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</div>