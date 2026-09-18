@extends('layouts.app')

@section('content')
<style>
  .admin-layout {
    display: grid;
    grid-template-columns: 260px 1fr;
    min-height: calc(100vh - 70px);
    background: #0b0c16;
    color: #e2e8f0;
    font-family: inherit;
  }

  @media (max-width: 900px) {
    .admin-layout {
      grid-template-columns: 1fr;
    }
  }

  .admin-sidebar {
    background: #111222;
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
    background: #c084fc;
    border-radius: 50%;
    box-shadow: 0 0 12px #c084fc;
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
    color: #94a3b8;
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
    background: linear-gradient(135deg, rgba(95, 21, 135, 0.25), rgba(139, 30, 196, 0.25));
    color: #d8b4fe;
    border: 1px solid rgba(192, 132, 252, 0.35);
  }

  .admin-main {
    display: flex;
    flex-direction: column;
    min-width: 0;
  }

  .admin-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 36px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    background: #0e0f1d;
  }

  .topbar-title h1 {
    font-size: 1.25rem;
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
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 18px;
    padding: 22px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    transition: transform 0.2s ease, border-color 0.2s ease;
    position: relative;
    overflow: hidden;
  }

  .stat-card::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(192, 132, 252, 0.4), transparent);
  }

  .stat-card:hover {
    transform: translateY(-2px);
    border-color: rgba(192, 132, 252, 0.35);
  }

  .stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .stat-title {
    font-size: 0.85rem;
    color: #94a3b8;
    font-weight: 500;
  }

  .stat-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: rgba(139, 30, 196, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #c084fc;
    font-size: 0.95rem;
  }

  .stat-value {
    font-size: 1.7rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
  }

  .stat-value small {
    font-size: 0.85rem;
    font-weight: 500;
    color: #94a3b8;
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
    background: rgba(139, 30, 196, 0.18);
    color: #d8b4fe;
  }

  .stat-badge.highlight {
    background: rgba(139, 30, 196, 0.25);
    border: 1px solid rgba(192, 132, 252, 0.35);
    color: #c084fc;
  }

  .stat-subtext {
    font-size: 0.78rem;
    color: #64748b;
  }

  .panel-card {
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
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
    font-size: 0.88rem;
    text-align: left;
  }

  .admin-table th {
    padding: 12px 16px;
    color: #64748b;
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
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
    background: rgba(34, 197, 94, 0.12);
    border: 1px solid rgba(34, 197, 94, 0.25);
    color: #4ade80;
  }

  .badge-plan {
    background: rgba(139, 30, 196, 0.18);
    color: #d8b4fe;
    border: 1px solid rgba(192, 132, 252, 0.3);
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
        <li><a href="{{ route('admin.index') }}" class="active">📊 Genel Bakış</a></li>
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
        <!-- Aktif Abone -->
        <div class="stat-card">
          <div class="stat-header">
            <span class="stat-title">Aktif Abone</span>
            <div class="stat-icon">👥</div>
          </div>
          <div class="stat-value">{{ $totalSubscription ?? 0 }}</div>
          <div class="stat-footer">
            <span class="stat-badge positive">+%8</span>
            <span class="stat-subtext">geçen aya göre</span>
          </div>
        </div>

        <!-- Aylık Tahmini Gelir -->
        <div class="stat-card">
          <div class="stat-header">
            <span class="stat-title">Aylık Tahmini Gelir</span>
            <div class="stat-icon">💳</div>
          </div>
          <div class="stat-value">{{ number_format($totalValue ?? 0, 2, ',', '.') }} ₺</div>
          <div class="stat-footer">
            <span class="stat-badge positive">+%12</span>
            <span class="stat-subtext">geçen aya göre</span>
          </div>
        </div>

        <!-- Depolama Doluluğu -->
        @php
          $safeMaxLimit = max((float) ($maxStorageLimit ?? 0), 1);
          $safeUsed = (float) ($usedStorage ?? 0);
          $storagePercentage = min(100, round(($safeUsed / $safeMaxLimit) * 100, 1));

          $usedFormatted = $safeUsed >= 1024 ? round($safeUsed / 1024, 2) . ' TB' : round($safeUsed, 2) . ' GB';
          $limitFormatted = $safeMaxLimit >= 1024 ? round($safeMaxLimit / 1024, 2) . ' TB' : round($safeMaxLimit, 2) . ' GB';
        @endphp
        <div class="stat-card">
          <div class="stat-header">
            <span class="stat-title">Depolama Doluluğu</span>
            <div class="stat-icon">💾</div>
          </div>
          <div class="stat-value">
            {{ $usedFormatted }} <small>/ {{ $limitFormatted }}</small>
          </div>
          <div class="stat-footer">
            <span class="stat-badge neutral">%{{ $storagePercentage }} Dolu</span>
          </div>
        </div>

        <!-- En Popüler Paket -->
        <div class="stat-card">
          <div class="stat-header">
            <span class="stat-title">En Popüler Paket</span>
            <div class="stat-icon">⚡</div>
          </div>
          <div class="stat-value">{{ $getMostPopularPlan?->name ?? 'Kayıt Yok' }}</div>
          <div class="stat-footer">
            <span class="stat-badge highlight">{{ $getMostPopularPlan?->subscriptions_count ?? 0 }} Abone</span>
          </div>
        </div>
      </div>

      <!-- Son Hareketler Tablosu -->
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
            @forelse($subscriptions as $sub)
              @if(!$sub->plan?->isDefault())
                <tr>
                  <td>{{ $sub->user?->email ?? 'Bilinmiyor' }}</td>
                  <td><span class="user-badge badge-plan">{{ $sub->plan?->name ?? 'Plan Yok' }}</span></td>
                  <td><span class="user-badge badge-active">Aktif</span></td>
                  <td>{{ $sub->created_at ? $sub->created_at->format('d M Y') : '-' }}</td>
                </tr>
              @endif
            @empty
              <tr>
                <td colspan="4" style="text-align: center; color: #64748b; padding: 24px;">Henüz aktif abonelik hareketi bulunmuyor.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
@endsection