<?php
namespace App\Services;

use App\Repositories\Contracts\AnnonceRepositoryInterface;
use App\Repositories\Contracts\CandidatureRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

class StatisticService
{
    protected $annonceRepository;
    protected $candidatureRepository;
    protected $userRepository;

    public function __construct(
        AnnonceRepositoryInterface $annonceRepository,
        CandidatureRepositoryInterface $candidatureRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->annonceRepository = $annonceRepository;
        $this->candidatureRepository = $candidatureRepository;
        $this->userRepository = $userRepository;
    }

    public function getRecruiterStats($userId)
    {
        $annonces = $this->annonceRepository->getByUser($userId);
        $annonceIds = $annonces->pluck('id');
        
        $totalCandidatures = $this->candidatureRepository->countByAnnonces($annonceIds);
        
        return [
            'total_annonces' => $annonces->count(),
            'active_annonces' => $annonces->where('is_active', true)->count(),
            'total_candidatures' => $totalCandidatures,
            'candidatures_by_status' => $this->candidatureRepository->countByStatus($annonceIds),
            'candidatures_by_annonce' => $this->candidatureRepository->countByAnnonce($annonceIds)
        ];
    }

    public function getAdminStats()
    {
        return [
            'total_users' => $this->userRepository->count(),
            'users_by_role' => $this->userRepository->countByRole(),
            'total_annonces' => $this->annonceRepository->count(),
            'annonces_by_status' => $this->annonceRepository->countByStatus(),
            'total_candidatures' => $this->candidatureRepository->count(),
            'candidatures_by_status' => $this->candidatureRepository->countByStatus()
        ];
    }
}