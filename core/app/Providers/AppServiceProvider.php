<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Ptc;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $general = gs();
        $viewShare['general'] = $general;
        $activeTemplate = activeTemplate();
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        if (Schema::hasTable('languages')) {
            $viewShare['language'] = Language::all();
        } else {
            $viewShare['language'] = collect();
        }
        $viewShare['emptyMessage'] = 'Data not found';
        view()->share($viewShare);


        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'           => User::banned()->count(),
                'emailUnverifiedUsersCount' => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => User::mobileUnverified()->count(),
                'kycUnverifiedUsersCount'   => User::kycUnverified()->count(),
                'kycPendingUsersCount'   => User::kycPending()->count(),
                'pendingTicketCount'         => SupportTicket::whereIN('status', [0,2])->count(),
                'pendingDepositsCount'    => Deposit::pending()->count(),
                'pendingWithdrawCount'    => Withdrawal::pending()->count(),
                'pendingPtcCount'    => Ptc::pending()->count(),
                'unreadContactCount'    => Schema::hasTable('contact_messages') ? \App\Models\ContactMessage::where('status', 'unread')->count() : 0,
            ]);
        });

        // Add unread contact count to admin views only (safer approach)
        view()->composer('admin.*', function ($view) {
            if (Schema::hasTable('contact_messages')) {
                try {
                    $unreadCount = \App\Models\ContactMessage::where('status', 'unread')->count();
                    $view->with('unreadContactCount', $unreadCount);
                } catch (\Exception $e) {
                    // If query fails for any reason, set count to 0
                    $view->with('unreadContactCount', 0);
                }
            }
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications'=>AdminNotification::where('read_status',0)->with('user')->orderBy('id','desc')->take(10)->get(),
                'adminNotificationCount'=>AdminNotification::where('read_status',0)->count(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if($general->force_ssl){
            \URL::forceScheme('https');
        }

        // Force root URL to respect subfolder configuration
        \URL::forceRootUrl(config('app.url'));

        Paginator::useBootstrapFour();
    }
}
