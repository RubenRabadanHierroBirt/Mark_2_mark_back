<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    protected $table = 'resultados';

    
    protected $primaryKey = 'id';

    
    public $timestamps = false;

    
    protected $fillable = [
        'id_competicion',
        'id_atleta',
        'tipo_evento',
        'categoria',
        'marca',
        'posicion',
        'wind_speed'
    ];

    
    protected $casts = [
        'posicion' => 'integer',
        'wind_speed' => 'float',
    ];

    
    public function competition()
    {
        return $this->belongsTo(Competition::class, 'id_competicion');
    }

    
    public function athlete()
    {
        return $this->belongsTo(Athlete::class, 'id_atleta');
    }

}
