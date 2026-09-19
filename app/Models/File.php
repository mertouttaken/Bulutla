<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
class File extends Model
{

    protected $fillable = [
        'project_id',
        'user_id',
        'original_name',
        'path',
        'mime_type',
        'size',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function formattedSize(): string
    {
        $mb = (float) $this->size;
        return number_format($mb / 1048576, 2) . ' MB';
    }
    public static function destroyData($user, $fileId = null): bool
    {
        if ($fileId) {
            $fileRecord = $user->files()->find($fileId);

            if (!$fileRecord) {
                return false;
            }

            if (Storage::disk('local')->exists($fileRecord->path)) {
                Storage::disk('local')->delete($fileRecord->path);
            }

            return (bool) $fileRecord->delete();
        }

        Storage::disk('local')->deleteDirectory("files/{$user->id}");

        $user->files()->delete();
        $user->projects()->delete();
        
        return (bool) $user->delete();
    }
}