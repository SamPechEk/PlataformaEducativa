@extends('app.Blank')
@section('tittle')
<title >{{$salon->nombre}}</title>
@endsection
@section('estilos')
<link rel="stylesheet" href="{{asset('public/institucion/styles.css')}}"> 
<style>
  .dark .card-primary:not(.card-outline) > .card-header {
    background-color: #343a40 !important;
}
  
</style>
@endsection
@section('titulopagina')
Bienvenido @{{admin[0].nombre}}
@endsection
@section('contenido')
    <!-- esto lo pueden borrar y remplazar por lo que bayan a usar-->
    <section class="content">
      <div class="container-fluid">
        <div class="row dark">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary dark">
              <div class="card-header">
                <h3 class="card-title">@{{e_interaccion}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div >
                <div  class="row">
                  <div class="col-md-12 col-xs-12 col-sm-12">
                    <h1 class="titulos">Alumnos del @{{salon.nombre}}</h1>
                    <form action="{{action('Maestro\MaestroController@save_c')}}" method="POST"> 
                     {{csrf_field()}}
                     <input type="hidden" name="idsalon" :value="salon.idsalon">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                                <th class="titulos" style="width: 70px !important;">Nombre </th>
                                <th  v-if="ifm" v-for="momento in momentos" :style="momento.style" class="titulos" >@{{momento.nombre}} <br><strong class="letras">@{{momento.estado}}</strong></th>
                                      
                            </tr>
                          </thead>
                      
                          <tbody>
                            <tr rol="row" class="" v-for="elemento in alumnos">
                              <td class="titulos">
                                <strong class="letras">@{{elemento.nombre}} </strong>
                                <br><img :src="'{{URL::to('/')}}/'+elemento.foto" width="35" class="img-circle elevation-2" alt="User Image"> 
                                <br>@{{elemento.matricula}}
                              </td>
                              
                            
                              <td v-if="ifm" v-for="momento in momentos" class="titulos" >
                                <div  v-if="momento.estado=='Finalizado'"> 
                                  <div v-if="momento.vif">Calificación: @{{momento.calificasion[elemento.i].valor}} 
                                        <br>Detalle: @{{momento.calificasion[elemento.i].nota}}
                                  </div>
                                  <div v-if="!momento.vif">
                                    Al parecer no registraste esta calificación :c
                                  </div>
                                </div>
                                <div  v-if="momento.some">
                                  <div  v-if="momento.vif">
                                        Calificación : @{{momento.calificasion[elemento.i].valor}} 
                                    <br>Detalle: @{{momento.calificasion[elemento.i].nota}} <br>
                                    <a :href="url_edit+'?idsalon='+salon.idsalon+'&idcalificasion='+momento.calificasion[elemento.i].idcalificasion" class="letras">EDITAR</a>
                                  </div>
                                  <div v-if="!momento.vif" class="row">
                                    <div class="col-sm-3">
                                      <!-- text input -->
                                      <div class="form-group">
                                        <label>Calificación </label>
                                        <input type="number" step="0.01" min="5" max="10" name="calificasion[]" :placeholder="'Ingrese la calificasion de: '+elemento.nombre" class="form-control">
                                      </div>
                                    </div>
                                    <div class="col-sm-9">
                                      <div class="form-group">
                                        <label>Observacion</label>
                                        <input type="text" name='observacion[]' class="form-control" placeholder="Alguna observacion de la calificasion?" value="Ninguno" >
                                      </div>
                                    </div>
                                  </div>
                                </div>

                              </td>
                            </tr>
                          </tbody>
                      
                        </table> 
                        <div v-if="boton">
                          <button @click="acept($event)"  type="submit" class="btn btn-danger float-right  btn-lg">Publicar calificaciones</button>
                        </div>     
                    </form>
                  </div>
                </div>
              </div>
          </div>

        </div>  
      </div>  
    </section>


    
    
    

    <!-- esto lo pueden borrar y remplazar por lo que bayan a usar-->

  <!-- importante no borren esto o n o funcionara jsjs -->
  
@endsection
@section('codigosopcional')
 
  <script src="{{asset('public/blank/collapsetogle.js')}}"></script>
  <!-- importante no borren esto o n o funcionara jsjs -->
  <script>
    new Vue({
      el:'#app',
      data:{
        bandera_pagina:0,
        admin:<?php echo json_encode($admin);?>,
        e_interaccion:'{{$message}}',
        objeto:'',
        bandera_interaccion:false,
        tipo:0,
        rol:<?php echo json_encode($rol);?>,
        alumnos:<?php echo json_encode($alumno);?> ,
        salon:<?php echo json_encode($salon);?>,
        momentos:<?php echo json_encode($momento);?>,
        calificasiones:<?php echo json_encode($calificasion);?>,
        ifm:'{{$ifm}}',
        some:'{{$some}}',
        vif:'{{$vif}}',
        boton:'{{$boton}}',
        url_edit:"{{action('Maestro\MaestroController@editar')}}"
      }
      ,methods:{
        estado_interaccion:function(accion,tipo) {
          this.bandera_interaccion=true;
          this.e_interaccion=accion;
          this.tipo=tipo;
          
        },
        acept:function(event) {
          conf=confirm("Porfavor revisa que todas las calificaciones esten capturadas, si estas seguro que es asi, vamos a guardarlas.");
          if (conf) {
            if (!confirm("¿Estas seguro?, Las calificaciones se guardaran de forma definitiva y luego editarlas no sera tan facil.")) {
              event.preventDefault();
            }
            
          }else{
            event.preventDefault();
          }
         
        }
      }
    });
</script>
@endsection

@section('usuario')
<strong><a href="#" class="d-block">@{{rol[0].nombre}}</a></strong>
<a href="#" class="d-block">{{auth()->user()->email}}</a>
@endsection
@section('foto')
{{URL::to('/')}}/{{$admin[0]->foto}}
@endsection


@section('sidebarcontent')
 <!-- IMPORTANTEEEEEEEEEEE -->
<!-- aQUI PODRAN PONER LAS OPCIONES DEL SIDEBAR SI NESESITAN MAS DE UNA YA SABEN UN FOREACH O VFOR PARA IR CREANDOLAS o solamente copian y pegan segun lo nesesiten --> 
   

  <li class="nav-item has-treeview">  
    <a href="{{action('Maestro\MaestroController@welcome')}}" class="nav-link">
      <i class="nav-icon far fa-plus-square"></i>
      <p>
     Volver a mis salones
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li>  
  <li class="nav-item has-treeview">
    <a  href="{{action('Maestro\MaestroController@ver_chats')}}" class="nav-link">
      <i class="nav-icon fas fa-envelope"></i>
      <p>
     Mensajes
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li>  

@endsection

