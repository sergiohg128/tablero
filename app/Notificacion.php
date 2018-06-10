<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use Carbon\Carbon;
use Auth;

class Notificacion extends Model
{
  use SoftDeletes; //habilita borrado suave (borrado por software)
  protected $dates = ['deleted_at'];

  protected $table = 'notificaciones';
  public $timestamps = false;

  protected $fillable = ['fecha', 'tipo', 'enlace', 'user_id'];

  public function scopeSearch($query, $search){
    $search = preg_replace('[\s+]','', $search);//quitar espacios
    $search = strtolower($search);//convertir todo a minusculas

    if($search != ""){
			$query->where(\DB::raw("REPLACE(LOWER(title),' ','')"), "LIKE", "%$search%")
			       ->orWhere(\DB::raw("LOWER(type)"), "LIKE", "%$search%");
		}
  }




  public function type_icon(){
    if($this->type=='actividad'){
      return '<i class="fa fa-sitemap"></i>';
    }elseif($this->type=='responsable'){
      return '<i class="fa fa-user"></i>';
    }
  }

  public function creadoHace(){
    $hoy = Carbon::now();
    $inicio = Carbon::create(
      date("Y", strtotime($this->date)),
      date("m", strtotime($this->date)),
      date("d", strtotime($this->date))
    );

    // return 'hola';

    $tiempo = $hoy->diffInDays($inicio);
    if($tiempo>7){
        $tiempo = $hoy->diffInWeeks($inicio);
        if($tiempo>4){//mas de 5 semanas
          $tiempo = $hoy->diffInMonths($inicio);
          if($tiempo>12){//mas de 12 meses
            $tiempo = $hoy->diffInYears($inicio);
            $tiempo.' años';
          }else{
            $tiempo.'meses';
          }
        }else{
          $tiempo.'semanas';
        }
    }elseif($tiempo==0){
      return '<span class="label label-default"><i class="fa fa fa-clock-o"></i> Hoy</span>';
    }

    return '<small class="label label-default"><i class="fa fa-clock-o"></i>'.$tiempo.' dias</small>';
  }

  public static function mycron(){
    $actividades = Actividad::all();

    foreach ($actividades as $key => $actividad) {

      $hoy = \Carbon\Carbon::now();

      $inicio = \Carbon\Carbon::create(
        date("Y", strtotime($actividad->fecha_inicio)),
        date("m", strtotime($actividad->fecha_inicio)),
        date("d", strtotime($actividad->fecha_inicio))
      );

      $fin = \Carbon\Carbon::create(
        date("Y", strtotime($actividad->fecha_fin_esperada)),
        date("m", strtotime($actividad->fecha_fin_esperada)),
        date("d", strtotime($actividad->fecha_fin_esperada))
      );

      $estimado = $fin->diffInDays($inicio); //tiempo estimado
      $transcurrido = $hoy->diffInDays($inicio); //tiempo transcurrido hasta hoy
      $progreso = round($transcurrido/$estimado*100);


      if($progreso>=81){
        // echo $actividad->id.'<br>';
        $responsables = $actividad->responsables;
        $msn = 'El progreso de la actividad <strong>"'.\App\Actividad::find($actividad->id)->nombre.'"</strong>
        segun el tiempo establecido a pasado el 80%
        <a target="_blank" href="'.url('/actividades/'.$actividad->id).'"><span class="label label-info" style="padding-bottom:0; padding-top:0">ver actividad</span></a>';
        foreach ($responsables as $key => $responsable) {
          $notify = \DB::table('notificaciones')->insert([
            'date'=>Carbon::now(),
            'type'=>'actividad',
            'action'=>'progreso',
            'title' => 'Progreso de la actividad',
            'from' => $responsable->user_id,//si from=to la notificacion sera de parte del sistema
            'to' =>  $responsable->user_id,
            'checked'=>false,
            'detail'=>$msn,
          ]);
        }
        // echo count($users);
      }
    }

    echo 'El Cron Diario se Realizo con Exito!!';
  }

// ------------------------------Static-----------------------------
  public static function toAdminActivityCreated(){
    $actividad = Actividad::all()->last();//actividad recien creada
    $from = User::find(Auth::user()->id);
    $msn = 'El usuario '.$from->nombres.' de la oficina '.$from->oficina->nombre.', ha creado
    una nueva actividad con nombre <strong>"'.$actividad->nombre.'" </strong>, has click
    <a target="_blank" href="'.url('/actividades/'.$actividad->id).'"><span class="label label-info" style="padding-bottom:0; padding-top:0">aqui</span></a>
     para darle un vistazo.';

    $admins = User::where('tipo','admin')->get();
    foreach ($admins as $key => $to) {
      $notify = \DB::table('notificaciones')->insert([
        'date'=>Carbon::now(),
        'type'=>'actividad',
        'action'=>'create',
        'title' => 'Nueva actividad',
        'from' => $from->id,
        'to' =>  $to->id,
        'checked'=>false,
        'detail'=>$msn,
      ]);
    }
  }

  public static function toUserLikeResponsableDeleted($actividad_id, $user_deleted_id){
    $msn = 'El usuario '.Auth::user()->nombres.' te ha eliminado como responsable de la
    actividad <strong>"'.Actividad::find($actividad_id)->nombre.'" </strong>. Gracias por tu ayuda <i class="fa fa-thumbs-o-up"></i>';
    $notify = \DB::table('notificaciones')->insert([
      'date'=>Carbon::now(),
      'type'=>'responsable',
      'action'=>'eliminar',
      'title' => 'Ha sido eliminado como responsable de una actividad',
      'from' => Auth::user()->id,
      'to' =>  $user_deleted_id,
      'checked'=>false,
      'detail'=>$msn,
    ]);
  }

  public static function toUserLikeResponsableAsignar($actividad_id, $user_asignado_id){
    $msn = 'El usuario '.Auth::user()->nombres.' te agregó como responsable de la
    actividad <strong>"'.Actividad::find($actividad_id)->nombre.'" </strong>. Puedes empezar a trabajar en ella, creando
    metas y cumpliendolas detro de las fechas y presupuestos establecidos.
    <a target="_blank" href="'.url('/actividades/'.$actividad_id).'"><span class="label label-info" style="padding-bottom:0; padding-top:0">ver actividad</span></a>';
    $notify = \DB::table('notificaciones')->insert([
      'date'=>Carbon::now(),
      'type'=>'responsable',
      'action'=>'asignar',
      'title' => 'Ha sido agregado como responsable de una actividad',
      'from' => Auth::user()->id,
      'to' =>  $user_asignado_id,
      'checked'=>false,
      'detail'=>$msn,
    ]);
  }

  public static function toUserLikeResponsableReasignar($actividad_id, $user_asignado_id){
    $msn = 'El usuario '.Auth::user()->nombres.' te ha agrego como responsable de la
    actividad <strong>"'.Actividad::find($actividad_id)->nombre.'" </strong> en la cual ya te encontrabas participando anteriormente.
    <a target="_blank" href="'.url('/actividades/'.$actividad_id).'"><span class="label label-info" style="padding-bottom:0; padding-top:0">ver actividad</span></a>';
    $notify = \DB::table('notificaciones')->insert([
      'date'=>Carbon::now(),
      'type'=>'responsable',
      'action'=>'reasignar',
      'title' => 'Ha vuelto a participar como responsable de una actividad',
      'from' => Auth::user()->id,
      'to' =>  $user_asignado_id,
      'checked'=>false,
      'detail'=>$msn,
    ]);
  }


  // ------------------------------DICCIONARIO------------------------------
  //(opcional): indica acividad o meta
  //NOTIFICACIONES->TIPOS:ACCION
  // actividad(1): crear(1), eliminar(2)
  // monitor(2):
  // responsable(3): asignar(1), reasignar(2), eliminar(2)
  // meta(4):
  // -----------------------------------------------------------------------

}
