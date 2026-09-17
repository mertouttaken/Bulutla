@extends('layouts.app')

@section('content')
<style>
  .upload-wrapper {
    max-width: 860px;
    margin: 40px auto;
    padding: 0 20px;
    font-family: inherit;
    color: #e2e8f0;
  }

  .upload-card {
    background: #111422;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    padding: 36px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.45);
    display: flex;
    flex-direction: column;
    gap: 28px;
  }

  .upload-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
  }

  .upload-header h2 {
    font-size: 1.4rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 6px 0;
    letter-spacing: -0.02em;
  }

  .upload-header p {
    margin: 0;
    font-size: 0.88rem;
    color: #8f9bba;
  }

  .storage-summary {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 14px;
    padding: 14px 18px;
    min-width: 220px;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .storage-labels {
    display: flex;
    justify-content: space-between;
    font-size: 0.8rem;
    font-weight: 600;
  }

  .storage-labels span.label {
    color: #8f9bba;
  }

  .storage-labels span.val {
    color: #cbd5e1;
  }

  .storage-progress {
    height: 7px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    overflow: hidden;
  }

  .storage-bar {
    height: 100%;
    background: linear-gradient(90deg, #6366f1, #a855f7);
    border-radius: 10px;
    transition: width 0.3s ease;
  }

  .dropzone {
    border: 2px dashed rgba(99, 102, 241, 0.35);
    border-radius: 16px;
    padding: 44px 24px;
    text-align: center;
    background: rgba(99, 102, 241, 0.02);
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
  }

  .dropzone.dragover {
    border-color: #a855f7;
    background: rgba(168, 85, 247, 0.06);
    transform: scale(0.995);
  }

  .dropzone-icon {
    width: 58px;
    height: 58px;
    border-radius: 14px;
    background: rgba(99, 102, 241, 0.12);
    border: 1px solid rgba(99, 102, 241, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
  }

  .dropzone-title {
    font-size: 1.05rem;
    font-weight: 600;
    color: #fff;
    margin: 0;
  }

  .dropzone-desc {
    font-size: 0.85rem;
    color: #8f9bba;
    margin: 0;
  }

  .dropzone-desc span {
    color: #818cf8;
    text-decoration: underline;
    font-weight: 500;
  }

  .dropzone-hint {
    font-size: 0.75rem;
    color: #64748b;
  }

  .file-preview-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 16px;
  }

  .file-item {
    background: #171b2e;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 12px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }

  .file-meta {
    display: flex;
    align-items: center;
    gap: 14px;
    overflow: hidden;
  }

  .file-icon {
    font-size: 1.3rem;
  }

  .file-info {
    display: flex;
    flex-direction: column;
    gap: 3px;
    overflow: hidden;
  }

  .file-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: #fff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .file-size {
    font-size: 0.78rem;
    color: #8f9bba;
  }

  .file-remove {
    background: transparent;
    border: none;
    color: #64748b;
    font-size: 1.1rem;
    cursor: pointer;
    padding: 6px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
  }

  .file-remove:hover {
    color: #f87171;
    background: rgba(239, 68, 68, 0.1);
  }

  .upload-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 14px;
    border-top: 1px solid rgba(255, 255, 255, 0.06);
    padding-top: 20px;
    margin-top: 20px;
  }

  .btn-cancel {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #cbd5e1;
    padding: 11px 22px;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s;
  }

  .btn-cancel:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
  }

  .btn-upload {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border: none;
    color: #fff;
    padding: 11px 26px;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.2s;
  }

  .btn-upload:hover {
    opacity: 0.9;
  }
</style>
<div class="upload-wrapper">
  <div class="upload-card">
    
    <div class="upload-header">
      <div>
        <h2>Dosya Yükle</h2>
        <p>Projeniz için doküman, medya veya veri dosyalarını içe aktarın.</p>
      </div>

      @php
        $rawUsed = (float) (Auth::user()->used_storage ?? 0);
        $planLimit = (float) (Auth::user()->plan?->storage_limit ?? 100);
        $percentage = $planLimit > 0 ? min(round(($rawUsed / $planLimit) * 100), 100) : 0;
      @endphp

      <div class="storage-summary">
        <div class="storage-labels">
          <span class="label">Kullanılan Alan</span>
          <span class="val">{{ $rawUsed }} / {{ $planLimit }} MB</span>
        </div>
        <div class="storage-progress">
          <div class="storage-bar" style="width: {{ $percentage }}%;"></div>
        </div>
      </div>
    </div>

    <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
      @csrf

      <input type="file" name="files[]" id="fileInput" multiple style="display: none;">

      <div class="dropzone" id="dropzone">
        <div class="dropzone-icon">📁</div>
        <p class="dropzone-title">Dosyaları sürükleyip buraya bırakın</p>
        <p class="dropzone-desc">veya cihazınızdan <span>dosya seçin</span></p>
        <span class="dropzone-hint">PNG, JPG, PDF, ZIP veya MP4 (Dosya başı maks. 50 MB)</span>
      </div>

      <div class="file-preview-list" id="previewList"></div>

      <div class="upload-actions">
        <a href="{{ route('home') }}" class="btn-cancel">İptal</a>
        <button type="submit" class="btn-upload" id="submitBtn">Yüklemeyi Başlat</button>
      </div>
    </form>

  </div>
</div>
@endsection