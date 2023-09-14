@extends('app.Blank')
@section('tittle')
<title >Mi escuela</title>
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
Hola, @{{admin[0].nombre}}
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
                <h3 v-if="!bandera_interaccion" class="card-title">@{{e_interaccion}}</h3>
                <h3 v-if="bandera_interaccion" class="card-title">@{{e_interaccion}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div v-if="tipo!=0">
                <div v-if="tipo==1" class="row">
                  <div class="col-md-12 col-xs-12 col-sm-12">
                   <h1 class="titulos">Maestros</h1>
                    <table class="table">
                      <tr>
                        <th class="titulos">Nombre</th>
                        <th class="titulos">Matricula</th>
                        <th class="titulos">Asignatura</th>
                        <th class="titulos">Usuario</th>
                        <th class="titulos">Contraseña</th>
                        <th class="titulos">Foto</th>
                        <th></th>
                        <th></th>
                        
                      </tr>
                      <tr v-for="elemento in maestros">
                        <td class="titulos">@{{elemento.nombre}}</td>
                        <td class="titulos">@{{elemento.matricula}}</td>
                        <td class="titulos">@{{elemento.asignatura}}</td>
                        <td class="titulos">@{{elemento.usuario}}</td>
                        <td class="titulos">@{{elemento.contrasena}}</td>
                        <td>
                          <img :src="'{{URL::to('/')}}/'+elemento.foto" width="35" class="img-circle elevation-2" alt="User Image">
                        </td>
                       <td>
                        <form v-if="elemento.delete" action="{{action('Institucion\InstitucionController@eliminar')}}" method="POST">
                              {{csrf_field()}}
                              <input type="hidden" name="idmaestro" :value="elemento.idmaestro">
                              <input type="hidden" name="idtipo" :value="tipo">
                              <input @click="confirmar_eliminar($event)" type="submit" class="btn btn-danger boton" name="operacion" value="eliminar">
                          </form>
                        </td>
                        <td>
                          <form action="{{action('Institucion\InstitucionController@editar')}}" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" name="idmaestro" :value="elemento.idmaestro">
                                <input type="hidden" name="idtipo" :value="tipo">

                                <input type="submit" class="btn btn-success boton" name="operacion" value="Editar">
                            </form>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>

                <div v-if="tipo==2" class="row">
                  <div class="col-md-12 col-xs-12 col-sm-12">
                   <h1 class="titulos">Alumnos</h1>
                    <table class="table">
                      <tr>
                        <th class="titulos">Nombre</th>
                        <th class="titulos">Matricula</th>
                        <th class="titulos">Salón</th>
                        <th class="titulos">Usuario</th>
                        <th class="titulos">Contraseña</th>
                        <th class="titulos">Foto</th>
                        <th class="titulos"></th>
                        <th></th>
                        
                      </tr>
                      <tr v-for="elemento in alumnos">
                        <td class="titulos">@{{elemento.nombre}}</td>
                        <td class="titulos">@{{elemento.matricula}}</td>
                        <td class="titulos">@{{elemento.salon}}</td>
                        <td class="titulos">@{{elemento.usuario}}</td>
                        <td class="titulos">@{{elemento.contrasena}}</td>
                        <td>
                          <img :src="'{{URL::to('/')}}/'+elemento.foto" width="35" class="img-circle elevation-2" alt="User Image">
                        </td>
                        <td>
                          <form v-if="elemento.delete" action="{{action('Institucion\InstitucionController@eliminar')}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="idalumno" :value="elemento.idalumno">
                            <input type="hidden" name="idtipo" :value="tipo">
                            
                            <input @click="confirmar_eliminar($event)" type="submit" class="btn btn-danger boton" name="operacion" value="eliminar">
                          </form>
                        </td>
                        <td>
                          <form action="{{action('Institucion\InstitucionController@editar')}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="idalumno" :value="elemento.idalumno">
                            <input type="hidden" name="idtipo" :value="tipo">
                            <input type="submit" class="btn btn-success boton" name="operacion" value="Editar">
                          </form>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                

                <div v-if="tipo==4" class="row">
                  <div class="col-md-12 col-xs-12 col-sm-12">
                   <h1 class="titulos">Salones</h1>
                    <table class="table">
                      <tr>
                        <th class="titulos">Nombre</th>
                        <th class="titulos"></th>
                        <th></th>
                        
                        
                      </tr>
                      <tr v-for="elemento in salones">
                        <td class="titulos">@{{elemento.nombre}}
                        
                          <form action="{{action('Institucion\InstitucionController@ver_salon')}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="idsalon" :value="elemento.idsalon">
                            <input  type="submit" class="btn btn-success boton" name="operacion" value="Ver detalles">

                          </form>
                      
                        </td>
                        <td>
                          <form action="{{action('Institucion\InstitucionController@editar')}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="idsalon" :value="elemento.idsalon">
                            <input type="hidden" name="idtipo" :value="tipo">
                            <input  type="submit" class="btn btn-success boton" name="operacion" value="Editar">

                          </form>
                        </td>
                       
                      </tr>
                    </table>
                  </div>
                </div>

                <div v-if="tipo==3" class="row">
                  <div class="col-md-12 col-xs-12 col-sm-12">
                   <h1 class="titulos">Asignaturas</h1>
                    <table class="table">
                      <tr>
                        <th class="titulos">Nombre</th>
                        <th class="titulos"></th>
                        
                      </tr>
                      <tr v-for="elemento in asignaturas">
                        <td class="titulos">@{{elemento.nombre}}</td>
                        <td>
                          <form action="{{action('Institucion\InstitucionController@editar')}}" method="POST">
                              {{csrf_field()}}
                              <input type="hidden" name="idasignatura" :value="elemento.idasignatura">
                              <input type="hidden" name="idtipo" :value="tipo">
                              <input type="submit" class="btn btn-success boton" name="operacion" value="Editar">

                          </form>
                        </td>
                      </tr>
                    </table>
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
        mensaje:"",
        bandera_pagina:0,
        admin:<?php echo json_encode($admin);?>,
        e_interaccion:'{{$message}}',
        objeto:'',
        bandera_interaccion:false,
        tipo:0,
        rol:<?php echo json_encode($rol);?>,
        asignaturas:<?php echo json_encode($asignatura);?>,
        salones:<?php echo json_encode($salon);?>,
        alumnos:<?php echo json_encode($alumno);?>,
        maestros:<?php echo json_encode($maestro);?>
        
      }
      ,methods:{
        estado_interaccion:function(accion,tipo) {
          this.bandera_interaccion=true;
          this.e_interaccion=accion;
          this.tipo=tipo;
          
        },
        confirmar_eliminar:function(event){
          if (!confirm("¿Estas seguro de eliminar este registro?, Esto ocasionara que se eliminen todos los registros de este elemento.")) {
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
    <a href="{{action('Institucion\InstitucionController@welcome')}}" class="nav-link">
      <i class="nav-icon far fa-plus-square"></i>
      <p>
      Click aqui para agregar
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li>  
  <li class="nav-item has-treeview menu-open">
    <a  @click="estado_interaccion('No olvides elegir un elemento!',0)" href="#" class="nav-link">
      <i class="nav-icon fas fa-eye"></i>
      <p>
      Ver elementos de mi escuela:
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
          <a href="#"  @click="estado_interaccion('Perfecto, estos son los maestros:',1)" class="nav-link">
            <i class="fas fa-users nav-icon"></i>
            <!-- ustedes deciden como cargar las opciones-->
            <p>Maestros</p>
          </a>
      </li>
      <li class="nav-item">
          <a href="#"  @click="estado_interaccion('Perfecto, estos son los alumnos:',2)" class="nav-link">
            <i class="fas fa-users nav-icon"></i>
            <!-- ustedes deciden como cargar las opciones-->
            <p>Alumnos</p>
          </a>
      </li>
      <li class="nav-item">
          <a href="#"  @click="estado_interaccion('Perfecto, estas son las asignaturas:',3)" class="nav-link">
            <i class="fas fa-book nav-icon"></i>
            <!-- ustedes deciden como cargar las opciones-->
            <p>Materias</p>
          </a>
      </li>
      <li class="nav-item">
          <a href="#"  @click="estado_interaccion('Perfecto, estos son los salones:',4)" class="nav-link">
            <i class="fas fa-building nav-icon"></i>
            <!-- ustedes deciden como cargar las opciones-->
            <p>Salones</p>
          </a>
      </li>
    </ul>
  </li>  

@endsection

