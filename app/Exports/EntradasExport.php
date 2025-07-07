<?php

namespace App\Exports;

use App\Models\Entrada;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EntradasExport implements FromCollection, WithHeadings
{
    protected $inicio;
    protected $fin;

    public function __construct($inicio, $fin)
    {
        $this->inicio = $inicio;
        $this->fin = $fin;
    }

    public function collection()
    {
        $query = Entrada::with('user', 'tipoalerta');

        if ($this->inicio) {
            $query->whereDate('fecha', '>=', $this->inicio);
        }

        if ($this->fin) {
            $query->whereDate('fecha', '<=', $this->fin);
        }

        return $query->get()->map(function ($e) {
            return [
                'descripcion' => $e->descripcion,
                'fecha' => $e->fecha,
                'hora' => $e->hora,
                'usuario' => $e->user->name ?? '—',
                'gestion' => $e->user->name ?? '—',
                'tipo_alerta' => $e->tipoalerta->descripcion ?? '—',
            ];
        });
    }

    public function headings(): array
    {
        return ['Descripción', 'Fecha', 'Hora', 'Usuario', 'Tipo de Alerta'];
    }
}
