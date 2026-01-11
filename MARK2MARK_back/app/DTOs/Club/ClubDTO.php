<?php

namespace App\DTOs\Club;

use App\Models\Club;
use JsonSerializable;

class ClubDTO implements JsonSerializable
{
    public int $id;
    public string $code;
    public string $name;
    public ?string $email;
    public ?string $direccion;
    public ?string $fotoUrl;
    public ?string $telefono;
    public ?string $responsable;
    public ?string $localidad;
    public ?int $codigo_postal;
    public string $estado;

    public ?string $username;

    public function __construct(Club $club)
    {
        $this->id = $club->id;
        $this->code = $club->code ?? '';
        $this->name = $club->name;
        $this->email = $club->email;
        $this->direccion = $club->direccion;
        $this->telefono = $club->telefono;
        $this->responsable = $club->responsable;
        $this->localidad = $club->localidad;
        $this->codigo_postal = $club->codigo_postal;
        $this->estado = $club->estado;
        $this->fotoUrl = $club->relationLoaded('user') && $club->user
            ? $club->user->imagen
            : null;


        $this->username = $club->relationLoaded('user') && $club->user
            ? $club->user->username
            : null;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
