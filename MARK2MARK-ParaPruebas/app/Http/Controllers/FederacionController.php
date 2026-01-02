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

        $ultimosResultados = Results::with(['athlete', 'competition'])
            ->join('competiciones', 'resultados.id_competicion', '=', 'competiciones.id')
            ->orderBy('competiciones.fecha', 'desc')
            ->select('resultados.*')
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
                'telefono' => "666 654 123",
                'direccion' => "calle federacion 3, 4"
            ],
            'ultimos_resultados' => $ultimosResultados->values()->map(function ($res) {
                $fecha = $res->competition?->fecha
                    ? Carbon::parse($res->competition->fecha)->format('d/m/y')
                    : null;
                $texto = trim(($res->competition?->name ?? '') . ' ' . ($res->athlete?->nombre ?? ''));

                return [
                    'id' => $res->id,
                    'fecha' => $fecha,
                    'texto' => $texto
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
