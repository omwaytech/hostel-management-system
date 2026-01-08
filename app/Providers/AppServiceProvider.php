<?php

namespace App\Providers;

use App\Models\Block;
use App\Models\SystemConfig;
use App\Models\HostelConfig;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Hostel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (session()->has('current_hostel_id')) {
                $hostel = Hostel::find(session('current_hostel_id'));
                $view->with('currentHostel', $hostel);
            } else {
                $view->with('currentHostel', null);
            }

            if (session()->has('current_block_id')) {
                $block = Block::find(session('current_block_id'));
                $view->with('currentBlock', $block);
            } else {
                $view->with('currentBlock', null);
            }

            // Share SystemConfig data across all views
            $systemConfigs = SystemConfig::pluck('value', 'key')->toArray();
            $view->with('systemConfigs', $systemConfigs);

            // Share HostelConfig data across all views (based on active_hostel session)
            // Only set if not already provided by controller
            if (!$view->offsetExists('hostelConfigs')) {
                if (session()->has('active_hostel')) {
                    $activeHostel = session('active_hostel');
                    $hostelConfigs = HostelConfig::where('hostel_id', $activeHostel->id)
                        ->pluck('value', 'key')
                        ->toArray();
                    $view->with('hostelConfigs', $hostelConfigs);
                } else {
                    $view->with('hostelConfigs', []);
                }
            }
        });

    }
}
