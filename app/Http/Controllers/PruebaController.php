<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\Personal;
use App\Model\Socio;
use App\Model\Tiposocio;
use App\Model\Servicio;
use App\Model\Sucursal;
use App\Model\Tiposervicio;
use Faker\Factory as Faker;


class PruebaController extends Controller{

	public function prueba(){
		switch (auth()->user()->idrol) {
			case 2:
				dd('bievenido maestro');
			break;
			
			case 3:
				dd('bievenido alumno');
				break;
		}
		
		

	}






	
	public function Personal(){
		$faker = Faker::create();
		$sucursales=Sucursal::all();
		for($i=1;$i<=50;$i++){
			$personal=new Personal();
			$personal->nombre=$faker->name.''.$faker->lastname;
			$personal->curp=$faker->regexify('([A-Z]){10}');
			$personal->foto='';
			$personal->idsucursal=$sucursales->random()->idsucursal;
			$personal->save();
		}

	}

	public function socio(){
		$faker = Faker::create();
		$Tiposocio=Tiposocio::all();
		for($i=1;$i<=50;$i++){
			$socio=new Socio();
			$socio->nombre=$faker->name.''.$faker->lastname;
			$socio->idtiposocio=$Tiposocio->random()->idtiposocio;
			$socio->save();
		}

	}

	public function servicio(){
		$faker = Faker::create();
		
		$modelos=array('Nissan', 'Gol', 'Ford','Sentra');

		$tipos=Tiposervicio::all();
		$personales=Personal::all();
		$socio=Socio::all();

		
		for($i=1;$i<=50;$i++){
			$tipo=$tipos->random();
			$servicio=new Servicio();

			// $servicio->nombre=$faker->name.''.$faker->lastname;
			$servicio->placa=$faker->regexify('Y([A-Z0-9]){2}-([0-9]){4}');
			$servicio->modelo=$faker->randomElement($modelos);
			$servicio->anio=$faker->numberBetween(2012,2021);
			$servicio->precio=$tipo->precio;
			$servicio->idtiposervicio=$tipo->idtiposervicio;
			$servicio->idpersonal=$personales->random()->idpersonal;
			$servicio->idsocio=$socio->random()->idsocio;
			$servicio->save();
		}
	}
}

 
 
