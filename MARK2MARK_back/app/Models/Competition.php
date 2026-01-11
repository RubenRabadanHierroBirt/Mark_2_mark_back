<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $table = 'competiciones';

    
    protected $primaryKey = 'id';

    
    public $timestamps = false;

    
    protected $fillable = [
        'name',
        'sede',
        'fecha',
        'organizador',
        'status',
        'fecha',
        // 'fecha_inicio',
        // 'fecha_fin',
        'revisado_federacion',

    ];

    
    protected $casts = [
        'fecha' => 'date',
        'revisado_federacion' => 'boolean',
    ];

    
    public function athleteRegistrations()
    {
        return $this->hasMany(AthleteRegistration::class, 'id_competicion');
    }
    
    public function results()
    {
        return $this->hasMany(Results::class, 'id_competicion');
    }

}
