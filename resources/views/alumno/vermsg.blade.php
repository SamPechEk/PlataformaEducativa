@extends('app.Blank')
@section('tittle')
<title >Ver mensajes</title>
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
Tranquilo @{{admin[0].nombre}}, nadie vera esto ... o si ...
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
                        <!-- mensajeeeeee -->
                        <div class="col-md-12">
            <!-- DIRECT CHAT WARNING -->
                        <div class="card card-warning direct-chat direct-chat-warning">
                          
                          <!-- /.card-header -->
                          <div  class="card-body">
                            <!-- Conversations are loaded here -->
                            <div  class="direct-chat-messages">
                              <div v-for="msg in mensajes">
                              <div v-if="recibe!=msg.de" class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                  <span class="direct-chat-name float-left">@{{maestro.nombre}}</span>
                                </div>
                                <!-- /.direct-chat-infos -->
                                <img class="direct-chat-img" src="{{URL::to('/')}}/{{$maestro->foto}}" alt="Message User Image">
                                <!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                  @{{msg.mensaje}}
                                </div>
                                <!-- /.direct-chat-text -->
                              </div>
                              <!-- /.direct-chat-msg -->

                              <!-- Message to the right -->
                              <div v-if="recibe==msg.de" class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                  <span class="direct-chat-name float-right">@{{admin[0].nombre}}</span>
                                </div>
                                <!-- /.direct-chat-infos -->
                                <img class="direct-chat-img" src="{{URL::to('/')}}/{{$admin[0]->foto}}" alt="Message User Image">
                                <!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                 @{{msg.mensaje}}
                                </div>
                                <!-- /.direct-chat-text -->
                              </div>
                              </div>
                              <!-- Message. Default to the left -->
                              
                              <!-- /.direct-chat-msg -->
                            </div>
                            <!--/.direct-chat-messages-->

                            <!-- Contacts are loaded here -->
                            
                            <!-- /.direct-chat-pane -->
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                            <form action="{{action('Alumno\AlumnoController@send')}}" method="post">
                              <div class="input-group">
                              {{csrf_field()}}
                                <input type="text" name="mensaje" placeholder="Escribe tu mensaje ..." class="form-control">
                                <input type="hidden" name="iddisputa" value="{{$iddisputa}}">
                                <span class="input-group-append">
                                  <button type="submit" class="btn btn-warning">Enviar</button>
                                </span>
                              </div>
                            </form>
                          </div>
                          <!-- /.card-footer-->
                        </div>
                        <!--/.direct-chat -->
                      </div>
                        
                        
                        <!--mensajeeeee-->
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
        maestro:<?php echo json_encode($maestro);?>,
        rol:<?php echo json_encode($rol);?>,
        e_interaccion:'{{$message}}',
        recibe:'{{$recibe}}',
        objeto:'',
        bandera_interaccion:false,
        tipo:0,
        input_:'',
        mensajes:<?php echo json_encode($mensajes);?>,
        url_ver:"{{action('Alumno\AlumnoController@ver_msg')}}",
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
    <a  href="{{action('Alumno\AlumnoController@ver_chats')}}" class="nav-link">
      <i class="nav-icon fas fa-flag"></i>
      <p>
     Volver a mensajes
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li>  

@endsection

