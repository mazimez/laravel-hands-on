<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostFile extends Model
{
    use HasFactory;

    //public $timestamps = false;

    //TABLE
    public $table = 'post_files';

    const PHOTO = "PHOTO", VIDEO = "VIDEO";

    //FILLABLE
    protected $fillable = [
        'post_id',
        'file_path'
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
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    //ATTRIBUTES
    //public function getExampleAttribute()
    //{
    //    return $data;
    //}

}
