<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PostComment extends Model
{
    use HasFactory;

    //public $timestamps = false;

    //TABLE
    public $table = 'post_comments';

    //FILLABLE
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
    ];

    /**
     * The "boot" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();
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
    protected $casts = [];

    //RELATIONSHIPS
    public function post()
    {
        return $this->belongsTo(Post::class)->withoutGlobalScope('active');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function badges()
    {
        return $this->morphMany(
            UserBadge::class,
            'badgeable',
            'badgeable_type',
            'badgeable_id',
            'id',
        );
    }

    //with polymorphism
    public function likers()
    {
        return $this->morphToMany(
            User::class, //class to which we finally wanted to connect
            'likable', //prefix for the polymorphic relationship
            'likables', //table name in which the polymorphic relationship data is stored
            'likable_id', //id column in that polymorphic table
            'user_id', //column name that connects to the final table(in our case `users`)
            'id', //primary key on final table(users)
        );
    }

    //ATTRIBUTES
    //public function getExampleAttribute()
    //{
    //    return $data;
    //}

}
