<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostFileController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @param  File  $file
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post, File $file)
    {
        Gate::authorize('deletePostFile', [File::class, $file, $post]);
        $file->delete();
        return response()->json([
            'message' => __('messages.post_file_deleted'),
            'status' => '1'
        ]);
    }
}
