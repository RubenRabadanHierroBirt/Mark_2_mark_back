<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AthleteRegistration extends Model
{
    protected $table = 'registros_atleta';

    
    protected $primaryKey = 'id';

    
    public $timestamps = false;

    
    protected $fillable = [
        'id_competicion',
        'id_atleta',
        'id_club',
        'tipo_evento',
        'dorsal'
    ];

    
    protected $casts = [
        'dorsal' => 'integer',
    ];

    
    public function competition()
    {
        return $this->belongsTo(Competition::class, 'id_competicion');
    }

    
    public function athlete()
    {
        return $this->belongsTo(Athlete::class, 'id_atleta');
    }

    
    public function club()
    {
        return $this->belongsTo(Club::class, 'id_club');
    }

}
