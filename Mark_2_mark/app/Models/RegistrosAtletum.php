<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RegistrosAtletum
 * 
 * @property int $id
 * @property int $id_competicion
 * @property int $id_atleta
 * @property int $id_club
 * @property string|null $tipo_evento
 * @property int|null $dorsal
 * @property Carbon|null $fecha_inscripcion
 * 
 * @property Competicione $competicione
 * @property Atleta $atleta
 * @property Club $club
 *
 * @package App\Models
 */
class RegistrosAtletum extends Model
{
	protected $table = 'registros_atleta';
	public $timestamps = false;

	protected $casts = [
		'id_competicion' => 'int',
		'id_atleta' => 'int',
		'id_club' => 'int',
		'dorsal' => 'int',
		'fecha_inscripcion' => 'datetime'
	];

	protected $fillable = [
		'id_competicion',
		'id_atleta',
		'id_club',
		'tipo_evento',
		'dorsal',
		'fecha_inscripcion'
	];

	public function competicione()
	{
		return $this->belongsTo(Competicione::class, 'id_competicion');
	}

	public function atleta()
	{
		return $this->belongsTo(Atleta::class, 'id_atleta');
	}

	public function club()
	{
		return $this->belongsTo(Club::class, 'id_club');
	}
}
