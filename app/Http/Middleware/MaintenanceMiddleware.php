<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MaintenanceSetting;

class MaintenanceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $maintenance = MaintenanceSetting::where('key', 'maintenance_mode')->first();
        $message = MaintenanceSetting::where('key', 'maintenance_message')->value('value');

        if ($maintenance && $maintenance->value === 'true') {
            return response()->view('maintenance', compact('message'));
        }

        return $next($request);
    }
}
