<?php
namespace App\DTOs;

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

    public function __construct(Athlete $athlete)
    {
        $this->id = $athlete->id;
        $this->nombre = $athlete->nombre;
        $this->email = $athlete->email;
        $this->telefono = $athlete->telefono;
        $this->fecha_nacimiento = $athlete->fecha_nacimiento;
        $this->status = $athlete->status;

        // Usuario → solo username
        $this->username = $athlete->relationLoaded('user') && $athlete->user
            ? $athlete->user->username
            : null;

        // Club → solo nombre
        $this->club = $athlete->relationLoaded('club') && $athlete->club
            ? $athlete->club->name
            : null;
    }


/*    private $nombre;
    private $apellido;
    private $prueba;
    private $marca;
    private $nombre_club;

    public function __construct(Athlete $atleta)
    {
        $this->nombre = $atleta->nombre;
        $this->apellido = $atleta->apellido;
        $this->prueba = $atleta->prueba;
        $this->marca = $atleta->marca;
        $this->nombre_club = $atleta->club->nombre_club;
    }
*/
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}