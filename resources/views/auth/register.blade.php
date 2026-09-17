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
        <a href="{{ route('login') }}">Giriş yap</a>
        <a href="{{ route('register') }}" class="active">Kayıt ol</a>
      </div>

      <form method="POST" action="{{ route('register-process') }}">
        @csrf
        <div class="field">
          <label for="name">Ad soyad</label>
          <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Ada Yılmaz" autocomplete="name" required>
        </div>
        <div class="field">
          <label for="email">E-posta</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="ad@sirket.com" autocomplete="email" required>
        </div>
        <div class="field">
          <label for="password">Şifre</label>
          <input id="password" type="password" name="password" placeholder="En az 8 karakter" autocomplete="new-password" required>
        </div>
        <div class="field">
          <label for="password_confirmation">Şifre (tekrar)</label>
          <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" autocomplete="new-password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Hesap oluştur</button>
      </form>

      <p class="auth-alt">
        Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş yapın</a>
      </p>
    </div>
  </div>
</div>
@endsection