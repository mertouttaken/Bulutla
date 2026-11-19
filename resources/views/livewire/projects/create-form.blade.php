<div class="create-project-container">

  <div class="create-header">
    <div class="header-left">
      <a href="{{ route('projects.show') }}" class="back-btn" title="Geri Dön">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </a>
      <div class="header-info">
        <p class="desk-kicker">KİŞİSEL ARŞİV / YENİ KLASÖR</p>
        <h1 class="motion-title">Yeni <em>proje.</em></h1>
        <p>Haritalar, eklentiler veya konfigürasyon paketleri için alan oluştur.</p>
      </div>
    </div>
  </div>

  <div class="create-card" data-sc-spotlight>
    <form wire:submit="save">
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label" for="name">
            Proje Adı
            <span class="label-hint">Maks. 255 karakter</span>
          </label>
          <input type="text" id="name" wire:model="name" placeholder="Örn: Skyblock PVP Paketi" class="form-control">
          @error('name') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="form-label">
            Proje Türü
            <span class="label-hint">Dosya hiyerarşisi ve etiket için</span>
          </label>
          <div class="category-picker">
            <label class="category-option">
              <input type="radio" wire:model="type" value="plugin">
              <div class="category-box">
                <span class="category-title"><i>JAR</i> Eklenti (Plugin)</span>
                <span class="category-desc">Spigot, Paper veya Script jar dosyaları.</span>
              </div>
            </label>

            <label class="category-option">
              <input type="radio" wire:model="type" value="map">
              <div class="category-box">
                <span class="category-title"><i>MAP</i> Harita / Dünya</span>
                <span class="category-desc">Özel yapılmış haritalar, şematikler ve spawnlar.</span>
              </div>
            </label>

            <label class="category-option">
              <input type="radio" wire:model="type" value="modpack">
              <div class="category-box">
                <span class="category-title"><i>PACK</i> Mod Paketi</span>
                <span class="category-desc">Forge, Fabric client ve sunucu paketleri.</span>
              </div>
            </label>

            <label class="category-option">
              <input type="radio" wire:model="type" value="config">
              <div class="category-box">
                <span class="category-title"><i>CFG</i> Yapılandırma</span>
                <span class="category-desc">YML, JSON veya optimize edilmiş ayar dosyaları.</span>
              </div>
            </label>
          </div>
          @error('type') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="description">
            Açıklama & Notlar
            <span class="label-hint">İsteğe Bağlı</span>
          </label>
          <textarea id="description" wire:model="description" rows="4" placeholder="Bu projenin amacı, kullanılan oyun sürümü veya sürüm notları..." class="form-control"></textarea>
          @error('description') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
          <a href="{{ route('projects.show') }}" class="btn-cta-secondary">Vazgeç</a>
          <button type="submit" class="btn-cta-primary" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="save">+ Projeyi Başlat</span>
            <span wire:loading wire:target="save">Başlatılıyor...</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>