<?php

namespace App\Providers;

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
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share schedule settings with the layout for the appointment modal
        \Illuminate\Support\Facades\View::composer('layouts.app', function ($view) {
            $defaultHours = [
                '1' => [['start' => '09:00', 'end' => '17:00']],
                '2' => [['start' => '09:00', 'end' => '17:00']],
                '3' => [['start' => '09:00', 'end' => '17:00']],
                '4' => [['start' => '09:00', 'end' => '17:00']],
                '5' => [['start' => '09:00', 'end' => '17:00']],
            ];
            $view->with('scheduleSettings', [
                'availableDays' => \App\Models\Setting::where('key', 'available_days')->first()?->value ?? json_encode(['1', '2', '3', '4', '5']),
                'workingHours' => \App\Models\Setting::where('key', 'working_hours')->first()?->value ?? json_encode($defaultHours),
                'bookedSlots' => \App\Models\Appointment::whereNotIn('status', ['cancelled'])->pluck('appointment_date')->toArray(),
            ]);
        });
    }
}
