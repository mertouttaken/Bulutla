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
          <li><a href="{{ route('admin.plans.index') }}"><i>02</i> Planlar</a></li>
          <li><a href="{{ route('admin.subscriptions.index') }}" class="active"><i>03</i> Abonelikler</a></li>
          <li><a href="{{ route('admin.users.index') }}"><i>04</i> Kullanıcılar</a></li>
        </ul>
      </nav>
    </aside>

    <div class="admin-main">
      <header class="admin-topbar">
        <div class="topbar-title">
        <p class="desk-kicker">YÖNETİM</p>
        <h1 class="motion-title">Abonelik Yönetimi</h1>
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

        <div class="content-header">
          <a href="{{ route('admin.subscriptions.index') }}" class="btn-back">← Abonelik Listesine Dön</a>
          <span class="badge {{ $subscription->status === 'active' ? 'badge-active' : 'badge-cancelled' }}">
            ● {{ $subscription->status === 'active' ? 'Aktif' : 'İptal Edilmiş' }}
          </span>
        </div>

        <div class="detail-grid">
          <!-- Sol Kart: Sabit Bilgiler -->
          <div class="detail-card">
            <div class="card-header">
              <h3>Abonelik & Kullanıcı Bilgileri</h3>
              <span style=" font-size: 0.85rem; font-weight: 600;">#SUB-{{ $subscription->id }}</span>
            </div>

            <div class="info-list">
              <div class="info-item">
                <span class="label">Kullanıcı Adı</span>
                <span class="val">{{ $subscription->user->name ?? 'Tanımsız' }}</span>
              </div>

              <div class="info-item">
                <span class="label">E-Posta</span>
                <span class="val">{{ $subscription->user->email ?? 'Tanımsız' }}</span>
              </div>

              <div class="info-item">
                <span class="label">Mevcut Plan</span>
                <span class="val">{{ $subscription->plan->name ?? 'Plan Yok' }}</span>
              </div>

              <div class="info-item">
                <span class="label">Plan Ücreti</span>
                <span class="val">{{ number_format($subscription->plan->price ?? 0, 2, ',', '.') }} ₺ / ay</span>
              </div>

              <div class="info-item">
                <span class="label">Başlangıç Tarihi</span>
                <span class="val">{{ $subscription->created_at ? $subscription->created_at->translatedFormat('d F Y H:i') : '-' }}</span>
              </div>

              <div class="info-item">
                <span class="label">Bitiş / Yenilenme Tarihi</span>
                <span class="val">{{ $subscription->ends_at ? \Carbon\Carbon::parse($subscription->ends_at)->translatedFormat('d F Y') : 'Süresiz' }}</span>
              </div>
            </div>
          </div>

          <!-- Sağ Kart: Canlı Güncelleme Formu -->
          <div class="detail-card">
            <div class="card-header">
              <h3>İşlemler</h3>
            </div>

            <form wire:submit="updateSubscription">
              <div class="form-group">
                <label>Plan Değiştir</label>
                <select wire:model="plan_id" class="form-control">
                  @foreach($plans as $plan)
                    <option value="{{ $plan->id }}">
                      {{ $plan->name }} ({{ number_format($plan->price, 2, ',', '.') }} ₺)
                    </option>
                  @endforeach
                </select>
                @error('plan_id') <span class="field-error">{{ $message }}</span> @enderror
              </div>

              <div class="form-group">
                <label>Durum Güncelle</label>
                <select wire:model="status" class="form-control">
                  <option value="active">Aktif</option>
                  <option value="cancelled">İptal Edilmiş</option>
                </select>
                @error('status') <span class="field-error">{{ $message }}</span> @enderror
              </div>

              <div class="form-group">
                <label>Bitiş Tarihi</label>
                <input type="date" wire:model="ends_at" class="form-control">
                @error('ends_at') <span class="field-error">{{ $message }}</span> @enderror
              </div>

              <button type="submit" class="btn-submit" wire:loading.attr="disabled">
                Değişiklikleri Kaydet
              </button>
            </form>

            @if($subscription->status === 'active')
              <button type="button" 
                      wire:click="cancelSubscription" 
                      wire:confirm="Bu aboneliği iptal etmek istediğinize emin misiniz?" 
                      class="btn-danger-outline">
                Aboneliği Sonlandır
              </button>
            @endif
          </div>
        </div>
      </main>
    </div>
  </div>
</div>