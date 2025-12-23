<?php

namespace App\DTOs\Competition;

class CompetitionResponseDTO
{
    public function __construct(
        public int $id,
        public string $nombre,
        public string $fecha_inicio,
        public string $fecha_fin,
        public string $lugar
    ) {}


public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}