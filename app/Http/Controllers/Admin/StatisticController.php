<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\User;
use App\Models\Candidature;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        return response()->json([
            'users_count' => User::count(),
            'annonces_count' => Annonce::count(),
            'active_annonces' => Annonce::where('is_active', true)->count(),
            'candidatures_count' => Candidature::count(),
            'latest_candidatures' => Candidature::with(['user', 'annonce'])
                ->latest()
                ->take(5)
                ->get()
        ]);
    }
}