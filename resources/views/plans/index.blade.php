@extends('layouts.app')
@section('content')
<section class="plans-page" aria-labelledby="plans-title">
  <header class="plans-page__head">
    <div>
      <p class="desk-kicker">PLANLAR</p>
      <h1 id="plans-title" class="motion-title">Projelerine <em>yer aç.</em></h1>
    </div>
    <p>Depolama alanını ve proje limitlerini karşılaştır. Planını istediğin zaman değiştir, dosyaların klasöründe kalır.</p>
  </header>
  @if(session('success'))<div class="archive-alert plans-alert" role="status">{{ session('success') }}</div>@endif
  @if(session('error'))<div class="archive-alert is-error plans-alert" role="alert">{{ session('error') }}</div>@endif
  @error('plan_id')<div class="archive-alert is-error plans-alert" role="alert">{{ $message }}</div>@enderror
  @include('plans.archive-list', ['allowChange' => true])
</section>
@endsection
