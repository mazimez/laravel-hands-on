<?php

namespace App\Console\Commands;

use App\Mail\MostPostedMail;
use App\Models\Post;
use App\Models\User;
use App\Traits\ErrorManager;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CalculateMonthlyRewards extends Command
{
    use ErrorManager;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:rewards:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command To calculate the monthly rewards and send it to Users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user_with_most_monthly_post = User::where('type', User::USER)
            ->withCount(['posts' => function ($query) {
                $query
                    ->where('created_at', '>=', Carbon::now()->startOfMonth())
                    ->where('created_at', '<=', Carbon::now()->endOfMonth());
            }])
            ->orderBy('posts_count', 'desc')
            ->first();
        try {
            Mail::to($user_with_most_monthly_post->email)
                ->send(new MostPostedMail($user_with_most_monthly_post, $user_with_most_monthly_post->posts_count));
        } catch (\Throwable $th) {
            ErrorManager::registerError($th->getMessage(), __FILE__, $th->getLine(), $th->getFile());
        }
    }
}