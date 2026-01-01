<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\DTOs\Club\ClubDTO;
use App\DTOs\Club\ClubDashboardDTO;
use App\Models\Results;
use App\Models\Competition;
use App\Models\Club;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClubController extends Controller
{
    public function getDashboard(Request $request)
    {
        $clubId = 1; // ID FIJO
        $club = Club::find($clubId);

      if (!$club) {
            return response()->json(['status' => 'ERROR', 'mensaje' => 'Club no encontrado'], 404);
        }

        // --- CAMBIO CLAVE AQUÍ ---
        // 1. Buscamos los IDs de los atletas que están AHORA en este club
        // Miramos la tabla 'atleta_club' que me has enseñado
        $idsAtletasDelClub = DB::table('atleta_club')
            ->where('id_club', $clubId)
            ->whereNull('fecha_fin') // Solo los activos (que no se han ido)
            ->pluck('id_atleta');    // Nos da una lista: [1, 4]

        // 2. Buscamos Resultados SOLO de esos atletas
        $resultados = Results::whereIn('id_atleta', $idsAtletasDelClub)
            ->with(['athlete', 'competition'])
            ->join('competiciones', 'resultados.id_competicion', '=', 'competiciones.id')
            ->orderBy('competiciones.fecha', 'desc')
            ->select('resultados.*') 
            ->take(3) 
            ->get();

        // 2. Buscamos Próximas Competiciones
        $proximas = Competition::where('fecha', '>=', Carbon::now())
            ->orderBy('fecha', 'asc')
            ->take(3)
            ->get();

        // 3. Usamos el DTO ESPECIAL para el Dashboard
        $dto = new ClubDashboardDTO($club, $resultados, $proximas);

        return response()->json([
            'status' => 'SUCCESS',
            'data' => $dto
        ], 200);
    }
    // FALTAN CREAR LAS VALIDACIONES PARA CREATE Y UPDATE, COMPROBAR SI FUNCIONAN LAS DE ATHLETE CON LA BBDD Y AÑADIRLAS AQUI
    public function getAll()
    {
        $clubs = Club::with('user')->get();
        $dtosClubs = [];

        foreach ($clubs as $club) {
            $dtosClubs[] = new ClubDTO($club);
        }

        if ($dtosClubs) {
            $status = 'SUCCESS';
            $cod = 200;
            $mensaje = 'Contenido mostrado correctamente';

            return $this->sendResponse($status, $cod, $mensaje, $dtosClubs);
        } else {
            $status = 'NO SUCCESS';
            $cod = 404;
            $mensaje = 'Error al acceder al contenido';

            return $this->sendResponse($status, $cod, $mensaje, null);
        }
    }
    
    public function create(Request $request)
    {
        $club = Club::create($request->all());

        if ($club) {
            return $this->sendResponse(
                $status = 'SUCCESS',
                $cod = 201,
                $mensaje = 'Elemento creado correctamente',
                new ClubDTO($club)
            );

        } else {

            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Error al crear el elemento',
                null
            );    
        }
    }
    
    public function getById(string $id)
    {
        $club = Club::with('user')->find($id);

        if ($club) {
            return $this->sendResponse(
                'SUCCESS',
                200,
                'Elemento mostrado correctamente',
                new ClubDTO($club)
            );
        } else {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Club no encontrado',
                null
            );
        }    }

    public function update(Request $request, string $id)
    {
        $club = Club::find($id);

        if ($club) {
            $club->update($request->all());

            return $this->sendResponse(
                'SUCCESS',
                200,
                'Elemento con ID ' . $id . ' actualizado correctamente',
                new ClubDTO($club)
            );
        } else {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Club no encontrado',
                null
            );
        }
    }
    
    
    public function delete(string $id)
    {
        $club = Club::find($id);

        if ($club) {
            $club->delete();

            return $this->sendResponse(
                'SUCCESS',
                200,
                'El siguiente elemento se ha eliminado correctamente',
                new ClubDTO($club)
            );
        } else {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Error al eliminar el elemento',
                null
            );
        }
    }

    public function sendResponse($status, $cod, $mensaje, $data) {
        return response()->json([
            'status' => $status,
            'codigo' => $cod,
            'mensaje' => $mensaje,
            'data' => $data
        ], $cod);
    }
}