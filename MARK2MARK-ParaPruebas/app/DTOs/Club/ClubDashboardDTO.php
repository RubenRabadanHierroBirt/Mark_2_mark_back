<?php

namespace App\DTOs\Club;

use App\Models\Club;
use JsonSerializable;
use Carbon\Carbon;

class ClubDashboardDTO implements JsonSerializable
{
    // PROPIEDADES PLANAS (Lo que espera tu HTML: datosClub.nombre, etc.)
    public int $id;
    public string $nombre;
    public ?string $email;
    public ?string $telefono;
    public ?string $direccion;
    public ?string $fotoUrl;

    // LISTAS (Lo que espera tu HTML: ultimosResultados, proximosCampeonatos)
    public array $ultimosResultados = [];
    public array $proximosCampeonatos = [];

    public function __construct(Club $club, $resultadosRecientes, $proximasCompetis)
    {
        // 1. Mapeo de datos del Club (Adaptamos BD -> Front)
        $this->id = $club->id;
        $this->nombre = $club->name; // Tu HTML pide 'nombre', tu BD tiene 'name'
        $this->email = $club->email;
        $this->telefono = $club->telefono;
        $this->direccion = $club->direccion;
        $this->fotoUrl = $club->user ? $club->user->imagen : null;

        // 2. Formatear Lista de Resultados
        foreach ($resultadosRecientes as $res) {
            // Construimos el texto: "Oro en 100m - Jon"
            $posicion = $res->posicion ? "Pos. {$res->posicion}" : ($res->marca ?? '-');
            $prueba = $res->tipo_evento ?? 'Prueba';
            $atleta = $res->athlete ? $res->athlete->nombre : 'Atleta';

            $texto = "$posicion en $prueba - $atleta";

            $this->ultimosResultados[] = [
                'id' => $res->id,
                'fecha' => $res->competition ? Carbon::parse($res->competition->fecha)->format('d/m/y') : '-',
                'texto' => $texto
            ];
        }

        // 3. Formatear Lista de Próximos Campeonatos
        foreach ($proximasCompetis as $comp) {
            $this->proximosCampeonatos[] = [
                'id' => $comp->id,
                'fecha' => Carbon::parse($comp->fecha)->format('d/m/y'),
                'texto' => $comp->name
            ];
        }
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
