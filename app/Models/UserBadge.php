<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserBadge extends Model
{
    use HasFactory;

    //public $timestamps = false;

    //TABLE
    public $table = 'user_badges';

    //FILLABLE
    protected $fillable = [
        'user_id',
        'badge_id',
        'badgeable_type',
        'badgeable_id',
        'meta_data'
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

    public function post()
    {
        return $this->morphTo(
            Post::class,
            'badgeable_type',
            'badgeable_id',
            'id'
        )->withoutGlobalScope('active');
    }

    public function badgeable(): MorphTo
    {
        return $this->morphTo();
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