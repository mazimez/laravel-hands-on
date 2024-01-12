<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommonPaginationRequest;
use App\Jobs\SendNotificationJob;
use App\Models\Badge;
use App\Models\Likable;
use App\Models\Notification;
use App\Models\Post;
use App\Models\UserTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Post $post, CommonPaginationRequest $request)
    {
        $data = $post->likers();
        if ($request->has('page')) {
            return response()->json(
                collect([
                    'message' => __('post_messages.post_likers_returned'),
                    'status' => '1',
                ])->merge($data->simplePaginate($request->has('per_page') ? $request->per_page : 10))
            );
        }

        return response()->json([
            'data' => $data->get(),
            'message' => __('post_messages.post_likers_returned'),
            'status' => '1',
        ]);
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

        //OPTION-1 (with proper message about like/unlike)
        $liker = $post->likers()->where('user_id', $auth_user->id)->first();
        if ($liker) {
            $post->likers()->detach($auth_user);

            return response()->json([
                'message' => __('post_messages.post_like_removed'),
                'status' => '1',
            ]);
        }
        $post->likers()->attach($auth_user);

        if ($auth_user->id != $post->user_id) {
            UserTag::addTags($auth_user, $post->tags->pluck('id')->toArray());
            $notification = $post->notifications()->create([
                'user_id' => $post->user_id,
                'title' => __('notification_messages.post_like_title', ['user_name' => $post->user->name]),
                'message' => __('notification_messages.post_like_message', ['post_title' => $post->title]),
                'type' => Notification::POST_LIKED,
                'click_action' => Notification::OPEN_POST,
                'meta_data' => [
                    'post_id' => $post->id,
                ],
            ]);
            SendNotificationJob::dispatch($notification);
        }

        $first_like_badge = Badge::where('slug', Badge::FIRST_LIKE)->first();
        if ($first_like_badge) {
            $user_to_give_badge = $post->user;
            if (! $user_to_give_badge->badges()->where('badges.id', $first_like_badge->id)->exists()) {
                $overall_post_like_count = Likable::where('user_id', '!=', $post->user_id)
                    ->whereHas('post', function ($query) use ($post) {
                        $query->where('user_id', $post->user_id);
                    })
                    ->where('likable_type', Post::class)
                    ->count();
                if ($overall_post_like_count > 0) {
                    $post->badges()->create([
                        'user_id' => $post->user_id,
                        'badge_id' => $first_like_badge->id,
                    ]);
                }
            }
        }

        return response()->json([
            'message' => __('post_messages.post_liked'),
            'status' => '1',
        ]);

        //OPTION-2 (with just toggle logic)
        // $post->likers()->toggle([$auth_user->id]);
        // return response()->json([
        //     'message' => __('post_messages.post_like_toggle'),
        //     'status' => '1'
        // ]);
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
