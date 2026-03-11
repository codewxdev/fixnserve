<?php

namespace App\Providers;

use App\Domains\Audit\Models\AdminActionLog;
use App\Domains\Audit\Models\SecurityAuditLog;
use App\Domains\Catalog\Models\Category;
use App\Domains\Catalog\Models\MartCategory;
use App\Domains\Catalog\Models\MartSubCategory;
use App\Domains\Catalog\Models\Skill;
use App\Domains\Catalog\Models\Specialty;
use App\Domains\Catalog\Models\Subcategory;
use App\Domains\Catalog\Models\SubSpecialty;
use App\Domains\Command\Models\EmergencyOverride;
use App\Domains\Command\Models\EmergencyOverrideLog;
use App\Domains\Command\Models\KillSwitch;
use App\Domains\Command\Models\Maintenance;
use App\Domains\RBAC\Models\PermissionAuditLog;
use App\Domains\System\Models\FeatureFlag;
use App\Domains\System\Models\FeatureFlagLog;
use App\Domains\System\Models\PlatformPreference;
use App\Models\AuditLog;
use App\Models\BusinessDoc;
use App\Models\ConsultantWeekDay;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Rating;
use App\Models\Service;
use App\Models\SubscriptionEntitlement;
use App\Models\SubscriptionPlan;
use App\Models\TransportType;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserLanguage;
use App\Observers\AutoTranslateObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        Category::observe(AutoTranslateObserver::class);
        MartCategory::observe(AutoTranslateObserver::class);
        MartSubCategory::observe(AutoTranslateObserver::class);
        Skill::observe(AutoTranslateObserver::class);
        Specialty::observe(AutoTranslateObserver::class);
        SubSpecialty::observe(AutoTranslateObserver::class);
        Subcategory::observe(AutoTranslateObserver::class);
        Product::observe(AutoTranslateObserver::class);
        AdminActionLog::observe(AutoTranslateObserver::class);
        SecurityAuditLog::observe(AutoTranslateObserver::class);
        EmergencyOverride::observe(AutoTranslateObserver::class);
        EmergencyOverrideLog::observe(AutoTranslateObserver::class);
        KillSwitch::observe(AutoTranslateObserver::class);
        Maintenance::observe(AutoTranslateObserver::class);
        PermissionAuditLog::observe(AutoTranslateObserver::class);
        FeatureFlag::observe(AutoTranslateObserver::class);
        FeatureFlagLog::observe(AutoTranslateObserver::class);
        PlatformPreference::observe(AutoTranslateObserver::class);
        AuditLog::observe(AutoTranslateObserver::class);
        BusinessDoc::observe(AutoTranslateObserver::class);
        ConsultantWeekDay::observe(AutoTranslateObserver::class);
        Country::observe(AutoTranslateObserver::class);
        Currency::observe(AutoTranslateObserver::class);
        Portfolio::observe(AutoTranslateObserver::class);
        Promotion::observe(AutoTranslateObserver::class);
        Rating::observe(AutoTranslateObserver::class);
        Service::observe(AutoTranslateObserver::class);
        SubscriptionEntitlement::observe(AutoTranslateObserver::class);
        SubscriptionPlan::observe(AutoTranslateObserver::class);
        TransportType::observe(AutoTranslateObserver::class);
        UserEducation::observe(AutoTranslateObserver::class);
        UserExperience::observe(AutoTranslateObserver::class);
        UserLanguage::observe(AutoTranslateObserver::class);

        RateLimiter::for('login', function (HttpRequest $request) {
            return Limit::perMinute(5)->by($request->email ?? $request->ip());
        });

        if (Cache::has('platform_preferences')) {
            config(['platform' => Cache::get('platform_preferences')]);
        }
    }
}
