<div class="auth-page">
  <div class="auth-shell">
    <figure class="auth-exhibit" aria-hidden="true">
      <div class="auth-stage" data-depth>
        <div class="archive-folder">
          <div class="folder-back"></div>
          <div class="sheet sheet-notes"><small>MD · GİRİŞ NOTU</small><b>Tekrar</b><p>Projelerin seni<br>bıraktığın yerde bekliyor.</p><i></i><i></i><strong>hosgeldin.md</strong></div>
          <div class="sheet sheet-colour"><small>ASE · PALET</small><div></div><strong>arsiv-palet.ase</strong></div>
          <div class="sheet sheet-map"><small>PDF · PAFTA</small><div></div><b>Son teslim</b><strong>teslim-v3.pdf</strong></div>
          <div class="folder-front"><div class="folder-rule"><span>BULUTLA</span><span>GİRİŞ / 01</span></div><strong>Arşiv.</strong><div class="folder-label"><span>Kişisel arşiv</span><i></i></div></div>
        </div>
      </div>
      <figcaption>"Abonelik takibini ve dosya kotasını artık tablolarda değil, tek ekranda yapıyoruz." <span>Bulutla kullanıcısı</span></figcaption>
    </figure>

    <div class="auth-panel">
      <p class="desk-kicker">ARŞİVE DÖNÜŞ</p>
      <h1 class="motion-title">Tekrar <em>hoş geldin.</em></h1>

      <nav class="auth-tabs" aria-label="Hesap">
        <a href="{{ route('login') }}" class="active" aria-current="page">Giriş yap</a>
        <a href="{{ route('register') }}">Kayıt ol</a>
      </nav>

      @if (session()->has('error'))
        <div class="archive-alert is-error" role="alert">{{ session('error') }}</div>
      @endif

      <form wire:submit="submit" class="archive-form">
        <div class="field">
          <label for="email">E-posta</label>
          <input id="email" type="email" wire:model="email" placeholder="ad@sirket.com" autocomplete="email">
          @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
          <label for="password">Şifre</label>
          <input id="password" type="password" wire:model="password" placeholder="••••••••" autocomplete="current-password">
          @error('password') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="field-row">
          <label class="check">
            <input type="checkbox" wire:model="remember">
            <span>Beni hatırla</span>
          </label>
          <a href="#" class="text-link">Şifremi unuttum</a>
        </div>

        <button type="submit" class="archive-primary archive-submit" wire:loading.attr="disabled">
          <span wire:loading.remove wire:target="submit">Giriş yap <span aria-hidden="true">↗</span></span>
          <span wire:loading wire:target="submit">Giriş yapılıyor…</span>
        </button>
      </form>

      <p class="auth-foot">Hesabın yok mu? <a href="{{ route('register') }}">Kayıt ol</a></p>
    </div>
  </div>
</div>
