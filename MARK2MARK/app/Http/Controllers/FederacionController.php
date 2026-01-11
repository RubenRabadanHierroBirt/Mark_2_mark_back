<?php

namespace App\Http\Controllers;

use App\DTOs\Competition\CompetitionDTO;
use App\Models\Competition;
use App\Models\Results;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FederacionController extends Controller
{
    public function getDashboard(Request $request)
    {
        $user = $request->user();
        if (!$user || $user->rol !== 'FEDERACION') {
            return $this->sendResponse('NO SUCCESS', 403, 'No autorizado', null);
        }

        $ultimasCompeticiones = Competition::where('fecha', '<', Carbon::now())
            ->orderBy('fecha', 'desc')
            ->take(3)
            ->get();

        $proximas = Competition::where('fecha', '>=', Carbon::now())
            ->orderBy('fecha', 'asc')
            ->take(3)
            ->get();

        $data = [
            'perfil' => [
                'nombre' => $user->username ?? 'Federacion',
                'email' => $user->email,
                'telefono' => null,
                'direccion' => null,
                'fotoUrl' => $user->imagen ?? null
            ],
            'ultimos_resultados' => $ultimasCompeticiones->values()->map(function ($competition) {
                $fecha = $competition->fecha
                    ? Carbon::parse($competition->fecha)->format('d/m/y')
                    : null;

                return [
                    'id' => $competition->id,
                    'fecha' => $fecha,
                    'texto' => $competition->name ?? ''
                ];
            }),
            'proximos_campeonatos' => $proximas->values()->map(function ($competition) {
                return new CompetitionDTO($competition);
            })
        ];

        return $this->sendResponse('SUCCESS', 200, 'Dashboard federacion cargado correctamente', $data);
    }

    public function sendResponse($status, $cod, $mensaje, $data)
    {
        return response()->json([
            'status' => $status,
            'codigo' => $cod,
            'mensaje' => $mensaje,
            'data' => $data
        ], $cod);
    }
}
