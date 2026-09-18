@extends('layouts.app')

@section('content')
<style>
  .create-project-container {
    max-width: 860px;
    margin: 0 auto;
    padding: 40px 24px;
    color: #e2e8f0;
    display: flex;
    flex-direction: column;
    gap: 32px;
  }

  .create-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    padding-bottom: 24px;
  }

  .header-left {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .back-btn {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9d9bb8;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .back-btn:hover {
    color: #ffffff;
    border-color: rgba(139, 30, 196, 0.45);
    background: #17182e;
  }

  .create-header h1 {
    font-size: 1.6rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 4px 0;
    letter-spacing: -0.02em;
  }

  .create-header p {
    margin: 0;
    font-size: 0.88rem;
    color: #9d9bb8;
  }

  .create-card {
    background: #111222;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
  }

  .create-card::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(139, 30, 196, 0.4), transparent);
  }

  .form-grid {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .form-label {
    font-size: 0.85rem;
    color: #ffffff;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .label-hint {
    font-size: 0.75rem;
    color: #64748b;
    font-weight: 400;
  }

  .form-control {
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 13px 16px;
    color: #ffffff;
    font-size: 0.9rem;
    outline: none;
    transition: all 0.2s ease;
  }

  .form-control:focus {
    border-color: #c084fc;
    box-shadow: 0 0 0 3px rgba(139, 30, 196, 0.18);
  }

  .form-control::placeholder {
    color: #475569;
  }

  .category-picker {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 14px;
  }

  .category-option {
    position: relative;
  }

  .category-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
  }

  .category-box {
    background: #17182e;
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 14px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .category-box:hover {
    border-color: rgba(139, 30, 196, 0.35);
    background: #1b1d38;
  }

  .category-option input[type="radio"]:checked + .category-box {
    border-color: #c084fc;
    background: rgba(95, 21, 135, 0.16);
    box-shadow: 0 0 16px rgba(139, 30, 196, 0.2);
  }

  .category-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .category-desc {
    font-size: 0.76rem;
    color: #9d9bb8;
    line-height: 1.4;
  }

  .form-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 14px;
    border-top: 1px solid rgba(255, 255, 255, 0.07);
    padding-top: 24px;
    margin-top: 8px;
  }

  .btn-cta-primary {
    background: linear-gradient(135deg, #5f1587, #8b1ec4);
    border: none;
    color: #ffffff;
    padding: 12px 26px;
    border-radius: 12px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 18px rgba(95, 21, 135, 0.35);
    transition: transform 0.15s ease, opacity 0.15s ease;
  }

  .btn-cta-primary:hover {
    opacity: 0.92;
    transform: translateY(-1px);
  }

  .btn-cta-secondary {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
    padding: 12px 22px;
    border-radius: 12px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.2s;
  }

  .btn-cta-secondary:hover {
    background: rgba(95, 21, 135, 0.12);
    border-color: rgba(139, 30, 196, 0.35);
    color: #ffffff;
  }

  .error-message {
    color: #ef4444;
    font-size: 0.78rem;
    margin-top: 4px;
  }
</style>

<div class="create-project-container">

  <div class="create-header">
    <div class="header-left">
      <a href="{{ route('projects.show') }}" class="back-btn" title="Geri Dön">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </a>
      <div>
        <h1>Yeni Proje Oluştur</h1>
        <p>Haritalar, eklentiler veya konfigürasyon paketleri için alan oluştur.</p>
      </div>
    </div>
  </div>

  <div class="create-card">
    <form action="{{ route('projects.store') }}" method="POST">
      @csrf

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label" for="name">
            Proje Adı
            <span class="label-hint">Maks. 255 karakter</span>
          </label>
          <input type="text" 
                 name="name" 
                 id="name" 
                 value="{{ old('name') }}" 
                 required 
                 placeholder="Örn: Skyblock PVP Paketi" 
                 class="form-control">
          @error('name')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label">
            Proje Türü
            <span class="label-hint">Dosya hiyerarşisi ve etiket için</span>
          </label>
          <div class="category-picker">
            <label class="category-option">
              <input type="radio" name="type" value="plugin" {{ old('type', 'plugin') === 'plugin' ? 'checked' : '' }}>
              <div class="category-box">
                <span class="category-title">
                  <span>⚡</span> Eklenti (Plugin)
                </span>
                <span class="category-desc">Spigot, Paper veya Script jar dosyaları.</span>
              </div>
            </label>

            <label class="category-option">
              <input type="radio" name="type" value="map" {{ old('type') === 'map' ? 'checked' : '' }}>
              <div class="category-box">
                <span class="category-title">
                  <span>🗺️</span> Harita / Dünya
                </span>
                <span class="category-desc">Özel yapılmış haritalar, şematikler ve spawnlar.</span>
              </div>
            </label>

            <label class="category-option">
              <input type="radio" name="type" value="modpack" {{ old('type') === 'modpack' ? 'checked' : '' }}>
              <div class="category-box">
                <span class="category-title">
                  <span>📦</span> Mod Paketi
                </span>
                <span class="category-desc">Forge, Fabric client ve sunucu paketleri.</span>
              </div>
            </label>

            <label class="category-option">
              <input type="radio" name="type" value="config" {{ old('type') === 'config' ? 'checked' : '' }}>
              <div class="category-box">
                <span class="category-title">
                  <span>⚙️</span> Yapılandırma
                </span>
                <span class="category-desc">YML, JSON veya optimize edilmiş ayar dosyaları.</span>
              </div>
            </label>
          </div>
          @error('type')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="description">
            Açıklama & Notlar
            <span class="label-hint">İsteğe Bağlı</span>
          </label>
          <textarea name="description" 
                    id="description" 
                    rows="4" 
                    placeholder="Bu projenin amacı, kullanılan oyun sürümü veya sürüm notları..." 
                    class="form-control" 
                    style="resize: vertical; font-family: inherit;">{{ old('description') }}</textarea>
          @error('description')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-actions">
          <a href="{{ route('projects.show') }}" class="btn-cta-secondary">Vazgeç</a>
          <button type="submit" class="btn-cta-primary">
            <span>+</span> Projeyi Başlat
          </button>
        </div>
      </div>
    </form>
  </div>

</div>
@endsection