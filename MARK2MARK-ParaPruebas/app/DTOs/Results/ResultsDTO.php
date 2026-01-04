<?php

namespace App\DTOs\Results;

use App\Models\Results;
use JsonSerializable;
use Carbon\Carbon;

class ResultsDTO implements JsonSerializable
{
    public int $id;
    public string $tipo_evento;
    public ?string $categoria;
    public ?string $marca;
    public ?int $posicion;
    public ?float $wind_speed;

    // Datos "aplanados" para el Frontend
    public ?string $athlete_nombre;
    public ?string $athlete_sexo;       // <--- AÑADIDO (Para el filtro)
    public ?string $athlete_club_id;    // <--- AÑADIDO (Para la tabla)
    public ?string $athlete_club_name;  // <--- NUEVO (Nombre del club)

    
    public ?string $competition_name;
    public ?string $competition_sede;
    public ?string $competition_fecha;
 

    public function __construct(Results $result)
    {
        $this->id = $result->id;
        $this->tipo_evento = $result->tipo_evento;
        $this->categoria = $result->categoria;
        $this->marca = $result->marca;
        $this->posicion = $result->posicion;
        $this->wind_speed = $result->wind_speed;

        // Mapeo de ATLETA
        if ($result->relationLoaded('athlete') && $result->athlete) {
            $this->athlete_nombre = $result->athlete->nombre;
            $this->athlete_sexo = $result->athlete->sexo;            
            $this->athlete_club_id = $result->athlete->club_actual_id;
            $this->athlete_club_name = $result->athlete->club?->name ?? null;
        } else {
            $this->athlete_nombre = null;
            $this->athlete_sexo = null;
            $this->athlete_club_id = null;
            $this->athlete_club_name = null;
        }

        // Mapeo de COMPETICIÓN
        if ($result->relationLoaded('competition') && $result->competition) {
            $this->competition_name = $result->competition->name;
            $this->competition_sede = $result->competition->sede;    
            $this->competition_fecha = Carbon::parse($result->competition->fecha)->format('Y-m-d');
        } else {
            $this->competition_name = null;
            $this->competition_sede = null;
            $this->competition_fecha = null;
        }
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
