<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    //public $timestamps = false;

    const FIRST_POST = "FIRST_POST";
    const PHONE_VERIFIED = "PHONE_VERIFIED";
    const EMAIL_VERIFIED = "EMAIL_VERIFIED";

    //TABLE
    public $table = 'badges';

    //FILLABLE
    protected $fillable = [
        'name',
        'slug',
        'description',
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
    //public function example(){
    //    return $this->hasMany();
    //}

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
