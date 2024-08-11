<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    //public $timestamps = false;

    //TABLE
    public $table = 'files';
    const PHOTO = "PHOTO", VIDEO = "VIDEO";
    //FILLABLE
    protected $fillable = [
        'user_id',
        'file_path',
        'type',
        'fileable_id',
        'fileable_type',
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
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->morphTo(
            User::class, //model that polymorphic table should connects to
            'fileable_type', //type column in that polymorphic table
            'fileable_id', //id column in that polymorphic table
            'id' //primary key on main table(user)
        );
    }

    public function post()
    {
        return $this->morphTo(
            Post::class, //model that polymorphic table should connects to
            'fileable_type', //type column in that polymorphic table
            'fileable_id', //id column in that polymorphic table
            'id' //primary key on main table(post)
        )->withoutGlobalScope('active');
    }

    //SCOPES
    //public function scopeExample($query)
    //{
    //    $query->where('columns_name', 'some_condition');
    //}

    //ATTRIBUTES
    //public function getExampleAttribute()
    //{
    //    return $data;
    //}

}
