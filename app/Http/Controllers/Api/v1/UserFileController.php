<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\CreateUserFileRequest;
use App\Http\Requests\CommonPaginationRequest;
use App\Models\File;
use App\Models\User;
use App\Traits\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserFileController extends Controller
{
    use FileManager;

    /**
     * Display a listing of the resource.
     *
     * @param  User  $user
     * @param  \Illuminate\Http\CommonPaginationRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(User $user, CommonPaginationRequest $request)
    {
        $this->authorize('viewUserFiles', [File::class, $user]);
        $data = $user->files();
        if ($request->has('page')) {
            return response()->json(
                collect([
                    'message' => __('user_messages.user_files_returned'),
                    'status' => '1',
                ])->merge($data->simplePaginate($request->has('per_page') ? $request->per_page : 10))
            );
        }

        return response()->json([
            'data' => $data->get(),
            'message' => __('user_messages.user_files_returned'),
            'status' => '1',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateUserFileRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserFileRequest $request)
    {
        $auth_user = Auth::user();
        if ($auth_user && $request->has('files')) {
            foreach ($request['files'] as $file) {
                $file_type = null;
                if (Str::of($file->getMimeType())->contains('image/')) {
                    $file_type = File::PHOTO;
                }
                if (Str::of($file->getMimeType())->contains('video/')) {
                    $file_type = File::VIDEO;
                }
                if (! in_array($file_type, [File::PHOTO, File::VIDEO])) {
                    return response()->json([
                        'message' => __('file_messages.file_type_not_supported'),
                        'status' => '0',
                    ]);
                }
                $auth_user->files()->create([
                    'user_id' => $auth_user->id,
                    'file_path' => $this->saveFile($file, 'users'),
                    'type' => $file_type,
                ]);
            }
        }

        return response()->json([
            'message' => __('user_messages.user_files_added'),
            'status' => '1',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user, File $file)
    {
        $this->authorize('deleteUserFile', [File::class, $file, $user]);
        $file->delete();

        return response()->json([
            'message' => __('user_messages.user_file_deleted'),
            'status' => '1',
        ]);
    }
}
