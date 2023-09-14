@extends('app.Blank')
@section('tittle')
<title >Bienvenido maestro</title>
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
                        <div class="card-body">
                            <div v-for="salon in salones" class=" col-sm-6 col-md-3">
                                <div class="info-box mb-3 dark">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <h2><span class="info-box-text letras">@{{salon.nombre}}</span></h2>
                                        <span class="info-box-number letras">Total de alumnos: @{{salon.total}}</span>
                                    </div>
                                <!-- /.info-box-content -->
                                <a :href="url_versalones+'?idsalon='+salon.idsalon" class="small-box-footer">Ir a este salon <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                                <!-- /.info-box -->
                            </div>
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
        periodo:<?php echo json_encode($periodo);?>,
        momento:<?php echo json_encode($momento);?>,
        isset:'{{$isset}}',
        salones:<?php echo json_encode($salon);?>,
        url_versalones:"{{action('Maestro\MaestroController@ver_salon')}}",
        ism:'{{$issetMsg}}'
      }
      ,methods:{
        validar:function(event) {
            this.bandera_pagina=0;
            if (this.tipo==5) {
                if (this.input_==="") {
                this.bandera_pagina=1;
                var bandera = 0;
                const da = document.getElementById('input_')
                for (let i = 0; i <= da.classList.length; i++) {
                    if (da.classList[i]=='is-invalid'){
                        bandera =1;
                    }
                    }
                    if (bandera!=1) {
                    da.classList.toggle('is-invalid')
                    } 
                
                }else{
                var bandera = 0;
                const da = document.getElementById('input_')
                for (let i = 0; i <= da.classList.length; i++) {
                    if (da.classList[i]=='is-invalid'){
                        bandera =1;
                    }
                    }
                    if (bandera==1) {
                    da.classList.toggle('is-invalid')
                    } 
                } 
            }			
            if (this.bandera_pagina==1) {
                event.preventDefault();
            }
            if (!confirm("Mensaje")) {
                event.preventDefault();
            }
                 
		},
        estado_interaccion:function(accion,tipo) {
          this.bandera_interaccion=true;
          this.e_interaccion=accion;
          this.tipo=tipo;
          switch (tipo) {
            case 1:
              this.objeto="del maestro."
            break;
            case 2:
              this.objeto="del alumno."
            break;
            case 3:
              this.objeto="de la materia."
            break;
            case 4:
              this.objeto="del salon."
            break;
          
            default:
              break;
          }
          
        }
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
    <a  @click="estado_interaccion('No olvides elegir que deseas hacer!',0)" href="#" class="nav-link">
      <i class="nav-icon far fa-calendar-alt"></i>
      <p>
      Eventos
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">

      <li class="nav-item has-treeview">
        <a  @click="estado_interaccion('Regresa a la barra lateral para visualizar los periodos!',0)" href="#" class="nav-link">
          <i class="far fa-flag nav-icon"></i>
          <p>
          Periodo escolar
          <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item" v-for="elemento in periodo">
          <button class="btn btn-info form-control boton disabled">@{{elemento.nombre}}->@{{elemento.estado}}</button>
          </li>
        </ul>
      </li>  



      <li class="nav-item has-treeview">
        <a  @click="estado_interaccion('Regresa a la barra lateral para visualizar los momentos!',0)" href="#" class="nav-link">
          <i class="fas fa-sync-alt nav-icon"></i>
          <p>
          Parciales
          <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li v-for="elemento in momento" class="nav-item">
              <button :class='elemento.class' class="btn form-control boton disabled">@{{elemento.nombre}}-><strong>@{{elemento.estado}}</strong></button>    
          </li>

        </ul>
      </li>  



    </ul>
  </li> 
  
  <li class="nav-item has-treeview">
    <a  href="{{action('Maestro\MaestroController@ver_chats')}}" class="nav-link">
      <i class="nav-icon fas fa-envelope"></i>
      <p>
     Mensajes<span v-if="ism" data-toggle="tooltip" title="3 New Messages" class="badge bg-success">Hay nuevos mensajes</span>
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li>  

@endsection

