<?php

namespace Tests\Feature;

use App\Models\QueueSession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QueueSessionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_remove_queue_user_clears_the_users_queue_session_from_route_params(): void
    {
        $queueSession = QueueSession::query()->create([
            'created_by' => null,
            'company_id' => null,
            'queue_status' => 'active',
            'name' => 'Morning Queue',
            'description' => 'Front desk queue',
        ]);

        $user = User::factory()->create([
            'mobile_number' => '09170000000',
            'queue_session_id' => $queueSession->id,
        ]);

        $response = $this->withoutMiddleware()->deleteJson(
            "/api/queue-sessions/{$queueSession->id}/queue-users/{$user->id}"
        );

        $response
            ->assertOk()
            ->assertJsonPath('userRemovedFromQue', true)
            ->assertJsonPath('data.id', $queueSession->id);

        $this->assertNull($user->fresh()->queue_session_id);
    }
}