<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the creation of a user using the factory.
     */
    public function test_user_creation(): void
    {
        $user = User::factory()->create();

        $response = User::find($user->id);

        $this->assertNotNull($response);
    }
}
