@extends('layouts.app')

@section('content')
<div class="auth-shell">
  <div class="auth-visual">
    <p class="eyebrow-label" style="color:var(--ink-muted);">Planla</p>
    <p class="quote">"Abonelik takibini artık tabloda değil, üründe yapıyoruz."</p>
    <p class="who">— Deneme kullanıcısı geri bildirimi</p>
  </div>
  <div class="auth-form-side">
    <div class="auth-box">
      <div class="auth-tabs">
        <a href="{{ route('login') }}" class="active">Giriş yap</a>
        <a href="{{ route('register') }}">Kayıt ol</a>
      </div>

      <form method="POST" action="{{ route('login-process') }}">
        @csrf
        <div class="field">
          <label for="email">E-posta</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="ad@sirket.com" autocomplete="email" required>
        </div>
        <div class="field">
          <label for="password">Şifre</label>
          <input id="password" type="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
        </div>
        <div class="field-row">
          <label style="display:flex; align-items:center; gap:8px; color:var(--ink-muted);">
            <input type="checkbox" name="remember" style="width:auto;"> Beni hatırla
          </label>
          <a href="#">Şifremi unuttum</a>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Giriş yap</button>
      </form>

      <p class="auth-alt">
        Hesabınız yok mu? <a href="{{ route('register') }}">Kayıt olun</a>
      </p>
    </div>
  </div>
</div>
@endsection