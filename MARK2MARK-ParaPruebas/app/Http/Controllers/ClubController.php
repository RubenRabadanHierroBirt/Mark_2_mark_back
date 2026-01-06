<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\DTOs\Club\ClubDTO;
use App\DTOs\Club\ClubDashboardDTO;
use App\Models\AthleteRegistration;
use App\Models\Competition;
use App\Models\Club;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClubController extends Controller
{
    public function getDashboard(Request $request)
    {

        // 1. OBTENER EL CLUB DEL USUARIO LOGUEADO
        $user = Auth::user();
        if (!$user) {
            return $this->sendResponse('NO SUCCESS', 401, 'Usuario no autenticado', null);
        }

        // Si el usuario es admin, quizás quieras pasar un ID, pero por defecto cogemos su club
        $club = $user->club;

        // Si no tiene club asociado (ej: es un usuario nuevo o admin sin club)
        if (!$club) {
            // Fallback para pruebas: Si envías ?club_id=1 en la URL lo usa, si no, error.
            $clubId = $request->query('club_id');
            if ($clubId) {
                $club = Club::find($clubId);
            }
        }

        if (!$club) {
            return $this->sendResponse('NO SUCCESS', 404, 'No tienes un club asociado', null);
        }

        $clubId = $club->id;

        // 2. Buscamos los IDs de los atletas que están AHORA en este club
        $idsAtletasDelClub = DB::table('atleta_club')
            ->where('id_club', $clubId)
            ->whereNull('fecha_fin')
            ->pluck('id_atleta');

        // 3. Buscamos Competiciones donde los atletas del club estan inscritos
        $inscripciones = AthleteRegistration::whereIn('id_atleta', $idsAtletasDelClub)
            ->with(['athlete', 'competition'])
            ->get();

        $competicionesRecientes = $inscripciones
            ->filter(fn ($reg) => $reg->competition && Carbon::parse($reg->competition->fecha)->lt(Carbon::today()))
            ->sortByDesc(fn ($reg) => $reg->competition->fecha)
            ->unique('id_competicion')
            ->values()
            ->take(3);

        // 4. Buscamos Próximas Competiciones
        $proximas = Competition::where('fecha', '>=', Carbon::now())
            ->orderBy('fecha', 'asc')
            ->take(3)
            ->get();

        // 5. Usamos el DTO
        $dto = new ClubDashboardDTO($club, $competicionesRecientes, $proximas);

        return $this->sendResponse('SUCCESS', 200, 'Dashboard cargado', $dto);
    }
    // FALTAN CREAR LAS VALIDACIONES PARA CREATE Y UPDATE, COMPROBAR SI FUNCIONAN LAS DE ATHLETE CON LA BBDD Y AÑADIRLAS AQUI
    public function getAll()
    {
        $clubs = Club::with('user')->get();
        $dtosClubs = [];

        foreach ($clubs as $club) {
            $dtosClubs[] = new ClubDTO($club);
        }

        return $this->sendResponse('SUCCESS', 200, 'Contenido mostrado correctamente', $dtosClubs);
    }

    public function create(Request $request)
    {
        // VALIDACIÓN
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clubs,email',
            'code' => 'required|unique:clubs,code'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('NO SUCCESS', 400, $validator->errors()->first(), null);
        }

        $club = Club::create($request->all());

        if ($club) {
            return $this->sendResponse('SUCCESS', 201, 'Elemento creado correctamente', new ClubDTO($club));
        } else {
            return $this->sendResponse('NO SUCCESS', 500, 'Error al crear el elemento', null);
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
        }
    }

    public function update(Request $request, string $id)
    {
        $club = Club::with('user')->find($id);

        if (!$club) {
            return $this->sendResponse('NO SUCCESS', 404, 'Club no encontrado', null);
        }

        // 1. Validar (Aceptamos 'nombre' del front y 'avatar' imagen)
        $validator = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'telefono'    => 'nullable|string',
            'avatar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('NO SUCCESS', 400, $validator->errors()->first(), null);
        }

        // 2. Actualizar datos de TEXTO (Mapeo manual)
        $club->name = $request->input('nombre'); // Front envía 'nombre', BD guarda 'name'
        $club->email = $request->input('email');

        if ($request->has('telefono')) $club->telefono = $request->input('telefono');
        if ($request->has('direccion')) $club->direccion = $request->input('direccion');
        if ($request->has('responsable')) $club->responsable = $request->input('responsable');
        if ($request->has('localidad')) $club->localidad = $request->input('localidad');
        if ($request->has('codigo_postal')) $club->codigo_postal = $request->input('codigo_postal');

        $club->save();

        // 3. Actualizar FOTO en la tabla USERS
        if ($request->hasFile('avatar')) {
            $user = $club->user; // El usuario due?o del club

            if ($user) {
                $cloudUrl = $this->uploadToCloudinary($request->file('avatar'));
                if (!$cloudUrl) {
                    return $this->sendResponse('NO SUCCESS', 500, 'Error subiendo imagen', null);
                }

                // Guardar URL en tabla users
                $user->imagen = $cloudUrl;
                $user->save();
            }
        }

        // Recargamos el club y su usuario para devolver el DTO actualizado con la foto nueva
        $club->refresh();
        $club->load('user');

        return $this->sendResponse('SUCCESS', 200, 'Club actualizado correctamente', new ClubDTO($club));
    }



    private function uploadToCloudinary($file): ?string
    {
        $cloudinaryUrl = env('CLOUDINARY_URL', '');
        if (!$cloudinaryUrl) {
            return null;
        }

        $parts = parse_url($cloudinaryUrl);
        if (!$parts || empty($parts['user']) || empty($parts['pass']) || empty($parts['host'])) {
            return null;
        }

        $apiKey = $parts['user'];
        $apiSecret = $parts['pass'];
        $cloudName = $parts['host'];
        $timestamp = time();
        $folder = 'avatars';
        $signatureBase = 'folder=' . $folder . '&timestamp=' . $timestamp;
        $signature = sha1($signatureBase . $apiSecret);

        $response = Http::asMultipart()->post(
            'https://api.cloudinary.com/v1_1/' . $cloudName . '/image/upload',
            [
                [
                    'name' => 'file',
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                ],
                ['name' => 'api_key', 'contents' => $apiKey],
                ['name' => 'timestamp', 'contents' => (string) $timestamp],
                ['name' => 'folder', 'contents' => $folder],
                ['name' => 'signature', 'contents' => $signature],
            ]
        );

        if (!$response->ok()) {
            return null;
        }

        return $response->json('secure_url');
    }

    public function delete(string $id)
    {
        $club = Club::find($id);

        if ($club) {
            $club->delete();
            return $this->sendResponse('SUCCESS', 200, 'Club eliminado', new ClubDTO($club));
        } else {
            return $this->sendResponse('NO SUCCESS', 404, 'Error al eliminar', null);
        }
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
