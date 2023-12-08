<?php

namespace App\Models;

use App\Traits\ErrorManager;
use App\Traits\FcmNotificationManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Notification extends Model
{
    use HasFactory, FcmNotificationManager, ErrorManager;
    //CLICK ACTIONS
    const OPEN_POST = "OPEN_POST", DO_NOTHING = "DO_NOTHING", OPEN_PROFILE = "OPEN_PROFILE";

    //TYPES
    const POST_LIKED = "POST_LIKED", NEW_BADGE_ADDED = "NEW_BADGE_ADDED";

    //public $timestamps = false;

    //TABLE
    public $table = 'notifications';

    //FILLABLE
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'click_action',
        'meta_data',
        'notifiable_type',
        'notifiable_id'
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
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function post()
    {
        return $this->morphTo(
            Post::class,
            'notifiable_type',
            'notifiable_id',
            'id'
        )
            ->withoutGlobalScope('active');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * send the notification to user based on it's data
     *
     * @param  \App\Models\Notification  $notification
     * @return boolean
     */
    static function sendNotification(Notification $notification)
    {
        try {
            switch ($notification->type) {
                case Notification::POST_LIKED:
                    $image_url = null;
                    $post = $notification->post;
                    if ($post) {
                        if ($post->file) {
                            $image_url = Storage::url($post->file->file_path);
                        }
                    }
                    FcmNotificationManager::sendNotification(
                        $notification->user->firebase_tokens,
                        $notification->title,
                        $notification->message,
                        $notification->click_action,
                        $notification->meta_data,
                        $image_url
                    );
                    break;

                default:
                    FcmNotificationManager::sendNotification(
                        $notification->user->firebase_tokens,
                        $notification->title,
                        $notification->message,
                        $notification->click_action,
                        $notification->meta_data
                    );
                    break;
            }
        } catch (\Throwable $th) {
            ErrorManager::registerError($th->getMessage(), __FILE__, $th->getLine(), $th->getFile());
        }

        return true;
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