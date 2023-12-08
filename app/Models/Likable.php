<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likable extends Model
{
    use HasFactory;

    //public $timestamps = false;

    //TABLE
    public $table = 'likables';

    //FILLABLE
    protected $fillable = [
        'user_id',
        'likable_type',
        'likable_id'
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
        return $this->morphTo(
            Post::class,
            'likable_type',
            'likable_id',
            'id'
        )->withoutGlobalScope('active')->withoutGlobalScope('is_liked');
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
