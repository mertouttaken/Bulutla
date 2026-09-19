@extends('layouts.app')

@section('title', 'Kullanıcı Düzenle - ' . $user->name)

@section('content')
<style>
  .admin-edit-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 36px 24px;
    color: #e2e8f0;
    font-family: inherit;
    display: flex;
    flex-direction: column;
    gap: 28px;
  }

  .admin-edit-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    padding-bottom: 24px;
  }

  .header-left {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .back-btn {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9d9bb8;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .back-btn:hover {
    color: #ffffff;
    border-color: rgba(139, 30, 196, 0.45);
    background: #17182e;
  }

  .header-info h1 {
    font-size: 1.6rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 4px 0;
    letter-spacing: -0.02em;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .user-role-badge {
    background: rgba(139, 30, 196, 0.18);
    border: 1px solid rgba(192, 132, 252, 0.3);
    color: #d8b4fe;
    font-size: 0.72rem;
    padding: 3px 9px;
    border-radius: 20px;
    font-weight: 600;
  }

  .header-info p {
    margin: 0;
    font-size: 0.88rem;
    color: #9d9bb8;
  }

  .edit-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
  }

  @media (max-width: 900px) {
    .edit-grid {
      grid-template-columns: 1fr;
    }
  }

  .panel-box {
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 18px;
    padding: 28px;
    display: flex;
    flex-direction: column;
    gap: 22px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
  }

  .panel-box::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(139, 30, 196, 0.35), transparent);
  }

  .panel-title {
    font-size: 1.05rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .form-row {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .form-row label {
    font-size: 0.82rem;
    color: #cbd5e1;
    font-weight: 500;
    display: flex;
    justify-content: space-between;
  }

  .form-row label span {
    color: #64748b;
    font-size: 0.75rem;
  }

  .form-input {
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    padding: 11px 14px;
    color: #ffffff;
    font-size: 0.88rem;
    outline: none;
    transition: all 0.2s ease;
  }

  .form-input:focus {
    border-color: #c084fc;
    box-shadow: 0 0 0 3px rgba(139, 30, 196, 0.15);
  }

  .form-select {
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    padding: 11px 14px;
    color: #ffffff;
    font-size: 0.88rem;
    outline: none;
    cursor: pointer;
  }

  .form-select:focus {
    border-color: #c084fc;
  }

  /* Neon Mor Toggle Switch */
  .toggle-container {
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 12px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }

  .toggle-text {
    display: flex;
    flex-direction: column;
    gap: 3px;
  }

  .toggle-title {
    font-size: 0.88rem;
    font-weight: 600;
    color: #ffffff;
  }

  .toggle-subtitle {
    font-size: 0.76rem;
    color: #9d9bb8;
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
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #272844;
    transition: 0.25s ease;
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
    background-color: #9d9bb8;
    transition: 0.25s ease;
    border-radius: 50%;
  }

  .switch input:checked + .slider {
    background: linear-gradient(135deg, #5f1587, #8b1ec4);
    border-color: rgba(192, 132, 252, 0.5);
    box-shadow: 0 0 12px rgba(139, 30, 196, 0.4);
  }

  .switch input:checked + .slider:before {
    transform: translateX(22px);
    background-color: #ffffff;
  }

  .btn-cta-primary {
    background: linear-gradient(135deg, #5f1587, #8b1ec4);
    border: none;
    color: #ffffff;
    padding: 11px 22px;
    border-radius: 12px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 18px rgba(95, 21, 135, 0.35);
    transition: transform 0.15s ease, opacity 0.15s ease;
  }

  .btn-cta-primary:hover {
    opacity: 0.92;
    transform: translateY(-1px);
  }

  .btn-cta-secondary {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
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
    background: rgba(95, 21, 135, 0.12);
    border-color: rgba(139, 30, 196, 0.35);
    color: #ffffff;
  }

  .summary-item {
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
  }

  .summary-label {
    color: #9d9bb8;
  }

  .summary-val {
    color: #ffffff;
    font-weight: 600;
  }
</style>

<div class="admin-edit-container">

  @if(session('success'))
    <div style="background: rgba(139, 30, 196, 0.15); border: 1px solid rgba(192, 132, 252, 0.35); color: #d8b4fe; padding: 14px 20px; border-radius: 12px; font-size: 0.88rem;">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); color: #fca5a5; padding: 14px 20px; border-radius: 12px; font-size: 0.88rem;">
      {{ $errors->first() }}
    </div>
  @endif

  <div class="admin-edit-header">
    <div class="header-left">
      <a href="{{ route('admin.users.index') }}" class="back-btn" title="Kullanıcılara Dön">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </a>
      <div class="header-info">
        <h1>
          {{ $user->name }}
          <span class="user-role-badge">ID: #{{ $user->id }}</span>
          @if($user->is_admin)
            <span class="user-role-badge" style="border-color: rgba(74, 222, 128, 0.3); color: #4ade80; background: rgba(74, 222, 128, 0.15);">Admin</span>
          @endif
        </h1>
        <p>Kullanıcı bilgilerini, yetkisini ve abonelik paketini güncelle.</p>
      </div>
    </div>
  </div>

  <div class="edit-grid">
    
    <div class="panel-box">
      <h3 class="panel-title">Hesap Detayları</h3>

      <form action="{{ route('admin.users.update', $user->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 18px; margin: 0;">
        @csrf
        @method('PUT')

        <div class="form-row">
          <label for="userName">Kullanıcı Adı</label>
          <input type="text" name="name" id="userName" value="{{ old('name', $user->name) }}" required class="form-input">
        </div>

        <div class="form-row">
          <label for="userEmail">E-Posta Adresi</label>
          <input type="email" name="email" id="userEmail" value="{{ old('email', $user->email) }}" required class="form-input">
        </div>

        <div class="form-row">
          <label for="userPassword">
            Yeni Şifre
            <span>(Değiştirmek istemiyorsanız boş bırakın)</span>
          </label>
          <input type="password" name="password" id="userPassword" placeholder="••••••••" class="form-input">
        </div>

        <div class="toggle-container">
          <div class="toggle-text">
            <span class="toggle-title">Yönetici Yetkisi (Admin)</span>
            <span class="toggle-subtitle">Bu kullanıcı admin paneline ve yönetim araçlarına tam erişebilir.</span>
          </div>

          <input type="hidden" name="is_admin" value="0">
          <label class="switch">
            <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
            <span class="slider"></span>
          </label>
        </div>

        <div class="form-row">
          <label for="userPlan">Tanımlı Plan</label>
          <select name="plan_id" id="userPlan" class="form-select">
            @foreach($plans ?? [] as $plan)
              <option value="{{ $plan->id }}" {{ $user->subscription?->plan_id == $plan->id ? 'selected' : '' }}>
                {{ $plan->name }} ({{ $plan->price }} ₺)
              </option>
            @endforeach
          </select>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
          <a href="{{ route('admin.users.index') }}" class="btn-cta-secondary">Vazgeç</a>
          <button type="submit" class="btn-cta-primary">Değişiklikleri Kaydet</button>
        </div>
      </form>
    </div>

    <div style="display: flex; flex-direction: column; gap: 20px;">
      
      <div class="panel-box">
        <h3 class="panel-title">Kaynak İstatistikleri</h3>

        <div style="display: flex; flex-direction: column; gap: 10px;">
          <div class="summary-item">
            <span class="summary-label">Aktif Projeler</span>
            <span class="summary-val">{{ $user->projects()->count() }} Adet</span>
          </div>

          <div class="summary-item">
            <span class="summary-label">Yüklü Dosyalar</span>
            <span class="summary-val">{{ $user->files()->count() }} Adet</span>
          </div>

          <div class="summary-item">
            <span class="summary-label">Depolama Alanı</span>
            <span class="summary-val" style="color: #c084fc;">
              {{ number_format($user->totalStorageBytes() / 1048576, 2) }} MB
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

      <div class="panel-box" style="border-color: rgba(239, 68, 68, 0.25);">
        <h3 class="panel-title" style="color: #f87171;">Tehlikeli Alan</h3>
        <p style="font-size: 0.8rem; color: #9d9bb8; margin: 0;">
          Bu kullanıcının hesabını ve bağlı tüm projelerini/dosyalarını kalıcı olarak silebilirsiniz.
        </p>

        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bu kullanıcıyı ve tüm verilerini kalıcı olarak silmek istediğinize emin misiniz?');" style="margin: 0;">
          @csrf
          @method('DELETE')
          <button type="submit" style="width: 100%; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); color: #ef4444; padding: 10px; border-radius: 10px; font-weight: 600; cursor: pointer;">
            Kullanıcıyı Sil
          </button>
        </form>
      </div>

    </div>

  </div>

</div>
@endsection