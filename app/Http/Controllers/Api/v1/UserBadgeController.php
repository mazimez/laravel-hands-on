<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommonPaginationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserBadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Requests\Api\v1\CommonPaginationRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(User $user, CommonPaginationRequest $request)
    {
        $data = $user->badges();

        $data = $data->orderBy('user_badges.created_at', 'desc');

        if ($request->has('search')) {
            $search = '%'.$request->search.'%';
            $data = $data->where(function ($query) use ($search) {
                $query->where('name', 'like', $search)
                    ->where('slug', 'like', $search)
                    ->where('description', 'like', $search);
            });
        }

        if ($request->has('page')) {
            return response()->json(
                collect([
                    'message' => __('badge_messages.user_badges_returned'),
                    'status' => '1',
                ])->merge($data->simplePaginate($request->has('per_page') ? $request->per_page : 10))
            );
        }

        return response()->json([
            'data' => $data->get(),
            'message' => __('badge_messages.user_badges_returned'),
            'status' => '1',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
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
