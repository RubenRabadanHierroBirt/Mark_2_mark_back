<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\AthleteRegistration;
use App\DTOs\Competition\CompetitionDTO;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Athlete;
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
            $atletas = Athlete::with(['club', 'user'])->get();
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
        $userId = $data['id_usuario'] ?? null;

        return DB::transaction(function () use ($data, $request, $userId) {
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
            $atleta = Athlete::create($data);

            if ($atleta) {
                $atleta->load(['user', 'club']);
                $status = 'SUCCESS';
                $cod = 201;
                $mensaje = 'Elemento creado correctamente';

                return $this->sendResponse($status, $cod, $mensaje, new AthleteDTO($atleta));
            }

            return $this->sendResponse('NO SUCCESS', 404, 'Error al crear el elemento', null);
        });
    }

    public function update(UpdateAthleteRequest $request, $id)
    {
        $atleta = Athlete::find($id);

        if ($atleta) {
            $atleta->update($request->validated());

            $status = 'SUCCESS';
            $cod = 200;
            $mensaje = 'Elemento con ID ' . $id . ' actualizado correctamente';

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
        $atleta = Athlete::find($id);

        if ($atleta) {
            $atleta->delete();

            $status = 'SUCCESS';
            $cod = 200;
            $mensaje = 'El siguiente elemento se ha eliminado correctamente';

            return $this->sendResponse($status, $cod, $mensaje, new AthleteDTO($atleta));
        } else {
            $status = 'NO SUCCESS';
            $cod = 404;
            $mensaje = 'Error al eliminar el elemento';

            return $this->sendResponse($status, $cod, $mensaje, null);
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

    /**
     * Endpoint para cargar el Dashboard completo (Perfil + Resultados + Próximos)
     */
    public function getDashboard()
    {
        // 1. OBTENER USUARIO
        $user = \Illuminate\Support\Facades\Auth::user();
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
                // 'avatar' => $atleta->avatar // Descomenta si tienes foto
            ],
            // Formatear Resultados para el Front
            'ultimos_resultados' => $ultimosResultados->values()->map(function ($res) {
                return [
                    'id' => $res->id,
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
}
