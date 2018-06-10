<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_documento extends Model
{
	use SoftDeletes; //habilita borrado suave (borrado por software)
	protected $dates = ['deleted_at'];
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'nombre', ];
	
	protected $table = 'tipo_documentos';

	public $timestamps = false;

	public function gastos()
	{
		return $this->hasMany(Gasto::class);
	}
}
