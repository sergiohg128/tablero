<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meta extends Model
{
	use SoftDeletes; //habilita borrado suave (borrado por software)
	protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'fecha_inicio_esperada', 'fecha_inicio', 'fecha_fin_esperada', 'fecha_fin', 'producto', 'presupuesto', 'estado', 'actividad_id', 'creador_id','informacion'
	];

	protected $table = 'metas';

	public $timestamps = false;

	public function actividad()
	{
		return $this->belongsTo(Actividad::class);
	}

	public function gastos()
	{
		return $this->hasMany(Gasto::class);
	}

	public function responsables()
	{
		return $this->belongsToMany(Responsable::class)->withTrashed();
	}

	public function requisitos()//romel
	{
		return $this->hasMany(Requisito::class);
	}

	public function monitoreos()
	{
		return $this->hasMany(Monitoreo::class);
	}

	public function creador()
	{
		return $this->belongsTo(User::class, 'creador_id')->withTrashed();
	}
}
