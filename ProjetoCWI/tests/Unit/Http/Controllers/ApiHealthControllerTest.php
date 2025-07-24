<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\ApiHealthController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ApiHealthControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Test the check method when external API is healthy.
     */
    public function test_check_healthy_response()
    {
        $fakeUrl = $this->faker->url;
        config(['services.external_health.url' => $fakeUrl]);

        $fakeResponse = [
            'response' => 'Fake Response',
            'status' => 'healthy',
            'external_api_status' => 200,
            'response_time_ms' => 50,
            'checked_at' => now()->toDateTimeString(),
        ];

        Http::fake([
            $fakeUrl => Http::response('Fake Response', 200, ['X-Time-Us' => 50000]),
        ]);

        $response = $this->getJson(action([ApiHealthController::class, 'check']));

        $response->assertOk();
        $response->assertJson($fakeResponse);
    }

    /**
     * Test the check method when external API responds with an error.
     */
    public function test_check_unhealthy_response()
    {
        $fakeUrl = $this->faker->url;
        config(['services.external_health.url' => $fakeUrl]);

        $fakeResponse = [
            'response' => 'Fake Error Response',
            'status' => 'unhealthy',
            'external_api_status' => 500,
            'response_time_ms' => 50,
            'checked_at' => now()->toDateTimeString(),
        ];

        Http::fake([
            $fakeUrl => Http::response('Fake Error Response', 500, ['X-Time-Us' => 50000]),
        ]);

        $response = $this->getJson(action([ApiHealthController::class, 'check']));

        $response->assertStatus(503);
        $response->assertJson($fakeResponse);
    }

    /**
     * Test the check method when external API is unreachable.
     */
    public function test_check_unreachable()
    {
        $fakeUrl = $this->faker->url;
        config(['services.external_health.url' => $fakeUrl]);

        Http::fake([
            $fakeUrl => Http::timeout(500),
        ]);

        Log::shouldReceive('error')
            ->once()
            ->withArgs(function ($message) {
                return str_contains($message, 'Health check failed:');
            });

        $response = $this->getJson(action([ApiHealthController::class, 'check']));

        $response->assertStatus(503);
        $response->assertJsonStructure([
            'status',
            'error',
            'checked_at',
        ]);

        $this->assertEquals('unreachable', $response['status']);
    }
}
