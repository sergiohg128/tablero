<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requisito extends Model
{
  use SoftDeletes; //habilita borrado suave (borrado por software)
  protected $dates = ['deleted_at'];

  protected $table = 'requisitos';
  public $timestamps = false;

  protected $fillable = [
        'nombre', 'estado', 'observacion', 'fecha_completado', 'meta_id'
  ];

  public function meta(){
    return $this->belongsto(Meta::class);
  }

  public function scopeSearch($query, $search){
    $search = preg_replace('[\s+]','', $search);//quitar espacios
    $search = strtolower($search);//convertir todo a minusculas
    if($search != ""){
      $query->where(\DB::raw("REPLACE(LOWER(nombre),' ', '')"), "LIKE", "%$search%");
    }
  }
}
