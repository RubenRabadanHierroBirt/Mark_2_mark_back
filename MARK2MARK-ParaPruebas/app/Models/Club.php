<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $table = 'clubs';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'code',
        'name',
        'email',
        'direccion',
        'telefono',
        'responsable',
        'estado',
        'codigo_postal',
        'localidad'
    ];

    protected $casts = [
        'codigo_postal' => 'integer',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    
    public function atletas()
    {
        return $this->hasMany(Athlete::class, 'club_actual_id');
    }

    /*
    public function atletasHistorico()
    {
        return $this->belongsToMany(
            Athlete::class,
            'atleta_club',
            'id_club',
            'id_atleta'
        )->withPivot(['fecha_inicio', 'fecha_fin']);
    }
        */
}
