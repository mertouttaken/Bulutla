<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file'       => 'required|file|max:102400',
            'project_id' => 'required|exists:projects,id',
        ]);

        $user = $request->user();
        $subscription = $user->subscription;

        if (!$subscription || $subscription->status !== 'active') {
            return back()->with('error', 'Dosya yüklemek için aktif bir aboneliğiniz olmalıdır.');
        }

        $project = $user->projects()->findOrFail($request->input('project_id'));

        $rawLimit = (string) ($user->plan?->storage_limit ?? '0');
        preg_match('/([\d.]+)\s*([a-zA-Z]*)/', $rawLimit, $matches);
        $limitValue = isset($matches[1]) ? (float) $matches[1] : 0;
        $limitUnit = isset($matches[2]) ? strtoupper(trim($matches[2])) : 'MB';
        $storageLimitMB = ($limitUnit === 'GB') ? ($limitValue * 1024) : $limitValue;

        $uploadedFile = $request->file('file');
        $fileSizeMB = $uploadedFile->getSize() / 1048576;

        $originalRawName = basename($uploadedFile->getClientOriginalName());
        $filenameOnly = pathinfo($originalRawName, PATHINFO_FILENAME);
        $extension = $uploadedFile->getClientOriginalExtension();

        $sluggedName = Str::slug($filenameOnly, '-');
        $safeOriginalName = $sluggedName . ($extension ? '.' . strtolower($extension) : '');

        if (empty($sluggedName)) {
            $safeOriginalName = 'file_' . time() . ($extension ? '.' . strtolower($extension) : '');
        }

        $path = $uploadedFile->store("files/{$user->id}/{$project->id}", 'local');

        try {
            DB::transaction(function () use ($user, $project, $fileSizeMB, $storageLimitMB, $safeOriginalName, $path, $uploadedFile) {
                User::where('id', $user->id)->lockForUpdate()->first();

                if (($user->storageUsedValue() + $fileSizeMB) > $storageLimitMB) {
                    throw new \Exception('Depolama alanı yetersiz!');
                }

                $user->files()->create([
                    'project_id'    => $project->id,
                    'original_name' => $safeOriginalName,
                    'path'          => $path,
                    'mime_type'     => $uploadedFile->getClientMimeType(),
                    'size'          => $uploadedFile->getSize(),
                ]);
            });
        } catch (\Exception $e) {
            Storage::disk('local')->delete($path);
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Dosya başarıyla yüklendi.');
    }

    public function download(Request $request, $fileId)
    {
        $user = $request->user();
        $fileRecord = $user->files()->find($fileId);

        if (!$fileRecord) {
            return back()->with('error', 'Dosya bulunamadı veya erişim izniniz yok.');
        }

        if (!Storage::disk('local')->exists($fileRecord->path)) {
            return back()->with('error', 'Dosya sunucuda bulunamadı.');
        }

        return response()->download(
            Storage::disk('local')->path($fileRecord->path), 
            $fileRecord->original_name,
            ['Content-Type' => $fileRecord->mime_type]
        );
    }

    public function destroy(Request $request, $fileId = null)
    {
        File::destroyData($request->user(), $fileId);
        return back()->with('success', 'Dosya başarıyla silindi.');
    }
}