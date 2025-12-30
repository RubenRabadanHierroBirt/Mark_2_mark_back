<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $email
 * @property string $rol
 * @property Carbon|null $creado_el
 * @property bool|null $desactivado
 * 
 * @property Collection|Atleta[] $atletas
 * @property Collection|Club[] $clubs
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuarios';
	public $timestamps = false;

	protected $casts = [
		'creado_el' => 'datetime',
		'desactivado' => 'bool'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'username',
		'password',
		'email',
		'rol',
		'creado_el',
		'desactivado',
		'imagen'
	];

	public function atletas()
	{
		return $this->hasMany(Atleta::class, 'id_usuario');
	}

	public function clubs()
	{
		return $this->hasMany(Club::class, 'id_usuario');
	}
}
