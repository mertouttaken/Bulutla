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

  .filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
  }

  .search-box {
    position: relative;
    min-width: 280px;
  }

  .search-input {
    width: 100%;
    background: #111422;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    padding: 10px 14px 10px 36px;
    font-size: 0.88rem;
    color: #fff;
    outline: none;
  }

  .search-input:focus {
    border-color: #6366f1;
  }

  .search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.85rem;
    color: #64748b;
  }

  .filter-group {
    display: flex;
    gap: 10px;
  }

  .filter-select {
    background: #111422;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.85rem;
    color: #cbd5e1;
    outline: none;
    cursor: pointer;
  }

  .panel-card {
    background: #111422;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
  }

  .admin-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.88rem;
    text-align: left;
  }

  .admin-table th {
    padding: 14px 20px;
    background: #151928;
    color: #64748b;
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
  }

  .admin-table td {
    padding: 18px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    color: #cbd5e1;
    vertical-align: middle;
  }

  .admin-table tr:last-child td {
    border-bottom: none;
  }

  .user-cell {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  .user-cell strong {
    color: #fff;
    font-size: 0.9rem;
  }

  .user-cell span {
    color: #64748b;
    font-size: 0.78rem;
  }

  .badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .badge-active {
    background: rgba(34, 197, 94, 0.12);
    color: #4ade80;
  }

  .badge-cancelled {
    background: rgba(239, 68, 68, 0.12);
    color: #f87171;
  }

  .badge-plan {
    background: rgba(168, 85, 247, 0.15);
    color: #d8b4fe;
    border: 1px solid rgba(168, 85, 247, 0.25);
  }

  .table-actions {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .table-actions form {
    margin: 0;
  }

  .action-btn.btn-disabled {
    opacity: 0.45;
    cursor: not-allowed;
    border-color: rgba(255, 255, 255, 0.05);
  }

  .action-btn {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #94a3b8;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 0.78rem;
    cursor: pointer;
    transition: all 0.2s;
  }

  .action-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
  }

  .action-btn.cancel:hover {
    background: rgba(239, 68, 68, 0.15);
    border-color: rgba(239, 68, 68, 0.3);
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
      <div class="filter-bar">
        <div class="search-box">
          <span class="search-icon">🔍</span>
          <input type="text" class="search-input" placeholder="Kullanıcı veya e-posta ara...">
        </div>
        <div class="filter-group">
          <select class="filter-select">
            <option value="">Tüm Planlar</option>
            <option value="free">Free</option>
            <option value="pro">Pro</option>
            <option value="enterprise">Enterprise</option>
          </select>
          <select class="filter-select">
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
            @foreach($subscriptions as $subscription)
              @if($subscription->plan->price > 0)
                <tr>
                  <td>
                    <div class="user-cell">
                      <strong>{{ $subscription->user->name ?? 'Bilinmiyor' }}</strong>
                      <span>{{ $subscription->user->email ?? 'Bilinmiyor' }}</span>
                    </div>
                  </td>
                  @php
                    $plan = $subscription->plan;
                    $class = 'badge badge-' . ($subscription->status === 'active' ? 'active' : 'cancelled');
                  @endphp
                  <td><span class="badge badge-plan">{{ $plan?->name }}</span></td>
                  <td><span class="{{ $class }}">● {{ $subscription->status === 'active' ? 'Aktif' : 'İptal Edilmiş' }}</span></td>
                  <td>{{ $plan?->price }} ₺ / ay</td>
                  <td>{{ $subscription->ends_at ?? 'Bilinmiyor' }}</td>
                  <td>
                    <div class="table-actions">
                      <a href="{{ route('admin.subscriptions.show', $subscription->id) }}" class="action-btn">Detay</a>

                      @if($subscription->status === 'active')
                        <form action="{{ route('admin.subscriptions.cancel', $subscription->id) }}" method="POST" onsubmit="return confirm('Aboneliği iptal etmek istediğinize emin misiniz?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="action-btn btn-danger">İptal Et</button>
                        </form>
                      @else
                        <button type="button" class="action-btn btn-disabled" disabled>İptal Edildi</button>
                      @endif
                    </div>
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
@endsection