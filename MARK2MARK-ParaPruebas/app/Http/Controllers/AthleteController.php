<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\AthleteRegistration;
use App\DTOs\Competition\CompetitionDTO;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\Club;
use App\Models\User;
use App\DTOs\Athlete\AthleteDTO;
use App\Http\Requests\CreateAthleteRequest;
use App\Http\Requests\UpdateAthleteRequest;

class AthleteController extends Controller
{
    // PRUEBA PARA QUE  GETALL DEPENDIENDO DEL ROL MUESTRA TODOS O SOLO LOS DEL CLUB
    // Si funciona hay que meter control de middleware en el endpoint para controlar que solo accedan roles fed y club. Si no puede tirar error. Lo pongo aqui para no olvidarme
    public function getAll(Request $request)
    {
        $user = $request->user();

        if ($user->rol === 'FEDERACION') {
            $atletas = Athlete::with(['club', 'user'])
                ->where('id_usuario', '!=', 1)
                ->get();
        } 
        elseif($user->rol === 'CLUB') {
            
            $club = $user->club;

            if (!$club) {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'El usuario no tiene club asociado',
                null
            );
        }

            $atletas = Athlete::with(['club', 'user'])
                ->where('club_actual_id', $club->id)
                ->where('id_usuario', '!=', 1)
                ->get();
        }


        $dtosAtletas = [];

        foreach ($atletas as $atleta) {
            $dtosAtletas[] = new AthleteDTO($atleta);
        }

        if ($dtosAtletas) {
            $status = 'SUCCESS';
            $cod = 200;
            $mensaje = 'Contenido mostrado correctamente';

            return $this->sendResponse($status, $cod, $mensaje, $dtosAtletas);
        } else {
            $status = 'NO SUCCESS';
            $cod = 404;
            $mensaje = 'Error al acceder al contenido';

            return $this->sendResponse($status, $cod, $mensaje, null);
        }
    }

    //////////////////////////////////////////////////// BACKUP DE GETALL SIMPLE
    // public function getAll()
    // {
    //     $atletas = Athlete::with('club')->get();
    //     $dtosAtletas = [];

    //     foreach ($atletas as $atleta) {
    //         $dtosAtletas[] = new AthleteDTO($atleta);
    //     }

    //     if ($dtosAtletas) {
    //         $status = 'SUCCESS';
    //         $cod = 200;
    //         $mensaje = 'Contenido mostrado correctamente';

    //         return $this->sendResponse($status, $cod, $mensaje, $dtosAtletas);
    //     } else {
    //         $status = 'NO SUCCESS';
    //         $cod = 404;
    //         $mensaje = 'Error al acceder al contenido';

    //         return $this->sendResponse($status, $cod, $mensaje, null);
    //     }
    // }

    public function getById($id)
    {
        $atleta = Athlete::with(['club', 'user'])->find($id);

        if ($atleta) {
            $status = 'SUCCESS';
            $cod = 200;
            $mensaje = 'Elemento mostrado correctamente';

            return $this->sendResponse($status, $cod, $mensaje, new AthleteDTO($atleta));
        } else {
            $status = 'NO SUCCESS';
            $cod = 404;
            $mensaje = 'Error al acceder al elemento';

            return $this->sendResponse($status, $cod, $mensaje, null);
        }
    }


 public function create(CreateAthleteRequest $request)
    {
        $data = $request->validated();
        
        // 1. OBTENEMOS EL USUARIO QUE HACE LA PETICIÓN
        $usuarioLogueado = $request->user();
        $userId = $data['id_usuario'] ?? null;

        return DB::transaction(function () use ($data, $request, $userId, $usuarioLogueado) {
            
            // CASO A: ERES UN CLUB (Se ignora el formulario y se usa TU club)
            if (strtoupper($usuarioLogueado->rol) === 'CLUB') {
                
                if (!$usuarioLogueado->club) {
                    \Illuminate\Support\Facades\Log::error('ERROR: Usuario CLUB sin club vinculado en BD');
                    return $this->sendResponse('NO SUCCESS', 400, 'Error: Tu usuario no tiene club asignado.', null);
                }

                // Asignamos AUTOMÁTICAMENTE tu club
                $data['club_actual_id'] = $usuarioLogueado->club->id;
                $data['club_nombre']    = $usuarioLogueado->club->name;
            } 
            
            // CASO B: ERES FEDERACIÓN (Usamos lo que elegiste en el desplegable)
            else {
                $clubId = $data['club_actual_id'] ?? null;
                if (!$clubId) {
                    $clubNombre = $request->input('club_nombre') ?? $request->input('club');
                    if ($clubNombre) {
                        $club = Club::where('name', $clubNombre)->first();
                        if ($club) {
                            $data['club_actual_id'] = $club->id;
                        }
                    }
                }
            }

            // Lógica de crear Usuario si no existe
            if (!$userId) {
                $username = $request->input('username') ?? $request->input('usuario');
                $emailUsuario = $request->input('email_usuario') ?? $data['email'] ?? null;

                if (!$username) {
                    return $this->sendResponse('NO SUCCESS', 422, 'Username requerido', null);
                }

                if (User::where('username', $username)->exists()) {
                    return $this->sendResponse('NO SUCCESS', 409, 'Username ya existe', null);
                }

                $password = $request->input('password') ?? Str::random(10);
                
                $user = User::create([
                    'username' => $username,
                    'email' => $emailUsuario,
                    'password' => $password,
                    'rol' => 'ATLETA',
                ]);

                $userId = $user->id;
            }

            $data['id_usuario'] = $userId;
            
            // Creamos el atleta
            $atleta = Athlete::create($data);

            if ($atleta) {
                $atleta->load(['user', 'club']);
                return $this->sendResponse('SUCCESS', 201, 'Elemento creado correctamente', new AthleteDTO($atleta));
            }

            return $this->sendResponse('NO SUCCESS', 404, 'Error al crear el elemento', null);
        });
    }

    public function update(UpdateAthleteRequest $request, $id)
    {
        $atleta = Athlete::find($id);

        if ($atleta) {
            $data = $request->validated();
            $atleta->update($data);

            if (array_key_exists('status', $data) && $atleta->user) {
                $desactivado = $data['status'] === 'Suspendido';
                $atleta->user->forceFill(['desactivado' => $desactivado])->save();
            }

            $status = 'SUCCESS';
            $cod = 200;
            $mensaje = 'Elemento con ID ' . $id . ' actualizado correctamente';

            $atleta->load(['user', 'club']);

            return $this->sendResponse($status, $cod, $mensaje, new AthleteDTO($atleta));
        } else {
            $status = 'NO SUCCESS';
            $cod = 404;
            $mensaje = 'Atleta no encontrado';

            return $this->sendResponse($status, $cod, $mensaje, null);
        }
    }

    public function delete($id)
    {
        $atleta = Athlete::with('user')->find($id);

        if (!$atleta) {
            return $this->sendResponse('NO SUCCESS', 404, 'Error al eliminar el elemento', null);
        }

        return DB::transaction(function () use ($atleta) {
            $user = $atleta->user;
            $atleta->delete();
            if ($user) {
                $user->delete();
            }

            return $this->sendResponse(
                'SUCCESS',
                200,
                'El siguiente elemento se ha eliminado correctamente',
                new AthleteDTO($atleta)
            );
        });
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

    /**
     * Endpoint para cargar el Dashboard completo (Perfil + Resultados + Próximos)
     */
    public function getDashboard()
    {
        // 1. OBTENER USUARIO
        $user = Auth::user();
        $atleta = $user->athlete; // Asumiendo relación en User

        if (!$atleta) {
            return $this->sendResponse('NO SUCCESS', 404, 'Perfil no encontrado', null);
        }

        // Cargar el Club para la tarjeta de Datos Personales
        $atleta->load('club');

        // 2. ÚLTIMOS RESULTADOS (Tarjeta Roja de Arriba)
        // Usa tu modelo 'Results.php'
        $ultimosResultados = $atleta->results()
            ->with('competition') // Carga la relación definida en Results.php
            ->get()
            ->filter(function ($res) {
                // Filtra solo si la competición existe y la fecha es PASADA
                return $res->competition && $res->competition->fecha < now();
            })
            ->sortByDesc(function ($res) {
                // Ordena por fecha: la más reciente arriba
                return $res->competition->fecha;
            })
            ->take(3); // Solo los 3 últimos

        // 3. PRÓXIMOS CAMPEONATOS (Tarjeta Roja de Abajo)
        // Usa tu modelo 'AthleteRegistration.php'
        $proximosCampeonatos = $atleta->registrations()
            ->with('competition') // Carga la relación definida en AthleteRegistration.php
            ->get()
            ->filter(function ($reg) {
                // Filtra solo si la competición existe y la fecha es FUTURA (o hoy)
                return $reg->competition && $reg->competition->fecha >= now();
            })
            ->sortBy(function ($reg) {
                // Ordena por fecha: la más cercana primero
                return $reg->competition->fecha;
            })
            ->take(3); // Solo los 3 siguientes

        // 4. PREPARAR JSON DE RESPUESTA
        $data = [
            'perfil' => [
                'nombre' => $atleta->nombre, // Ajusta si tienes apellidos aparte
                'email' => $atleta->email,
                'telefono' => $atleta->telefono,
                'club' => $atleta->club ? $atleta->club->name : 'Sin Club',
                'avatar' => $user->imagen ?? null
            ],
            // Formatear Resultados para el Front
            'ultimos_resultados' => $ultimosResultados->values()->map(function ($res) {
                return [
                    'id' => $res->id,
                    'competition_id' => $res->competition->id,
                    // Carbon convierte la fecha fea de SQL a "15/10/25"
                    'fecha' => \Carbon\Carbon::parse($res->competition->fecha)->format('d/m/y'),
                    'evento' => ($res->competition->sede ?? '') . ' ' . $res->competition->name,
                    'categoria' => $res->categoria,
                    'marca' => $res->marca,
                    'detalle_url' => '/resultados/' . $res->id
                ];
            }),
            // Formatear Próximos usando tu DTO existente
            'proximos_campeonatos' => $proximosCampeonatos->values()->map(function ($reg) {
                //return \App\DTOs\Competition\CompetitionDTO::fromModel($reg->competition);
                return new \App\DTOs\Competition\CompetitionDTO($reg->competition);
            })
        ];

        return $this->sendResponse('SUCCESS', 200, 'Dashboard cargado correctamente', $data);
    }

    public function downloadUltimosResultadosExcel()
    {
        $user = Auth::user();
        $atleta = $user->athlete;

        if (!$atleta) {
            return $this->sendResponse('NO SUCCESS', 404, 'Perfil no encontrado', null);
        }

        $ultimosResultados = $atleta->results()
            ->with('competition')
            ->get()
            ->filter(function ($res) {
                return $res->competition && $res->competition->fecha < now();
            })
            ->sortByDesc(function ($res) {
                return $res->competition->fecha;
            })
            ->take(3);

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['Fecha', 'Evento', 'Categoria', 'Marca']);

        foreach ($ultimosResultados as $res) {
            $fecha = \Carbon\Carbon::parse($res->competition->fecha)->format('d/m/y');
            $evento = trim(($res->competition->sede ?? '') . ' ' . $res->competition->name);
            fputcsv($handle, [$fecha, $evento, $res->categoria, $res->marca]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="ultimos_resultados_atleta.csv"'
        ]);
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */  
        $user = Auth::user(); // Este es el USUARIO (donde está la foto)
        $atleta = $user->athlete; // Este es el ATLETA (donde están los datos)

        if (!$atleta) {
            return response()->json(['status' => 'ERROR', 'mensaje' => 'Perfil no encontrado'], 404);
        }

        // 1. Validar
        $validator = Validator::make($request->all(), [
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email',
            'telefono' => 'nullable|string',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'ERROR', 'mensaje' => $validator->errors()->first()], 400);
        }

        // 2. Actualizar datos del ATLETA (Texto)
        $atleta->nombre = $request->input('nombre');
        $atleta->email = $request->input('email');
        $atleta->telefono = $request->input('telefono');
        $atleta->save();

        // 3. Actualizar foto del USUARIO (Imagen)
        if ($request->hasFile('avatar')) {
            $cloudUrl = $this->uploadToCloudinary($request->file('avatar'));
            if (!$cloudUrl) {
                return response()->json(['status' => 'ERROR', 'mensaje' => 'Error subiendo imagen'], 500);
            }

            $user->imagen = $cloudUrl;
            $user->save(); // <--- IMPORTANTE: Guardamos el usuario
        }

        // 4. Devolver respuesta
        // Recargamos el usuario dentro del atleta para que el DTO pille la foto nueva
        $atleta->load('user'); 

        return response()->json([
            'status' => 'SUCCESS',
            'mensaje' => 'Perfil actualizado correctamente',
            'data' => new AthleteDTO($atleta)
        ], 200);
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
}
