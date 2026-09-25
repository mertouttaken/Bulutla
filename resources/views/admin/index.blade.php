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
    display: flex;
    min-height: calc(100vh - 70px);
    background: var(--bg-surface);
    color: #e2e8f0;
    width: 100%;
  }

  .admin-sidebar {
    width: 260px;
    flex-shrink: 0;
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
    flex: 1;
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
      <livewire:admin.admin-stats />
      <livewire:admin.recent-subscriptions-table />
    </main>
  </div>
</div>
@endsection