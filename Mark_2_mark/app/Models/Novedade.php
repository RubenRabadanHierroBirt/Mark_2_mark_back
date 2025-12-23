<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Novedade
 * 
 * @property int $id
 * @property Carbon $fecha
 * @property string $contenido
 * @property string $tipo
 *
 * @package App\Models
 */
class Novedade extends Model
{
	protected $table = 'novedades';
	public $timestamps = false;

	protected $casts = [
		'fecha' => 'datetime'
	];

	protected $fillable = [
		'fecha',
		'contenido',
		'tipo'
	];
}
