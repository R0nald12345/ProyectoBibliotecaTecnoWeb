<?php

namespace App\Http\Controllers;

use App\Models\Control;
use App\Models\entrada;
use App\Models\salida;
use App\Models\User;
use Carbon\Carbon;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;


class ControlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio') ?? Carbon::today()->toDateString();
        $fechaFin = $request->input('fecha_fin') ?? Carbon::today()->toDateString();

        $entradas = entrada::whereBetween('fecha', [$fechaInicio, $fechaFin])->get();
        $salidas = salida::whereBetween('fecha', [$fechaInicio, $fechaFin])->get();

        $estudiantesActuales = User::role('estudiante')->count();
        $capacidadMaxima = 150;

        $entradasPorHora = $entradas
            ->groupBy(fn($e) => Carbon::parse($e->fecha)->toDateString())
            ->map(fn($group) => $group->count());

        $salidasPorHora = $salidas
            ->groupBy(fn($s) => Carbon::parse($s->fecha)->toDateString())
            ->map(fn($group) => $group->count());


        $usuariosPorRol = Role::all()
            ->filter(fn($rol) => $rol->name !== 'admin')
            ->mapWithKeys(fn($rol) => [
                $rol->name => $rol->users->count()
            ]);


        return Inertia::render('Control/Index', [
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Control $control)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Control $control)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Control $control)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Control $control)
    {
        //
    }
}
