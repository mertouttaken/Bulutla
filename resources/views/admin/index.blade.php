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
    gap: 32px;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 20px;
  }

  .stat-card {
    background: linear-gradient(180deg, #151928 0%, #111422 100%);
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    padding: 22px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
    transition: transform 0.2s ease, border-color 0.2s ease;
  }

  .stat-card:hover {
    transform: translateY(-2px);
    border-color: rgba(99, 102, 241, 0.3);
  }

  .stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .stat-title {
    font-size: 0.85rem;
    color: #8f9bba;
    font-weight: 500;
  }

  .stat-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.04);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #a5b4fc;
  }

  .stat-value {
    font-size: 1.75rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
  }

  .stat-footer {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .stat-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 6px;
  }

  .stat-badge.positive {
    background: rgba(34, 197, 94, 0.12);
    color: #4ade80;
  }

  .stat-badge.neutral {
    background: rgba(148, 163, 184, 0.12);
    color: #94a3b8;
  }

  .stat-badge.highlight {
    background: rgba(139, 92, 246, 0.15);
    color: #c084fc;
  }

  .stat-subtext {
    font-size: 0.78rem;
    color: #64748b;
  }

  .panel-card {
    background: #111422;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
  }

  .panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .panel-header h3 {
    font-size: 1.05rem;
    font-weight: 600;
    margin: 0;
    color: #fff;
  }

  .admin-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    text-align: left;
  }

  .admin-table th {
    padding: 12px 16px;
    color: #64748b;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
  }

  .admin-table td {
    padding: 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    color: #cbd5e1;
  }

  .admin-table tr:last-child td {
    border-bottom: none;
  }

  .user-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .badge-active {
    background: rgba(34, 197, 94, 0.15);
    color: #4ade80;
  }

  .badge-plan {
    background: rgba(99, 102, 241, 0.15);
    color: #a5b4fc;
    border: 1px solid rgba(99, 102, 241, 0.2);
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
        <li><a href="#" class="active">📊 Genel Bakış</a></li>
        <li><a href="{{ route('admin.plans.index') }}">📦 Planlar</a></li>
        <li><a href="{{ route('admin.subscriptions.index') }}">💳 Abonelikler</a></li>
        <li><a href="{{ route('admin.users.index') }}">👥 Kullanıcılar</a></li>
      </ul>
    </nav>
  </aside>

  <div class="admin-main">
    <header class="admin-topbar">
      <div class="topbar-title">
        <h1>Genel Bakış</h1>
      </div>
      <div class="topbar-user">
        <span>👤 {{ Auth::user()->name ?? 'Yönetici' }}</span>
      </div>
    </header>

    <main class="admin-content">
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-header">
            <span class="stat-title">Aktif Abone</span>
            <div class="stat-icon">👥</div>
          </div>
          <div class="stat-value">{{$totalSubscription}}</div>
          <div class="stat-footer">
            <span class="stat-badge positive">+%8</span>
            <span class="stat-subtext">geçen aya göre</span>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <span class="stat-title">Aylık Tahmini Gelir</span>
            <div class="stat-icon">💳</div>
          </div>
          <div class="stat-value">{{ $totalValue }} ₺</div>
          <div class="stat-footer">
            <span class="stat-badge positive">+%12</span>
            <span class="stat-subtext">geçen aya göre</span>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <span class="stat-title">Depolama Doluluğu</span>
            <div class="stat-icon">💾</div>
          </div>
            @php
                $storagePercentage = ($usedStorage / $maxStorageLimit) * 100;
                $maxStorageLimitFixed = $maxStorageLimit >= 1000 ? number_format($maxStorageLimit / 1000, 2) . ' TB' : $maxStorageLimit . ' GB';
                $usedStorageFixed = $usedStorage >= 1000 ? number_format($usedStorage / 1000, 2) . ' TB' : $usedStorage . ' GB';
            @endphp

          <div class="stat-value">
            {{ $maxStorageLimitFixed }}
            <span style="font-style: italic; font-size: 0.5em; color: #9d9b9b; font-weight: 400;"> / {{ $usedStorageFixed }}</span>
          </div>
          <div class="stat-footer">
            <span class="stat-badge neutral">% {{ number_format($storagePercentage, 2) }}</span>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <span class="stat-title">En Popüler Paket</span>
            <div class="stat-icon">⚡</div>
          </div>
          <div class="stat-value">{{ $getMostPopularPlan->name }}</div>
          <div class="stat-footer">
            <span class="stat-badge highlight">{{ $getMostPopularPlan->subscriptions_count }} Kullanıcı</span>
          </div>
        </div>
      </div>

      <div class="panel-card">
        <div class="panel-header">
          <h3>Son Abonelik Hareketleri</h3>
        </div>
        <table class="admin-table">
          <thead>
            <tr>
              <th>Kullanıcı</th>
              <th>Mevcut Plan</th>
              <th>Durum</th>
              <th>Kayıt Tarihi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($subscriptions as $subscription)
            <tr>
              <td>{{ $subscription->user->email ?? 'Bilinmiyor' }}</td>
              <td><span class="user-badge badge-plan">{{ $subscription->plan->name ?? 'Bilinmiyor' }}</span></td>
              <td><span class="user-badge badge-active">Aktif</span></td>
              <td>{{ $subscription->created_at ? \Carbon\Carbon::parse($subscription->created_at)->format('d M Y') : 'Bilinmiyor' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
@endsection