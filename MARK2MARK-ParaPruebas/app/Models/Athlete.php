<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    protected $table = 'atletas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'club_actual_id',
        'nombre',
        'email',
        'telefono',
        'fecha_nacimiento',
        'status'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'club_actual_id');
    }

    public function results()
    {
        return $this->hasMany(Results::class, 'id_atleta');
    }
    public function registrations()
    {
        return $this->hasMany(AthleteRegistration::class, 'id_atleta');
    }
}
