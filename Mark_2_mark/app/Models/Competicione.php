<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Competicione
 * 
 * @property int $id
 * @property string $name
 * @property string|null $sede
 * @property Carbon $fecha
 * @property string|null $organizador
 * @property string|null $status
 * @property bool|null $revisado_federacion
 * @property Carbon|null $creado_el
 * @property Carbon|null $fecha_inicio
 * @property Carbon|null $fecha_fin
 * @property Carbon|null $fecha_limite
 * 
 * @property Collection|RegistrosAtletum[] $registros_atleta
 * @property Collection|RegistrosClub[] $registros_clubs
 * @property Collection|Resultado[] $resultados
 *
 * @package App\Models
 */
class Competicione extends Model
{
	protected $table = 'competiciones';
	public $timestamps = false;

	protected $casts = [
		'fecha' => 'datetime',
		'revisado_federacion' => 'bool',
		'creado_el' => 'datetime',
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime',
		'fecha_limite' => 'datetime'
	];

	protected $fillable = [
		'name',
		'sede',
		'fecha',
		'organizador',
		'status',
		'revisado_federacion',
		'creado_el',
		'fecha_inicio',
		'fecha_fin',
		'fecha_limite'
	];

	public function registros_atleta()
	{
		return $this->hasMany(RegistrosAtletum::class, 'id_competicion');
	}

	public function registros_clubs()
	{
		return $this->hasMany(RegistrosClub::class, 'id_competicion');
	}

	public function resultados()
	{
		return $this->hasMany(Resultado::class, 'id_competicion');
	}
}
