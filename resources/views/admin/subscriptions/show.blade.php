@extends('layouts.app')

@section('content')
<style>
  .admin-layout {
    display: grid;
    grid-template-columns: 260px 1fr;
    min-height: calc(100vh - 70px);
    background: #0b0d14;
    color: #e2e8f0;
    font-family: inherit;
  }

  .admin-sidebar {
    background: #111420;
    border-right: 1px solid rgba(255, 255, 255, 0.06);
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
    color: #8f9bba;
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

  .admin-main {
    display: flex;
    flex-direction: column;
  }

  .admin-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 36px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
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
    border: 1px solid rgba(255, 255, 255, 0.06);
    font-size: 0.85rem;
    color: #cbd5e1;
  }

  .admin-content {
    padding: 36px;
    display: flex;
    flex-direction: column;
    gap: 28px;
  }

  .content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .btn-back {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
  }

  .btn-back:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
  }

  .detail-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 28px;
  }

  .detail-card {
    background: #111422;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    padding: 26px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    gap: 22px;
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
  }

  .card-header h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
  }

  .badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .badge-active {
    background: rgba(34, 197, 94, 0.15);
    color: #4ade80;
    border: 1px solid rgba(34, 197, 94, 0.25);
  }

  .badge-cancelled {
    background: rgba(239, 68, 68, 0.15);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.25);
  }

  .info-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
  }

  .info-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .info-item span.label {
    font-size: 0.78rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.04em;
  }

  .info-item span.val {
    font-size: 0.95rem;
    color: #fff;
    font-weight: 500;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 16px;
  }

  .form-group label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #8f9bba;
  }

  .form-control {
    background: #171b2e;
    border: 1px solid rgba(255, 255, 255, 0.09);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.9rem;
    color: #fff;
    outline: none;
    transition: border-color 0.2s;
  }

  .form-control:focus {
    border-color: #6366f1;
  }

  .btn-submit {
    background: linear-gradient(135deg, #5f1587, #7f12bc);
    border: none;
    color: #fff;
    padding: 11px 18px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.88rem;
    cursor: pointer;
    width: 100%;
    transition: opacity 0.2s;
  }

  .btn-submit:hover {
    opacity: 0.9;
  }

  .btn-danger-outline {
    background: transparent;
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #f87171;
    padding: 11px 18px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.88rem;
    cursor: pointer;
    width: 100%;
    transition: all 0.2s;
  }

  .btn-danger-outline:hover {
    background: rgba(239, 68, 68, 0.15);
    color: #fca5a5;
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
        <li><a href="{{ route('admin.plans.index') }}">📦 Planlar</a></li>
        <li><a href="{{ route('admin.subscriptions.index') }}" class="active">💳 Abonelikler</a></li>
        <li><a href="{{ route('admin.users.index') }}">👥 Kullanıcılar</a></li>
      </ul>
    </nav>
  </aside>

  <div class="admin-main">
    <header class="admin-topbar">
      <div class="topbar-title">
        <h1>Abonelik Yönetimi</h1>
      </div>
      <div class="topbar-user">
        <span>👤 {{ Auth::user()->name ?? 'Yönetici' }}</span>
      </div>
    </header>

    <main class="admin-content">
      <div class="content-header">
        <a href="{{ route('admin.subscriptions.index') }}" class="btn-back">← Abonelik Listesine Dön</a>
        @php
          $subscriptionStatusClass = $subscription->status === 'active' ? 'badge-active' : 'badge-cancelled';
          $subscriptionStatusName = $subscription->status === 'active' ? 'Aktif' : 'İptal Edilmiş';
        @endphp
        <span class="badge {{ $subscriptionStatusClass }}">
          ● {{ $subscriptionStatusName }}
        </span>
      </div>

      <div class="detail-grid">
        <div class="detail-card">
          <div class="card-header">
            <h3>Abonelik & Kullanıcı Bilgileri</h3>
            <span style="color: #6366f1; font-size: 0.85rem; font-weight: 600;">#SUB-{{ $subscription->id }}</span>
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
              <span class="val">{{ $subscription->plan->price ?? 0 }} ₺ / ay</span>
            </div>

            <div class="info-item">
              <span class="label">Başlangıç Tarihi</span>
              <span class="val">{{ $subscription->created_at?->format('d.m.Y H:i') ?? '-' }}</span>
            </div>

            <div class="info-item">
              <span class="label">Bitiş / Yenilenme Tarihi</span>
              <span class="val">{{ $subscription->ends_at ? \Carbon\Carbon::parse($subscription->ends_at)->format('d.m.Y') : 'Süresiz / Otomatik' }}</span>
            </div>
          </div>
        </div>

        <div class="detail-card">
          <div class="card-header">
            <h3>İşlemler</h3>
          </div>

          <form action="{{ route('admin.subscriptions.update', $subscription->id) }}" method="POST">
            @csrf

            <div class="form-group">
              <label>Plan Değiştir</label>
              <select name="plan_id" class="form-control">
                @foreach($plans as $plan)
                  <option value="{{ $plan->id }}" {{ $subscription->plan_id == $plan->id ? 'selected' : '' }}>
                    {{ $plan->name }} ({{ $plan->price }} ₺)
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Durum Güncelle</label>
              <select name="status" class="form-control">
                <option value="active" {{ $subscription->status === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="cancelled" {{ $subscription->status === 'cancelled' ? 'selected' : '' }}>İptal Edilmiş</option>
              </select>
            </div>

            <div class="form-group">
              <label>Bitiş Tarihi</label>
              <input type="date" name="ends_at" class="form-control" value="{{ $subscription->ends_at ? \Carbon\Carbon::parse($subscription->ends_at)->format('Y-m-d') : '' }}">
            </div>

            <button type="submit" class="btn-submit">Değişiklikleri Kaydet</button>
          </form>

          <form action="{{ route('admin.subscriptions.cancel', $subscription->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-danger-outline">Aboneliği Sonlandır</button>
          </form>
        </div>
      </div>
    </main>
  </div>
</div>
@endsection