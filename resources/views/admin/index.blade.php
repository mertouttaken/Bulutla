@extends('layouts.app')

@section('content')
<style>
  :root {
    --bg-surface: #0b0c16;
    --bg-sidebar: #111222;
    --bg-card: rgba(17, 18, 34, 0.85);
    --border-subtle: rgba(255, 255, 255, 0.07);
    --border-accent: rgba(192, 132, 252, 0.35);
    --neon-purple: #c084fc;
    --neon-purple-glow: rgba(192, 132, 252, 0.25);
    --text-primary: #f8fafc;
    --text-muted: #8f9bba;
  }

  .admin-layout {
    display: grid;
    grid-template-columns: 260px 1fr;
    min-height: calc(100vh - 70px);
    background: var(--bg-surface);
    color: #e2e8f0;
    font-family: inherit;
  }

  @media (max-width: 960px) {
    .admin-layout {
      grid-template-columns: 1fr;
    }
    .admin-sidebar {
      display: none;
    }
  }

  .admin-sidebar {
    background: var(--bg-sidebar);
    border-right: 1px solid var(--border-subtle);
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
    background: var(--neon-purple);
    border-radius: 50%;
    box-shadow: 0 0 12px var(--neon-purple);
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
    color: var(--text-muted);
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
    border: 1px solid var(--border-accent);
    box-shadow: 0 0 14px rgba(139, 30, 196, 0.2);
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
    border-bottom: 1px solid var(--border-subtle);
    background: #0e0f1d;
  }

  .topbar-title h1 {
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0;
    color: #fff;
    letter-spacing: -0.01em;
  }

  .topbar-user {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.03);
    padding: 6px 14px;
    border-radius: 20px;
    border: 1px solid var(--border-subtle);
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
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 22px;
  }

  .stat-card {
    background: var(--bg-card);
    backdrop-filter: blur(16px);
    border: 1px solid var(--border-subtle);
    border-radius: 20px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
  }

  .stat-card::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 20px;
    padding: 1px;
    background: linear-gradient(135deg, rgba(192, 132, 252, 0.3), transparent 60%);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
  }

  .stat-card:hover {
    transform: translateY(-3px);
    border-color: var(--border-accent);
    box-shadow: 0 12px 35px rgba(95, 21, 135, 0.25);
  }

  .stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .stat-title {
    font-size: 0.85rem;
    color: var(--text-muted);
    font-weight: 600;
  }

  .stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: rgba(139, 30, 196, 0.16);
    border: 1px solid rgba(192, 132, 252, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--neon-purple);
  }

  .stat-value {
    font-size: 1.85rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.03em;
    display: flex;
    align-items: baseline;
    gap: 6px;
  }

  .stat-value small {
    font-size: 0.88rem;
    font-weight: 500;
    color: #64748b;
  }

  /* Depolama Barı */
  .storage-progress-bg {
    width: 100%;
    height: 6px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 99px;
    overflow: hidden;
  }

  .storage-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #7e22ce, #c084fc);
    border-radius: 99px;
    box-shadow: 0 0 10px var(--neon-purple-glow);
  }

  .stat-footer {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .stat-badge {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 6px;
  }

  .stat-badge.positive {
    background: rgba(34, 197, 94, 0.12);
    border: 1px solid rgba(34, 197, 94, 0.25);
    color: #4ade80;
  }

  .stat-badge.neutral {
    background: rgba(139, 30, 196, 0.18);
    border: 1px solid rgba(192, 132, 252, 0.3);
    color: #d8b4fe;
  }

  .stat-badge.highlight {
    background: rgba(139, 30, 196, 0.22);
    border: 1px solid rgba(192, 132, 252, 0.35);
    color: #c084fc;
  }

  .stat-subtext {
    font-size: 0.78rem;
    color: #64748b;
  }

  .panel-card {
    background: var(--bg-card);
    backdrop-filter: blur(16px);
    border: 1px solid var(--border-subtle);
    border-radius: 22px;
    padding: 28px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
  }

  .panel-card::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 22px;
    padding: 1px;
    background: linear-gradient(135deg, rgba(192, 132, 252, 0.3), transparent 60%);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
  }

  .panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--border-subtle);
  }

  .panel-header h3 {
    font-size: 1.12rem;
    font-weight: 700;
    margin: 0;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .table-responsive {
    overflow-x: auto;
  }

  .admin-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.88rem;
    text-align: left;
  }

  .admin-table th {
    padding: 14px 18px;
    color: #64748b;
    font-weight: 600;
    font-size: 0.76rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid var(--border-subtle);
  }

  .admin-table td {
    padding: 16px 18px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    color: #cbd5e1;
    vertical-align: middle;
  }

  .admin-table tr:hover td {
    background: rgba(255, 255, 255, 0.02);
  }

  .admin-table tr:last-child td {
    border-bottom: none;
  }

  .user-cell {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .user-avatar {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: rgba(139, 30, 196, 0.2);
    border: 1px solid rgba(192, 132, 252, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.82rem;
    color: #d8b4fe;
    flex-shrink: 0;
  }

  .user-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.74rem;
    font-weight: 600;
    letter-spacing: 0.02em;
  }

  .badge-active {
    background: rgba(34, 197, 94, 0.12);
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: #4ade80;
  }

  .badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #4ade80;
    box-shadow: 0 0 6px #4ade80;
  }

  .badge-plan {
    background: rgba(139, 30, 196, 0.16);
    color: #d8b4fe;
    border: 1px solid rgba(192, 132, 252, 0.35);
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
        
        <div class="stat-card">
          <div class="stat-header">
            <span class="stat-title">Aktif Abone</span>
            <div class="stat-icon">
              <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
            </div>
          </div>
          <div class="stat-value">{{ $totalSubscription ?? 0 }}</div>
          <div class="stat-footer">
            <span class="stat-badge positive">+%8</span>
            <span class="stat-subtext">geçen aya göre</span>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <span class="stat-title">Aylık Tahmini Gelir</span>
            <div class="stat-icon">
              <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
          </div>
          <div class="stat-value">{{ number_format($totalValue ?? 0, 2, ',', '.') }} ₺</div>
          <div class="stat-footer">
            <span class="stat-badge positive">+%12</span>
            <span class="stat-subtext">geçen aya göre</span>
          </div>
        </div>

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
            <div class="stat-icon">
              <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
              </svg>
            </div>
          </div>
          <div class="stat-value">
            {{ $usedFormatted }} <small>/ {{ $limitFormatted }}</small>
          </div>
          <div class="storage-progress-bg">
            <div class="storage-progress-fill" style="width: {{ $storagePercentage }}%;"></div>
          </div>
          <div class="stat-footer">
            <span class="stat-badge neutral">%{{ $storagePercentage }} Dolu</span>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <span class="stat-title">En Popüler Paket</span>
            <div class="stat-icon">
              <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            </div>
          </div>
          <div class="stat-value">{{ $getMostPopularPlan?->name ?? 'Kayıt Yok' }}</div>
          <div class="stat-footer">
            <span class="stat-badge highlight">{{ $getMostPopularPlan?->subscriptions_count ?? 0 }} Aktif Abone</span>
          </div>
        </div>

      </div>

      <div class="panel-card">
        <div class="panel-header">
          <h3>
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--neon-purple);">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Son Abonelik Hareketleri
          </h3>
        </div>

        <div class="table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Kullanıcı</th>
                <th>Mevcut Plan</th>
                <th>Durum</th>
                <th>Kayıt Tarihi</th>
                <th>Bitiş Tarihi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($subscriptions as $sub)
                @if(!$sub->plan?->isDefault())
                  <tr>
                    <td>
                      <div class="user-cell">
                        <div class="user-avatar">
                          {{ strtoupper(substr($sub->user?->name ?? $sub->user?->email ?? 'U', 0, 1)) }}
                        </div>
                        <div style="display: flex; flex-direction: column;">
                          <strong style="color: #fff; font-size: 0.88rem;">{{ $sub->user?->name ?? 'Kullanıcı' }}</strong>
                          <span style="font-size: 0.78rem; color: var(--text-muted);">{{ $sub->user?->email ?? 'Bilinmiyor' }}</span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="user-badge badge-plan">{{ $sub->plan?->name ?? 'Plan Yok' }}</span>
                    </td>
                    <td>
                      <span class="user-badge badge-active">
                        <span class="badge-dot"></span>
                        {{ strtoupper($sub->status == 'active' ? 'AKTİF' : 'PASİF') }}
                      </span>
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.82rem;">
                      {{ $sub->created_at ? $sub->created_at->translatedFormat('d F Y') : '-' }}
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.82rem;">
                      {{ $sub->created_at ? $sub->created_at->addMonth()->translatedFormat('d F Y') : '-' }}
                    </td>
                  </tr>
                @endif
              @empty
                <tr>
                  <td colspan="4" style="text-align: center; color: #64748b; padding: 36px;">
                    Henüz aktif bir abonelik hareketi bulunmuyor.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </main>
  </div>
</div>
@endsection