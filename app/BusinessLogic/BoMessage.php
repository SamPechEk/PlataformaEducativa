<?php
namespace App\BusinessLogic;
Use App\model\Disputa;
Use App\model\Mensaje;
Use App\model\Alumno;
Use App\model\Maestro;

class BoMessage{
    function crear_disputa($objeto){
       $disputa = new Disputa();
       $disputa->idcalificasion = $objeto->idcalificasion;
       $disputa->idalumno = Alumno::where('idusuario',$objeto->de)->get()[0]->idalumno;
       $disputa->idmaestro = Maestro::where('idusuario',$objeto->para)->get()[0]->idmaestro;
       $disputa->save();
       $objeto->iddisputa = $disputa->iddisputa;
       return $objeto;
    }

    function crear_mensaje($objeto){
        if (isset($objeto->idcalificasion)) {
            $objeto = $this->crear_disputa($objeto);
        }
        $mensaje = new Mensaje();
        $mensaje->iddisputa = $objeto->iddisputa;
        $mensaje->de = $objeto->de;
        $mensaje->para = $objeto->para;
        $mensaje->mensaje = $objeto->mensaje;
        $mensaje->estado = 'NO LEIDO';
        $mensaje->save();
        return $mensaje;
     }

}