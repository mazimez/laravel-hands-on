<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollows extends Model
{
    use HasFactory;

    //public $timestamps = false;

    //TABLE
    public $table = 'user_follows';

    //FILLABLE
    protected $fillable = [
        'follower_id',
        'followed_id',
    ];

    //HIDDEN
    protected $hidden = [];

    //APPENDS
    protected $appends = [];

    //WITH
    protected $with = [];

    //CASTS
    protected $casts = [];

    //RELATIONSHIPS
    public function follower()
    {
        return $this->belongsTo(User::class, 'id', 'follower_id');
    }
    public function followed()
    {
        return $this->belongsTo(User::class, 'id', 'followed_id');
    }

    //ATTRIBUTES
    //public function getExampleAttribute()
    //{
    //    return $data;
    //}

}
