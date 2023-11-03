<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ConfirmPhoneRequest;
use App\Http\Requests\Api\v1\GetUserDetailRequest;
use App\Http\Requests\Api\v1\LoginRequest;
use App\Http\Requests\Api\v1\SocialLoginRequest;
use App\Http\Requests\Api\v1\UserCreateRequest;
use App\Http\Requests\Api\v1\UserIndexRequest;
use App\Http\Requests\Api\v1\UserUpdateRequest;
use App\Models\Badge;
use App\Models\User;
use App\Models\UserBadge;
use App\Traits\FileManager;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    use FileManager;
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
     * Login the user with social account(via access token)
     *
     * @param  \App\Http\Requests\Api\v1\SocialLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function socialLogin(SocialLoginRequest $request)
    {
        try {
            $social_user = Socialite::driver($request->provider)->userFromToken($request->access_token);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'message' => __('messages.invalid_access_token'),
                'status' => '0',
            ]);
        }

        $user = User::where('type', User::USER)->where('email', $social_user->getEmail())->first();
        if (!$user) {
            $user = User::create([
                'name' => $social_user->getName(),
                'profile_image' => $this->saveFileFromUrl($social_user->getAvatar(), 'users'),
                'email' => $social_user->getEmail(),
                'password' => null,
                'type' => User::USER
            ]);
        }

        return response()->json([
            'data' => $user->refresh(),
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

        if ($request->has('search')) {
            $search = '%' . $request->search . '%';
            $data = $data->where(function ($query) use ($search) {
                $query = $query->where('name', 'like', $search)
                    ->orWhere('phone_number', 'like', $search)
                    ->orWhere('email', 'like', $search);
            });
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
     * @param  \App\Http\Requests\Api\v1\UserCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'profile_image' => $request->hasFile('profile_image') ? $this->saveFile($request->profile_image, 'users') : null,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => User::USER
        ]);
        return response()->json([
            'message' => __('messages.user_registered'),
            'status' => '1'
        ]);
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
     * @param  \App\Http\Requests\Api\v1\UserUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request)
    {
        $auth_user = Auth::user();
        if ($request->has('name')) {
            $auth_user->name = $request->name;
        }
        if ($request->has('phone_number')) {
            if (User::where('phone_number', $request->phone_number)->where('id', '!=', $auth_user->id)->exists()) {
                return response()->json([
                    'message' => __('messages.phone_number_already_used'),
                    'status' => '1'
                ]);
            }
            $auth_user->phone_number = $request->phone_number;
        }
        if ($request->hasFile('profile_image')) {
            if ($auth_user->profile_image) {
                $this->deleteFile($auth_user->profile_image);
            }
            $auth_user->profile_image = $this->saveFile($request->profile_image, 'users');
        }

        $auth_user->save();
        return response()->json([
            'data' => $auth_user->refresh(),
            'message' => __('messages.user_updated'),
            'status' => '1'
        ]);
    }

    /**
     * send verification code to user's phone number.
     *
     * @return \Illuminate\Http\Response
     */
    public function verifyPhone()
    {
        $user = Auth::user();
        if ($user->is_phone_verified) {
            return response()->json([
                'message' => __('messages.phone_number_already_verified'),
                'status' => '0'
            ]);
        }
        $phone_verified_badge = Badge::where('slug', Badge::PHONE_VERIFIED)->first();
        if ($phone_verified_badge) {
            UserBadge::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'badge_id' => $phone_verified_badge->id,
            ]);
        }
        User::sendOtp($user);
        return response()->json([
            'message' => __('messages.otp_sent_to_user'),
            'status' => '1'
        ]);
    }

    /**
     * confirm user's phone number with given verification code
     *
     * @param  \App\Http\Requests\Api\v1\ConfirmPhoneRequest $request
     * @return \Illuminate\Http\Response
     */
    public function confirmPhone(ConfirmPhoneRequest $request)
    {
        $user = Auth::user();
        if ($user->otp != $request->otp) {
            return response()->json([
                'message' => __('messages.wrong_otp'),
                'status' => '1'
            ]);
        }
        $user->otp = null;
        $user->is_phone_verified = 1;
        $user->save();
        $phone_verified_badge = Badge::where('slug', Badge::PHONE_VERIFIED)->first();
        if ($phone_verified_badge) {
            UserBadge::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'badge_id' => $phone_verified_badge->id,
            ]);
        }
        return response()->json([
            'message' => __('messages.otp_verified'),
            'status' => '1'
        ]);
    }

    /**
     * verify user's email
     *
     * @param  Illuminate\Http\Request $request
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verifyEmail(Request $request, $hash)
    {
        $user_id = Crypt::decrypt($hash);
        $user = User::findOrFail($user_id);
        $user->is_email_verified = 1;
        $user->save();
        $email_verified_badge = Badge::where('slug', Badge::EMAIL_VERIFIED)->first();
        if ($email_verified_badge) {
            UserBadge::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'badge_id' => $email_verified_badge->id,
            ]);
        }

        return view('email_verified');
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
