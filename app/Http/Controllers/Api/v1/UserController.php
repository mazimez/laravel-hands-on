<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\GetUserDetailRequest;
use App\Http\Requests\Api\v1\LoginRequest;
use App\Http\Requests\Api\v1\UserIndexRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Login the user and return the bearer token
     *
     * @param  \App\Http\Requests\Api\v1\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => __('messages.user_not_found'),
                'status' => '0',
            ]);
        }

        if (!password_verify($request->password, $user->password)) {
            return response()->json([
                'message' => __('messages.wrong_password'),
                'status' => '0',
            ]);
        }
        return response()->json([
            'data' => $user,
            'token' => $user->createToken($request->header('User-Agent') ?? $request->ip())->plainTextToken,
            'message' => __('messages.user_login'),
            'status' => '1'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Api\v1\UserIndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserIndexRequest $request)
    {
        $data = User::query();
        if ($request->has('latitude') && $request->has('longitude')) {
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            if ($latitude && $longitude) {
                $data = $data->selectRaw(
                    "*,
                round(( 6371 * acos( cos( radians(?) ) *
                cos( radians( latitude ) )
                * cos( radians( longitude ) - radians(?)
                ) + sin( radians(?) ) *
                sin( radians( latitude ) ) )
                ),2) AS distance ",
                    [$latitude, $longitude, $latitude]
                );

                $data = $data->orderBy('distance', 'asc');
            }

            if ($request->has('distance')) {
                $data = $data->having('distance', '<', $request->distance);
            }
        }

        if ($request->has('page')) {
            return response()->json(
                collect([
                    'message' => __('messages.user_list_returned'),
                    'status' => '1',
                ])->merge($data->simplePaginate($request->has('per_page') ? $request->per_page : 10))
            );
        }
        return response()->json([
            'data' => $data->get(),
            'message' => __('messages.user_list_returned'),
            'status' => '1'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(GetUserDetailRequest $request)
    {
        $user = Auth::user();
        if ($request->has('user_id')) {
            $user = User::findOrFail($request->user_id);
        }
        return response()->json([
            'data' => $user,
            'message' => __('messages.user_detail_returned'),
            'status' => '1'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
