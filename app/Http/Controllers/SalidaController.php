<?php

namespace App\Http\Controllers;

use App\Exports\EntradasExport;
use App\Exports\SalidasExport;
use App\Models\Salida;
use App\Models\TipoAlerta;
use App\Models\User;
use App\Models\Gestion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class SalidaController extends Controller
{

    public function exportExcel(Request $request)
    {
        return Excel::download(new SalidasExport($request->inicio, $request->fin), 'salidas.xlsx');
    }


    public function index()
    {
        $salidas = Salida::with(['user', 'tipoalerta', 'gestion'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Salida/Index', [
            'salidas' => $salidas
        ]);
    }

    public function create()
    {
        $usuarios = User::select('id', 'name')->get();
        $tiposAlerta = TipoAlerta::select('id', 'descripcion')->get();
        $gestiones = Gestion::select('id', 'nombre')->get();

        $fecha = now()->format('Y-m-d');
        $hora = now()->format('H:i');

        return Inertia::render('Salida/Create', [
            'usuarios' => $usuarios,
            'tipos_alerta' => $tiposAlerta,
            'gestiones' => $gestiones,
            'fecha_actual' => $fecha,
            'hora_actual' => $hora,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion'     => 'required|string|max:255',
            'fecha'           => 'required|date',
            'hora'            => 'required',
            'user_id'         => 'required|exists:users,id',
            'tipoalerta_id'   => 'required|exists:tipoalerta,id',
            'gestion_id'      => 'required|exists:gestion,id',
        ]);

        Salida::create($data);

        return redirect()->route('salida.index')->with('success', 'Salida creada correctamente.');
    }

    public function edit(Salida $salida)
    {
        // Implementar si necesitas edición
    }

    public function update(Request $request, Salida $salida)
    {
        // Implementar si necesitas actualización
    }

    public function destroy($id)
    {
        $salida = Salida::findOrFail($id);
        $salida->delete();

        return redirect()->route('salida.index')->with('success', 'Salida eliminada correctamente.');
    }
}
