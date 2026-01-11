<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
        protected $table = 'novedades';

    
    protected $primaryKey = 'id';

    
    public $timestamps = false;

    
    protected $fillable = [
        'fecha',
        'contenido',
        'tipo'
    ];

    
    protected $casts = [
        'fecha' => 'datetime',
    ];

}
