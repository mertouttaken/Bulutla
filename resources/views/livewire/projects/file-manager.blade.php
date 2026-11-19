<div class="files-container">
  

  @if(session('success'))
    <div class="archive-alert" role="status">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="archive-alert is-error" role="alert">
      {{ session('error') }}
    </div>
  @endif

  <div class="files-header files-header--center">
    <a href="{{ route('projects.show') }}" class="files-back"><span aria-hidden="true">←</span> Projelerim</a>
    <p class="desk-kicker">PROJE ARŞİVİ / DOSYALAR</p>
    <h1 class="motion-title">{{ $project->name }}</h1>
    @if($project->description)<p class="files-desc">{{ $project->description }}</p>@endif
  </div>

  <div x-data="{ over: false }">
    <label for="projectFileInput" class="drop-zone" :class="{ 'is-over': over }"
           @dragenter="over = true" @dragleave="over = false" @drop="over = false" data-sc-spotlight>
      <span class="drop-zone__icon" aria-hidden="true">
        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 16V4m0 0l-4 4m4-4l4 4M5 16v2a2 2 0 002 2h10a2 2 0 002-2v-2"/></svg>
      </span>
      <span class="drop-zone__text">
        <span wire:loading.remove wire:target="uploadedFile"><b>Dosyanı buraya bırak</b> ya da seçmek için tıkla</span>
        <span wire:loading wire:target="uploadedFile"><b>Yükleniyor…</b> klasöre yerleştiriliyor</span>
      </span>
      <span class="drop-zone__limit">EN FAZLA 100 MB</span>
      <span class="drop-zone__bar" wire:loading wire:target="uploadedFile" aria-hidden="true"></span>
      <input type="file" wire:model="uploadedFile" id="projectFileInput" class="drop-zone__input">
    </label>
    @error('uploadedFile')
      <p class="field-error drop-zone__error">{{ $message }}</p>
    @enderror
  </div>

  <div class="stats-bar">
    <div>
      Kayıtlı dosya: <strong><span data-tick>{{ count($files) }}</span> adet</strong>
    </div>
    <div>
      Toplam boyut: <strong class="lilac-num"><span data-tick>{{ number_format($files->sum('size') / 1048576, 2) }}</span> MB</strong>
    </div>
  </div>

  @php
    // One colour family per kind of file, so a glance at the table sorts it.
    $kinds = [
      'image' => ['png','jpg','jpeg','gif','webp','svg','bmp','tif','tiff','heic','psd','ai'],
      'doc'   => ['pdf','doc','docx','txt','md','rtf','odt','pages','key','ppt','pptx'],
      'media' => ['mp4','mov','avi','mkv','webm','mp3','wav','flac','ogg','m4a'],
      'pack'  => ['zip','rar','7z','tar','gz','jar'],
      'data'  => ['xls','xlsx','csv','json','yml','yaml','xml','sql','dwg','dxf','ase'],
    ];
  @endphp
  <div class="paper-table">
    @forelse($files as $file)
      @php
        $ext = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));
        $kind = 'other';
        foreach ($kinds as $k => $list) { if (in_array($ext, $list, true)) { $kind = $k; break; } }
        $label = strtoupper(substr($ext, 0, 5)) ?: 'DOSYA';
      @endphp
      <article class="paper-card paper-card--{{ $kind }}" wire:key="paper-{{ $file->id }}">
        <span class="paper-card__tab">{{ $label }}</span>
        <span class="paper-card__glyph" aria-hidden="true">{{ $label }}</span>
        <h3 class="paper-card__name" title="{{ $file->original_name }}">{{ $file->original_name }}</h3>
        <p class="paper-card__meta">{{ number_format($file->size / 1048576, 2) }} MB · {{ $file->created_at ? $file->created_at->diffForHumans() : 'Bilinmiyor' }}</p>
        <div class="paper-card__actions">
          <a href="{{ route('files.download', $file->id) }}" class="paper-card__btn">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-4-4m4 4l4-4M5 20h14"/></svg>
            İndir
          </a>
          <button type="button" class="paper-card__btn paper-card__btn--danger"
                  wire:click="deleteFile({{ $file->id }})"
                  wire:confirm="Bu dosyayı projeden silmek istediğinize emin misiniz?">Sil</button>
        </div>
      </article>
    @empty
      <p class="files-empty">Bu proje henüz boş. İlk dosyanı yukarıdaki alana bırak.</p>
    @endforelse
  </div>
</div>