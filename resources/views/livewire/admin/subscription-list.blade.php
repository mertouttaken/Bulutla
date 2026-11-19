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

        <div class="filter-bar">
          <div class="search-box">
            <span class="search-icon" aria-hidden="true">⌕</span>
            <input type="text" 
                   wire:model.live.debounce.300ms="search" 
                   class="search-input" 
                   placeholder="Kullanıcı veya e-posta ara...">
          </div>

          <div class="filter-group">
            <select wire:model.live="planFilter" class="filter-select">
              <option value="">Tüm Planlar</option>
              @foreach($plans as $plan)
                <option value="{{ $plan->slug }}">{{ $plan->name }}</option>
              @endforeach
            </select>

            <select wire:model.live="statusFilter" class="filter-select">
              <option value="">Durum: Tümü</option>
              <option value="active">Aktif</option>
              <option value="cancelled">İptal Edilmiş</option>
            </select>
          </div>
        </div>

        <div class="panel-card">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Abone</th>
                <th>Mevcut Plan</th>
                <th>Durum</th>
                <th>Fiyat</th>
                <th>Bitiş / Yenilenme</th>
                <th>İşlemler</th>
              </tr>
            </thead>
            <tbody>
              @forelse($subscriptions as $subscription)
                <tr>
                  <td>
                    <div class="user-cell">
                      <strong>{{ $subscription->user->name ?? 'Bilinmiyor' }}</strong>
                      <span>{{ $subscription->user->email ?? 'Bilinmiyor' }}</span>
                    </div>
                  </td>
                  <td>
                    <span class="badge badge-plan">{{ $subscription->plan->name ?? '-' }}</span>
                  </td>
                  <td>
                    <span class="badge badge-{{ $subscription->status === 'active' ? 'active' : 'cancelled' }}">
                      ● {{ $subscription->status === 'active' ? 'Aktif' : 'İptal Edilmiş' }}
                    </span>
                  </td>
                  <td>{{ number_format($subscription->plan->price ?? 0, 2, ',', '.') }} ₺ / ay</td>
                  <td>{{ $subscription->ends_at ? \Carbon\Carbon::parse($subscription->ends_at)->translatedFormat('d M Y') : 'Bilinmiyor' }}</td>
                  <td>
                    <div class="table-actions">
                      <a href="{{ route('admin.subscriptions.show', $subscription->id) }}" class="action-btn">Detay</a>

                      @if($subscription->status === 'active')
                        <button type="button" 
                                wire:click="cancelSubscription({{ $subscription->id }})" 
                                wire:confirm="Aboneliği iptal etmek istediğinize emin misiniz?" 
                                class="action-btn btn-danger">
                          İptal Et
                        </button>
                      @else
                        <button type="button" class="action-btn btn-disabled" disabled>İptal Edildi</button>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" style="text-align: center; padding: 36px;">
                    Filtre kriterlerine uygun abonelik bulunamadı.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div style="margin-top: 10px;">
          {{ $subscriptions->links() }}
        </div>
      </main>
    </div>
  </div>
</div>