<?php

namespace App\Http\Controllers;

use App\Exports\EntradasExport;
use App\Exports\SalidasExport;
use App\Models\salida;
use App\Models\TipoAlerta;
use App\Models\User;
use App\Models\Gestion;
use Carbon\Carbon;
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

        $gestiones = Gestion::select('id', 'nombre')
            ->where('estado', 'activo')
            ->get();

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
        $codigo = $request->user_id;

        // Buscar usuario
        $user = User::find($codigo);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Usuario no encontrado comunicarse con el ADMINISTRADOR',
            ], 404);
        }

        // Asignar rol si no lo tiene
        if (!$user->hasRole('estudiante')) {
            $user->assignRole('estudiante');
        }

        $hoy = Carbon::today();


        Salida::create([
            'descripcion' => 'Salida por código QR',
            'fecha' => $hoy,
            'hora' => Carbon::now()->toTimeString(),
            'user_id' => $user->id,
            'gestion_id' => 1,
            'tipoalerta_id' => $request->tipoalerta_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Asistencia Salida registrada correctamente',
        ]);
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
