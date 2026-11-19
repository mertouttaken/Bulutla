@extends('layouts.app')
@section('content')
@php
  // Loose files on the desk. x/y are the scatter offsets from the folder mouth
  // (vw / vh), r is the resting tilt. The order is the filing order.
  $loose = [
    ['rodos-son-v7.pdf',      'PDF', -38, -30, -11],
    ['palet-FINAL2.ase',      'ASE',  34, -34,   8],
    ['notlar (1).md',         'MD',  -24, -42,   5],
    ['cephe-render.png',      'PNG',  40,  -8,  -6],
    ['teklif_rev.docx',       'DOC', -44,   2,   9],
    ['arazi-etudu.dwg',       'DWG',  20, -46, -14],
    ['butce.xlsx',            'XLS', -12, -20,  12],
    ['IMG_4402.jpg',          'JPG',  28, -22,  -3],
    ['sunum-yeni.key',        'KEY', -34, -14,  -8],
    ['malzeme-listesi.csv',   'CSV',  44, -38,   4],
    ['kroki.svg',             'SVG',   4, -48,  -9],
    ['teslim-gercek-son.zip', 'ZIP', -48, -40,   7],
  ];
  $fileCount = count($loose);
  $planCount = count($plans);
  $current = auth()->user()?->subscription?->plan?->id;
@endphp

<div class="bx">

  {{-- 1 HERO: layered planes, the headline sits between the folder's back and its sheets --}}
  <section class="hx" data-sc-act="pin" data-sc-span="2.4" data-sc-drift="#161518" aria-labelledby="hx-title">
    <div class="hx-stage" data-sc-stage data-hx-pointer>
      <div class="hx-wall" aria-hidden="true"></div>
      <div class="hx-light" aria-hidden="true"></div>
      <p class="hx-ghost" aria-hidden="true">Arşiv</p>

      <div class="hx-plane hx-back" aria-hidden="true"><div class="hx-back__body"></div></div>

      <h1 id="hx-title" class="hx-title" data-sc-cue="0 1 0 0.25">Her dosya<br><em>yerinde.</em></h1>

      <div class="hx-plane hx-sheets" aria-hidden="true">
        <div class="hx-sheet hx-sheet--map"><small>PDF · ÇİZİM PAFTASI</small><div class="hx-map"></div><b>Arazi etüdü</b><strong>arazi-etudu.pdf</strong></div>
        <div class="hx-sheet hx-sheet--colour"><small>ASE · RENK KATALOĞU</small><div class="hx-swatch"></div><strong>rodos-palet.ase</strong></div>
        <div class="hx-sheet hx-sheet--notes"><small>MD · PROJE NOTLARI</small><b>Rodos</b><p>Malzeme çalışması.<br>Renk ve doku notları.</p><i></i><i></i><strong>proje-notlari.md</strong></div>
      </div>

      <div class="hx-plane hx-front" aria-hidden="true">
        <div class="hx-front__body">
          <div class="folder-rule"><span>BULUTLA</span><span>PROJE / 01</span></div>
          <strong>Rodos.</strong>
          <div class="folder-label"><span>Proje arşivi</span><i></i></div>
        </div>
      </div>


      <div class="hx-copy">
        <p class="hx-lede" data-sc-cue="0 0.5 0 0.3">Çizimler, belgeler, son teslimler. Projene ait her şey tek klasörde, kullandığın alan tek bakışta.</p>
        <p class="hx-lede hx-lede--2" data-sc-cue="0.46 1 0.2 0.25">Klasörü açtığında dosyan orada. Hangi sürüm olduğunu düşünmeden.</p>
        <div class="hx-actions" data-sc-cue="0 1 0 0.2">
          @auth
            <a class="archive-primary" href="{{ route('dashboard') }}">Panelime git <span aria-hidden="true">↗</span></a>
            <a class="hx-link" href="{{ route('subscriptions.show') }}">Planımı yönet</a>
          @else
            <a class="archive-primary" href="{{ route('register') }}">Ücretsiz başla <span aria-hidden="true">↗</span></a>
            <a class="hx-link" href="{{ route('plans.index') }}">Planları incele</a>
          @endauth
        </div>
      </div>
    </div>
  </section>

  {{-- 2 TENSION: the desk as it really is --}}
  <section class="tx" data-sc-act="flow" data-sc-drift="#1b1820" aria-labelledby="tx-title">
    <div class="tx-grid">
      <div class="tx-copy" data-sc-in data-sc-stagger="70">
        <h2 id="tx-title" class="tx-title">Bugün dosyaların <em>neredeydi?</em></h2>
        <p>Çizim masaüstünde.</p>
        <p>Son sürüm bir e-postanın ekinde.</p>
        <p>Palet, kimsenin bulamadığı bir USB'de.</p>
      </div>
      <div class="tx-desk" data-sc-reveal="left" data-sc-reveal-at="0.04 0.24" aria-hidden="true">
        @foreach($loose as $i => [$name, $ext, $x, $y, $r])
          @if($i < 9)
          <span class="tx-file" style="--i:{{ $i }};--r:{{ $r }}deg"><small>{{ $ext }}</small>{{ $name }}</span>
          @endif
        @endforeach
      </div>
    </div>
  </section>

  {{-- 3 PEAK, the signature move: scroll files every loose file into one folder --}}
  <section class="px" data-sc-act="pin" data-sc-span="3.4" data-sc-drift="#221f24" data-filing data-filing-total="{{ $fileCount }}" aria-labelledby="px-title">
    <div class="px-stage" data-sc-stage>
      <h2 id="px-title" class="px-title" data-sc-cue="0 0.62 0 0.2">Tek tek, <em>klasörüne.</em></h2>
      <h2 class="px-title px-title--end" data-sc-cue="0.66 1 0.14 0.12" data-sc-kinetic="lines">Bir proje. Bir klasör. <em>Hepsi yerinde.</em></h2>

      <div class="px-folder" aria-hidden="true">
        <div class="px-back"></div>
        <div class="px-stack"></div>
        <div class="px-files">
          @foreach($loose as $i => [$name, $ext, $x, $y, $r])
            <span class="px-file" style="--x0:{{ $x }}vw;--y0:{{ $y }}vh;--r0:{{ $r }}deg;--s:{{ number_format(0.08 + $i * 0.046, 3, '.', '') }}"><small>{{ $ext }}</small>{{ $name }}</span>
          @endforeach
        </div>
        <div class="px-front">
          <div class="folder-rule"><span>BULUTLA</span><span>PROJE / 01</span></div>
          <strong>Rodos.</strong>
          <div class="folder-label"><span data-filing-count>0 / {{ $fileCount }} dosya</span><i></i></div>
        </div>
        <span class="px-stamp">Arşivlendi</span>
      </div>
      <p class="px-caption" data-sc-cue="0.66 1 0.14 0.12">Rodos · {{ $fileCount }} dosya · tek yerde</p>
    </div>
  </section>

  {{-- 4 RANGE: plans travel past like shelves in a plan chest --}}
  <section class="rx" data-sc-act="pan" data-sc-span="{{ number_format(max(2.2, $planCount * 0.45 + 1.3), 2, '.', '') }}" data-sc-drift="#19171b" aria-labelledby="rx-title">
    <div class="rx-stage" data-sc-stage>
      <div class="rx-rail" data-sc-pan="0.06">
        <header class="rx-head">
          <h2 id="rx-title" class="rx-title">Projelerine <em>yer aç.</em></h2>
          <p>Her plan aynı arşiv. Sadece raf genişler.</p>
        </header>
        @forelse($plans as $plan)
          @php
            $raw = $plan->features;
            $features = is_array($raw) ? $raw : (json_decode((string) $raw, true) ?? explode(',', (string) $raw));
          @endphp
          <article class="rx-card" data-sc-tilt="6">
            <div class="rx-card__tab">{{ str_pad((string) ($loop->iteration), 2, '0', STR_PAD_LEFT) }} · {{ strtoupper($plan->slug) }}</div>
            <h3>{{ $plan->name }}</h3>
            @if($current === $plan->id)<p class="rx-flag">Mevcut plan</p>
            @elseif(($mostPopularPlan ?? null)?->id === $plan->id)<p class="rx-flag">En çok tercih edilen</p>@endif
            <dl class="rx-spec">
              <div><dt>Fiyat</dt><dd>{{ $plan->price > 0 ? $plan->price.' ₺ / ay' : 'Ücretsiz' }}</dd></div>
              <div><dt>Depolama</dt><dd>{{ $plan->storage_limit ?? '-' }}</dd></div>
              <div><dt>Proje</dt><dd>{{ ($plan->project_limit && $plan->project_limit > 0) ? $plan->project_limit : 'Sınırsız' }}</dd></div>
            </dl>
            <ul>@foreach((array) $features as $feature) @if(is_string($feature) && trim($feature) !== '')<li>{{ trim($feature) }}</li>@endif @endforeach</ul>
            @guest
              <a href="{{ route('register') }}">Bu planla başla ↗</a>
            @else
              @if($current === $plan->id)
                <a href="{{ route('subscriptions.show') }}">Aboneliğimi gör ↗</a>
              @else
                <a href="{{ route('plans.index') }}">Planı incele ↗</a>
              @endif
            @endguest
          </article>
        @empty
          <article class="rx-card"><h3>Plan yok</h3><p>Şu anda listelenecek plan bulunmuyor.</p></article>
        @endforelse
        <p class="rx-note">Planını istediğin zaman değiştir. Dosyaların klasöründe kalır.</p>
      </div>
    </div>
  </section>

  @auth
    @include('archive-account')
  @endauth

  {{-- 6 CLOSE --}}
  <section class="cx" data-sc-act="flow" data-sc-drift="#141316" data-sc-spotlight aria-labelledby="cx-title">
    <div class="cx-inner" data-sc-in data-sc-stagger="80">
      <div class="cx-folder" aria-hidden="true"><span>Klasörün</span><b>Hazır.</b></div>
      <h2 id="cx-title" class="cx-title">Klasörün <em>hazır.</em></h2>
      <p>İlk projeni aç, ilk dosyanı bırak. Gerisini arşiv halleder.</p>
      @auth
        <a class="archive-primary" href="{{ route('projects.show') }}">Projelerime git <span aria-hidden="true">↗</span></a>
      @else
        <a class="archive-primary" href="{{ route('register') }}">Ücretsiz başla <span aria-hidden="true">↗</span></a>
      @endauth
    </div>
  </section>
</div>

@push('scripts')
<script src="{{ asset('home-archive.js') }}?v={{ filemtime(public_path('home-archive.js')) }}"></script>
@endpush
@endsection
