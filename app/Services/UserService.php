<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function registerUser(array $data): array
    {
        if ($this->userRepository->findByEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Cet email est déjà utilisé.']
            ]);
        }

        $user = $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);

        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    /**
     * Connecte un utilisateur
     */
    public function loginUser(array $credentials): array
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Identifiants incorrects']
            ]);
        }

        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logoutUser($user): void
    {
        $user->tokens()->delete();
    }

    /**
     * Met à jour le profil utilisateur
     */
    public function updateProfile($userId, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($userId, $data);
    }

    /**
     * Récupère les utilisateurs par rôle
     */
    public function getUsersByRole(string $role, int $perPage = 15)
    {
        return $this->userRepository->getUsersByRole($role)->paginate($perPage);
    }

    /**
     * Supprime un utilisateur (admin seulement)
     */
    public function deleteUser($userId): bool
    {
        return $this->userRepository->delete($userId);
    }

    /**
     * Recherche d'utilisateurs
     */
    public function searchUsers(string $query, ?string $role = null)
    {
        return $this->userRepository->search($query, $role);
    }
}