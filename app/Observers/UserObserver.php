<?php

namespace App\Observers;

use App\Mail\WelcomeMail;
use App\Models\File;
use App\Models\User;
use App\Traits\ErrorManager;
use App\Traits\FileManager;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    use FileManager, ErrorManager;
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        try {
            Mail::to($user->email)
                ->send(new WelcomeMail($user));
        } catch (\Throwable $th) {
            ErrorManager::registerError($th->getMessage(), __FILE__, $th->getLine(), $th->getFile());
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        File::destroy($user->files()->get()->pluck('id'));
        $this->deleteFile($user->profile_image);
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
