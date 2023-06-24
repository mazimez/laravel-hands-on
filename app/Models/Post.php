<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

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

    //ATTRIBUTES
    //public function getExampleAttribute()
    //{
    //    return $data;
    //}

}
