@extends('layouts.app')

@section('content')
<div class="admin-layout">
  <aside class="admin-sidebar">
    <div class="sidebar-brand">
      <h2>Bulutla Admin</h2>
    </div>
    <nav class="sidebar-nav">
      <ul>
        <li><a href="{{ route('admin.index') }}" class="active">Genel Bakış</a></li>
        <li><a href="{{ route('admin.plans.index') }}">Planlar</a></li>
        <li><a href="{{ route('admin.subscriptions.index') }}">Abonelikler</a></li>
        <li><a href="{{ route('admin.users.index') }}">Kullanıcılar</a></li>
      </ul>
    </nav>
  </aside>

  <div class="admin-main">
    <header class="admin-topbar">
      <div class="topbar-title">Panel</div>
      <div class="topbar-user">
        <span>{{ Auth::user()->name ?? 'Yönetici' }}</span>
      </div>
    </header>

    <main class="admin-content">
      <div class="wrap">
        <div class="stats-grid">
          <div class="stat-card">
            <span class="stat-title">Toplam Abone</span>
            <div class="stat-value">1.280</div>
            <span class="stat-badge positive">+%8 bu ay</span>
          </div>

          <div class="stat-card">
            <span class="stat-title">Aylık Tahmini Gelir</span>
            <div class="stat-value">45.200 ₺</div>
            <span class="stat-badge positive">+%12 bu ay</span>
          </div>

          <div class="stat-card">
            <span class="stat-title">Depolama Doluluğu</span>
            <div class="stat-value">640 GB</div>
            <span class="stat-badge neutral">%64 / 1 TB</span>
          </div>

          <div class="stat-card">
            <span class="stat-title">En Popüler Paket</span>
            <div class="stat-value">Pro Plan</div>
            <span class="stat-badge highlight">854 Aktif</span>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>
@endsection