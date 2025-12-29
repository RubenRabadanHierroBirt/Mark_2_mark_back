<?php

namespace App\DTOs\Competition;

use JsonSerializable;
use Carbon\Carbon;

class CompetitionDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $sede,
        public string $fecha

    ) {}

    /**
     * Convierte el modelo de la Base de Datos al formato del DTO
     */
    public static function fromModel($competition): self
    {
        return new self(
            id: $competition->id,

            // Mapeo directo de nombres (BD -> DTO)
            name: $competition->name,

            // Si la sede es NULL en la BD, mostramos un texto por defecto
            sede: $competition->sede ?? 'Ubicación por definir',

            // Usamos la columna 'fecha' (que es NOT NULL) para mostrar el día principal
            fecha: Carbon::parse($competition->fecha)->format('d/m/y')
        );
    }


    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
