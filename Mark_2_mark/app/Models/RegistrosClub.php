<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RegistrosClub
 * 
 * @property int $id
 * @property int $id_competicion
 * @property int $id_club
 * @property Carbon|null $fecha_registro
 * 
 * @property Competicione $competicione
 * @property Club $club
 *
 * @package App\Models
 */
class RegistrosClub extends Model
{
	protected $table = 'registros_club';
	public $timestamps = false;

	protected $casts = [
		'id_competicion' => 'int',
		'id_club' => 'int',
		'fecha_registro' => 'datetime'
	];

	protected $fillable = [
		'id_competicion',
		'id_club',
		'fecha_registro'
	];

	public function competicione()
	{
		return $this->belongsTo(Competicione::class, 'id_competicion');
	}

	public function club()
	{
		return $this->belongsTo(Club::class, 'id_club');
	}
}
