<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidatureRequest;
use App\Models\Annonce;
use App\Models\Candidature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidatureController extends Controller
{
    public function store(StoreCandidatureRequest $request, Annonce $annonce)
    {
        $this->authorize('create', Candidature::class);
        
        $candidature = Candidature::create([
            'user_id' => Auth::id(),
            'annonce_id' => $annonce->id,
            'cv_path' => $request->file('cv')->store('cvs'),
            'motivation_letter_path' => $request->file('motivation_letter')->store('letters'),
            'status' => 'pending'
        ]);

        return response()->json($candidature, 201);
    }

    public function destroy(Candidature $candidature)
    {
        $this->authorize('delete', $candidature);
        
        Storage::delete([$candidature->cv_path, $candidature->motivation_letter_path]);
        $candidature->delete();
        
        return response()->json(null, 204);
    }
}