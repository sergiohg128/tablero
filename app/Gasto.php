<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gasto extends Model
{
	use SoftDeletes; //habilita borrado suave (borrado por software)
	protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion', 'monto', 'numero', 'fecha', 'tipo', 'meta_id', 'tipo_documento_id',
	];
	
	protected $table = 'gastos';

	public $timestamps = false;

	public function meta()
	{
		return $this->belongsTo(Meta::class);
	}

	public function tipo_documento()
	{
		return $this->belongsTo(Tipo_documento::class)->withTrashed();
	}
}
