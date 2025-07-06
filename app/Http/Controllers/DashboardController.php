<?php

namespace App\Http\Controllers;

use App\Models\entrada;
use App\Models\salida;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio') ?? Carbon::today()->toDateString();
        $fechaFin = $request->input('fecha_fin') ?? Carbon::today()->toDateString();

        $entradas = Entrada::whereBetween('fecha', [$fechaInicio, $fechaFin])->get();
        $salidas = Salida::whereBetween('fecha', [$fechaInicio, $fechaFin])->get();

        $estudiantesActuales = User::role('estudiante')->count();
        $capacidadMaxima = 150;

        $entradasPorHora = $entradas
            ->groupBy(fn($e) => Carbon::parse($e->fecha)->toDateString())
            ->map(fn($group) => $group->count());

        $salidasPorHora = $salidas
            ->groupBy(fn($s) => Carbon::parse($s->fecha)->toDateString())
            ->map(fn($group) => $group->count());


        $usuariosPorRol = Role::all()->mapWithKeys(fn($rol) => [
            $rol->name => $rol->users->count()
        ]);

        return Inertia::render('Dashboard', [
            'estadisticas' => [
                'estudiantesActuales' => $estudiantesActuales,
                'entradasHoy' => $entradas->count(),
                'salidasHoy' => $salidas->count(),
                'capacidadMaxima' => $capacidadMaxima,
                'usuariosPorRol' => $usuariosPorRol,
                'entradasPorHora' => $entradasPorHora,
                'salidasPorHora' => $salidasPorHora,
            ],
            'filtros' => [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
            ]
        ]);
    }
}
