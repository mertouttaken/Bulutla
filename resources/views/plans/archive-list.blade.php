@php
    $current = auth()->user()?->subscription?->plan?->id;
@endphp
<div class="plan-shelf">
@forelse($plans as $plan)
  @php
    $raw = $plan->features;
    $features = is_array($raw) ? $raw : (json_decode((string)$raw, true) ?? explode(',', (string)$raw));
  @endphp
  <article class="rx-card {{ $current === $plan->id ? 'is-current' : '' }}" data-sc-tilt="5">
    <div class="rx-card__tab">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }} · {{ strtoupper($plan->slug) }}</div>
    <h3>{{ $plan->name }}</h3>
    @if($current === $plan->id)<p class="rx-flag">Mevcut plan</p>
    @elseif(($mostPopularPlan ?? null)?->id === $plan->id)<p class="rx-flag">En çok tercih edilen</p>@endif
    @if($plan->description)<p class="rx-desc">{{ $plan->description }}</p>@endif
    <dl class="rx-spec">
      <div><dt>Fiyat</dt><dd>{{ $plan->price > 0 ? $plan->price.' ₺ / ay' : 'Ücretsiz' }}</dd></div>
      <div><dt>Depolama</dt><dd>{{ $plan->storage_limit ?? '-' }}</dd></div>
      <div><dt>Proje</dt><dd>{{ ($plan->project_limit && $plan->project_limit > 0) ? $plan->project_limit : 'Sınırsız' }}</dd></div>
    </dl>
    <ul>@foreach((array)$features as $feature) @if(is_string($feature) && trim($feature) !== '')<li>{{ trim($feature) }}</li>@endif @endforeach</ul>
    @guest
      <a href="{{ route('register') }}">Bu planla başla ↗</a>
    @else
      @if($current === $plan->id)
        <a href="{{ route('subscriptions.show') }}">Aboneliğimi gör ↗</a>
      @elseif($allowChange ?? false)
        <form method="POST" action="{{ route('change-plan') }}">@csrf<input type="hidden" name="plan" value="{{ $plan->slug }}"><button type="submit">Bu plana geç ↗</button></form>
      @else
        <a href="{{ route('plans.index') }}">Planı incele ↗</a>
      @endif
    @endguest
  </article>
@empty
  <p>Şu anda listelenecek plan bulunmuyor.</p>
@endforelse
</div>
