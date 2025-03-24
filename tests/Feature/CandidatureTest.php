<?php

namespace Tests\Feature;

use App\Models\Candidature;
use App\Models\User;
use App\Services\CandidatureService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidatureServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(CandidatureService::class);
    }

    public function test_change_status()
    {
        $candidature = Candidature::factory()->create(['status' => 'pending']);
        $this->service->changeStatus($candidature->id, 'accepted');
        
        $this->assertEquals('accepted', $candidature->fresh()->status);
    }

    public function test_candidate_cannot_change_status()
    {
        $candidate = User::factory()->create(['role' => 'candidate']);
        $candidature = Candidature::factory()->create();
        
        $this->actingAs($candidate);
        $response = $this->putJson("/api/candidatures/{$candidature->id}", [
            'status' => 'accepted'
        ]);
        
        $response->assertForbidden();
    }
}