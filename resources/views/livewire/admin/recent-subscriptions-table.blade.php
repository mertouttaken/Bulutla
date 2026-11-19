<div>

  <div class="panel-card">
    <div class="panel-header">
      <h3>
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                      <strong style=" font-size: 0.88rem;">{{ $sub->user?->name ?? 'Kullanıcı' }}</strong>
                      <span style="font-size: 0.78rem;">{{ $sub->user?->email ?? 'Bilinmiyor' }}</span>
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
                <td style=" font-size: 0.82rem;">
                  {{ $sub->created_at ? $sub->created_at->translatedFormat('d F Y') : '-' }}
                </td>
                <td style=" font-size: 0.82rem;">
                  {{ $sub->created_at ? $sub->created_at->addMonth()->translatedFormat('d F Y') : '-' }}
                </td>
              </tr>
            @endif
          @empty
            <tr>
              <td colspan="5" style="text-align: center; padding: 36px;">
                Henüz aktif bir abonelik hareketi bulunmuyor.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>