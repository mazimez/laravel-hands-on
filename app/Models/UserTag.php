<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UserTag extends Model
{
    use HasFactory;

    //public $timestamps = false;

    //TABLE
    public $table = 'user_tags';

    //FILLABLE
    protected $fillable = [
        'user_id',
        'tag_id',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    /**
     * add the tags into user's interested tags list
     *
     * @param  User  $user instance of user model on which you want to add tags
     * @param    $tag_ids  array of tag ids that you want to add into users
     */
    public static function addTags(User $user, $tag_ids)
    {
        $user->tags()->syncWithoutDetaching($tag_ids);
        Cache::put('user_'.$user->id.'_tag_ids', $user->tags->pluck('id')->toArray(), now()->addWeek());
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
