<?php

namespace App\DTOs\Competition;

use App\Models\Competition;
use JsonSerializable;
use Carbon\Carbon;

class CompetitionDTO implements JsonSerializable

{

    public int $id;
    public string $name;
    public ?string $sede;
    public string $fecha;
    public ?string $organizador;
    public string $status;
    public bool $revisado_federacion;
    public string $creado_el;
    public int $total_atletas;
    public int $total_clubes;

    public function __construct(Competition $competition)
    {
        $this->id = $competition->id;
        $this->name = $competition->name;
        $this->sede = $competition->sede;
        $this->organizador = $competition->organizador;
        $this->status = $competition->status;

        $this->fecha = $competition->fecha
            ? Carbon::parse($competition->fecha)->format('d/m/y')
            : ''; 

        $this->revisado_federacion = (bool) $competition->revisado_federacion;

        $this->total_atletas = $competition->total_atletas ?? 0;
        $this->total_clubes = $competition->total_clubes ?? 0;
    }



    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
