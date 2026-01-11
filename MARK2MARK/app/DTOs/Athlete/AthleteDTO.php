<?php
namespace App\DTOs\Athlete;

use App\Models\Athlete;
use JsonSerializable;

class AthleteDTO implements JsonSerializable {


    public int $id;
    public string $nombre;
    public ?string $email;
    public ?string $telefono;
    public ?string $fecha_nacimiento;
    public string $status;
    public ?string $username;
    public ?string $club;
    public ?int $club_actual_id;
    public ?string $avatar;

    public function __construct(Athlete $athlete)
    {
        $this->id = $athlete->id;
        $this->nombre = $athlete->nombre;
        $this->email = $athlete->email;
        $this->telefono = $athlete->telefono;
        $this->fecha_nacimiento = $athlete->fecha_nacimiento;
        $this->status = $athlete->status;
        $this->avatar = $athlete->user ? $athlete->user->avatar : null;

        
        $this->username = $athlete->relationLoaded('user') && $athlete->user
            ? $athlete->user->username
            : null;

        
        $this->club = $athlete->relationLoaded('club') && $athlete->club
            ? $athlete->club->name
            : null;

        $this->club_actual_id = $athlete->club_actual_id;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}