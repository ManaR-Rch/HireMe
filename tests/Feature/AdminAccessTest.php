<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    public function test_admin_dashboard_access()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/api/admin/stats');
        $response->assertOk();
    }

    public function test_non_admin_cannot_access_dashboard()
    {
        $user = User::factory()->create(['role' => 'recruiter']);
        $response = $this->actingAs($user)->get('/api/admin/stats');
        $response->assertForbidden();
    }
}