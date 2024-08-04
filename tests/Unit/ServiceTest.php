<?php

namespace Tests\Unit;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the creation of a service using the factory.
     *
     * @return void
     */
    public function test_service_creation(): void
    {
        // Create a service using the factory
        $service = Service::factory()->create();

        // Check if the service was created and has the expected attributes
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => $service->name,
            'description' => $service->description,
            'price' => $service->price,
        ]);
    }
}
