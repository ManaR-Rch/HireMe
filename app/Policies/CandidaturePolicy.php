<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Candidature;
use Illuminate\Auth\Access\HandlesAuthorization;

class CandidaturePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Candidature $candidature)
    {
        return $user->id === $candidature->user_id 
               || $user->id === $candidature->annonce->user_id
               || $user->role === 'admin';
    }

    public function create(User $user)
    {
        return $user->role === 'candidate';
    }

    public function update(User $user, Candidature $candidature)
    {
        return $user->id === $candidature->annonce->user_id;
    }

    public function delete(User $user, Candidature $candidature)
    {
        return $user->id === $candidature->user_id
               || $user->role === 'admin';
    }
}