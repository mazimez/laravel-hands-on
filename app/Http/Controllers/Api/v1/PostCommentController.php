<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\CreatePostCommentRequest;
use App\Http\Requests\Api\v1\EditPostCommentRequest;
use App\Http\Requests\CommonPaginationRequest;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize('viewAny', [PostComment::class, $post]);
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
        Gate::authorize('create', [PostComment::class, $post]);
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
    public function update(Post $post, PostComment $comment, EditPostCommentRequest $request)
    {
        Gate::authorize('update', [PostComment::class, $comment, $post]);
        $comment->comment = $request->comment;
        $comment->save();
        return response()->json([
            'data' => $comment->refresh()->loadMissing(['user']),
            'message' => __('messages.post_comment_updated'),
            'status' => '1'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post, PostComment $comment)
    {
        Gate::authorize('delete', [PostComment::class, $comment, $post]);
        $comment->delete();
        return response()->json([
            'message' => __('messages.comment_deleted'),
            'status' => '1'
        ]);
    }
}
