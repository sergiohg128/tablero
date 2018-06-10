<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicador extends Model
{
	use SoftDeletes; //habilita borrado suave (borrado por software)
	protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','descripcion','tipo', 'creador_id', 'oficina_id','anio','valor'
	];
	
	protected $table = 'indicadores';

	public $timestamps = false;

	public function creador()
	{
		return $this->belongsTo(User::class, 'creador_id')->withTrashed();
	}

	public function oficina()
	{
		return $this->belongsTo(Oficina::class)->withTrashed();
	}

	public function actividades()
	{
		return $this->hasMany(Actividad::class)->orderBy("id");
	}

	public function scopeSearch($query, $search){
		$search = preg_replace('[\s+]','', $search);//quitar espacios
		$search = strtolower($search);//convertir todo a minusculas
		if($search != ""){
			$query->where(\DB::raw("LOWER(nombre)"), "LIKE", "%$search%");
		}
	}

	public function porcentaje(){
		$total = 0;
		$cantidad = 0;
		$actividades = $this->actividades;
		foreach($actividades as $actividad){
			$metas = count($actividad->metas) ;
            $metasCumplidas = count($actividad->metas->where('estado', 'F'));
            if($this->tipo=='1'){
            	if($metas==$metasCumplidas)	{
            		$total++;
            	}
        	}elseif($this->tipo=='2') {
        		if($metas==$metasCumplidas)	{
					if($actividad->indicador_valor>0){
	        			$total = $total + $actividad->indicador_valor;
	        			$cantidad = $cantidad +1;
	        		}
        		}
        	}
		}

		if($this->tipo=='1') {
			$resultado = ($total/$this->valor)*100;
		}
		elseif($this->tipo=='2') {
			if($cantidad==0){
				$total = 0;
			}else{
				$total = $total/$cantidad;
			}				
			$resultado = $total;
		}

		return $resultado;
	}
}
