<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\TitleHelper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register global helper functions
        if (!function_exists('app_title')) {
            function app_title(string $title = null): string
            {
                return TitleHelper::generate($title);
            }
        }
        
        if (!function_exists('app_name')) {
            function app_name(): string
            {
                return TitleHelper::getAppName();
            }
        }
        
        if (!function_exists('hospital_info')) {
            function hospital_info(): array
            {
                return TitleHelper::getHospitalInfo();
            }
        }
        
        if (!function_exists('meta_info')) {
            function meta_info(): array
            {
                return TitleHelper::getMetaInfo();
            }
        }
        
        if (!function_exists('og_title')) {
            function og_title(string $title = null): string
            {
                return TitleHelper::getOgTitle($title);
            }
        }
        
        if (!function_exists('og_description')) {
            function og_description(string $description = null): string
            {
                return TitleHelper::getOgDescription($description);
            }
        }
    }
}
