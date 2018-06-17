<?php

namespace App\Http\Controllers;
use App\Http\Requests\ActividadRequest;
use Illuminate\Http\Request;

use App\Actividad;
use App\Oficina;
use App\User;
use App\Responsable;
use App\Indicador;
use Carbon\Carbon;
use View;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportesController extends Controller
{
    public function __construct(){
      $this->middleware('auth');

      $this->estiloshtml = '<style>
            
                *{
                    margin: 0;
                    padding: 0;
                    font-height: 10px;
                    margin-top: 5px;
                }
                
                body {
                    display: block;
                    width: 90%;
                    margin: auto;
                    margin-top: 40px;
                    margin-bottom: 40px;
                    position: relative;
                }

                table {
                	width: 100%;
				  border-collapse: collapse;
				}

				table,tr,td,th{
					border: 1px solid black;
					text-align: center;
				}

				th{
					font-weight: bold;
					text-transform: uppercase;
				}

                .centro{
                        text-align: center;
                }

                .izquierda{
                        text-align: left !important;
                }

                .derecha{
                        text-align: right;
                }

                .metas{
                	font-size : 0.9em;
                }

                ul{
                	margin-left: 15px;
                }

                </style>';
        
        $this->cabecerahtml = '
                     <div class="centro"><h2>REPORTE DE ACTIVIDADES</h2></div>
                     <br>';

        $this->cabecerahtml2 = '
                     <div class="centro"><h2>REPORTE DE ACTIVIDAD</h2></div>
                     <br>';

        $this->head = '<!DOCTYPE html><html>'.$this->estiloshtml.'<body>'.$this->cabecerahtml;
        $this->head2 = '<!DOCTYPE html><html>'.$this->estiloshtml.'<body>'.$this->cabecerahtml2;
    }

    public function index(Request $request){
      $id = 0;
      if(Auth::user()->tipo!="admin"){
        $id = Auth::user()->oficina_id;
      }
      $actividades = Actividad::select("actividades.*")->join("users","actividades.creador_id","=","users.id");
      if($id>0){
        $actividades = $actividades->where("users.oficina_id",$id);
      }
      $actividades = $actividades->orderBy("fecha_creacion","desc")->get();
      return view('reportes.index', compact('actividades'));
    }


    //actividades por oficina
    public function reporte(Request $request){
    	$oficina = $request->input("oficina");
    	$desde = $request->input("fecha_inicio");
    	$hasta = $request->input("fecha_fin");
    	$estado = $request->input("estado");
    	$actividades = Actividad::select("actividades.*")->join("users","actividades.creador_id","=","users.id");
    	if($oficina>0){
    		$actividades = $actividades->where("users.oficina_id",$oficina);
    	}

    	if(!empty($desde)){
    		$actividades = $actividades->where("fecha_inicio",">=",$desde);
    	}

    	if(!empty($hasta)){
    		$actividades = $actividades->where("fecha_fin","<=",$hasta.' 23:59:59');
    	}
    	$actividades = $actividades->get();

	    $dompdf = new Dompdf();
	    $dompdf->setPaper('A4','landscape');
	    $html = $this->head;
	    $html = $html.
	    			'<table class="tablacuerpo">
	    				<tr>
	    					<th rowspan="2">N°</th>
	    					<th rowspan="2">Nombre</th>
	    					<th rowspan="2">Monitor</th>
	    					<th rowspan="2">Inicio</th>
	    					<th rowspan="2">Fin</th>
	    					<th rowspan="2">Estado</th>
	    					<th colspan="2">Metas</th>
	    					<th rowspan="2">Tiempo</th>
	    				</tr>
	    				<tr>
	    					<th>Tot.</th>
	    					<th>Fin.</th>
	    				</tr>';
	    $cont = 0;
	    foreach($actividades as $actividad){
	    	$meta_success=false;//para pintar fila si la meta esta cumplida
            $metas = count($actividad->metas) ;
            $metasCumplidas = count($actividad->metas->where('estado', 'F'));
            $imprimirfila = "";
            $estilofila = "x";
            if($metas==0){
              $actividadestado = 'Pendiente';
            }elseif($metas==$metasCumplidas){
              $actividadestado = 'Finalizado';
            }else{
              $actividadestado = 'En proceso';
            }

            $ok = false;
            if($estado=="Todos"){
            	$ok = true;
            }else{
            	if($estado==$actividadestado){
            		$ok = true;
            	}
            }
            if($ok){
		    	$cont++;
		    	$html = $html .
		    				'<tr>
		    					<td>'.$cont.'</td>
		    					<td class="izquierda">'.$actividad->nombre.'</td>
		    					<td>'.$actividad->monitor->completo().'</td>
		    					<td>'.date("d-m-Y", strtotime($actividad->fecha_inicio)).'</td>';
		    	if($actividad->fecha_fin!=null){
		    		$html = $html . '<td>'.date("d-m-Y", strtotime($actividad->fecha_fin)).'</td>';
		    	}else{
		    		$html = $html . '<td>-</td>';
		    	}
		    	$html = $html .'
		    					<td>'.$actividadestado.'</td>
		    					<td>'.$metas.'</td>
		    					<td>'.$metasCumplidas.'</td>
		    					<td>'.$actividad->porcentaje().'%</td>
		    				</tr>';
            }
	    }
	    	  
	    $html = $html . '</table></body></html>';

	    $dompdf->loadHtml($html, 'UTF-8');
	    $dompdf->render();
	    $dompdf->stream('reporte.pdf',array('Attachment'=>0));
    }
    
    //actividad 
    public function reporte2(Request $request){
    	$id = $request->input("actividad");
    	$detalle = $request->input("detalle");

    	$actividad = Actividad::find($id);

        $metas = count($actividad->metas) ;
        $metasCumplidas = count($actividad->metas->where('estado', 'F'));
        $imprimirfila = "";
        $estilofila = "x";
        if($metas==0){
          $actividadestado = 'Pendiente';
        }elseif($metas==$metasCumplidas){
          $actividadestado = 'Finalizado';
        }else{
          $actividadestado = 'En proceso';
        }

	    $dompdf = new Dompdf();
	    $dompdf->setPaper('A4');
	    $html = $this->head2;
	    
	    //informacion principal
	    $html = $html.
	    			'<div>
		    			<h3 class="centro">'.$actividad->nombre.'</h3>
		    			<br><br>
		    			<h4><u>INFORMACIÓN GENERAL</u></h4>
		    			<ul>
			    			<li><b>Estado: </b>'.$actividadestado.'</li>
			    			<li><b>Metas totales: </b>'.$metas.'</li>
			    			<li><b>Metas cumplidas: </b>'.$metasCumplidas.'</li>
			    			<li><b>Presupuesto: </b>S/ '.$actividad->presupuesto.'</li>
			    			<li><b>Fecha de Creación: </b>'.date("d-m-Y", strtotime($actividad->fecha_creacion)).'</li>
			    			<li><b>Fecha de Inicio: </b>'.date("d-m-Y", strtotime($actividad->fecha_inicio)).'</li>
			    			<li><b>Fecha de Fin Esperada: </b>'.date("d-m-Y", strtotime($actividad->fecha_fin_esperada)).'</li>';
		if($actividad->fecha_fin!=null){
			$html = $html . '<li><b>Fecha de Fin: </b>'.date("d-m-Y", strtotime($actividad->fecha_fin)).'</li>';
		}
		if($actividad->numero_resolucion!=null){
			$html = $html . '<li><b>Número de Resolución: </b>'.$actividad->numero_resolucion.'</li>';
		}
		if($actividad->fecha_resolucion!=null){
			$html = $html . '<li><b>Fecha de Resolución: </b>'.date("d-m-Y", strtotime($actividad->fecha_resolucion)).'</li>';
		}
		if($actividad->fecha_acta!=null){
			$html = $html . '<li><b>Fecha de Acta: </b>'.date("d-m-Y", strtotime($actividad->fecha_acta)).'</li>';
		}
		$html = $html .
							'<li><b>Descripción de Acta: </b>'.$actividad->descripcion_acta.'</li>
			    			<li><b>Creador: </b>'.$actividad->creador->completo().'</li>
			    			<li><b>Monitor: </b>'.$actividad->indicador_id.'</li>';
		if($actividad->indicador_id>0){
			$html = $html . '<li><b>Indicador: </b>'.$actividad->indicador->nombre.'</li>';
		}
			    			
		$html = $html . '</ul>
		    		</div>';

		//usuarios
		$html = $html .
					'<div>
						<br><br>
		    			<h4><u>USUARIOS</u></h4>
						<table>
							<tr>
								<th>N°</th>
								<th>Nombre</th>
								<th>Rol</th>
							</tr>
							<tr>
								<td>1</td>
								<td>'.$actividad->creador->completo().'</td>
								<td>Creador</td>
							</tr>
							<tr>
								<td>2</td>
								<td>'.$actividad->monitor->completo().'</td>
								<td>Monitor</td>
							</tr>';
		$cont = 2;
		foreach($actividad->responsables as $key=> $responsable){
			$cont++;
			$html = $html.	'<tr>
								<td>'.$cont.'</td>
								<td>'.$responsable->user->completo().'</td>
								<td>Responsable</td>
							</tr>';
		}
		$html = $html .	'</table>
					</div>';


		//metas
		$html = $html .
					'<div>
						<br><br>
		    			<h4><u>METAS</u></h4>
						<table class="metas">
							<tr>
								<th rowspan="2">N°</th>
								<th rowspan="2">Nombre</th>
								<th rowspan="2">Presupuesto</th>
								<th rowspan="2">Estado</th>
								<th colspan="2">Esperada</th>
								<th colspan="2">Real</th>
							</tr>
							<tr>
								<th>Inicial</th>
								<th>Final</th>
								<th>Inicial</th>
								<th>Final</th>
							</tr>';
		$cont = 0;
		foreach($actividad->metas as $meta){
			$cont++;
			$html = $html.		'<tr>
									<td>'.$cont.'</td>
									<td>'.$meta->nombre.'</td>
									<td>'.$meta->presupuesto.'</td>';
			if ($meta->estado == 'P'){
				$html = $html . '<td>Pendiente</td>';
			}else if ($meta->estado == 'E'){
				$html = $html . '<td>En proceso</td>';
			}else if ($meta->estado == 'F'){
				$html = $html . '<td>Finalizado</td>';
			}

			if($meta->fecha_inicio_esperada!=null){
				$html = $html .'<td>'.date("d-m-Y", strtotime($meta->fecha_inicio_esperada)).'</td>';	
			}else{
				$html = $html .'<td></td>';
			}
			if($meta->fecha_fin_esperada!=null){
				$html = $html .'<td>'.date("d-m-Y", strtotime($meta->fecha_fin_esperada)).'</td>';	
			}else{
				$html = $html .'<td></td>';
			}
			if($meta->fecha_inicio!=null){
				$html = $html .'<td>'.date("d-m-Y", strtotime($meta->fecha_inicio)).'</td>';	
			}else{
				$html = $html .'<td></td>';
			}
			if($meta->fecha_fin!=null){
				$html = $html .'<td>'.date("d-m-Y", strtotime($meta->fecha_fin)).'</td>';	
			}else{
				$html = $html .'<td></td>';
			}
			$html = $html .'</tr>';
		}
		$html = $html .	'</table>
					</div>';

		//detalle de metas
		if($detalle=="S"){
			$html = $html .
						'<div style="page-break-after: always;"></div>
						<div>
							<h2 class="centro">DETALLE DE METAS</h2>
							<br><br>';
			foreach($actividad->metas as $meta){
				$html = $html .
							'<div>
								<h4><u>'.$meta->nombre.'</u></h4>
								<p><b>Producto:</b>'.$meta->producto.'</p>
								<p><b>Presupuesto: </b>'.$meta->presupuesto.'</p>
								<p><b>Fecha de Inicio Esperada: </b>'.date("d-m-Y", strtotime($meta->fecha_inicio_esperada)).'</p>
								<p><b>Fecha de Fin Esperada: </b>'.date("d-m-Y", strtotime($meta->fecha_fin_esperada)).'</p>';
				if($meta->fecha_inicio!=null){
					$html = $html . '<p><b>Fecha de Inicio Real: </b>'.date("d-m-Y", strtotime($meta->fecha_inicio)).'</p>';
				}else{
					$html = $html . '<p><b>Fecha de Inicio Real: </b>-</p>';
				}
				if($meta->fecha_fin!=null){
					$html = $html . '<p><b>Fecha de Fin Real: </b>'.date("d-m-Y", strtotime($meta->fecha_fin)).'</p>';
				}else{
					$html = $html . '<p><b>Fecha de Fin Real: </b>-</p>';
				}

				$html = $html . 
								'<br>
								<h5>RESPONSABLES</h5>
								<ul>';
				foreach($meta->responsables as $responsable){
					$html = $html . 
									'<li>'.$responsable->user->completo().'</li>';
				}
				$html = $html . '</ul>
								</div>';



				//GASTOS			
				$html = $html .'<table class="metas">
								<tr>
									<th colspan="5">GASTOS</th>
								</tr>
								<tr>
									<th>N°</th>
									<th>Fecha</th>
									<th>Documento</th>
									<th>Detalle</th>
									<th>Importe</th>
								</tr>';
				$cont = 0;
				$total = 0;
				if(count($meta->gastos)>0){
					foreach($meta->gastos as $gasto){
						$cont++;
						$html = $html .
									'<tr>
										<td>'.$cont.'</td>
										<td>'.date("d-m-Y", strtotime($gasto->fecha)).'</td>
										<td>'.$gasto->tipo_documento->nombre.' # '.$gasto->numero.'</td>
										<td>'.$gasto->descripcion.'</td>
										<td>'.$gasto->monto.'</td>
									</tr>';
						$total += $gasto->monto;
					}
					$html = $html .
								'<tr>
									<td></td>
									<td></td>
									<td></td>
									<td><b>TOTAL</b></td>
									<td><b>'.$total.'</b></td>
								</tr>';
				}else{
					$html = $html .
								'<tr>
									<td colspan="5">No hay registros</td>
								</tr>';
				}
					
				$html = $html .
							'</table>
							<br>';
			
				//MONITOREOS
				$html = $html .'<table class="metas">
								<tr>
									<th colspan="4">MONITOREOS</th>
								</tr>
								<tr>
									<th>N°</th>
									<th>Descripción</th>
									<th>Fecha</th>
									<th>Observación</th>
								</tr>';
				$cont = 0;
				$total = 0;
				if(count($meta->monitoreos)>0){
					foreach($meta->monitoreos as $monitoreo){
							$cont++;
							$html = $html .
										'<tr>
											<td>'.$cont.'</td>
											<td>'.$monitoreo->descripcion.'</td>
											<td>'.date("d-m-Y", strtotime($monitoreo->fecha)).'</td>
											<td>'.$monitoreo->observacion.'</td>
										</tr>';
					}
				}else{
					$html = $html .
								'<tr>
									<td colspan="4">No hay registros</td>
								</tr>';
				}
				$html = $html .
							'</table>
							<br>';
			
				//
			}
		}
	    	  
	    $html = $html . '</body></html>';

	    $dompdf->loadHtml($html, 'UTF-8');
	    $dompdf->render();
	    $dompdf->stream('reporte.pdf',array('Attachment'=>0));
    }
    
    
}
