<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Club
 * 
 * @property int $id
 * @property int|null $id_usuario
 * @property string $code
 * @property string $name
 * @property string|null $direccion
 * @property string|null $telefono
 * @property string|null $responsable
 * @property string|null $estado
 * @property int|null $codigo_postal
 * @property string|null $localidad
 * 
 * @property Usuario|null $usuario
 * @property Collection|Atleta[] $atletas
 * @property Collection|RegistrosAtletum[] $registros_atleta
 * @property Collection|RegistrosClub[] $registros_clubs
 *
 * @package App\Models
 */
class Club extends Model
{
	protected $table = 'clubs';
	public $timestamps = false;

	protected $casts = [
		'id_usuario' => 'int',
		'codigo_postal' => 'int'
	];

	protected $fillable = [
		'id_usuario',
		'code',
		'name',
		'direccion',
		'telefono',
		'responsable',
		'estado',
		'codigo_postal',
		'localidad'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'id_usuario');
	}

	public function atletas()
	{
		return $this->hasMany(Atleta::class, 'club_actual_id');
	}

	public function registros_atleta()
	{
		return $this->hasMany(RegistrosAtletum::class, 'id_club');
	}

	public function registros_clubs()
	{
		return $this->hasMany(RegistrosClub::class, 'id_club');
	}
}
