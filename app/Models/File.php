<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;

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
}