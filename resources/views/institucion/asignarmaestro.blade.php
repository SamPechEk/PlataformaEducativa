@extends('app.Blank')
@section('tittle')
<title >Asignar maestro</title>
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
                <h3 class="card-title">@{{e_interaccion}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div>
                <div  class="row">
                  <div class="col-md-12 col-xs-12 col-sm-12">
                   <h1 class="titulos">Maestros de {{$materia->nombre}}</h1>
                   <form role="form" action="{{action('Institucion\InstitucionController@save_maestro')}}" method="POST">
                      {{csrf_field()}}
                      <input type="hidden" name="idsalon" class="form-control" :value="salon.idsalon">
                      <input type="hidden" name="idasignatura" class="form-control" :value="materia.idasignatura">
                      <input type="hidden" name="idmaestroant" class="form-control" :value="maestroant">
                      
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <div class="form-group">
                                  <label class="titulos">Maestros registrados</label>
                                  <select name="idmaestro" class="form-control titulos" > 
                                    <option class="titulos" v-for="elemento in maestro"  :value="elemento.idmaestro" >@{{elemento.nombre}}</option>  
                                  </select>
                                </div>
                              <button type="submit" class="btn btn-success boton">Asignar</button>
                            </div> 
                          </div>
                        </div>
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
        admin:<?php echo json_encode($admin);?>,
        e_interaccion:'{{$message}}',
        rol:<?php echo json_encode($rol);?>,
        materia:<?php echo json_encode($materia);?>,
        maestro:<?php echo json_encode($maestro);?>,
        salon:<?php echo json_encode($salon);?>,
        maestroant:'{{$maestroant}}'   
      }
      ,methods:{
        
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
  <li class="nav-item has-treeview">
    <a  href="{{action('Institucion\InstitucionController@miescuela')}}" class="nav-link">
      <i class="nav-icon fas fa-edit"></i>
      <p>
      Volver a elementos de mi escuela:
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li>  

@endsection

