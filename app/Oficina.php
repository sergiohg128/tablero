<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oficina extends Model
{
    use SoftDeletes; //habilita borrado suave (borrado por software)
    protected $dates = ['deleted_at'];

    protected $table = 'oficinas';
    public $timestamps = false;

    protected $fillable = ['nombre'];
    //protected $guarded = ['id'];

    public function scopeSearch($query, $search){
		$search = preg_replace('[\s+]','', $search);//quitar espacios
		$search = strtolower($search);//convertir todo a minusculas
		if($search != ""){
			$query->where(\DB::raw("LOWER(nombre)"), "LIKE", "%$search%");
		}
	}
	
	// Added

	public function users()
	{
		return $this->hasMany(User::class);
	}
}