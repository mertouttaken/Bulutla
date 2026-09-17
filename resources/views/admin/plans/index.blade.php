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

  .submenu {
    list-style: none;
    padding-left: 28px;
    margin-top: 6px;
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .submenu a {
    font-size: 0.82rem;
    padding: 8px 12px;
    color: #64748b;
  }

  .submenu a.sub-active {
    color: #fff;
    background: rgba(255, 255, 255, 0.05);
    font-weight: 600;
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

  .plans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
  }

  .plan-card {
    background: linear-gradient(180deg, #151928 0%, #111422 100%);
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    padding: 26px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    position: relative;
  }

  .plan-card.featured {
    border-color: rgba(99, 102, 241, 0.4);
    box-shadow: 0 0 25px rgba(99, 102, 241, 0.12);
  }

  .plan-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
  }

  .plan-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 6px 0;
  }

  .plan-badge {
    font-size: 0.75rem;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 600;
  }

  .plan-badge.active {
    background: rgba(34, 197, 94, 0.15);
    color: #4ade80;
  }

  .plan-price-box {
    display: flex;
    align-items: baseline;
    gap: 4px;
  }

  .plan-price {
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
  }

  .plan-period {
    font-size: 0.85rem;
    color: #64748b;
  }

  .plan-limits {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 16px 0;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
  }

  .limit-item {
    display: flex;
    justify-content: space-between;
    font-size: 0.88rem;
    color: #94a3b8;
  }

  .limit-item strong {
    color: #e2e8f0;
  }

  .plan-features-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .plan-features-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.85rem;
    color: #cbd5e1;
  }

  .plan-features-list .check {
    color: #6366f1;
    font-weight: bold;
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
        <li>
          <a href="#" class="active">📦 Planlar</a>
          <ul class="submenu">
            <li><a href="#" class="sub-active">📋 Mevcut Plan Listesi</a></li>
            <li><a href="{{ route('admin.plans.actions') }}">⚡ Hızlı İşlemler & Ekleme</a></li>
          </ul>
        </li>
        <li><a href="{{ route('admin.subscriptions.index') }}">💳 Abonelikler</a></li>
        <li><a href="{{ route('admin.users.index') }}">👥 Kullanıcılar</a></li>
      </ul>
    </nav>
  </aside>

  <div class="admin-main">
    <header class="admin-topbar">
      <div class="topbar-title">
        <h1>Mevcut Plan Listesi</h1>
      </div>
      <div class="topbar-user">
        <span>👤 {{ Auth::user()->name ?? 'Yönetici' }}</span>
      </div>
    </header>

    <main class="admin-content">
      <div class="plans-grid">
        @foreach($plans as $plan)
          <div class="plan-card">
            <div class="plan-header">
              <div>
                <h3 class="plan-name">{{ $plan->name ?? 'Free' }}</h3>
              </div>
              <span class="plan-badge active">Aktif</span>
            </div>
            <div class="plan-price-box">
              <span class="plan-price">{{ isset($plan->price) ? number_format($plan->price, 2, ',', '.') : '999,00' }} ₺</span>
              <span class="plan-period">/ ay</span>
            </div>
            <div class="plan-limits">
              <div class="limit-item">
                <span>Depolama Limiti:</span>
                <strong>{{ $plan->storage_limit ?? '100 MB' }}</strong>
              </div>
              <div class="limit-item">
                <span>Proje Limiti:</span>
                <strong>{{ $plan->project_limit > 0 ? $plan->project_limit : 'Sınırsız' }}</strong>
              </div>
            </div>
            <ul class="plan-features-list">
                @php
                    $json = json_decode($plan->features, true);
                    $features = is_array($json) ? $json : explode(',', $plan->features);
                @endphp
                @foreach($features as $feature)
                  <li><span class="check">✔</span> {{ $feature }}</li>
                @endforeach
            </ul>
          </div>
        @endforeach
      </div>
    </main>
  </div>
</div>
@endsection