<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //
    }

    /**
     * Toggle the post like resource
     *
     * @param  Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Post $post)
    {
        $auth_user = Auth::user();
        $post_like = PostLike::where('user_id', $auth_user->id)->where('post_id', $post->id)->first();
        if ($post_like) {
            $post_like->delete();
            return response()->json([
                'message' => __('messages.post_like_removed'),
                'status' => '1'
            ]);
        }
        $post_like = PostLike::create([
            'user_id' => $auth_user->id,
            'post_id' => $post->id,
        ]);
        return response()->json([
            'message' => __('messages.post_liked'),
            'status' => '1'
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
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
    }
}
