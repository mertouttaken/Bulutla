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
    justify-content: center;
  }

  .edit-card {
    background: #111422;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 18px;
    padding: 32px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.35);
    width: 100%;
    max-width: 760px;
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
  }

  .card-header h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .btn-back {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 0.82rem;
    text-decoration: none;
    transition: all 0.2s;
  }

  .btn-back:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
  }

  .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
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
    padding: 11px 14px;
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
    min-height: 90px;
  }

  .card-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.06);
  }

  .btn-secondary {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
    padding: 11px 20px;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.2s;
  }

  .btn-secondary:hover {
    background: rgba(255, 255, 255, 0.08);
    color: #fff;
  }

  .btn-submit {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border: none;
    color: #fff;
    padding: 11px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: opacity 0.2s;
  }

  .btn-submit:hover {
    opacity: 0.9;
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
        <h1>Planı Düzenle</h1>
      </div>
      <div class="topbar-user">
        <span>👤 {{ Auth::user()->name ?? 'Yönetici' }}</span>
      </div>
    </header>

    <main class="admin-content">
      <div class="edit-card">
        <div class="card-header">
          <h3>✏️ {{ $plan->name }} Planını Düzenle</h3>
          <a href="{{ route('admin.plans.actions') }}" class="btn-back">← Geri Dön</a>
        </div>

        <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="form-grid">
            <div class="form-group">
              <label>Plan Adı</label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $plan->name) }}" required>
            </div>

            <div class="form-group">
              <label>Slug</label>
              <input type="text" name="slug" class="form-control" value="{{ old('slug', $plan->slug) }}" required>
            </div>

            <div class="form-group">
              <label>Aylık Ücret (₺)</label>
              <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $plan->price) }}" required>
            </div>

            <div class="form-group">
              <label>Depolama Limiti</label>
              <input type="text" name="storage_limit" class="form-control" value="{{ old('storage_limit', $plan->storage_limit) }}">
            </div>

            <div class="form-group">
              <label>Proje Limiti</label>
              <input type="number" name="project_limit" class="form-control" value="{{ old('project_limit', $plan->project_limit) }}">
            </div>

            <div class="form-group">
              <label>Görüntülenme Sırası</label>
              <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $plan->sort_order) }}">
            </div>

            <div class="form-group full">
              <label>Açıklama</label>
              <textarea name="description" class="form-control">{{ old('description', $plan->description) }}</textarea>
            </div>

            <div class="form-group full">
              <label>Özellikler (Virgülle ayırın)</label>
              <input type="text" name="features" class="form-control" value="{{ old('features', $plan->features) }}">
            </div>
          </div>

          <div class="card-actions">
            <a href="{{ route('admin.plans.actions') }}" class="btn-secondary">İptal</a>
            <button type="submit" class="btn-submit">Değişiklikleri Kaydet</button>
          </div>
        </form>
      </div>
    </main>
  </div>
</div>
@endsection