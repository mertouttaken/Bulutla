<div>
  <style>
    :root {
      --bg-surface: #0b0d14;
      --bg-sidebar: #111420;
      --bg-card: rgba(17, 20, 34, 0.85);
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
      border: 1px solid var(--border-subtle);
      font-size: 0.85rem;
      color: #cbd5e1;
    }

    .admin-content {
      padding: 36px;
      display: flex;
      flex-direction: column;
      gap: 28px;
    }

    .content-header-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
    }

    .btn-cta-primary {
      background: linear-gradient(135deg, #7e22ce, #a855f7);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: #ffffff;
      padding: 10px 20px;
      border-radius: 12px;
      font-size: 0.88rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 18px rgba(168, 85, 247, 0.35);
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-cta-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 24px rgba(168, 85, 247, 0.5);
    }

    .plans-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 24px;
      align-items: stretch;
    }

    .plan-card {
      background: var(--bg-card);
      backdrop-filter: blur(16px);
      border: 1px solid var(--border-subtle);
      border-radius: 22px;
      padding: 28px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      gap: 22px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
      position: relative;
      overflow: hidden;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .plan-card::before {
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

    .plan-card:hover {
      transform: translateY(-3px);
      border-color: var(--border-accent);
      box-shadow: 0 14px 35px rgba(95, 21, 135, 0.3);
    }

    .plan-card.is-default {
      border-color: rgba(192, 132, 252, 0.45);
      background: linear-gradient(180deg, rgba(95, 21, 135, 0.12) 0%, rgba(17, 20, 34, 0.9) 100%);
    }

    .plan-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 12px;
    }

    .plan-title-col {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .plan-name {
      font-size: 1.35rem;
      font-weight: 800;
      color: #fff;
      margin: 0;
      letter-spacing: -0.02em;
    }

    .plan-slug {
      font-size: 0.78rem;
      color: #64748b;
    }

    .badges-wrap {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 6px;
    }

    .plan-badge {
      font-size: 0.7rem;
      padding: 3px 9px;
      border-radius: 12px;
      font-weight: 600;
      letter-spacing: 0.02em;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .badge-default {
      background: rgba(192, 132, 252, 0.18);
      border: 1px solid rgba(192, 132, 252, 0.4);
      color: #d8b4fe;
    }

    .badge-order {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--border-subtle);
      color: var(--text-muted);
    }

    .plan-price-box {
      display: flex;
      align-items: baseline;
      gap: 6px;
      padding-bottom: 4px;
    }

    .plan-price {
      font-size: 2.2rem;
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.03em;
    }

    .plan-period {
      font-size: 0.88rem;
      color: var(--text-muted);
    }

    .plan-desc {
      font-size: 0.84rem;
      color: var(--text-muted);
      line-height: 1.5;
      margin: 0;
    }

    .plan-limits {
      background: rgba(14, 15, 29, 0.6);
      border: 1px solid var(--border-subtle);
      border-radius: 14px;
      padding: 14px 16px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .limit-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.84rem;
      color: var(--text-muted);
    }

    .limit-item strong {
      color: #e2e8f0;
      font-weight: 600;
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
      font-size: 0.84rem;
      color: #cbd5e1;
    }

    .plan-features-list .check-icon {
      width: 18px;
      height: 18px;
      border-radius: 6px;
      background: rgba(192, 132, 252, 0.15);
      color: var(--neon-purple);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.72rem;
      flex-shrink: 0;
    }

    .plan-card-footer {
      border-top: 1px solid var(--border-subtle);
      padding-top: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .btn-edit-plan {
      color: var(--neon-purple);
      font-size: 0.85rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s;
    }

    .btn-edit-plan:hover {
      color: #ffffff;
      transform: translateX(3px);
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
              <li><a href="{{ route('admin.plans.index') }}" class="sub-active">📋 Mevcut Plan Listesi</a></li>
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
        <div class="content-header-actions">
          <div>
            <p style="margin: 0; font-size: 0.9rem; color: var(--text-muted);">
              Sistemde kayıtlı tüm paketler ve abonelik sınırları aşağıda listelenmiştir.
            </p>
          </div>
          <a href="{{ route('admin.plans.actions') }}" class="btn-cta-primary">
            <span>+</span> Yeni Plan Tanımla
          </a>
        </div>

        <div class="plans-grid">
          @forelse($plans as $plan)
            <div class="plan-card {{ $plan->is_default ? 'is-default' : '' }}">
              <div style="display: flex; flex-direction: column; gap: 18px;">
                <div class="plan-header">
                  <div class="plan-title-col">
                    <h3 class="plan-name">{{ $plan->name ?? 'Plan' }}</h3>
                    <span class="plan-slug">slug: /{{ $plan->slug }}</span>
                  </div>

                  <div class="badges-wrap">
                    @if($plan->is_default)
                      <span class="plan-badge badge-default">★ Varsayılan</span>
                    @endif
                    <span class="plan-badge badge-order">Sıra #{{ $plan->sort_order ?? 0 }}</span>
                  </div>
                </div>

                <div class="plan-price-box">
                  <span class="plan-price">{{ number_format($plan->price ?? 0, 2, ',', '.') }} ₺</span>
                  <span class="plan-period">/ ay</span>
                </div>

                @if($plan->description)
                  <p class="plan-desc">{{ $plan->description }}</p>
                @endif

                <div class="plan-limits">
                  <div class="limit-item">
                    <span>Depolama Alanı</span>
                    <strong style="color: var(--neon-purple);">{{ $plan->storage_limit ?? '100 MB' }}</strong>
                  </div>
                  <div class="limit-item">
                    <span>Proje Kotası</span>
                    <strong>{{ ($plan->project_limit && $plan->project_limit > 0) ? $plan->project_limit . ' Adet' : 'Sınırsız' }}</strong>
                  </div>
                </div>

                <ul class="plan-features-list">
                  @php
                    $json = json_decode($plan->features, true);
                    $features = is_array($json) ? $json : array_filter(array_map('trim', explode(',', (string)$plan->features)));
                  @endphp
                  @forelse($features as $feature)
                    <li>
                      <span class="check-icon">✓</span>
                      <span>{{ $feature }}</span>
                    </li>
                  @empty
                    <li style="color: #64748b; font-style: italic;">Ek özellik belirtilmemiş.</li>
                  @endforelse
                </ul>
              </div>

              <div class="plan-card-footer">
                <span style="font-size: 0.78rem; color: #64748b;">
                  Aktif Kayıt: <strong style="color: #cbd5e1;">{{ $plan->subscriptions_count }}</strong>
                </span>
                <a href="{{ route('admin.plans.edit', $plan) }}" class="btn-edit-plan">
                  <span>Düzenle</span>
                  <span>→</span>
                </a>
              </div>
            </div>
          @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted); background: var(--bg-card); border-radius: 18px; border: 1px dashed var(--border-subtle);">
              Henüz tanımlanmış bir plan bulunamadı.
            </div>
          @endforelse
        </div>
      </main>
    </div>
  </div>
</div>