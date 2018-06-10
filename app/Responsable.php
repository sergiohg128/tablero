<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Responsable extends Model
{
    use SoftDeletes; //habilita borrado suave (borrado por software)
    protected $dates = ['deleted_at'];
  
    protected $table = 'responsables';
    public $timestamps = false;

    protected $fillable = [];
	

	// Added
	public function metas()
	{
		return $this->belongsToMany(Meta::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class)->withTrashed();
	}

	public function actividad()
	{
		return $this->belongsTo(Actividad::class);
	}
}
