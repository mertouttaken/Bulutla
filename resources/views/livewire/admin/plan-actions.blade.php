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
              <li><a href="{{ route('admin.plans.actions') }}" class="sub-active">Hızlı işlemler</a></li>
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
        <h1 class="motion-title">Hızlı İşlemler & Yeni Plan</h1>
        </div>
        <div class="topbar-user">
          <span>{{ Auth::user()->name ?? 'Yönetici' }}</span>
        </div>
      </header>

      <main class="admin-content">
        @if(session('success'))
          <div class="archive-alert" role="status">
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
                  @error('name') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                  <label>Slug</label>
                  <input type="text" wire:model="slug" class="form-control" placeholder="pro">
                  @error('slug') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                  <label>Aylık Ücret (₺)</label>
                  <input type="number" step="0.01" wire:model="price" class="form-control" placeholder="149.00">
                  @error('price') <span class="field-error">{{ $message }}</span> @enderror
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
                      <span style="font-size: 0.75rem;">(#{{ $plan->sort_order ?? 0 }})</span>
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