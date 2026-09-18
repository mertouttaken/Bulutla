@extends('layouts.app')

@section('content')
<style>
  @keyframes slideRightAnimation {
    0% {
      transform: translateX(50px);
      opacity: 0;
    }
    100% {
      transform: translateX(0);
      opacity: 1;
    }
  }

  .register-page {
    min-height: 85vh;
    padding: 60px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0b0c16 radial-gradient(circle at 50% 15%, rgba(139, 30, 196, 0.18) 0%, transparent 60%);
    box-sizing: border-box;
    font-family: inherit;
    color: #e2e8f0;
  }

  .register-box {
    width: 100%;
    max-width: 960px;
    display: flex;
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 24px;
    box-shadow: 0 20px 48px rgba(0, 0, 0, 0.45);
    overflow: hidden;
    animation: slideRightAnimation 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    will-change: transform, opacity;
  }

  @media (max-width: 860px) {
    .register-box {
      flex-direction: column;
      max-width: 480px;
    }
    .register-visual {
      display: none;
    }
  }

  .register-visual {
    flex: 1 1 45%;
    background: linear-gradient(180deg, rgba(95, 21, 135, 0.25) 0%, #0d0e1b 100%);
    border-right: 1px solid rgba(255, 255, 255, 0.06);
    padding: 48px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .brand-pill {
    display: inline-block;
    background: rgba(139, 30, 196, 0.2);
    border: 1px solid rgba(192, 132, 252, 0.35);
    color: #c084fc;
    font-size: 0.82rem;
    padding: 4px 14px;
    border-radius: 999px;
    font-weight: 600;
    align-self: flex-start;
  }

  .quote-content {
    margin: auto 0;
  }

  .quote-text {
    font-size: 1.35rem;
    font-weight: 600;
    line-height: 1.45;
    color: #ffffff;
    margin: 0 0 14px 0;
  }

  .quote-author {
    font-size: 0.85rem;
    color: #94a3b8;
    margin: 0;
  }

  .register-form-wrap {
    flex: 1 1 55%;
    padding: 48px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    box-sizing: border-box;
  }

  .tab-switch {
    display: flex !important;
    flex-direction: row !important;
    width: 100% !important;
    background: #17182e;
    padding: 4px;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.06);
    margin-bottom: 28px;
    box-sizing: border-box;
  }

  .tab-switch a {
    flex: 1 1 50% !important;
    text-align: center;
    padding: 10px 0;
    font-size: 0.88rem;
    font-weight: 600;
    text-decoration: none;
    color: #94a3b8;
    border-radius: 9px;
    transition: all 0.2s ease;
    white-space: nowrap !important;
    display: inline-block;
  }

  .tab-switch a:hover {
    color: #ffffff;
  }

  .tab-switch a.active {
    background: linear-gradient(135deg, #5f1587, #8b1ec4);
    color: #ffffff;
    box-shadow: 0 2px 10px rgba(139, 30, 196, 0.35);
  }

  .form-group-list {
    display: flex;
    flex-direction: column;
    gap: 18px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
  }

  .form-group label {
    font-size: 0.82rem;
    font-weight: 600;
    color: #cbd5e1;
  }

  .form-group input {
    width: 100%;
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 0.9rem;
    color: #ffffff;
    outline: none;
    transition: all 0.2s ease;
    box-sizing: border-box;
  }

  .form-group input:focus {
    border-color: #c084fc;
    box-shadow: 0 0 0 3px rgba(192, 132, 252, 0.15);
    background: #1b1d36;
  }

  .form-group input::placeholder {
    color: #64748b;
  }

  .btn-create {
    width: 100%;
    background: linear-gradient(135deg, #5f1587, #8b1ec4);
    border: none;
    color: #ffffff;
    padding: 13px;
    border-radius: 12px;
    font-size: 0.92rem;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(139, 30, 196, 0.35);
    transition: all 0.2s ease;
    margin-top: 6px;
  }

  .btn-create:hover {
    transform: translateY(-2px);
    opacity: 0.95;
  }

  .bottom-text {
    margin: 20px 0 0 0;
    font-size: 0.85rem;
    color: #94a3b8;
    text-align: center;
  }

  .bottom-text a {
    color: #c084fc;
    text-decoration: none;
    font-weight: 600;
  }

  .bottom-text a:hover {
    text-decoration: underline;
  }
</style>

<div class="register-page">
  <div class="register-box">
    <div class="register-visual">
      <span class="brand-pill">Bulutla</span>
      <div class="quote-content">
        <p class="quote-text">"Dosyaları ve kotaları tek ekrandan yönetmek ekibin işini inanılmaz hızlandırdı."</p>
        <p class="quote-author">— Bulutla Kullanıcı Yorumu</p>
      </div>
      <div></div>
    </div>

    <div class="register-form-wrap">
      <div class="tab-switch">
        <a href="{{ route('login') }}">Giriş Yap</a>
        <a href="{{ route('register') }}" class="active">Kayıt Ol</a>
      </div>

      <form method="POST" action="{{ route('register-process') }}" class="form-group-list">
        @csrf
        <div class="form-group">
          <label for="name">Ad Soyad</label>
          <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Ad Soyad" autocomplete="name" required>
        </div>

        <div class="field form-group">
          <label for="email">E-posta</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="ad@sirket.com" autocomplete="email" required>
        </div>

        <div class="form-group">
          <label for="password">Şifre</label>
          <input id="password" type="password" name="password" placeholder="En az 8 karakter" autocomplete="new-password" required>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Şifre Tekrar</label>
          <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" autocomplete="new-password" required>
        </div>

        <button type="submit" class="btn-create">Hesap Oluştur</button>
      </form>

      <p class="bottom-text">
        Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş yapın</a>
      </p>
    </div>
  </div>
</div>
@endsection