<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Http\Requests\StoreAnnonceRequest;
use App\Http\Requests\UpdateAnnonceRequest;

class AnnonceController extends Controller
{
    public function index()
    {
        return Annonce::where('is_active', true)->get();
    }

    public function store(StoreAnnonceRequest $request)
    {
        $annonce = Annonce::create($request->validated());
        return response()->json($annonce, 201);
    }

    public function show(Annonce $annonce)
    {
        return $annonce;
    }

    public function update(UpdateAnnonceRequest $request, Annonce $annonce)
    {
        $annonce->update($request->validated());
        return response()->json($annonce);
    }

    public function destroy(Annonce $annonce)
    {
        $annonce->delete();
        return response()->json(null, 204);
    }
}