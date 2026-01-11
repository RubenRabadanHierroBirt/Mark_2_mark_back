<?php

namespace App\DTOs\Club;

use App\Models\Club;
use JsonSerializable;
use Carbon\Carbon;

class ClubDashboardDTO implements JsonSerializable
{
    public int $id;
    public string $nombre;
    public ?string $email;
    public ?string $telefono;
    public ?string $direccion;
    public ?string $fotoUrl;
    public array $ultimosResultados = [];
    public array $proximosCampeonatos = [];

    public function __construct(Club $club, $resultadosRecientes, $proximasCompetis)
    {
        $this->id = $club->id;
        $this->nombre = $club->name; 
        $this->email = $club->email;
        $this->telefono = $club->telefono;
        $this->direccion = $club->direccion;
        $this->fotoUrl = $club->user ? $club->user->imagen : null;

        foreach ($resultadosRecientes as $registro) {
            $competition = $registro->competition;
            if (!$competition) {
                continue;
            }

            $this->ultimosResultados[] = [
                'id' => $competition->id,
                'fecha' => $competition->fecha ? Carbon::parse($competition->fecha)->format('d/m/y') : '-',
                'texto' => $competition->name ?? ''
            ];
        }

        // Formatear Lista de Próximos Campeonatos
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
