<?php

namespace App\Http\Controllers\Maestro;
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
use Faker\Factory as Faker;
Use App\model\Disputa;
Use App\model\Mensaje;
use App\BusinessLogic\BoMessage;






class MaestroController extends Controller{
    //para obtener los datos esenciales de la vista
    public function ob_user(){
        $admin=Maestro::where('idusuario',auth()->user()->idusuario)->get();
        $rol=Rol::where('idrol',auth()->user()->idrol)->get();
        $datos['isset']=true;
        $momento=Momento::all();
        if (count($momento)==0) {
            $datos['isset']=false;
        } 
        for ($i=0; $i <count($momento) ; $i++) { 
			if ($momento[$i]->estado=="Finalizado") {
				$momento[$i]->class="btn-danger";

			}
			if ($momento[$i]->estado=="Activo") {
				$momento[$i]->class="btn-info";
			}
			if ($momento[$i]->estado=='Futuro') {
				$momento[$i]->class="btn-success";
			}	
		}
        $datos['momento']=$momento;
        $datos['admin']=$admin;
        $datos['rol']=$rol;
        $datos['periodo']=Periodo::all();
        $datos['message']='Bienvenido, aqui podras visualizar los salones en los que actualmente impartes clases, dandole click a estos podras ver los alumnos que lo conforman y si hay un momento activo podras asignar una calificasion.';
        return $datos;
    }

    public function welcome(Request $r){
        //obtiene datos esenciales de la vista
        $datos=$this->ob_user();
        //para comprobar sin venimos de algun form
        if ($r->isMethod('post')) {
            $data=$r->all();
            if (isset($data['tipo'])) {
                $datos['message']='hola';
            }    
        }
       
        
        if (isset($r->all()['idsalon'])) {
            
            $permiso=$this->validar_per($r);
            if (!$permiso) {
                $datos['message']='No tienes permiso para administrar este salon, porfavor deja de intentar evadir el sistema.';
            }
        }
       
        
        $maestro=Maestro::where('idusuario',auth()->user()->idusuario)->get();
        //comprueba si el maestro esta en algun salon
        $si_maestro=Maestro_salon::where('idmaestro',$maestro[0]->idmaestro)->get();
       
        
        $datos_salon=array();
        foreach ($si_maestro as $elemento) {
            $bandera=false;
            $si_materia=Asignatura_salon::where('idsalon',$elemento->idsalon)->get();
            foreach ($si_materia as $key) {
               if ($key->idasignatura==$maestro[0]->idasignatura) {
                    $bandera=true;
               }
            }
            if ($bandera) {
                $datos_salon[]=$key;
            }
            
        }

        $datos['salon']=array();
        foreach ($datos_salon as $elemento) {
            $salon=Salon::find($elemento->idsalon);
            $al=Alumno::where('idsalon',$salon->idsalon)->get();
            $total=0;
            foreach ($al as $elemento) {
                $total++;
            }
            
            $salon->total=$total;
            $datos['salon'][]=$salon;
        }

        $issetM=false;
		$mensajes=Mensaje::where('estado','NO LEIDO')->get();
        
		foreach ($mensajes as $key) {
			if ($key->para==auth()->user()->idusuario) {
				$issetM=true;
			}
		
		}
		$datos['issetMsg']=$issetM;
        return view('maestro.welcome')->with($datos);

    }
    public function validar_per($x){
        $data=$this->ob_user();
        $datos=$x->all();
        $permiso=false;
        $defper=Maestro_salon::where('idsalon',$datos['idsalon'])->get();
        foreach ($defper as $per) {
            if ($per->idmaestro==$data['admin'][0]->idmaestro) {
               $permiso=true;
            }
        }
        return $permiso;
    }
    public function ver_salon(Request $r){
	
		$datos=$r->all();
		$data=$this->ob_user();
        $permiso=$this->validar_per($r);
        if (!$permiso) {
            return $this->welcome($r);
        }
		$alumnos=Alumno::where('idsalon',$datos['idsalon'])->get();
        $cuenta=0;
        for ($i=0; $i <count($alumnos) ; $i++) { 
            $alumnos[$i]->i=$cuenta;
            $cuenta++;
        }
		$data['alumno']=$alumnos;
		$data['message']='hola';
        $salon=Salon::where('idsalon',$datos['idsalon'])->get();
        $data['salon']=$salon[0];
        $momentos=Momento::all();
        $momentoshow=array();
        $data['message']='Estos son los alumnos, cuando se activen los momentos de evaluacion podras administrarlos aqui!';
        $data['some']=false;
        ##
        $data['vif']=false;
        $data['calificasion']=$momentoshow;
        $data['boton']=false;
       
        foreach ($momentos as $momento) {
            if ($momento->estado=='Finalizado') {
                $momento->vif=true;
               
                $momento->calificasion=DB::table('calificasion')
                ->select(
                        'idcalificasion',
                        'valor'
                        ,'nota'
                        ,'idasignatura',
                        'idsalon'
                        
                    )
                ->whereRaw("idsalon like '%".$datos['idsalon']."%' and idasignatura like'%".Maestro::where('idusuario',auth()->user()->idusuario)->get()[0]->idasignatura."%' and idmomento like'%".$momento->idmomento."%'and idperiodo like'%".Periodo::where('estado','Activo')->get()[0]->idperiodo."%'")
                ->get();
                if (count($momento->calificasion)==0) {
                   
                    $momento->vif=false;
                }
                $data['message']='El momento de evaluacion anterior a finalizado, pronto habra uno nuevo, espera instrucciones.';
                $momento->style='width: 20px';
                $momentoshow[]=$momento;
               
            }
            if($momento->estado=='Activo'){
               
                $consulta=DB::table('if_save')
                ->select(
                        'idsalon'
                        ,'idmaestro'
                        ,'idmomento'
                        
                    )
                ->whereRaw("idsalon like '%".$datos['idsalon']."%' and idmaestro like'%".Maestro::where('idusuario',auth()->user()->idusuario)->get()[0]->idmaestro."%' and idmomento like'%".$momento->idmomento."%'")
                ->get();
               
                if (isset($consulta[0]->idsalon)) {
                   
                    $momento->calificasion=DB::table('calificasion')
                    ->select(
                            'idcalificasion',
                            'valor'
                            ,'nota'
                            ,'idasignatura',
                            'idsalon'
                            
                        )
                    ->whereRaw("idsalon like '%".$datos['idsalon']."%' and idasignatura like'%".Maestro::where('idusuario',auth()->user()->idusuario)->get()[0]->idasignatura."%' and idmomento like'%".$momento->idmomento."%'and idperiodo like'%".Periodo::where('estado','Activo')->get()[0]->idperiodo."%'")
                    ->get();
                    
                    if (isset($momento->calificasion[0])) {
                        $data['vif']=true;
                        $momento->vif=true;
                        
                    }
                }else {
                    $data['boton']=true;
                }
                $data['message']='Es hora de asignar calificasiones, vamos!';
                $momento->some=true;
                $momentoshow[]=$momento;
                $data['some']=true;
               
            }
            if (count($alumnos)==0) {
                $data['message']='ho vaya, aun no hay alumnos, ignora el boton';
            }
        }

        $data['momento']=$momentoshow;
        $ifm=true;
        if (count($momentoshow)==0) {
            $data['message']='Aun no hay ni un momento activo, pronto podras asignar calificasiones, espera el mensaje de tu director.';
            $ifm=false;
        }
        $data['ifm']=$ifm;
		if($r->isMethod('post')){
            $data['message']='Se han registrado las calificasiones con exito, aun puedes editarlas hasta que el director las inhabilite.';
            if (!isset($r->all()['calificasion'])) {
                $data['message']='Te dije que ignores el boton, casi haces colapsar el sistema!';
            }
		}
        if (isset($r->all()['operacion'])) {
            $data['message']='Ya se ha modificado la calificasion!';
        }
	
		return view('maestro.versalon')->with($data);
	}
    public function save_c(Request $r){
       
        $data=$r->all();
        if (isset($data['operacion'])) {
           
            $c=Calificasion::find($data['idcalificasion']);
            $c->valor=$data['calificasion'];
            $c->save();
            return $this->ver_salon($r);
        }
        if (!isset($data['calificasion'])) {
            return $this->ver_salon($r);
        }

       
       
       
        $as=Maestro::where('idusuario',auth()->user()->idusuario)->get()[0]->idasignatura;
        $al=Alumno::where('idsalon',$data['idsalon'])->get();
        if (isset(Momento::where('estado','Activo')->get()[0]->idmomento)) {
            $m=Momento::where('estado','Activo')->get()[0]->idmomento;
        }
        
        $p=Periodo::where('estado','Activo')->get()[0]->idperiodo;
        $val=$data['calificasion'];
        $obs=$data['observacion'];
        if (isset($m)) {
            $consulta=DB::table('if_save')
            ->select(
                    'idsalon'
                    ,'idmaestro'
                    ,'idmomento'
                    
                )
            ->whereRaw("idsalon like '%".$data['idsalon']."%' and idmaestro like'%".Maestro::where('idusuario',auth()->user()->idusuario)->get()[0]->idmaestro."%' and idmomento like'%".$m."%'")
            ->get();
        }else{
            return $this->ver_salon($r);
        }
       
        if (isset($consulta[0]->idsalon)) {
            return $this->ver_salon($r);
        }
        
        
        for ($i=0; $i <count($data['calificasion']) ; $i++) { 
            $calificasion=new Calificasion();
            $calificasion->valor=$val[$i];
            $calificasion->nota=$obs[$i];
            $calificasion->idalumno=$al[$i]->idalumno;
            $calificasion->idmomento=$m;
            $calificasion->idasignatura=$as;
            $calificasion->idperiodo=$p;
            $calificasion->idsalon=$data['idsalon'];
            $calificasion->save();
        }
        $save=new If_save();
        $save->idmomento=$m;
        $save->idsalon=$data['idsalon'];
        $save->idmaestro=Maestro::where('idusuario',auth()->user()->idusuario)->get()[0]->idmaestro;
        $save->save();
        return $this->ver_salon($r);
    }
    public function editar(Request $r){
        
        $datos=$r->all();
        $data=$this->ob_user();
        $data['calificasion']=Calificasion::find($datos['idcalificasion']);
        $data['idsalon']=$datos['idsalon'];
        $data['message']="introduce los datos para modificar la calificasion";
        return view('maestro.edit')->with($data);


    }

    public function ver_chats(){
		$datos = $this->ob_user();
		$disputas = DB::table('disputa')
        ->join('alumno','disputa.idalumno','=','alumno.idalumno')
		->select(
				'iddisputa',
                'idcalificasion',
                DB::Raw('alumno.nombre as alumno'),
                'idsalon'
				
			)
		->whereRaw("disputa.idmaestro like '%".$datos['admin'][0]->idmaestro."%'")
		->get();
        
		
		foreach ($disputas as $key) {
            $mensajes = Mensaje::where('iddisputa',$key->iddisputa)->get();
            $key->class='bg-info';
            foreach ($mensajes as $sms) {
                if (($sms->estado=='NO LEIDO') &&($sms->de!=auth()->user()->idusuario)) {
                   $key->class='bg-danger';
                }
            }
            $cali = Calificasion::find($key->idcalificasion);
            $key->calificasion = $cali->valor;
            $salon = Salon::find($key->idsalon)->nombre;
            $key->salon = $salon;
			
			
		}
        $datos['disputas'] = $disputas;
        $datos['message'] = 'A qui podras ver los mensajes de alumnos que no estan de acuerdo con su calificacion, estos solo son del momento activo y seran eliminados una vez este finalize.';
        return view('maestro.verchats')->with($datos);
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
		$alumno = Alumno::find($disp[0]->idalumno);
        $datos['alumno'] = $alumno;
        $datos['mensajes'] = $mensajes;
        $datos['recibe'] = $datos['admin'][0]->idusuario;
        $datos['message'] = 'Estos son tus mensajes con: '.$alumno->nombre;
        $datos['iddisputa'] = $data['iddisputa'];
        return view('maestro.vermsg')->with($datos);
    }

    public function send(Request $r){
		$data = $r->all();
		$mensaje = new BoMessage();
		$objeto = new \StdClass();
		$objeto->iddisputa = $data['iddisputa'];
		$objeto->mensaje = $data['mensaje'];
        $objeto->de = auth()->user()->idusuario;
        $objeto->para = Alumno::find(Disputa::find($data['iddisputa'])->idalumno)->idusuario;
        $resultado=$mensaje->crear_mensaje($objeto);

		
        return $this->ver_msg($r);
    }
}
