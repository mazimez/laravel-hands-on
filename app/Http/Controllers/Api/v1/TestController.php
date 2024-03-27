<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Traits\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    use FileManager;
    public function fileUpload(Request $request)
    {
        $file_path = null;
        if ($request->has('file')) {
            $file_path = $this->saveFile($request->file, 'test');
        }
        return response()->json([
            'data' => Storage::url($file_path),
            'message' => __('messages.file_uploaded'),
            'status' => '1',
        ]);
    }
    public function fileDestroy(Request $request)
    {
        $this->deleteFile($request->file_path);
        return response()->json([
            'message' => __('messages.file_deleted'),
            'status' => '1',
        ]);
    }
}
