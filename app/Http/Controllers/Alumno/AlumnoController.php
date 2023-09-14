<?php

namespace App\Http\Controllers\Alumno;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Model\Rol;
use App\Model\Salon;
use App\Model\Asignatura;
use App\Model\Alumno;
use App\Model\Maestro;
use App\Model\Usuario;
use App\Model\Asignatura_salon;
use App\Model\Maestro_salon;
use App\Model\Momento;
use App\Model\Periodo;
use App\Model\Calificasion;
use App\Model\If_save;
Use App\model\Disputa;
Use App\model\Mensaje;

use App\BusinessLogic\BoMessage;
use Faker\Factory as Faker;

class AlumnoController extends Controller{

	public function ob_user(){
        $admin=Alumno::where('idusuario',auth()->user()->idusuario)->get();
        $rol=Rol::where('idrol',auth()->user()->idrol)->get();
        $datos['admin']=$admin;
        $datos['rol']=$rol;
        $datos['message']='Bienvenido, aqui encontraras tus calificasiones!';
        return $datos;
    }
	public function welcome(){
        $datos=$this->ob_user();
		$per_act=Periodo::where('estado','Activo')->get()[0]->idperiodo;
		$calificasiones=DB::table('calificasion')
                    ->select(
                            'idcalificasion',
                            'valor'
                            ,'nota'
                            ,'idasignatura',
                            'idsalon',
							'idmomento'
                            
                        )
                    ->whereRaw("idperiodo like '%".$per_act."%' and idalumno like'%".Alumno::where('idusuario',auth()->user()->idusuario)->get()[0]->idalumno."%'")
                    ->get();
					
		$asignaturas=Asignatura_salon::where('idsalon',Alumno::where('idusuario',auth()->user()->idusuario)->get()[0]->idsalon)->get();
		$momentos=Momento::all();
		$momentos_filter=array();
		foreach ($momentos as $moment) {
			if ($moment->estado=='Activo' || $moment->estado=='Finalizado') {
				if ($moment->estado=="Finalizado") {
					$moment->class="btn-info";
	
				}
				if ($moment->estado=="Activo") {
					$moment->class="btn-success";
				}	
				$momentos_filter[]=$moment;
			}
		}
		$datos['momentos']=$momentos;
		$datos['isset_m']=true;
        if (count($momentos_filter)==0) {
            $datos['isset_m']=false;
			$datos['message']='Aun no hay calificasiones, pero tranquilo pronto tendras buenas noticias.... O malas...';
        } 
        
		$datos['momento']=$momentos_filter;
		
		foreach ($asignaturas as $asig) {
			$asig->nombre=Asignatura::find($asig->idasignatura)->nombre;
			$calis=array();
			for ($i=0; $i <count($momentos_filter) ; $i++) { 
				$calis[]='';		
				foreach ($calificasiones as $c) {
					if ($c->idmomento==$momentos_filter[$i]->idmomento) {
						if ($c->idasignatura==$asig->idasignatura) {
							
							$c->editar=false;
							if ($momentos_filter[$i]->estado=='Activo') {
								$c->disputa=false;
								$c->editar=true;
								$d=Disputa::all();
								foreach ($d as $k) {
									if ($k->idcalificasion==$c->idcalificasion) {
										$c->disputa=true;
									}
								}
							}
							$c->isset=true;
							$calis[$i]=$c;	
						}
					}		
				}
			}
			
			
			$asig->calificaciones=$calis;
		}
		#para filtrar las calificasiones por  momento y asignatura
		
		$issetM=false;
		$mensajes=Mensaje::where('estado','NO LEIDO')->get();
		foreach ($mensajes as $key) {
			if ($key->para==auth()->user()->idusuario) {
				$issetM=true;
			}
		
		}
		$datos['issetMsg']=$issetM;
		$datos['data']=$asignaturas;
		return view('alumno.welcome')->with($datos);
    }	

    public function disputa(Request $r){
		$datos = $this->ob_user();
		$data = $r->all();
		$calificasion = Calificasion::find($data['idcalificasion']);
		
        $para=DB::table('maestro')
		->join('maestro_salon','maestro_salon.idmaestro','=','maestro.idmaestro')
		->join('asignatura','maestro.idasignatura','=','asignatura.idasignatura')
		->select(
				'idusuario',
				'maestro.nombre',
				DB::Raw('asignatura.nombre as asignatura')
				
			)
		->whereRaw("idsalon like '%".$datos['admin'][0]->idsalon."%' and maestro.idasignatura like'%".$calificasion->idasignatura."%'")
		->get()[0];
		$datos['para'] = $para;
		$datos['cali'] = $calificasion->idcalificasion;
        $datos['message']='A continuacion escribe un mensaje para tu profesor '.$para->nombre." de ".$para->asignatura;
        return view('alumno.newdisputa')->with($datos);
    }

	public function send(Request $r){
		$data = $r->all();
		$mensaje = new BoMessage();
		$objeto = new \StdClass();
		$d=Disputa::all();
		if (isset($data['idcalificasion'])) {
			foreach ($d as $key) {
				if ($key->idcalificasion==$data['idcalificasion']) {
					return $this->ver_chats();
				}
			}
			$objeto->idcalificasion = $data['idcalificasion'];
			$objeto->de = $data['de'];
			$objeto->para = $data['para'];
			$objeto->mensaje = $data['mensaje'];
			$resultado=$mensaje->crear_mensaje($objeto);
		}
		if (isset($data['iddisputa'])) {
			$mensaje = new BoMessage();
			$objeto = new \StdClass();
			$objeto->iddisputa = $data['iddisputa'];
			$objeto->mensaje = $data['mensaje'];
			$objeto->de = auth()->user()->idusuario;
			$objeto->para = Maestro::find(Disputa::find($data['iddisputa'])->idmaestro)->idusuario;
			$resultado=$mensaje->crear_mensaje($objeto);
		}

		if (!isset($data['iddisputa'])) {
			return $this->ver_chats();
		}
        return $this->ver_msg($r);
    }

	public function ver_chats(){
		$datos = $this->ob_user();
		$disputas = DB::table('disputa')
        ->join('maestro','disputa.idmaestro','=','maestro.idmaestro')
		->select(
				'iddisputa',
                'idcalificasion',
                DB::Raw('maestro.nombre as maestro'),
                'idasignatura'
				
			)
		->whereRaw("disputa.idalumno like '%".$datos['admin'][0]->idalumno."%'")
		->get();
		
		foreach ($disputas as $key) {
			$key->class='bg-info';
			$mensajes = Mensaje::where('iddisputa',$key->iddisputa)->get();
            foreach ($mensajes as $sms) {
                if (($sms->estado=='NO LEIDO') &&($sms->de!=auth()->user()->idusuario)) {
                   $key->class='bg-danger';
                }
            }
            $cali = Calificasion::find($key->idcalificasion);
            $key->calificasion = $cali->valor;
            $asig = Asignatura::find($key->idasignatura)->nombre;
            $key->asignatura = $asig;
			
			
		}
        $datos['disputas'] = $disputas;
        $datos['message'] = 'Aqui encontraras las discusiones que has abierto sobre tus calificasiones.';
        return view('alumno.verchats')->with($datos);
    }
	public function ver_msg(Request $r){
		$datos = $this->ob_user();
        $data = $r->all();
		$mensajes = Mensaje::where('iddisputa',$data['iddisputa'])->get();
		foreach ($mensajes as $sms) {
			if (($sms->estado=='NO LEIDO') && ($sms->de!=auth()->user()->idusuario)) {
				$sms->estado='LEIDO';
				$sms->save();
			}
		}
        $disp = Disputa::where('iddisputa',$data['iddisputa'])->get();
		$maestro = Maestro::find($disp[0]->idmaestro);
        $datos['maestro'] = $maestro;
        $datos['mensajes'] = $mensajes;
        $datos['recibe'] = $datos['admin'][0]->idusuario;
        $datos['message'] = 'Estos son tus mensajes con: '.$maestro->nombre;
        $datos['iddisputa'] = $data['iddisputa'];
        return view('alumno.vermsg')->with($datos);
    }

 
 
}