<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AtletaClub
 * 
 * @property int $id
 * @property int $id_atleta
 * @property int $id_club
 * @property Carbon $fecha_inicio
 * @property Carbon|null $fecha_fin
 * 
 * @property Atleta $atleta
 * @property Club $club
 *
 * @package App\Models
 */
class AtletaClub extends Model
{
	protected $table = 'atleta_club';
	public $timestamps = false;

	protected $casts = [
		'id_atleta' => 'int',
		'id_club' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime'
	];

	protected $fillable = [
		'id_atleta',
		'id_club',
		'fecha_inicio',
		'fecha_fin'
	];

	public function atleta()
	{
		return $this->belongsTo(Atleta::class, 'id_atleta');
	}

	public function club()
	{
		return $this->belongsTo(Club::class, 'id_club');
	}
}
