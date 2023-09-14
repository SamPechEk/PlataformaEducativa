@extends('app.Blank')
@section('tittle')
<title >welcome</title>
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
                    <h3 v-if="!bandera_interaccion" class="card-title">@{{e_interaccion}}</h3>
                    <h3 v-if="bandera_interaccion" class="card-title">@{{e_interaccion}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">

              <div class="card card-prirary cardutline direct-chat direct-chat-primary">
                    <div class="card-header">
                        <h3 class="card-title">Escribe el motivo de tu reclamo</h3>
                    </div>
                    <!-- /.card-header -->
                    
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <form action="{{action('Alumno\AlumnoController@send')}}" method="post">
                        <div class="input-group">
                        {{csrf_field()}}
                            <input id="input_" v-model="input_" type="text" name="mensaje" placeholder="Type Message ..." class="form-control">
                            <input type="hidden" name="para" :value="para.idusuario">
                            <input type="hidden" name="de" :value="admin[0].idusuario">
                            <input type="hidden" name="idcalificasion" :value="cali">
                            <span class="input-group-append">
                            <button @click="validar($event)" type="submit" class="btn btn-primary form-control">Enviar</button>
                            </span>
                        </div>
                        </form>
                    </div>
                    <!-- /.card-footer-->
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
        para:<?php echo json_encode($para);?>,
        cali:'{{$cali}}'
      }
      ,methods:{
        validar:function(event) {
            this.bandera_pagina=0;
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
            		
            if (this.bandera_pagina==1) {
                event.preventDefault();
            }else{
                if (!confirm('ENVIAR?')) {
                event.preventDefault();
              }
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
<!-- aQUI PODRAN PONER LAS OPCIONES DEL SIDEBAR SI NESESITAN MAS DE UNA YA SABEN UN FOREACH O VFOR PARA IR CREANDOLAS o solamente copian y pegan segun lo nesesiten --> 
    

  <li class="nav-item has-treeview">
    <a href="{{action('Alumno\AlumnoController@welcome')}}" class="nav-link">
      <i class="nav-icon fas fa-edit"></i>
      <p>
        Ver mis calificaciones:
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li> 

  

@endsection