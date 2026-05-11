<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enseignant;

class EnseignantController extends Controller
{
    public function index()
    {
        try {
            return Enseignant::orderBy('id', 'desc')->get();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function genérerMatricule()
    {
        $last = Enseignant::orderBy('id', 'desc')->first();

        if ($last) {
            $lastMatricule = intval(substr($last->matricule, 3));
            $number = $lastMatricule + 1;
        } else {
            $number = 1;
        }

        $matricule = 'ENS' . str_pad($number, 4, '0', STR_PAD_LEFT);

        return $matricule;
    }

    public function getMatricule()
    {

        return response()->json(['matricule' => $this->genérerMatricule()]);
    }

    public function store(Request $request)
    {
        $enseignant = Enseignant::create([
            'matricule' => $this->genérerMatricule(),
            'nom' => $request->nom,
            'taux' => $request->taux,
            'heures' => $request->heures
        ]);

        return response()->json($enseignant, 201);
    }

    public function show($id)
    {
        return Enseignant::findOrFail($id);
    }


    public function update(Request $request, $id)
    {
        $enseignant = Enseignant::findOrFail($id);

        $enseignant->update([
            'nom' => $request->nom,
            'taux' => $request->taux,
            'heures' => $request->heures
        ]);

        return response()->json($enseignant, 200);
    }


    public function destroy($id)
    {
        Enseignant::destroy($id);
        return response()->json(null, 204);
    }
}
