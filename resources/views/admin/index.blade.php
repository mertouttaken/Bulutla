@extends('layouts.app')

@section('content')

<div class="admin-layout">
  <aside class="admin-sidebar">
    <a href="{{ route('home') }}" class="sidebar-brand">
      <span class="dot"></span>
      <h2>Bulutla</h2><small>YÖNETİM ARŞİVİ</small>
    </a>
    <nav class="sidebar-nav">
      <ul>
        <li><a href="{{ route('admin.index') }}" class="active"><i>01</i> Genel bakış</a></li>
        <li><a href="{{ route('admin.plans.index') }}"><i>02</i> Planlar</a></li>
        <li><a href="{{ route('admin.subscriptions.index') }}"><i>03</i> Abonelikler</a></li>
        <li><a href="{{ route('admin.users.index') }}"><i>04</i> Kullanıcılar</a></li>
      </ul>
    </nav>
  </aside>

  <div class="admin-main">
    <header class="admin-topbar">
      <div class="topbar-title">
        <p class="desk-kicker">YÖNETİM</p>
        <h1 class="motion-title">Genel Bakış</h1>
      </div>
      <div class="topbar-user">
        <span>{{ Auth::user()->name ?? 'Yönetici' }}</span>
      </div>
    </header>

    <main class="admin-content">
      <livewire:admin.admin-stats />
      <livewire:admin.recent-subscriptions-table />
    </main>
  </div>
</div>
@endsection