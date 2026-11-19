<div>

  <div class="admin-layout">
    <aside class="admin-sidebar">
      <a href="{{ route('home') }}" class="sidebar-brand">
        <span class="dot"></span>
        <h2>Bulutla</h2><small>YÖNETİM ARŞİVİ</small>
      </a>
      <nav class="sidebar-nav">
        <ul>
          <li><a href="{{ route('admin.index') }}"><i>01</i> Genel bakış</a></li>
          <li>
            <a href="#" class="active"><i>02</i> Planlar</a>
            <ul class="submenu">
              <li><a href="{{ route('admin.plans.index') }}" class="sub-active">Plan listesi</a></li>
              <li><a href="{{ route('admin.plans.actions') }}">Hızlı işlemler</a></li>
            </ul>
          </li>
          <li><a href="{{ route('admin.subscriptions.index') }}"><i>03</i> Abonelikler</a></li>
          <li><a href="{{ route('admin.users.index') }}"><i>04</i> Kullanıcılar</a></li>
        </ul>
      </nav>
    </aside>

    <div class="admin-main">
      <header class="admin-topbar">
        <div class="topbar-title">
        <p class="desk-kicker">YÖNETİM</p>
        <h1 class="motion-title">Mevcut Plan Listesi</h1>
        </div>
        <div class="topbar-user">
          <span>{{ Auth::user()->name ?? 'Yönetici' }}</span>
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
            <div data-sc-tilt="5" class="plan-card {{ $plan->is_default ? 'is-default' : '' }}">
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
                    <li style=" font-style: italic;">Ek özellik belirtilmemiş.</li>
                  @endforelse
                </ul>
              </div>

              <div class="plan-card-footer">
                <span style="font-size: 0.78rem;">
                  Aktif Kayıt: <strong>{{ $plan->subscriptions_count }}</strong>
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