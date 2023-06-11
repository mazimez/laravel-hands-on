<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\PostCreateRequest;
use App\Http\Requests\Api\v1\PostIndexRequest;
use App\Http\Requests\Api\v1\PostUpdateRequest;
use App\Models\Post;
use App\Models\PostFile;
use App\Traits\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\Expr\FuncCall;

class PostController extends Controller
{
    use FileManager;
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Api\v1\PostIndexRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PostIndexRequest $request)
    {
        $data = Post::query();

        if ($request->has('user_id')) {
            $data = $data->where('user_id', $request->user_id);
        }

        if ($request->has('search')) {
            $search = '%' . $request->search . '%';
            $data = $data->where(function ($query) use ($search) {
                $query = $query->where('title', 'like', $search)
                    ->orWhere('description', 'like', $search);
            });
        }

        if ($request->has('sort_field')) {
            $sort_field = $request->sort_field;
            $sort_order = $request->input('sort_order', 'asc'); //default ascending
            if (!in_array($sort_field, Schema::getColumnListing((new Post())->table))) {
                return response()->json([
                    'message' => __('messages.invalid_field_for_sorting'),
                    'status' => '0'
                ]);
            }
            $data = $data->orderBy($sort_field, $sort_order);
        } else {
            $data = $data->latest();
        }

        if ($request->has('page')) {
            return response()->json(
                collect([
                    'message' => __('messages.post_list_returned'),
                    'status' => '1',
                ])->merge($data->simplePaginate($request->has('per_page') ? $request->per_page : 10))
            );
        }
        return response()->json([
            'data' => $data->get(),
            'message' => __('messages.post_list_returned'),
            'status' => '1'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\v1\PostCreateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostCreateRequest $request)
    {
        $auth_user = Auth::user();
        $post = Post::create([
            'user_id' => $auth_user->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        if ($post && $request->has('files')) {
            foreach ($request['files'] as $file) {
                PostFile::create([
                    'post_id' => $post->id,
                    'file_path' => $this->saveFile($file, 'posts'),
                ]);
            }
        }
        return response()->json([
            'data' => $post->refresh(),
            'message' => __('messages.post_created'),
            'status' => '1'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        return response()->json([
            'data' => $post,
            'message' => __('messages.post_detail_returned'),
            'status' => '1'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\v1\PostUpdateRequest  $request
     * @param  Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        if ($request->has('title')) {
            $post->title = $request->title;
        }
        if ($request->has('description')) {
            $post->description = $request->description;
        }
        if (!$post->isDirty()) {
            return response()->json([
                'message' => __('messages.nothing_to_update'),
                'status' => '0'
            ]);
        }
        $post->save();
        return response()->json([
            'data' => $post,
            'message' => __('messages.post_updated'),
            'status' => '1'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'message' => __('messages.post_deleted'),
            'status' => '1'
        ]);
    }
}
