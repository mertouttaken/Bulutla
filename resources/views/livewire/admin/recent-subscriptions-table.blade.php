<div>
  <style>
    .panel-card {
      background: rgba(17, 18, 34, 0.85);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.07);
      border-radius: 22px;
      padding: 28px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
      position: relative;
      overflow: hidden;
      margin-top: 28px;
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
      border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    }

    .panel-header h3 {
      font-size: 1.12rem;
      font-weight: 700;
      margin: 0;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .table-responsive {
      overflow-x: auto;
      width: 100%;
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
      border-bottom: 1px solid rgba(255, 255, 255, 0.07);
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
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: rgba(139, 30, 196, 0.2);
      border: 1px solid rgba(192, 132, 252, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 0.85rem;
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

  <div class="panel-card">
    <div class="panel-header">
      <h3>
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #c084fc;">
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
                      <span style="font-size: 0.78rem; color: #8f9bba;">{{ $sub->user?->email ?? 'Bilinmiyor' }}</span>
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
                <td style="color: #8f9bba; font-size: 0.82rem;">
                  {{ $sub->created_at ? $sub->created_at->translatedFormat('d F Y') : '-' }}
                </td>
                <td style="color: #8f9bba; font-size: 0.82rem;">
                  {{ $sub->created_at ? $sub->created_at->addMonth()->translatedFormat('d F Y') : '-' }}
                </td>
              </tr>
            @endif
          @empty
            <tr>
              <td colspan="5" style="text-align: center; color: #64748b; padding: 36px;">
                Henüz aktif bir abonelik hareketi bulunmuyor.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>