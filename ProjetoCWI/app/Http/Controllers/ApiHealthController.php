<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiHealthController extends Controller
{
    public function check(Request $request)
    {
        try {
            $externalUrl = config('services.external_health.url');

            $response = Http::timeout(3)
                ->retry(3, 100)
                ->get($externalUrl);

            return response()->json([
                'response' => $response->body(),
                'status' => $response->successful() ? 'healthy' : 'unhealthy',
                'external_api_status' => $response->status(),
                'response_time_ms' => $response->handlerStats()['total_time_us'] / 1000,
                'checked_at' => now()->toDateTimeString()
            ], $response->successful() ? 200 : 503);

        } catch (\Exception $e) {
            Log::error("Health check failed: " . $e->getMessage());

            return response()->json([
                'status' => 'unreachable',
                'error' => $e->getMessage(),
                'checked_at' => now()->toDateTimeString()
            ], 503);
        }
    }
}
