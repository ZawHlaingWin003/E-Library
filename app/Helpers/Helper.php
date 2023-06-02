<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function storeFile($file, $folder, $name = '')
    {
        if ($name) {
            $fileName = date('YmdHis') . "-" . strtolower(str_replace(' ', '-', $name)) . '.' . $file->getClientOriginalExtension();
        } else {
            $fileName = date('YmdHis'). '.' . $file->getClientOriginalExtension();
        }

        $file->storeAs($folder, $fileName);

        return $fileName;
    }

    public static function deleteOldFile($file, $folder)
    {
        $oldFile = "{$folder}/{$file}";
        if (Storage::exists($oldFile)) {
            Storage::delete($oldFile);
        }
    }
}