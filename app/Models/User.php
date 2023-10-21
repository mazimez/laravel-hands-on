<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\SmsManager;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    const ADMIN = "ADMIN", USER = "USER";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'profile_image',
        'phone_number',
        'email',
        'password',
        'latitude',
        'longitude',
        'type',
        'otp',
        'is_phone_verified',
        'is_email_verified'
    ];

    /**
     * The "boot" method of the model.
     */
    //discussion going-on in this StackOverflow question: https://stackoverflow.com/questions/76598897/laravel-global-scope-using-global-scope-on-user-model-with-auth-in-it
    // protected static function boot(): void
    // {
    //     parent::boot();
    //     static::addGlobalScope('is_following', function ($query) {
    //         $user = Auth::user();
    //         if (!$user) {
    //             return $query;
    //         }
    //         return $query->withExists(['followers as is_following' => function ($query) use ($user) {
    //             return $query->where('user_follows.follower_id', $user->id);
    //         }]);
    //     });
    // }

    //APPENDS
    protected $appends = [
        'is_following'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'otp',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'distance' => "string",
        'is_following' => 'boolean'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, UserFollows::class, 'followed_id', 'follower_id', 'id', 'id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, UserFollows::class, 'follower_id', 'followed_id', 'id', 'id');
    }

    public function files()
    {
        return $this->morphMany(
            File::class, //model that stores data about polymorphic relationship
            'fileable', //prefix for the polymorphic relationship
            'fileable_type', //type column in that polymorphic table
            'fileable_id', //id column in that polymorphic table
            'id', //primary key on this table(model)
        );
    }

    public function badges()
    {
        return $this->belongsToMany(
            Badge::class,
            UserBadge::class,
            'user_id',
            'badge_id',
            'id',
            'id'
        )->withPivot(['created_at', 'updated_at']);
    }

    static function sendOtp(User $user)
    {
        if (config('services.two_factor.is_otp_live')) {
            if (!$user->phone_number) {
                throw new Exception(__('messages.need_phone_number_to_send_otp'));
            }

            $generatedOtp = null;
            do {
                $generatedOtp = mt_rand(1000, 9999);
            } while (User::where('otp', $generatedOtp)->first());

            SmsManager::sendTwoFactorMessage($user->phone_number, $generatedOtp);

            $user->otp = $generatedOtp;
            $user->save();
        } else {
            $user->otp = '1234';
            $user->save();
        }
    }

    //SCOPES
    // public function scopeAddIsFollowingBool($query)
    // {
    //     $user = Auth::user();
    //     if (!$user) {
    //         return $query;
    //     }
    //     return $query->withExists(['followers as is_following' => function ($query) use ($user) {
    //         return $query->where('user_follows.follower_id', $user->id);
    //     }]);
    // }

    //ATTRIBUTES
    public function getIsFollowingAttribute()
    {
        //FIXME::dont use attribute, try to do it with scope instead
        $user = Auth::user();
        if (!$user) {
            return false;
        }
        return UserFollows::where('followed_id', $user->id)->where('follower_id', $this->id)->exists();
    }
}