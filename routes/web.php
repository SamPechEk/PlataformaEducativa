<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 
   

Route::group(['middleware' => 'auth'],function(){
   //login

   Route::post('/logout','Auth\LoginController@logout')->name('logout');
   //login


   Route::group(['middleware' => 'candado2:ADMIN'],function(){

      Route::match(array('GET','POST'),'/institucion','Institucion\InstitucionController@welcome');
      Route::post('/save','Institucion\InstitucionController@save');
      Route::post('/delete','Institucion\InstitucionController@eliminar');
      Route::post('/edit','Institucion\InstitucionController@editar');
      Route::match(array('GET','POST'),'/miescuela','Institucion\InstitucionController@miescuela');
      Route::post('/versalon','Institucion\InstitucionController@ver_salon');
      Route::post('/asignarmateria','Institucion\InstitucionController@asignar_materia');
      Route::post('/saveasignatura','Institucion\InstitucionController@save_asignatura');
      Route::post('/asignarmaestro','Institucion\InstitucionController@asignar_maestro');
      Route::post('/savemaestro','Institucion\InstitucionController@save_maestro');
      Route::post('/registrarperiodo','Institucion\InstitucionController@registrar_periodo');
      Route::post('/registrarmomento','Institucion\InstitucionController@registrar_momento');
      Route::post('/manipularmomento','Institucion\InstitucionController@manipular_momento');
   });  

   Route::group(['middleware' => 'candado2:MAESTRO'],function(){
      Route::match(array('GET','POST'),'/maestro','Maestro\MaestroController@welcome');
      Route::match(array('GET','POST'),'/versalonm','Maestro\MaestroController@ver_salon');
      Route::get('/editarcalificasion','Maestro\MaestroController@editar');
      Route::post('/savecalificasion','Maestro\MaestroController@save_c');
      Route::get('/chatsMaestro','Maestro\MaestroController@ver_chats');
      Route::post('/sendmaestro','Maestro\MaestroController@send');
      Route::match(array('GET','POST'),'/mensajesM','Maestro\MaestroController@ver_msg');

   });

   Route::group(['middleware' => 'candado2:ALUMNO'],function(){
      Route::match(array('GET','POST'),'/alumno','Alumno\AlumnoController@welcome');
      Route::get('/newdisputa','Alumno\AlumnoController@disputa');
      Route::post('/sendalumno','Alumno\AlumnoController@send');
      Route::get('/chatsAlumno','Alumno\AlumnoController@ver_chats');
      Route::match(array('GET','POST'),'/mensajesA','Alumno\AlumnoController@ver_msg');


   });


   //pruebas
   
   //pruebas
   //pruebas
   Route::get('foto/{nombre_foto}','Institucion\InstitucionController@mostrar_foto');
}); 
Route::get('/','Auth\LoginController@formulario')->middleware('guest');
Route::post('/login','Auth\LoginController@login')->name('login')->middleware('guest');   


