<?php

namespace Tests\Feature;

use App\Modules\User\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page()
    {
        $response = $this->get('/subscriptions');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_visit_the_subscriptions_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/subscriptions');
        $response->assertStatus(200);
    }
}
