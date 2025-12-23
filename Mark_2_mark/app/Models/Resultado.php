<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Resultado
 * 
 * @property int $id
 * @property int $id_competicion
 * @property int $id_registro_atletico
 * @property string $tipo_evento
 * @property string|null $categoria
 * @property string|null $marca
 * @property int|null $posicion
 * @property float|null $wind_speed
 * 
 * @property Competicione $competicione
 * @property Atleta $atleta
 *
 * @package App\Models
 */
class Resultado extends Model
{
	protected $table = 'resultados';
	public $timestamps = false;

	protected $casts = [
		'id_competicion' => 'int',
		'id_registro_atletico' => 'int',
		'posicion' => 'int',
		'wind_speed' => 'float'
	];

	protected $fillable = [
		'id_competicion',
		'id_registro_atletico',
		'tipo_evento',
		'categoria',
		'marca',
		'posicion',
		'wind_speed'
	];

	public function competicione()
	{
		return $this->belongsTo(Competicione::class, 'id_competicion');
	}

	public function atleta()
	{
		return $this->belongsTo(Atleta::class, 'id_registro_atletico');
	}
}
