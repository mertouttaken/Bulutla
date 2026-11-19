<div class="auth-page">
  <div class="auth-shell">
    <figure class="auth-exhibit" aria-hidden="true">
      <div class="auth-stage" data-depth>
        <div class="archive-folder">
          <div class="folder-back"></div>
          <div class="sheet sheet-notes"><small>MD · İLK NOT</small><b>Başlangıç</b><p>İlk projeni aç,<br>dosyalarını yerleştir.</p><i></i><i></i><strong>ilk-proje.md</strong></div>
          <div class="sheet sheet-colour"><small>ASE · PALET</small><div></div><strong>yeni-palet.ase</strong></div>
          <div class="sheet sheet-map"><small>PDF · PAFTA</small><div></div><b>Taslak</b><strong>taslak-01.pdf</strong></div>
          <div class="folder-front"><div class="folder-rule"><span>BULUTLA</span><span>YENİ / 00</span></div><strong>Senin.</strong><div class="folder-label"><span>Boş klasör</span><i></i></div></div>
        </div>
      </div>
      <figcaption>"Dosyaları ve kotaları tek ekrandan yönetmek ekibin işini inanılmaz hızlandırdı." <span>Bulutla kullanıcısı</span></figcaption>
    </figure>

    <div class="auth-panel">
      <p class="desk-kicker">YENİ ARŞİV</p>
      <h1 class="motion-title">Klasörünü <em>aç.</em></h1>

      <nav class="auth-tabs" aria-label="Hesap">
        <a href="{{ route('login') }}">Giriş yap</a>
        <a href="{{ route('register') }}" class="active" aria-current="page">Kayıt ol</a>
      </nav>

      <form wire:submit="submit" class="archive-form">
        <div class="field">
          <label for="name">Ad Soyad</label>
          <input id="name" type="text" wire:model="name" placeholder="Ad Soyad" autocomplete="name">
          @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
          <label for="email">E-posta</label>
          <input id="email" type="email" wire:model="email" placeholder="ad@sirket.com" autocomplete="email">
          @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="field-pair">
          <div class="field">
            <label for="password">Şifre</label>
            <input id="password" type="password" wire:model="password" placeholder="En az 6 karakter" autocomplete="new-password">
            @error('password') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          <div class="field">
            <label for="password_confirmation">Şifre tekrar</label>
            <input id="password_confirmation" type="password" wire:model="password_confirmation" placeholder="••••••••" autocomplete="new-password">
          </div>
        </div>

        <button type="submit" class="archive-primary archive-submit" wire:loading.attr="disabled">
          <span wire:loading.remove wire:target="submit">Hesap oluştur <span aria-hidden="true">↗</span></span>
          <span wire:loading wire:target="submit">Hesap oluşturuluyor…</span>
        </button>
      </form>

      <p class="auth-foot">Zaten hesabın var mı? <a href="{{ route('login') }}">Giriş yap</a></p>
    </div>
  </div>
</div>
