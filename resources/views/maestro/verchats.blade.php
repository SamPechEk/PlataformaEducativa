@extends('app.Blank')
@section('tittle')
<title >Disputas de calificaciones</title>
@endsection
@section('estilos')
<link rel="stylesheet" href="{{asset('public/institucion/styles.css')}}"> 
<link rel="stylesheet" href="{{asset('public/toastr/toastr.min.css')}}"> 

<style>
  .dark .card-primary:not(.card-outline) > .card-header {
    background-color: #343a40 !important;
}
  
</style>
@endsection
@section('titulopagina')
A chatear, @{{admin[0].nombre}}
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
                        
                        <div v-for="disput in disputa" class="col-md-3 col-sm-6 col-12">
                        <a :href="url_ver+'?iddisputa='+disput.iddisputa">
                          <div class="info-box">
                            <span class="info-box-icon" :class="disput.class"><i class="far fa-envelope"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Con: @{{disput.alumno}}</span>
                              <span class="info-box-number">Salón :  @{{disput.salon}}</span>
                              <span class="info-box-number">Calificación:  @{{disput.calificasion}}</span>
                              <span class="info-box-number" v-if="disput.class=='bg-danger'"><strong>HAY NUEVOS MENSAJES</strong></span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                          </a>
                        </div> 
                        
                    </div>
                </div>
            </div>
        </div>
    </section">
    
    

    <!-- esto lo pueden borrar y remplazar por lo que bayan a usar-->

  <!-- importante no borren esto o n o funcionara jsjs -->
  
@endsection
@section('codigosopcional')
  <script src="{{asset('public/blank/jquery.min.js')}}"></script>
  <script src="{{asset('public/toastr/toastr.min.js')}}"></script>
  <script src="{{asset('public/sweetalert2/sweetalert2.min.js')}}"></script>
  <script type="text/javascript">
    $(function() {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      $('.toastsDefaultDanger').click(function() {
        $(document).Toasts('create', {
          class: 'bg-danger', 
          title: 'Pasos para agregar los momentos:',
          subtitle: 'Lee con atencion',
          body: 'MENSAJE',
          icon: 'fas fa-exclamation-triangle'
        })
      });
    });
  </script>
  
  <script src="{{asset('public/blank/collapsetogle.js')}}"></script>
  <!-- importante no borren esto o n o funcionara jsjs -->
  <script>
    new Vue({
      el:'#app',
      data:{
        bandera_pagina:0,
        admin:<?php echo json_encode($admin);?>,
        rol:<?php echo json_encode($rol);?>,
        e_interaccion:'{{$message}}',
        objeto:'',
        bandera_interaccion:false,
        tipo:0,
        input_:'',
        disputa:<?php echo json_encode($disputas);?>,
        momento:<?php echo json_encode($momento);?>,
        url_ver:"{{action('Maestro\MaestroController@ver_msg')}}",
      }
      ,methods:{
        
      },
      components:{
        
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
<!-- aQUI PODRAN PONER LAS OPCIONES DEL SIDEBAR SI NESESITAN MAS DE UNA YA SABEN UN FOREACH O VFOR PARA IR CREANDOLAS o solamente copian y pegan segun lo nesesiten    

  <li class="nav-item has-treeview">
    <a href="{{action('Institucion\InstitucionController@miescuela')}}" class="nav-link">
      <i class="nav-icon fas fa-edit"></i>
      <p>
        Ver elementos de mi escuela:
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li> 
-->
  
  
  <li class="nav-item has-treeview">
    <a  href="{{action('Maestro\MaestroController@welcome')}}" class="nav-link">
      <i class="nav-icon fas fa-flag"></i>
      <p>
     Volver a mis salones
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li>  

@endsection

