<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AthleteClub extends Model
{
    protected $table = 'atleta_club';

    
    protected $primaryKey = 'id';

    
    public $timestamps = false;

    
    protected $fillable = [
        'id_atleta',
        'id_club',
        'fecha_inicio',
        'fecha_fin'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function atleta()
    {
        return $this->belongsTo(Athlete::class, 'id_atleta');
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'id_club');
    }

}
