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
        $datos = \App\Models\Gestion::withCount('entradas')->get()->map(function ($g) {
            return [
                'gestion' => $g->nombre,
                'total' => $g->entradas_count,
            ];
        });

        return Inertia::render('Dashboard', [ // Asegúrate que sea 'Dashboard' con D mayúscula
            'entradasPorGestion' => $datos
        ]);
    }
}
