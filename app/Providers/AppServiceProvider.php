<?php

namespace App\Providers;

use App\Models\Contact;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNAdapter;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('includes.header', function ($view) {
            $contact_info = Contact::first();
            $view->with('contact', $contact_info);
        });
        View::composer('includes.footer', function ($view) {
            $contact_info = Contact::first();
            $view->with('contact', $contact_info);
        });
    }
}
