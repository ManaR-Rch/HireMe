<?php

namespace Tests\Feature;

use App\Models\Annonce;
use App\Models\User;
use Tests\TestCase;

class AnnoncePolicyTest extends TestCase
{
    public function test_recruiter_can_create_annonces()
    {
        $user = User::factory()->create(['role' => 'recruiter']);
        $this->assertTrue($user->can('create', Annonce::class));
    }

    public function test_candidate_cannot_create_annonces()
    {
        $user = User::factory()->create(['role' => 'candidate']);
        $this->assertFalse($user->can('create', Annonce::class));
    }

    public function test_owner_can_update_annonce()
    {
        $user = User::factory()->create(['role' => 'recruiter']);
        $annonce = Annonce::factory()->create(['user_id' => $user->id]);
        $this->assertTrue($user->can('update', $annonce));
    }
}