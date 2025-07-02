<?php

namespace App\Http\Controllers;

use App\Models\dashboard;
use App\Models\entrada;
use App\Models\Gestion;
use App\Models\salida;
use App\Models\tipoalerta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function graficoEntradasPorGestion()
    {
        $entradasPorGestion = \App\Models\Entrada::selectRaw('gestion_id, COUNT(*) as total')
            ->groupBy('gestion_id')
            ->with('gestion') // Asegúrate de tener la relación definida
            ->get()
            ->map(function ($item) {
                return [
                    'gestion' => $item->gestion->nombre ?? 'Sin nombre',
                    'total' => $item->total
                ];
            });

        return Inertia::render('Dashboard', [
            'entradasPorGestion' => $entradasPorGestion
        ]);
    }
}
