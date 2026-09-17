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

  .badge-admin {
    background: rgba(239, 68, 68, 0.15);
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.25);
  }

  .badge-user {
    background: rgba(148, 163, 184, 0.12);
    color: #94a3b8;
  }

  .storage-progress {
    display: flex;
    flex-direction: column;
    gap: 6px;
    width: 140px;
  }

  .progress-track {
    background: #1b2033;
    border-radius: 4px;
    height: 6px;
    overflow: hidden;
  }

  .progress-fill {
    background: linear-gradient(90deg, #6366f1, #8b5cf6);
    height: 100%;
    border-radius: 4px;
  }

  .storage-text {
    font-size: 0.75rem;
    color: #64748b;
  }

  .table-actions {
    display: flex;
    gap: 8px;
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

  .action-btn.danger:hover {
    background: rgba(239, 68, 68, 0.15);
    border-color: rgba(239, 68, 68, 0.3);
    color: #fca5a5;
  }
</style>

<div class="admin-layout">
  <aside class="admin-sidebar">
    <div class="sidebar-brand">
      <span class="dot"></span>
      <h2>Planla Admin</h2>
    </div>
    <nav class="sidebar-nav">
      <ul>
        <li><a href="{{ route('admin.index') }}">📊 Genel Bakış</a></li>
        <li><a href="{{ route('admin.plans.index') }}">📦 Planlar</a></li>
        <li><a href="{{ route('admin.subscriptions.index') }}">💳 Abonelikler</a></li>
        <li><a href="{{ route('admin.users.index') }}" class="active">👥 Kullanıcılar</a></li>
      </ul>
    </nav>
  </aside>

  <div class="admin-main">
    <header class="admin-topbar">
      <div class="topbar-title">
        <h1>Kullanıcı Yönetimi</h1>
      </div>
      <div class="topbar-user">
        <span>👤 {{ Auth::user()->name ?? 'Yönetici' }}</span>
      </div>
    </header>

    <main class="admin-content">
      <div class="filter-bar">
        <div class="search-box">
          <span class="search-icon">🔍</span>
          <input type="text" class="search-input" placeholder="İsim veya e-posta ara...">
        </div>
        <div class="filter-group">
          <select class="filter-select">
            <option value="">Rol: Tümü</option>
            <option value="admin">Yönetici</option>
            <option value="user">Standart Kullanıcı</option>
          </select>
          <select class="filter-select">
            <option value="">Plan: Tümü</option>
            @foreach($plans as $plan)
              <option value="{{ $plan->slug }}">{{ $plan->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="panel-card">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Kullanıcı</th>
              <th>Yetki</th>
              <th>Aktif Plan</th>
              <th>Depolama Kullanımı</th>
              <th>Proje Kullanımı</th>
              <th>Kayıt Tarihi</th>
              <th>İşlemler</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td>
                <div class="user-cell">
                  <strong>{{ $user->name }}</strong>
                  <span>{{ $user->email }}</span>
                </div>
              </td>
              <td><span class="badge badge-{{ $user->is_admin ? 'admin' : 'user' }}">{{ $user->is_admin ? 'Yönetici' : 'Kullanıcı' }}</span></td>
              <td>{{ $user->plan->name ?? 'Free' }}</td>
              <td>
                <div class="storage-progress">
                  <div class="progress-track">
                    @php
                      $limit = (float) ($user->plan?->storage_limit ?? 0);
                      $used = (float) $user->storageUsedValue();

                      $storagePercentage = $limit > 0 ? min(round(($used / $limit) * 100), 100) : 0;
                    @endphp
                    <div class="progress-fill" style="width: {{ $storagePercentage }}%;"></div>
                  </div>
                  <span class="storage-text">{{ $user->storageUsedFormatted() }} / {{ $user->plan?->storage_limit ?? '100' }}</span>
                </div>
              </td>
              <td>
                <div class="storage-progress">
                  <div class="progress-track">
                    @php
                      $limit = (float) ($user->plan?->project_limit ?? 0);
                      $used = (float) $user->projectUsedValue();

                      $projectPercentage = $limit > 0 ? min(round(($used / $limit) * 100), 100) : 0;
                    @endphp
                    <div class="progress-fill" style="width: {{ $projectPercentage }}%;"></div>
                  </div>
                  <span class="storage-text">{{ $user->projectUsedValue() }} / {{ $user->plan?->project_limit < 0 ? 'Sınırsız' : $user->plan?->project_limit ?? '0' }}</span>
                </div>
              </td>
              <td>{{ $user->created_at->format('d M Y') }}</td>
              <td>
                <div class="table-actions">
                  <button class="action-btn">Düzenle</button>
                  <button class="action-btn danger">Engelle</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
@endsection