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
            : ''; // He puesto string vacía por defecto si es null para evitar errores en front

        $this->revisado_federacion = (bool) $competition->revisado_federacion;

        // === ASIGNACIÓN DE CONTADORES ===
        // Intentamos leer la propiedad dinámica. Si no existe, ponemos 0.
        $this->total_atletas = $competition->total_atletas ?? 0;
        $this->total_clubes = $competition->total_clubes ?? 0;
    }


    ////////////////////// DTO HECHO POR KEIDY, MODIFICO POR CONSISTENCIA. GUARDO POR TENER BACKUP POR QUE SE USO MÉTODO EN EL ATHLETECONTROLLER
    // /**
    //  * Convierte el modelo de la Base de Datos al formato del DTO
    //  */
    // public static function fromModel($competition): self
    // {
    //     return new self(
    //         id: $competition->id,

    //         // Mapeo directo de nombres (BD -> DTO)
    //         name: $competition->name,

    //         // Si la sede es NULL en la BD, mostramos un texto por defecto
    //         sede: $competition->sede ?? 'Ubicación por definir',

    //         // Usamos la columna 'fecha' (que es NOT NULL) para mostrar el día principal
    //         fecha: Carbon::parse($competition->fecha)->format('d/m/y')
    //     );
    // }


    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
