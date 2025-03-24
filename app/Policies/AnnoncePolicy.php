<?php
// app/Policies/AnnoncePolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\Annonce;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnoncePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Annonce $annonce)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->role === 'recruiter';
    }

    public function update(User $user, Annonce $annonce)
    {
        return $user->id === $annonce->user_id;
    }

    public function delete(User $user, Annonce $annonce)
    {
        return $user->id === $annonce->user_id || $user->role === 'admin';
    }
}