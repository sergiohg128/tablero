<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monitoreo extends Model
{
	use SoftDeletes; //habilita borrado suave (borrado por software)
	protected $dates = ['deleted_at'];

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion', 'fecha', 'observacion', 'meta_id'
	];
	
	protected $table = 'monitoreos';

	public $timestamps = false;

	public function meta()
	{
		return $this->belongsTo(Meta::class);
	}
}