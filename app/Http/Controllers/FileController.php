<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:102400',
        ]);

        $user = $request->user();

        if (!$user) {
            return back()->with('error', 'Oturum açmanız gerekiyor.');
        }

        $subscription = $user->subscription;
        if (!$subscription || $subscription->status !== 'active') {
            return back()->with('error', 'Dosya yüklemek için aktif bir aboneliğiniz olmalıdır.');
        }

        $rawLimit = (string) ($user->plan?->storage_limit ?? '0');
        preg_match('/([\d.]+)\s*([a-zA-Z]*)/', $rawLimit, $matches);
        $limitValue = isset($matches[1]) ? (float) $matches[1] : 0;
        $limitUnit = isset($matches[2]) ? strtoupper(trim($matches[2])) : 'MB';
        $storageLimitMB = ($limitUnit === 'GB') ? ($limitValue * 1024) : $limitValue;

        $uploadedFile = $request->file('file');
        $fileSizeMB = $uploadedFile->getSize() / 1048576;

        if (($user->storageUsedValue() + $fileSizeMB) > $storageLimitMB) {
            return back()->with('error', 'Depolama limitiniz doldu. Lütfen planınızı yükseltin.');
        }

        $path = $uploadedFile->store("files/{$user->id}", 'local');

        $project = $user->projects()->firstOrCreate([
            'name' => 'Default Project',
        ]);

        $user->files()->create([
            'project_id'    => $project->id,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'path'          => $path,
            'mime_type'     => $uploadedFile->getClientMimeType(),
            'size'          => $uploadedFile->getSize(), // Bayt
        ]);

        return back()->with('success', 'Dosya başarıyla yüklendi.');
    }
    public function download(Request $request, $fileId)
    {
        $user = $request->user();

        if (!$user) {
            return back()->with('error', 'Oturum açmanız gerekiyor.');
        }

        $fileRecord = $user->files()->find($fileId);

        if (!$fileRecord) {
            return back()->with('error', 'Dosya bulunamadı veya erişim izniniz yok.');
        }

        if (!Storage::disk('local')->exists($fileRecord->path)) {
            return back()->with('error', 'Dosya sunucuda bulunamadı.');
        }

        return response()->download(Storage::disk('local')->path($fileRecord->path), $fileRecord->original_name);
    }
    public function destroy(Request $request, $fileId)
    {
        $user = $request->user();

        if (!$user) {
            return back()->with('error', 'Oturum açmanız gerekiyor.');
        }

        $fileRecord = $user->files()->find($fileId);

        if (!$fileRecord) {
            return back()->with('error', 'Dosya bulunamadı veya erişim izniniz yok.');
        }

        if (Storage::disk('local')->exists($fileRecord->path)) {
            Storage::disk('local')->delete($fileRecord->path);
        }

        $fileRecord->delete();

        return back()->with('success', 'Dosya başarıyla silindi.');
    }
}