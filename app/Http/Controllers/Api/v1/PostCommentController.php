<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\CreatePostCommentRequest;
use App\Http\Requests\CommonPaginationRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Api\v1\CreatePostCommentRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Post $post, CommonPaginationRequest $request)
    {
        $data = $post->comments()->with(['user']);

        $data = $data->latest();
        if ($request->has('page')) {
            return response()->json(
                collect([
                    'message' => __('messages.post_comment_list_returned'),
                    'status' => '1',
                ])->merge($data->simplePaginate($request->has('per_page') ? $request->per_page : 10))
            );
        }
        return response()->json([
            'data' => $data->get(),
            'message' => __('messages.post_comment_list_returned'),
            'status' => '1'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Post $post, CreatePostCommentRequest $request)
    {
        $auth_user = Auth::user();
        $comment = $post->comments()->create([
            'user_id' => $auth_user->id,
            'comment' => $request->comment,
        ]);
        return response()->json([
            'data' => $comment->refresh()->loadMissing(['user']),
            'message' => __('messages.post_comment_list_returned'),
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