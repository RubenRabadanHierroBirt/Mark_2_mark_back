<?php

namespace App\DTOs\Result;

use App\Models\Results;
use JsonSerializable;
use Carbon\Carbon;

class ResultsDTO implements JsonSerializable
{
    public int $id;
    public int $competition_id;
    public int $athlete_id;
    public string $tipo_evento;
    public ?string $categoria;
    public ?string $marca;
    public ?int $posicion;
    public ?float $wind_speed;

    
    public ?string $competition_name;
    public ?string $competition_fecha;
    public ?string $athlete_nombre;

    public function __construct(Results $result)
    {
        $this->id = $result->id;
        $this->competition_id = $result->id_competicion;
        $this->athlete_id = $result->id_atleta;
        $this->tipo_evento = $result->tipo_evento;
        $this->categoria = $result->categoria;
        $this->marca = $result->marca;
        $this->posicion = $result->posicion;
        $this->wind_speed = $result->wind_speed;

        // Relaciones (si vienen cargadas)
        $this->competition_name = $result->relationLoaded('competition') && $result->competition
            ? $result->competition->name
            : null;

        $this->competition_fecha = $result->relationLoaded('competition') && $result->competition
            ? Carbon::parse($result->competition->fecha)->format('Y-m-d')
            : null;

        $this->athlete_nombre = $result->relationLoaded('athlete') && $result->athlete
            ? $result->athlete->nombre
            : null;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
