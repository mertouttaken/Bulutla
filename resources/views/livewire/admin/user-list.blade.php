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
          <li><a href="{{ route('admin.subscriptions.index') }}"><i>03</i> Abonelikler</a></li>
          <li><a href="{{ route('admin.users.index') }}" class="active"><i>04</i> Kullanıcılar</a></li>
        </ul>
      </nav>
    </aside>

    <div class="admin-main">
      <header class="admin-topbar">
        <div class="topbar-title">
        <p class="desk-kicker">YÖNETİM</p>
        <h1 class="motion-title">Kullanıcı Yönetimi</h1>
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
                   placeholder="İsim veya e-posta ara...">
          </div>

          <div class="filter-group">
            <select wire:model.live="roleFilter" class="filter-select">
              <option value="">Rol: Tümü</option>
              <option value="admin">Yönetici</option>
              <option value="user">Standart Kullanıcı</option>
            </select>

            <select wire:model.live="planFilter" class="filter-select">
              <option value="">Plan: Tümü</option>
              @foreach($plans as $plan)
                <option value="{{ $plan->slug }}">{{ $plan->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="panel-card">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Kullanıcı</th>
                <th>Yetki</th>
                <th>Aktif Plan</th>
                <th>Depolama Kullanımı</th>
                <th>Proje Kullanımı</th>
                <th>Kayıt Tarihi</th>
                <th>İşlemler</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
                @php
                  $rawLimit = (string) ($user->plan?->storageLimit() ?? $user->plan?->storage_limit ?? '0');
                  preg_match('/([\d.]+)\s*([a-zA-Z]*)/', $rawLimit, $matches);
                  $limitVal = isset($matches[1]) ? (float) $matches[1] : 0;
                  $limitUnit = isset($matches[2]) ? strtoupper(trim($matches[2])) : 'MB';
                  $limit = ($limitUnit === 'GB') ? ($limitVal * 1024) : $limitVal;
                  $used = method_exists($user, 'storageUsedValue') ? (float) $user->storageUsedValue() : 0;
                  $storagePercentage = $limit > 0 ? min(round(($used / $limit) * 100), 100) : 0;

                  $projLimit = (int) ($user->plan?->project_limit ?? 0);
                  $projUsed = method_exists($user, 'projectUsedValue') ? (int) $user->projectUsedValue() : $user->projects()->count();
                  $projectPercentage = $projLimit > 0 ? min(round(($projUsed / $projLimit) * 100), 100) : 0;
                @endphp
                <tr>
                  <td>
                    <div class="user-cell">
                      <strong>{{ $user->name }}</strong>
                      <span>{{ $user->email }}</span>
                    </div>
                  </td>
                  <td>
                    <span class="badge badge-{{ $user->is_admin ? 'admin' : 'user' }}">
                      {{ $user->is_admin ? 'Yönetici' : 'Kullanıcı' }}
                    </span>
                  </td>
                  <td>{{ $user->plan?->name ?? 'Free' }}</td>
                  <td>
                    <div class="storage-progress">
                      <div class="progress-track">
                        <div class="progress-fill" style="width: {{ $storagePercentage }}%;"></div>
                      </div>
                      <span class="storage-text">
                        {{ method_exists($user, 'storageUsedFormatted') ? $user->storageUsedFormatted() : $used . ' MB' }} / {{ $user->plan?->storage_limit ?? '100 MB' }}
                      </span>
                    </div>
                  </td>
                  <td>
                    <div class="storage-progress">
                      <div class="progress-track">
                        <div class="progress-fill" style="width: {{ $projectPercentage }}%;"></div>
                      </div>
                      <span class="storage-text">
                        {{ $projUsed }} / {{ $projLimit <= 0 ? 'Sınırsız' : $projLimit }}
                      </span>
                    </div>
                  </td>
                  <td>{{ $user->created_at?->translatedFormat('d M Y') }}</td>
                  <td>
                    <div class="table-actions">
                      <a href="{{ route('admin.users.edit', $user) }}" class="action-btn">Düzenle</a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" style="text-align: center; padding: 36px;">
                    Filtre kriterlerine uygun kullanıcı bulunamadı.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div style="margin-top: 10px;">
          {{ $users->links() }}
        </div>
      </main>
    </div>
  </div>
</div>