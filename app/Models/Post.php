<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    //public $timestamps = false;

    //TABLE
    public $table = 'posts';

    //FILLABLE
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'meta_data',
        'is_verified',
        'is_blocked'
    ];

    /**
     * The "boot" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope('active', function ($query) {
            $query->where('posts.is_verified', 1)->where('posts.is_blocked', 0);
        });

        static::addGlobalScope('is_liked', function ($query) {
            $user = Auth::user();
            if (!$user) {
                return $query;
            }
            return $query->withExists(['likers as is_liked' => function ($query) use ($user) {
                return $query->where('users.id', $user->id);
            }]);
        });
    }


    //HIDDEN
    protected $hidden = [];

    //APPENDS
    protected $appends = [];

    //WITH
    protected $with = [];

    //CASTS
    protected $casts = [
        'meta_data' => 'array'
    ];

    //RELATIONSHIPS
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function files()
    {
        return $this->hasMany(PostFile::class);
    }
    public function file()
    {
        return $this->hasOne(PostFile::class)->where('type', PostFile::PHOTO);
    }
    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }
    public function likers()
    {
        return $this->belongsToMany(User::class, PostLike::class, 'post_id', 'user_id', 'id', 'id');
    }

    //SCOPES
    public function scopeMostLikedFirst($query)
    {
        return $query->withCount(['likers'])->orderBy('likers_count', 'desc');
    }

    //ATTRIBUTES
    //public function getExampleAttribute()
    //{
    //    return $data;
    //}

}
