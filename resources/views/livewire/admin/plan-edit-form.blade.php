<div>

  <div class="admin-layout">
    <aside class="admin-sidebar">
      <a href="{{ route('home') }}" class="sidebar-brand">
        <span class="dot"></span>
        <h2>Bulutla</h2><small>YÖNETİM ARŞİVİ</small>
      </a>
      <nav class="sidebar-nav">
        <ul>
          <li><a href="{{ route('admin.index') }}"><i>01</i> Genel bakış</a></li>
          <li>
            <a href="#" class="active"><i>02</i> Planlar</a>
            <ul class="submenu">
              <li><a href="{{ route('admin.plans.index') }}">Plan listesi</a></li>
              <li><a href="{{ route('admin.plans.actions') }}">Hızlı işlemler</a></li>
            </ul>
          </li>
          <li><a href="{{ route('admin.subscriptions.index') }}"><i>03</i> Abonelikler</a></li>
          <li><a href="{{ route('admin.users.index') }}"><i>04</i> Kullanıcılar</a></li>
        </ul>
      </nav>
    </aside>

    <div class="admin-main">
      <header class="admin-topbar">
        <div class="topbar-title">
        <p class="desk-kicker">YÖNETİM</p>
        <h1 class="motion-title">Planı Düzenle</h1>
        </div>
        <div class="topbar-user">
          <span>{{ Auth::user()->name ?? 'Yönetici' }}</span>
        </div>
      </header>

      <main class="admin-content">
        <div class="edit-card">
          <div class="card-header">
            <h3>{{ $plan->name }} Planını Düzenle</h3>
            <a href="{{ route('admin.plans.actions') }}" class="btn-back">← Geri Dön</a>
          </div>

          <form wire:submit="update">
            <div class="form-grid">
              <div class="form-group">
                <label>Plan Adı</label>
                <input type="text" wire:model="name" class="form-control">
                @error('name') <span class="field-error">{{ $message }}</span> @enderror
              </div>

              <div class="form-group">
                <label>Slug</label>
                <input type="text" wire:model="slug" class="form-control">
                @error('slug') <span class="field-error">{{ $message }}</span> @enderror
              </div>

              <div class="form-group">
                <label>Aylık Ücret (₺)</label>
                <input type="number" step="0.01" wire:model="price" class="form-control">
                @error('price') <span class="field-error">{{ $message }}</span> @enderror
              </div>

              <div class="form-group">
                <label>Depolama Limiti</label>
                <input type="text" wire:model="storage_limit" class="form-control">
              </div>

              <div class="form-group">
                <label>Proje Limiti</label>
                <input type="number" wire:model="project_limit" class="form-control">
              </div>

              <div class="form-group">
                <label>Görüntülenme Sırası</label>
                <input type="number" wire:model="sort_order" class="form-control">
              </div>

              <div class="form-group full">
                <label>Açıklama</label>
                <textarea wire:model="description" class="form-control"></textarea>
              </div>

              <div class="form-group full">
                <label>Özellikler (Virgülle ayırın)</label>
                <input type="text" wire:model="features" class="form-control">
              </div>
            </div>

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

            <div class="card-actions">
              <a href="{{ route('admin.plans.actions') }}" class="btn-secondary">İptal</a>
              <button type="submit" class="btn-submit">Değişiklikleri Kaydet</button>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>
</div>