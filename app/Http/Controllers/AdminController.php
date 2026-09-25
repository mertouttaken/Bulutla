<?php

namespace App\Http\Controllers;

use App\Models\File as FileModel;

class AdminController extends Controller
{
    public function maxServerStorageLimit()
    {
        return round(disk_total_space(storage_path()) / 1024 / 1024 / 1024, 2);
    }

    public function usedServerStorage()
    {
        return round(FileModel::sum('size') / 1024 / 1024 / 1024, 2);
    }
}