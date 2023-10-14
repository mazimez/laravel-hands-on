<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Mail\SampleMail;
use App\Traits\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

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

    public function sendMail(Request $request)
    {
        if ($request->has('file') && $request->has('file_extension')) {
            Mail::to($request->mail)
                ->locale($request->input('use_locale', 'en'))
                ->send(new SampleMail(
                    $request->message ?? 'test message',
                    file_get_contents($request->file->getRealPath()),
                    $request->file_extension
                ));
        } else {
            Mail::to($request->mail)
                ->locale($request->input('use_locale', 'en'))
                ->send(new SampleMail($request->message));
        }

        return response()->json([
            'message' => __('messages.send_mail'),
            'status' => '1',
        ]);
    }

    public function googleLogin(Request $request)
    {
        try {
            $social_user = Socialite::driver('google')->userFromToken($request->access_token);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'message' => __('messages.invalid_access_token'),
                'status' => '0',
            ]);
        }

        return response()->json([
            'id' => $social_user->getId(),
            'email' => $social_user->getEmail(),
            'name' => $social_user->getName(),
            'avatar' => $social_user->getAvatar(),
            'data' => $social_user,
            'message' => __('messages.social_user_returned'),
            'status' => '1',
        ]);
    }

    public function fileUploadFromUrl(Request $request)
    {
        return response()->json([
            'data' => $this->saveFileFromUrl($request->url, "test"),
            'message' => __('messages.file_uploaded'),
            'status' => '1',
        ]);
    }
}
