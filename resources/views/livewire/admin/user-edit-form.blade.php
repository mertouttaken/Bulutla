<div class="admin-edit-container">
  <style>
    :root {
      --bg-surface: #0e0f1d;
      --bg-card: rgba(17, 18, 34, 0.85);
      --bg-card-hover: rgba(23, 24, 46, 0.95);
      --border-subtle: rgba(255, 255, 255, 0.08);
      --border-accent: rgba(192, 132, 252, 0.35);
      --neon-purple: #c084fc;
      --neon-purple-glow: rgba(192, 132, 252, 0.25);
      --text-primary: #f8fafc;
      --text-muted: #94a3b8;
    }

    .admin-edit-container {
      max-width: 1140px;
      margin: 0 auto;
      padding: 40px 24px 80px 24px;
      color: #e2e8f0;
      font-family: inherit;
      display: flex;
      flex-direction: column;
      gap: 32px;
    }

    .alert-box {
      padding: 14px 20px;
      border-radius: 14px;
      font-size: 0.88rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      backdrop-filter: blur(8px);
    }

    .alert-success {
      background: linear-gradient(90deg, rgba(95, 21, 135, 0.3), rgba(17, 18, 34, 0.8));
      border: 1px solid var(--border-accent);
      color: #f3e8ff;
      box-shadow: 0 4px 20px rgba(95, 21, 135, 0.2);
    }

    .alert-danger {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.35);
      color: #fca5a5;
    }

    .admin-edit-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
      border-bottom: 1px solid var(--border-subtle);
      padding-bottom: 24px;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .back-btn {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background: var(--bg-card);
      border: 1px solid var(--border-subtle);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-muted);
      text-decoration: none;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .back-btn:hover {
      color: #ffffff;
      border-color: var(--border-accent);
      background: #17182e;
      transform: translateX(-2px);
      box-shadow: 0 0 16px var(--neon-purple-glow);
    }

    .header-info h1 {
      font-size: 1.7rem;
      font-weight: 800;
      color: var(--text-primary);
      margin: 0 0 6px 0;
      letter-spacing: -0.02em;
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .user-role-badge {
      background: rgba(139, 30, 196, 0.18);
      border: 1px solid rgba(192, 132, 252, 0.3);
      color: #d8b4fe;
      font-size: 0.72rem;
      padding: 3px 10px;
      border-radius: 20px;
      font-weight: 600;
      letter-spacing: 0.02em;
    }

    .badge-admin {
      border-color: rgba(74, 222, 128, 0.35);
      color: #4ade80;
      background: rgba(74, 222, 128, 0.12);
      box-shadow: 0 0 10px rgba(74, 222, 128, 0.15);
    }

    .header-info p {
      margin: 0;
      font-size: 0.9rem;
      color: var(--text-muted);
    }

    .edit-grid {
      display: grid;
      grid-template-columns: 1.8fr 1.2fr;
      gap: 28px;
      align-items: start;
    }

    @media (max-width: 960px) {
      .edit-grid {
        grid-template-columns: 1fr;
      }
    }

    .panel-box {
      background: var(--bg-card);
      backdrop-filter: blur(16px);
      border: 1px solid var(--border-subtle);
      border-radius: 22px;
      padding: 28px;
      display: flex;
      flex-direction: column;
      gap: 22px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      position: relative;
      overflow: hidden;
    }

    .panel-box::before {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 22px;
      padding: 1px;
      background: linear-gradient(135deg, rgba(192, 132, 252, 0.4), transparent 60%);
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      pointer-events: none;
    }

    .panel-title {
      font-size: 1.12rem;
      font-weight: 700;
      color: var(--text-primary);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
      letter-spacing: -0.01em;
    }

    .form-row {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .form-row label {
      font-size: 0.82rem;
      color: #cbd5e1;
      font-weight: 600;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .form-row label span {
      color: #64748b;
      font-size: 0.75rem;
      font-weight: 400;
    }

    .form-input, .form-select {
      background: rgba(14, 15, 29, 0.85);
      border: 1px solid var(--border-subtle);
      border-radius: 12px;
      padding: 12px 16px;
      color: #ffffff;
      font-size: 0.88rem;
      outline: none;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      box-sizing: border-box;
      width: 100%;
    }

    .form-input:focus, .form-select:focus {
      border-color: var(--neon-purple);
      box-shadow: 0 0 0 3px var(--neon-purple-glow);
      background: #15162b;
    }

    .form-select {
      cursor: pointer;
    }

    .toggle-container {
      background: rgba(14, 15, 29, 0.7);
      border: 1px solid var(--border-subtle);
      border-radius: 14px;
      padding: 16px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      transition: border-color 0.2s ease;
    }

    .toggle-container:hover {
      border-color: rgba(192, 132, 252, 0.25);
    }

    .toggle-text {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .toggle-title {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--text-primary);
    }

    .toggle-subtitle {
      font-size: 0.78rem;
      color: var(--text-muted);
      line-height: 1.4;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 28px;
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
      border: 1px solid rgba(255, 255, 255, 0.12);
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 20px;
      width: 20px;
      left: 3px;
      bottom: 3px;
      background-color: #94a3b8;
      transition: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      border-radius: 50%;
    }

    .switch input:checked + .slider {
      background: linear-gradient(135deg, #7e22ce, #a855f7);
      border-color: rgba(192, 132, 252, 0.6);
      box-shadow: 0 0 16px rgba(168, 85, 247, 0.45);
    }

    .switch input:checked + .slider:before {
      transform: translateX(22px);
      background-color: #ffffff;
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
      display: inline-flex;
      align-items: center;
      justify-content: center;
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
      padding: 11px 20px;
      border-radius: 12px;
      font-size: 0.88rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s;
    }

    .btn-cta-secondary:hover {
      background: rgba(168, 85, 247, 0.12);
      border-color: var(--border-accent);
      color: #ffffff;
    }

    .summary-item {
      background: rgba(14, 15, 29, 0.6);
      border: 1px solid var(--border-subtle);
      border-radius: 14px;
      padding: 14px 18px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.88rem;
    }

    .summary-label {
      color: var(--text-muted);
      font-weight: 500;
    }

    .summary-val {
      color: #ffffff;
      font-weight: 600;
    }

    .panel-danger {
      border-color: rgba(239, 68, 68, 0.3);
      background: linear-gradient(180deg, rgba(239, 68, 68, 0.03) 0%, rgba(17, 18, 34, 0.85) 100%);
    }

    .panel-danger::before {
      background: linear-gradient(135deg, rgba(239, 68, 68, 0.4), transparent 60%);
    }

    .btn-danger-action {
      width: 100%;
      background: rgba(239, 68, 68, 0.12);
      border: 1px solid rgba(239, 68, 68, 0.35);
      color: #f87171;
      padding: 12px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 0.88rem;
      cursor: pointer;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-danger-action:hover {
      background: #ef4444;
      color: #ffffff;
      border-color: #ef4444;
      box-shadow: 0 4px 20px rgba(239, 68, 68, 0.35);
      transform: translateY(-1px);
    }
  </style>

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
          @error('name') <span style="color: #f87171; font-size: 0.78rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
          <label for="userEmail">E-Posta Adresi</label>
          <input type="email" id="userEmail" wire:model="email" class="form-input">
          @error('email') <span style="color: #f87171; font-size: 0.78rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
          <label for="userPassword">
            Yeni Şifre
            <span>(Değiştirmek istemiyorsanız boş bırakın)</span>
          </label>
          <input type="password" id="userPassword" wire:model="password" placeholder="••••••••" class="form-input">
          @error('password') <span style="color: #f87171; font-size: 0.78rem;">{{ $message }}</span> @enderror
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
          @error('plan_id') <span style="color: #f87171; font-size: 0.78rem;">{{ $message }}</span> @enderror
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
            <span class="summary-val" style="color: {{ $user->subscription?->status === 'active' ? '#4ade80' : '#f87171' }};">
              {{ strtoupper($user->subscription?->status === 'active' ? 'Aktif' : 'Pasif') }}
            </span>
          </div>
        </div>
      </div>

      <div class="panel-box panel-danger">
        <h3 class="panel-title" style="color: #f87171;">
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