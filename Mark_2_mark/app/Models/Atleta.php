<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Atleta
 * 
 * @property int $id
 * @property int|null $id_usuario
 * @property int|null $club_actual_id
 * @property string $nombre
 * @property string|null $email
 * @property string|null $telefono
 * @property Carbon|null $fecha_nacimiento
 * @property string|null $status
 * 
 * @property Usuario|null $usuario
 * @property Club|null $club
 * @property Collection|Club[] $clubs
 * @property Collection|RegistrosAtletum[] $registros_atleta
 * @property Collection|Resultado[] $resultados
 *
 * @package App\Models
 */
class Atleta extends Model
{
	protected $table = 'atletas';
	public $timestamps = false;

	protected $casts = [
		'id_usuario' => 'int',
		'club_actual_id' => 'int',
		'fecha_nacimiento' => 'datetime'
	];

	protected $fillable = [
		'id_usuario',
		'club_actual_id',
		'nombre',
		'email',
		'telefono',
		'fecha_nacimiento',
		'status'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'id_usuario');
	}

	public function club()
	{
		return $this->belongsTo(Club::class, 'club_actual_id');
	}

	public function clubs()
	{
		return $this->belongsToMany(Club::class, 'atleta_club', 'id_atleta', 'id_club')
					->withPivot('id', 'fecha_inicio', 'fecha_fin');
	}

	public function registros_atleta()
	{
		return $this->hasMany(RegistrosAtletum::class, 'id_atleta');
	}

	public function resultados()
	{
		return $this->hasMany(Resultado::class, 'id_registro_atletico');
	}
}
