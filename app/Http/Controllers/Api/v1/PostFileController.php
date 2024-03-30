<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostFileController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @param  PostFile  $postFile
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post, PostFile $file)
    {
        Gate::authorize('delete', [PostFile::class, $file, $post]);
        $file->delete();
        return response()->json([
            'message' => __('messages.post_file_deleted'),
            'status' => '1'
        ]);
    }
}
