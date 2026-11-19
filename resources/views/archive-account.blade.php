@php
  $usedMB = (float) Auth::user()->storageUsedValue();
  $rawLimit = (string) (Auth::user()->plan?->storageLimit() ?? Auth::user()->plan?->storage_limit ?? '0');
  preg_match('/([\d.]+)\s*([a-zA-Z]*)/', $rawLimit, $matches);
  $limitVal = isset($matches[1]) ? (float) $matches[1] : 0;
  $limitUnit = isset($matches[2]) ? strtoupper(trim($matches[2])) : 'MB';
  $storageLimitMB = ($limitUnit === 'GB') ? ($limitVal * 1024) : $limitVal;
  $storagePct = $storageLimitMB > 0 ? min(round(($usedMB / $storageLimitMB) * 100), 100) : 0;

  $usedProj = (int) Auth::user()->projectUsedValue();
  $projLimit = (int) (Auth::user()->plan?->projectLimit() ?? Auth::user()->plan?->project_limit ?? 0);
  $projPct = $projLimit > 0 ? min(round(($usedProj / $projLimit) * 100), 100) : 0;
@endphp
<section class="ax" data-sc-act="flow" data-sc-drift="#1d1a21" aria-labelledby="ax-title">
  <div class="ax-inner">
    <div class="ax-head" data-sc-in data-sc-stagger="70">
      <h2 id="ax-title" class="ax-title">Hesabına <em>bir bakış.</em></h2>
      <p>
        {{ Auth::user()->plan?->name ?? 'Plan yok' }} ·
        @if(Auth::user()->plan?->is_default)
          Varsayılan plan
        @elseif(Auth::user()->subscription?->ends_at)
          {{ Auth::user()->subscription->ends_at->translatedFormat('d F Y') }} tarihinde yenilenir
        @else
          Süresiz
        @endif
      </p>
    </div>
    <div class="ax-figures" data-sc-in data-sc-stagger="90">
      <div class="ax-figure">
        <span class="ax-label">Depolama</span>
        <p class="ax-num"><span data-tick>{{ $usedMB }}</span> <small>/ {{ $storageLimitMB }} MB</small></p>
        <div class="track-bar"><div class="fill-bar" style="--bar-fill: {{ $storagePct }}%;"></div></div>
      </div>
      <div class="ax-figure">
        <span class="ax-label">Aktif proje</span>
        <p class="ax-num"><span data-tick>{{ $usedProj }}</span> <small>/ {{ $projLimit > 0 ? $projLimit : 'Sınırsız' }}</small></p>
        <div class="track-bar"><div class="fill-bar" style="--bar-fill: {{ $projPct }}%;"></div></div>
      </div>
    </div>
  </div>
</section>
