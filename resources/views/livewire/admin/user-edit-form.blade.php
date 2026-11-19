<div class="admin-edit-container">

  @if(session('success'))
    <div class="alert-box alert-success">
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div class="alert-box alert-danger">
      <span>{{ session('error') }}</span>
    </div>
  @endif

  <div class="admin-edit-header">
    <div class="header-left">
      <a href="{{ route('admin.users.index') }}" class="back-btn" title="Kullanıcılara Dön">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </a>
      <div class="header-info">
        <p class="desk-kicker">YÖNETİM / KULLANICI</p>
        <h1>
          {{ $user->name }}
          <span class="user-role-badge">ID: #{{ $user->id }}</span>
          @if($user->is_admin)
            <span class="user-role-badge badge-admin">Admin</span>
          @endif
        </h1>
        <p>Kullanıcı bilgilerini, yönetici yetkisini ve abonelik paketini güncelle.</p>
      </div>
    </div>
  </div>

  <div class="edit-grid">
    <!-- Sol Panel: Düzenleme Formu -->
    <div class="panel-box">
      <h3 class="panel-title">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--neon-purple);">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Hesap Detayları
      </h3>

      <form wire:submit="updateUser" style="display: flex; flex-direction: column; gap: 20px; margin: 0;">
        <div class="form-row">
          <label for="userName">Kullanıcı Adı</label>
          <input type="text" id="userName" wire:model="name" class="form-input">
          @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
          <label for="userEmail">E-Posta Adresi</label>
          <input type="email" id="userEmail" wire:model="email" class="form-input">
          @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
          <label for="userPassword">
            Yeni Şifre
            <span>(Değiştirmek istemiyorsanız boş bırakın)</span>
          </label>
          <input type="password" id="userPassword" wire:model="password" placeholder="••••••••" class="form-input">
          @error('password') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="toggle-container">
          <div class="toggle-text">
            <span class="toggle-title">Yönetici Yetkisi (Admin)</span>
            <span class="toggle-subtitle">Bu kullanıcı admin paneline ve yönetim paneli fonksiyonlarına tam erişebilir.</span>
          </div>

          <label class="switch">
            <input type="checkbox" wire:model="is_admin">
            <span class="slider"></span>
          </label>
        </div>

        <div class="form-row">
          <label for="userPlan">Tanımlı Abonelik Planı</label>
          <select id="userPlan" wire:model="plan_id" class="form-select">
            <option value="">Plan Yok</option>
            @foreach($plans as $plan)
              <option value="{{ $plan->id }}">
                {{ $plan->name }} ({{ number_format($plan->price, 2) }} ₺)
              </option>
            @endforeach
          </select>
          @error('plan_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
          <a href="{{ route('admin.users.index') }}" class="btn-cta-secondary">Vazgeç</a>
          <button type="submit" class="btn-cta-primary" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="updateUser">Değişiklikleri Kaydet</span>
            <span wire:loading wire:target="updateUser">Kaydediliyor...</span>
          </button>
        </div>
      </form>
    </div>

    <!-- Sağ Panel: İstatistikler ve Tehlikeli Alan -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
      <div class="panel-box">
        <h3 class="panel-title">
          <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--neon-purple);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
          </svg>
          Kaynak İstatistikleri
        </h3>

        <div style="display: flex; flex-direction: column; gap: 12px;">
          <div class="summary-item">
            <span class="summary-label">Aktif Projeler</span>
            <span class="summary-val">{{ $user->projects->count() }} Adet</span>
          </div>

          <div class="summary-item">
            <span class="summary-label">Yüklü Dosyalar</span>
            <span class="summary-val">{{ $user->files->count() }} Adet</span>
          </div>

          <div class="summary-item">
            <span class="summary-label">Depolama Alanı</span>
            <span class="summary-val" style="color: var(--neon-purple);">
              {{ method_exists($user, 'totalStorageBytes') ? number_format($user->totalStorageBytes() / 1048576, 2) : '0' }} MB
            </span>
          </div>

          <div class="summary-item">
            <span class="summary-label">Abonelik Durumu</span>
            <span class="summary-val" data-state="{{ $user->subscription?->status === 'active' ? 'ok' : 'off' }}">
              {{ strtoupper($user->subscription?->status === 'active' ? 'Aktif' : 'Pasif') }}
            </span>
          </div>
        </div>
      </div>

      <div class="panel-box panel-danger">
        <h3 class="panel-title">
          <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
          </svg>
          Tehlikeli Alan
        </h3>
        <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0; line-height: 1.5;">
          Bu kullanıcının hesabını ve bağlı tüm projelerini/dosyalarını kalıcı olarak silebilirsiniz. Bu işlem geri alınamaz.
        </p>

        <button type="button" 
                wire:click="deleteUser" 
                wire:confirm="Bu kullanıcıyı ve tüm verilerini kalıcı olarak silmek istediğinize emin misiniz?" 
                class="btn-danger-action">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
          </svg>
          Kullanıcıyı Tamamen Sil
        </button>
      </div>
    </div>
  </div>
</div>