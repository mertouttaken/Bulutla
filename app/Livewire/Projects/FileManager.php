<?php

namespace App\Livewire\Projects;

use App\Models\File;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
#[Title('Dosya Yönetimi')]
class FileManager extends Component
{
    use WithFileUploads;

    public Project $project;
    public $uploadedFile;

    public function mount(int $projectId)
    {
        $this->project = Auth::user()->projects()->findOrFail($projectId);
    }

    public function updatedUploadedFile()
    {
        $this->validate([
                'uploadedFile' => 'required|file|max:102400',
            ], [
                'uploadedFile.required' => 'Lütfen bir dosya seçin.',
                'uploadedFile.file'     => 'Yüklenen içerik geçerli bir dosya olmalıdır.',
                'uploadedFile.max'      => 'Yüklemeye çalıştığınız dosya 100 MB sınırını aşıyor.',
            ]);

        $user = Auth::user();
        $subscription = $user->subscription;

        if (!$subscription || $subscription->status !== 'active') {
            session()->flash('error', 'Dosya yüklemek için aktif bir aboneliğiniz olmalıdır.');
            $this->reset('uploadedFile');
            return;
        }

        $rawLimit = (string) ($user->plan?->storage_limit ?? '0');
        preg_match('/([\d.]+)\s*([a-zA-Z]*)/', $rawLimit, $matches);
        $limitValue = isset($matches[1]) ? (float) $matches[1] : 0;
        $limitUnit = isset($matches[2]) ? strtoupper(trim($matches[2])) : 'MB';
        $storageLimitMB = ($limitUnit === 'GB') ? ($limitValue * 1024) : $limitValue;

        $fileSizeMB = $this->uploadedFile->getSize() / 1048576;

        $originalRawName = basename($this->uploadedFile->getClientOriginalName());
        $filenameOnly = pathinfo($originalRawName, PATHINFO_FILENAME);
        $extension = $this->uploadedFile->getClientOriginalExtension();

        $sluggedName = Str::slug($filenameOnly, '-');
        $safeOriginalName = $sluggedName . ($extension ? '.' . strtolower($extension) : '');

        if (empty($sluggedName)) {
            $safeOriginalName = 'file_' . time() . ($extension ? '.' . strtolower($extension) : '');
        }

        $path = $this->uploadedFile->store("files/{$user->id}/{$this->project->id}", 'local');

        try {
            DB::transaction(function () use ($user, $fileSizeMB, $storageLimitMB, $safeOriginalName, $path) {
                User::where('id', $user->id)->lockForUpdate()->first();

                if (($user->storageUsedValue() + $fileSizeMB) > $storageLimitMB) {
                    throw new \Exception('Depolama alanı yetersiz!');
                }

                $user->files()->create([
                    'project_id'    => $this->project->id,
                    'original_name' => $safeOriginalName,
                    'path'          => $path,
                    'mime_type'     => $this->uploadedFile->getClientMimeType(),
                    'size'          => $this->uploadedFile->getSize(),
                ]);
            });
        } catch (\Exception $e) {
            Storage::disk('local')->delete($path);
            session()->flash('error', $e->getMessage());
            $this->reset('uploadedFile');
            return;
        }

        $this->reset('uploadedFile');
        $this->project->load('files');
        session()->flash('success', 'Dosya başarıyla yüklendi.');
    }

    public function downloadFile(int $fileId)
    {
        $user = Auth::user();
        $fileRecord = $user->files()->find($fileId);

        if (!$fileRecord) {
            session()->flash('error', 'Dosya bulunamadı veya erişim izniniz yok.');
            return;
        }

        if (!Storage::disk('local')->exists($fileRecord->path)) {
            session()->flash('error', 'Dosya sunucuda bulunamadı.');
            return;
        }

        return Storage::disk('local')->download(
            $fileRecord->path,
            $fileRecord->original_name,
            ['Content-Type' => $fileRecord->mime_type]
        );
    }

    public function deleteFile(int $fileId)
    {
        File::destroyData(Auth::user(), $fileId);
        $this->project->load('files');
        session()->flash('success', 'Dosya başarıyla silindi.');
    }

    public function render()
    {
        $files = $this->project->files()->latest()->get();

        return view('livewire.projects.file-manager', [
            'files' => $files,
        ]);
    }
}