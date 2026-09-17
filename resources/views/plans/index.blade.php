@extends('layouts.app')

@section('content')
<section style="padding-top:56px;">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title">Planlar</h2>
      <p class="section-note">Aylık faturalandırma, istediğiniz an iptal edebilirsiniz.</p>
    </div>
    
    <div class="plans-grid">
      @foreach($plans as $plan)
        <div class="plan-card">
          <h3 class="plan-name">{{ $plan->name }}</h3>
          <p class="plan-price">{{ $plan->price }} ₺</p>
          <p class="plan-desc">{{ $plan->description }}</p>
          <ul class="plan-features">
          
          @php
              $json = json_decode($plan->features, true);
              $features = is_array($json) ? $json : explode(',', $plan->features);
          @endphp
          @foreach($features as $feature)
            <li><span class="check">✔</span> {{ $feature }}</li>
          @endforeach
          </ul>
          @if(!Auth::check())
            <a href="{{ route('register') }}" class="btn btn-primary btn-block disabled">Bu planı seç</a>
          @elseif($plan->slug === Auth::user()->load('subscription.plan')->subscription->plan->slug)
            <button type="button" class="btn btn-ghost btn-block" disabled>Bu planı kullanıyorsunuz</button>
          @else
            <form action="{{ route('change-plan') }}" method="POST">
              @csrf
              <input type="hidden" name="plan" value="free">
              <button type="submit" class="btn btn-primary btn-block disabled">Bu plana geç</button>
            </form>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
