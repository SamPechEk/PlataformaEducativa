<?php

namespace App\Http\Controllers\Institucion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Model\Admin;
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
use App\Model\If_save;
use App\Model\Calificasion;
use App\Model\Mensaje;
use App\Model\Disputa;

use Faker\Factory as Faker;





class InstitucionController extends Controller{
	public function miescuela(Request $r){
        $admin=Admin::where('idusuario',auth()->user()->idusuario)->get();
		$rol=Rol::where('idrol',auth()->user()->idrol)->get();
		$asignaturas=Asignatura::all();
		$salones=Salon::all();
		$maestros=Maestro::all();
		$contador=0;
		foreach ($maestros as $elemento) {
			$elemento->delete=false;
			if (count(Maestro_salon::where('idmaestro',$elemento->idmaestro)->get())==0) {
				$elemento->delete=true;
			}
			$usuario=Usuario::where('idusuario',$elemento->idusuario)->get();
			$elemento->usuario=$usuario[0]->email;
			$elemento->contrasena="User@".$elemento->matricula;
			$asignatura=Asignatura::where('idasignatura',$elemento->idasignatura)->get();
			$elemento->asignatura=$asignatura[0]->nombre;
			$maestros[$contador]=$elemento;
			$contador++;
		}
		$alumnos=Alumno::all();
		$contador=0;
		
		foreach ($alumnos as $elemento) {
			$elemento->delete=false;
			if (count(Calificasion::where('idalumno',$elemento->idalumno)->get())==0) {
				$elemento->delete=true;
			}
			
			$usuario=Usuario::where('idusuario',$elemento->idusuario)->get();
			$elemento->usuario=$usuario[0]->email;
			$elemento->contrasena="User@".$elemento->matricula;
			$salon=Salon::where('idsalon',$elemento->idsalon)->get();
			$elemento->salon=$salon[0]->nombre;
			$alumnos[$contador]=$elemento;
			$contador++;
		}

        $datos['admin']=$admin;
		$datos['rol']=$rol;
		$datos['maestro']=$maestros;
		$datos['alumno']=$alumnos;
		$datos['asignatura']=$asignaturas;
		$datos['salon']=$salones;

		//para comprobar sin venimos del formulario
		
		$datos['message']='Hola, elige que quieres ver en la barra de la izquierda.';

		$data=$r->all();
		
		if(isset($data['operacion'])){

			if($data['operacion']=='eliminar'){
				$datos['message']='Hemos eliminado todos los datos del elemento selecionado.';
			}
			if($data['operacion']=='paso2'){
				$datos['message']='Hemos editado un registro con exito.';
			}
		}
		

		return view('institucion.miescuela')->with($datos);

	}

	public function welcome(Request $r){

		//para comprobar sin venimos del formulario
		if ($r->isMethod('post')) {
			$data=$r->all();
			if (isset($data['tipo'])) {
				$datos['message']=$this->save($r);
			}
			if (isset($data['inicioperiodo'])) {
				$datos['message']='Un nuevo ciclo escolar esta en curso, los datos anteriores han sido archivados y tu escuela esta en espera de nuevos registros.';
			}
			if (isset($data['nombresmomentos'])) {
				$datos['message']='Los momentos de evaluacion han sido dados de alta con exito en el sistema ahora puedes controlarlos desde la misma pestana en la que los agregaste.';
			}
			if (isset($data['idmomento'])) {
				if ($data['accion']=='Activar') {
					$datos['message']='Se a activado el momento de evaluacion, ahora los profesores ya pueden asignar calificasiones.';
				}
				if ($data['accion']=='Reactivar') {
					$datos['message']='Se a reactivado el momento de evaluacion, ahora los profesores pueden manipular de nuevo las calificasiones, no olvides finalizarlo despues. Y si habia un momento en curso, activalo!';
				}
				if ($data['accion']=='Finalizar') {
					$datos['message']='Se a desactivado el momento de evaluacion, ahora ya no se pueden manipular las calificasiones, pero ya puedes activar el siguiente momento en cuanto te sea nesesario o reactivar el anterior si surge un problema.';
				}
				
			}
			
			
		}else{
			$datos['message']='Hola, elige un elemento en la barra de la izquierda';
		}
		
		$admin=Admin::where('idusuario',auth()->user()->idusuario)->get();
		$rol=Rol::where('idrol',auth()->user()->idrol)->get();
		$asignaturas=Asignatura::all();
		$salones=Salon::all();
		$datos['isset']=true;

        $datos['admin']=$admin;
		$datos['rol']=$rol;
		$datos['asignatura']=$asignaturas;
		$datos['salon']=$salones;
		$datos['periodo']=Periodo::all();
		$momento=Momento::all();
		
		if (count($momento)==0) {
			$datos['isset']=false;
		}
		for ($i=0; $i <count($momento) ; $i++) { 
			if ($momento[$i]->estado=="Finalizado") {
				$momento[$i]->class="btn-danger";
				$momento[$i]->label="Reactivar";

			}
			if ($momento[$i]->estado=="Activo") {
				$momento[$i]->class="btn-info";
				$momento[$i]->label="Finalizar";
			}
			if ($momento[$i]->estado=='Futuro') {
				$momento[$i]->class="btn-success";
				$momento[$i]->label="Activar";
				if (isset($momento[$i-1])) {
					if ($momento[$i-1]->estado=="Futuro") {
						$momento[$i]->class='btn-success disabled';
					}	
				}
				if (isset($momento[$i-1]->estado)) {
					if ($momento[$i-1]->estado=='Activo') {
						$momento[$i]->class='btn-success disabled';
					}
				}
				
				
			}
			
			
			
			
		}
		
		
		
		$datos['momento']=$momento;
		
		return view('institucion.welcome')->with($datos);

	}
	public function save($r){
		$data=$r->all();
		
		if ($data['tipo']==1 || $data['tipo']==2) {
			$explode_email=explode('@',$data['email']);
			$email_nuevo=$explode_email[0].'@plataforma.edu';
			$validar=Usuario::all();
			foreach ($validar as $valida) {
				if ($valida->email==$email_nuevo) {
					return 'ERROR, el email ya pertenece a un usuario.';
				}
			}
			if ($data['tipo']==2) {
				$validar2=Alumno::all();
				foreach ($validar2 as $valida) {
					if ($valida->nombre==$data['nombre']) {
						return 'ERROR, el alumno ya tiene una cuenta.';
					}
				}
				$tipo_user=3;

			}
			if ($data['tipo']==1) {
				$validar3=Maestro::all();
				foreach ($validar3 as $valida) {
					if ($valida->nombre==$data['nombre']) {
						return 'ERROR, el maestro ya tiene una cuenta.';
					}
				}
				$tipo_user=2;
			}

			$faker = Faker::create();
			$bandera=false;
			while (!$bandera) {
				$matricula=$faker->regexify('([0-9]){10}');
				$bandera2=false;
				$validar2=Alumno::all();
				foreach ($validar2 as $valida) {
					if ($valida->matricula==$matricula) {
						$bandera2=true;
					}
				}
				$validar3=Maestro::all();
				foreach ($validar3 as $valida) {
					if ($valida->matricula==$matricula) {
						$bandera2=true;
					}
				}
				if(!$bandera2){
					$bandera=true;
				}
			}
			$usuario=new Usuario();
			$usuario->idrol=$tipo_user;
			$password='User@'.$matricula;
			$usuario->email=$email_nuevo;
			$usuario->password=bcrypt($password);
			$usuario->save();
			
		}
	
		if($r->hasfile('foto')){
			
			$archivo=$r->file('foto');
			if ($tipo_user==2) {
				$nombre='maestro'.$matricula.'.'.$archivo->getClientOriginalExtension();
				$nombre_archivo=$archivo->storeAs('foto', $nombre);
			}else {
				$nombre='alumno'.$matricula.'.'.$archivo->getClientOriginalExtension();
				$nombre_archivo=$archivo->storeAs('foto', $nombre);
			}
			
		}
		else{
			$nombre_archivo='';
		}
			
		switch ($data['tipo']) {
			case 1:
				$maestro=new Maestro();
				$maestro->nombre=$data['nombre'];
				$maestro->idasignatura=$data['idasignatura'];
				$maestro->matricula=$matricula;
				$maestro->idusuario=$usuario->idusuario;
				$maestro->foto=$nombre_archivo;
				$maestro->save();
				return 'Hemos agregado con exito a un Maestro! Su usuario es: '.$usuario->email.' y su clave: '.$password;
				break;
			case 2:
				$alumno=new Alumno();
				$alumno->nombre=$data['nombre'];
				$alumno->idsalon=$data['idsalon'];
				$alumno->matricula=$matricula;
				$alumno->idsalon=$data['idsalon'];
				$alumno->foto=$nombre_archivo;
				$alumno->idusuario=$usuario->idusuario;
				$alumno->save();
				return 'Hemos agregado con exito a un Alumno! Su usuario es: '.$usuario->email.' y su clave: '.$password;
				break;
			case 3:
				$validar=Asignatura::all();
				foreach ($validar as $valida) {
					if ($valida->nombre==$data['nombre']) {
						return 'ERROR, la materia ya esta registrada.';
					}
				}
				$asignatura=new Asignatura();
				$asignatura->nombre=$data['nombre'];
				$asignatura->save();
				return 'Hemos agregado con exito una Materia!';
				break;
			case 4:
				$validar=Salon::all();
				foreach ($validar as $valida) {
					if ($valida->nombre==$data['nombre']) {
						return 'ERROR, ya existe un salon con ese nombre.';
					}
				}
				$salon=new Salon();
				$salon->nombre=$data['nombre'];
				$salon->save();
				return 'Hemos agregado con exito un Salon!';
				break;
		}
	}

	public function mostrar_foto($nombre_foto){
		
		$path = storage_path('app/foto/'.$nombre_foto);

		if(!file::exists($path)){
			abort(404);
		}

		$file = File::get($path);
		$type = File::mimeType($path);
		$response = Response::make($file, 200);
		$response -> header("Content-Type", $type);
		return $response;

	}

	public function eliminar(Request $r){
		$data=$r->all();
		if ($data['idtipo']==1) {
			$maestro=Maestro::find($data['idmaestro']);
			$iduser=$maestro->idusuario;
			$usuario=Usuario::find($iduser);
			Storage::delete($maestro->foto);
			$maestro->delete();
			$usuario->delete();
			
		}
		if ($data['idtipo']==2) {
			$alumno=Alumno::find($data['idalumno']);
			$iduser=$alumno->idusuario;
			$usuario=Usuario::find($iduser);
			Storage::delete($alumno->foto);
			$alumno->delete();
			$usuario->delete();
		}
		
		return $this->miescuela($r);
	}

	public function editar(Request $r){
		$data=$r->all();
		if($data['operacion']=='paso2'){
			switch ($data['tipo']) {
				case 1:
					if($r->hasfile('foto')){
						$archivo=$r->file('foto');
						$matricula=$data['matricula'];
						$nombre='maestro'.$matricula.'-'.time().'.'.$archivo->getClientOriginalExtension();
						
						$nombre_archivo=$archivo->storeAs('foto', $nombre);
					}
					else{
						$nombre_archivo='';
					}
					$maestro=Maestro::find($data['ideditar']);
				
					if($nombre_archivo!=''){
						Storage::delete($maestro->foto);
						$maestro->foto=$nombre_archivo;
					}
					$maestro->nombre=$data['nombre'];
					$maestro->idasignatura=$data['idasignatura'];
					if($nombre_archivo!=''){
						$maestro->foto=$nombre_archivo;
					}	
					$maestro->save();
					return $this->miescuela($r);
					break;
				case 2:
					if($r->hasfile('foto')){
						$archivo=$r->file('foto');
						$matricula=$data['matricula'];
						$nombre='alumno'.$matricula.'-'.time().'.'.$archivo->getClientOriginalExtension();
						
						
						$nombre_archivo=$archivo->storeAs('foto', $nombre);
					}
					else{
						$nombre_archivo='';
					}
					$alumno=Alumno::find($data['ideditar']);
				
				
					if($nombre_archivo!=''){
						Storage::delete($alumno->foto);
						$alumno->foto=$nombre_archivo;
					}
					$alumno->nombre=$data['nombre'];
					$alumno->idsalon=$data['idsalon'];
					if($nombre_archivo!=''){
						$alumno->foto=$nombre_archivo;
					}	
					$alumno->save();
					return $this->miescuela($r);
					break;
				case 3:
					$validar=Asignatura::all();
					$bandera=false;
					foreach ($validar as $valida) {
						if ($valida->nombre==$data['nombre']) {
							$bandera=true;
						}
					}
					if (!$bandera) {
						$asignatura=Asignatura::find($data['ideditar']);
						$asignatura->nombre=$data['nombre'];
						$asignatura->save();
					}
					
					return $this->miescuela($r);
					break;
				case 4:
					$validar=Salon::all();
					$bandera=false;
					foreach ($validar as $valida) {
						if ($valida->nombre==$data['nombre']) {
							$bandera=true;
						}
					}
					if (!$bandera) {
						$salon=Salon::find($data['ideditar']);
						$salon->nombre=$data['nombre'];
						$salon->save();
					}
					
					return $this->miescuela($r);
					break;
			}
		}
		if ($data['operacion']=='Editar') {
			$admin=Admin::where('idusuario',auth()->user()->idusuario)->get();
			$rol=Rol::where('idrol',auth()->user()->idrol)->get();
			$asignaturas=Asignatura::all();
			$salones=Salon::all();
			$datos['admin']=$admin;
			$datos['rol']=$rol;
			$datos['asignatura']=$asignaturas;
			$datos['salon']=$salones;
			switch ($data['idtipo']) {
			
				case 1:
					$datos['tipo']=1;
					$maestro=Maestro::find($data['idmaestro']);
					$iduser=$maestro->idusuario;
					$usuario=Usuario::find($iduser);
					$maestro->email=$usuario->email;
					$maestro->ideditar=$maestro->idmaestro;
					$datos['a_editar']=$maestro;
					break;
				case 2:
					$datos['tipo']=2;
					$alumno=Alumno::find($data['idalumno']);
					$iduser=$alumno->idusuario;
					$usuario=Usuario::find($iduser);
					$alumno->email=$usuario->email;
					$alumno->ideditar=$alumno->idalumno;
					$datos['a_editar']=$alumno;
					break;
				case 3:
					$datos['tipo']=3;
					$asignatura=Asignatura::find($data['idasignatura']);
					$asignatura->ideditar=$asignatura->idasignatura;
					$datos['a_editar']=$asignatura;
					break;
				case 4:
					$datos['tipo']=4;
					$salon=Salon::find($data['idsalon']);
					$salon->ideditar=$salon->idsalon;
					$datos['a_editar']=$salon;
					break;
			}
			return view('institucion.editar')->with($datos);
		}

		
		
	}
	public function ver_salon(Request $r){
		$data=$r->all();
		$datos['admin']=Admin::where('idusuario',auth()->user()->idusuario)->get();
		$datos['rol']=Rol::where('idrol',auth()->user()->idrol)->get();
		$alumnos=Alumno::where('idsalon',$data['idsalon'])->get();
		$contador=0;
		foreach ($alumnos as $elemento) {
			$usuario=Usuario::where('idusuario',$elemento->idusuario)->get();
			$elemento->usuario=$usuario[0]->email;
			$elemento->contrasena="User@".$elemento->matricula;
			$salon=Salon::where('idsalon',$elemento->idsalon)->get();
			$elemento->salon=$salon[0]->nombre;
			$alumnos[$contador]=$elemento;
			$contador++;
		}
		$datos['alumno']=$alumnos;

		$materias=Asignatura_salon::where('idsalon',$data['idsalon'])->get();
		$materia=array();
		if (isset($materias)) {
			foreach ($materias as $elemento) {
				$materia[]=Asignatura::find($elemento->idasignatura);
	
			}
		}
		
		foreach ($materia as $elemento) {
			$consulta=DB::table('maestro_salon')
					->join('maestro','maestro.idmaestro','=','maestro_salon.idmaestro')
					->select(
							'idsalon'
							,'maestro.nombre as nombre',
							'maestro.idasignatura',
							'maestro.idmaestro'
							
						)
					->whereRaw("idsalon like '%".$data['idsalon']."%' and maestro.idasignatura like'%".$elemento['idasignatura']."%'")
					->get();
				$elemento->idmaestro=0;
			if (isset($consulta[0])) {
				$elemento->nombremaestro=$consulta[0]->nombre;
				$elemento->idmaestro=$consulta[0]->idmaestro;			
			}
			

		}
		
		


		$datos['asignatura']=$materia;
		$datos['message']='Aqui podras ver los alumnos y materias asignadas a un salon.';
		
		if (isset($data['idasignatura'])) {
			$datos['message']='Hemos modificado las materias del salon.';
		}
		if (isset($data['idmaestroant'])) {
			$datos['message']='Hemos cambiado un maestro de este salon';
		}

		$datos['salon']=Salon::find($data['idsalon']);
		
		return view('institucion.versalon')->with($datos);
	}

	public function asignar_materia(Request $r){
		$data=$r->all();
		$datos['admin']=Admin::where('idusuario',auth()->user()->idusuario)->get();
		$datos['rol']=Rol::where('idrol',auth()->user()->idrol)->get();
		$datos['alumno']=Alumno::where('idsalon',$data['idsalon'])->get();
		$datos['salon']=Salon::find($data['idsalon']);
		$datos['message']='Elige las materias para el '.$datos['salon']->nombre;			
		
		$asig=Asignatura_salon::where('idsalon',$data['idsalon'])->get();
		$materias=Asignatura::all();
		
		for ($i=0; $i < count($materias); $i++) { 
			$bandera=false;
			foreach ($asig as $elemento) {
				if ($elemento->idasignatura==$materias[$i]->idasignatura) {
					$bandera=true;
				}
				$materias[$i]->asignada=$bandera;
			}
		}
		$datos['asignatura']=$materias;
		
		return view('institucion.asignarmateria')->with($datos);
	}

	public function save_asignatura(Request $r){

		$datos=$r->all();
		Asignatura_salon::where('idsalon',$datos['idsalon'])->delete();
		if(isset($datos['idasignatura'])){
			foreach($datos['idasignatura'] as $materiaa){
				$materia=new Asignatura_salon();
				$materia->idasignatura=$materiaa;
				$materia->idsalon=$datos['idsalon'];
				$materia->save();
				
			}
		}
		return $this->ver_salon($r);
	
		
	}

	public function asignar_maestro(Request $r){

		$data=$r->all();
		$datos['admin']=Admin::where('idusuario',auth()->user()->idusuario)->get();
		$datos['rol']=Rol::where('idrol',auth()->user()->idrol)->get();
		$datos['alumno']=Alumno::where('idsalon',$data['idsalon'])->get();
		$datos['salon']=Salon::find($data['idsalon']);
		$datos['materia']=Asignatura::find($data['idasignatura']);
		$datos['message']='Elige el profesor de '.$datos['materia']->nombre.' para el '.$datos['salon']->nombre;			
		
	
		$maestro=Maestro::where('idasignatura',$data['idasignatura'])->get();
		
		
		$datos['maestro']=$maestro;
		$datos['maestroant']=$data['idmaestro'];
		return view('institucion.asignarmaestro')->with($datos);
	}
	
	public function save_maestro(Request $r){

		$datos=$r->all();
		
		if (isset($datos['idmaestroant'])) {
			$consulta=DB::table('maestro_salon')
					->select(
							'idsalon'
							,'idmaestro'
							
						)
					->whereRaw("idsalon like '%".$datos['idsalon']."%' and idmaestro like'%".$datos['idmaestroant']."%'")
					->delete();
		}
		if(isset($datos['idmaestro'])){
		
			$maestro=new Maestro_salon();
			$maestro->idmaestro=$datos['idmaestro'];
			$maestro->idsalon=$datos['idsalon'];
			$maestro->save();
				
			
		}
		return $this->ver_salon($r);
	
		
	}


	public function registrar_periodo(Request $r){
		$data=$r->all();
		$nombre1=explode('-',$data['inicioperiodo']);
		$nombre2=explode('-',$data['finperiodo']);
		$nombre=$nombre1[0].'-'.$nombre1[1].'_'.$nombre2[0].'-'.$nombre2[1];
		$momento=Momento::all();
		foreach ($momento as $elemento) {
			$elemento->estado='Futuro';
			$elemento->save();
		}
		$v_if=If_save::all();
		foreach ($v_if as $elemento) {
			$elemento->delete();
		}
		$periodoant=Periodo::all();
		foreach ($periodoant as $elemento) {
			if ($elemento->estado=='Activo') {
				$elemento->estado='Pasado';
				$elemento->save();
			}
		}
		$periodo=new Periodo();
		$periodo->inicio=$data['inicioperiodo'];
		$periodo->fin=$data['finperiodo'];
		$periodo->nombre=$nombre;
		$periodo->estado='Activo';
		$periodo->save();
		return $this->welcome($r);

	}
	public function registrar_momento(Request $r){
		$data=$r->all();
		$momentos=explode(',',$data['nombresmomentos']);
		for ($i=0; $i < count($momentos) ; $i++) { 
			$variable=Momento::all();
			$bandera=false;
			foreach ($variable as $elemento) {
				if ($elemento->nombre==$momentos[$i]) {
					$bandera=true;
				}
			}
			if (!$bandera) {
				$momento=new Momento();
				$momento->nombre=$momentos[$i];
				$momento->estado='Futuro';
				$momento->save();
			}
			
		}
		return $this->welcome($r);

	}
	public function manipular_momento(Request $r){
		$data=$r->all();
		switch ($data['accion']) {
			case 'Activar':
				$momento=Momento::find($data['idmomento']);
				$momento->estado='Activo';
				$momento->save();
			break;
			case 'Reactivar':
				$m=Momento::where('estado','Activo')->get();
				for ($i=0; $i <count($m) ; $i++) { 
					$m[$i]->estado='Futuro';
					$m[$i]->save();
				}
				
				$momento=Momento::find($data['idmomento']);
				$momento->estado='Activo';
				$momento->save();
			break;
			case 'Finalizar':
				$momento=Momento::find($data['idmomento']);
				$momento->estado='Finalizado';
				$momento->save();
				$mensajes = Mensaje::all();
				foreach ($mensajes as $key) {
					$key->delete();
				}
				$disputas = Disputa::all();
				foreach ($disputas as $key) {
					$key->delete();
				}
			break;
			
		}
		return $this->welcome($r);

	}

	
	







	
	
}