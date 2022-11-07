<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('backend.layouts.main', function ($view) {
            $view
                ->with('new_noti', Notification::where([
                    ['user_id', Auth::user()->id],
                ])->take(3)->orderBy('created_at', 'desc')->get())
                ->with('count_noti', Notification::where([
                    ['user_id', Auth::user()->id],
                    ['read', 0]
                ])->count())
                ->with('all_noti_count', Notification::where('user_id', Auth::user()->id)->count());
        });
    }
}
