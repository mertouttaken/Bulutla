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

  .content-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 28px;
  }

  .action-card {
    background: #111422;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    padding: 26px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    padding-bottom: 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
  }

  .card-header h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
  }

  .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .form-group.full {
    grid-column: span 2;
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

  textarea.form-control {
    resize: vertical;
    min-height: 80px;
  }

  .btn-submit {
    background: linear-gradient(135deg, #5f1587, #3f0b5c);
    border: none;
    color: #fff;
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
    transition: opacity 0.2s;
  }

  .btn-submit:hover {
    opacity: 0.9;
  }

  .quick-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .quick-item {
    background: #151928;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .quick-info h4 {
    margin: 0 0 4px 0;
    font-size: 0.95rem;
    color: #fff;
  }

  .quick-info span {
    font-size: 0.8rem;
    color: #64748b;
  }

  .quick-actions {
    display: flex;
    gap: 8px;
  }

  .btn-action {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.78rem;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
  }

  .btn-action:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
  }

  .btn-danger {
    color: #f87171;
    border-color: rgba(239, 68, 68, 0.2);
  }

  .btn-danger:hover {
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
        <li>
          <a href="#" class="active">📦 Planlar</a>
          <ul class="submenu">
            <li><a href="{{ route('admin.plans.index') }}">📋 Mevcut Plan Listesi</a></li>
            <li><a href="{{ route('admin.plans.actions') }}" class="sub-active">⚡ Hızlı İşlemler & Ekleme</a></li>
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
        <h1>Hızlı İşlemler & Yeni Plan</h1>
      </div>
      <div class="topbar-user">
        <span>👤 {{ Auth::user()->name ?? 'Yönetici' }}</span>
      </div>
    </header>

    <main class="admin-content">
      <div class="content-grid">
        <div class="action-card">
          <div class="card-header">
            <h3>Yeni Plan Tanımla</h3>
          </div>
          <form action="{{ route('admin.plans.store') }}" method="POST">
            @csrf
            <div class="form-grid">
              <div class="form-group">
                <label>Plan Adı</label>
                <input type="text" name="name" class="form-control" placeholder="Örn: Free" required>
              </div>
              <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" class="form-control" placeholder="free" required>
              </div>
              <div class="form-group">
                <label>Aylık Ücret (₺)</label>
                <input type="number" step="0.01" name="price" class="form-control" placeholder="149.00" required>
              </div>
              <div class="form-group">
                <label>Görüntülenme Sırası</label>
                <input type="number" name="sort_order" class="form-control" placeholder="0" value="0">
              </div>
              <div class="form-group">
                <label>Depolama Limiti</label>
                <input type="text" name="storage_limit" class="form-control" placeholder="Örn: 5 GB">
              </div>
              <div class="form-group">
                <label>Proje Limiti</label>
                <input type="number" name="project_limit" class="form-control" placeholder="5">
              </div>
              <div class="form-group full">
                <label>Açıklama</label>
                <textarea name="description" class="form-control" placeholder="Plan hakkında kısa bilgilendirme..."></textarea>
              </div>
              <div class="form-group full">
                <label>Özellikler (Virgülle ayırın)</label>
                <input type="text" name="features" class="form-control" placeholder="5 proje, 5 GB alan, Canlı destek">
              </div>
              <div class="form-group full">
                <button type="submit" class="btn-submit">Planı Kaydet ve Yayınla</button>
              </div>
            </div>
          </form>
        </div>

        <div class="action-card">
          <div class="card-header">
            <h3>Hızlı Yönetim</h3>
          </div>
          <div class="quick-list">
            @foreach ($plans as $plan)
              <div class="quick-item">
                <div class="quick-info">
                  <h4>{{ $plan->name ?? 'Free' }} <span style="font-size: 0.75rem; color: #726d75;">(#{{ $plan->sort_order ?? 0 }})</span></h4>
                  <span>{{ $plan->price ?? '0' }} ₺ / ay • {{ $plan->storage_limit ?? '100 MB' }}</span>
                </div>
                <div class="quick-actions">
                  <a href="{{ route('admin.plans.edit', $plan) }}" class="btn-action">Düzenle</a>
                  <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-danger">Sil</button>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </main>
  </div>
</div>
@endsection