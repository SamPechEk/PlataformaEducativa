@extends('app.Blank')
@section('tittle')
<title >Editar calificación</title>
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
Ten cuidado, @{{admin[0].nombre}}
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
                <form action="{{action('Maestro\MaestroController@save_c')}}" method="POST"> 
                  {{csrf_field()}}
                  <input type="hidden" name="idcalificasion" :value="idcalificasion"> 
                  <input type="hidden" name="operacion" value="edit">
                  <input type="hidden" name="idsalon" :value="idsalon">   
                  <div class="row">
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group" >
                        <label>Calificación </label>
                        <input id="input_valor" v-model="input_valor" type="number" step="0.01" min="5" max="10" name="calificasion" placeholder="'Ingrese la nueva calificasion." class="form-control">
                      </div>
                    </div>
                    <div class="col-sm-9">
                      <div class="form-group">
                        <label>Motivo del cambio</label>
                        <input id="input_motivo" type="text" name='motivo' class="form-control" placeholder="Porque la modificas?" v-model="input_motivo">
                      </div>
                    </div>
                  </div> 
                  <button @click="validar($event)"  type="submit" class="btn btn-danger float-right  btn-lg">Actualizar calificación</button>     
                </form>
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
        url_versalones:"{{action('Maestro\MaestroController@ver_salon')}}",
        input_motivo:'',
        input_valor:'{{$calificasion->valor}}',
        idcalificasion:'{{$calificasion->idcalificasion}}',
        idsalon:'{{$idsalon}}'
      }
      ,methods:{
        validar:function(event) {
            this.bandera_pagina=0;
            if (this.input_valor=="") {
              this.bandera_pagina=1;
              var bandera = 0;
              const da = document.getElementById('input_valor');
              for (let i = 0; i <= da.classList.length; i++) {
                if (da.classList[i]=='is-invalid'){
                    bandera =1;
                }
              }
              if (bandera!=1) {
                da.classList.toggle('is-invalid');
              } 
              
              }else{
                var bandera = 0;
                const da = document.getElementById('input_valor')
                for (let i = 0; i <= da.classList.length; i++) {
                  if (da.classList[i]=='is-invalid'){
                      bandera =1;
                  }
                }
                if (bandera==1) {
                  da.classList.toggle('is-invalid')
                } 
              }
            	

            if (this.input_motivo=="") {
              this.bandera_pagina=1;
              var bandera = 0;
              const da = document.getElementById('input_motivo');
              for (let i = 0; i <= da.classList.length; i++) {
                if (da.classList[i]=='is-invalid'){
                    bandera =1;
                }
              }
              if (bandera!=1) {
                da.classList.toggle('is-invalid');
              } 
              
              }else{
                var bandera = 0;
                const da = document.getElementById('input_motivo')
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
              if (!confirm("Seguro de modificarla, esto sera notificado a tu director.")) {
                event.preventDefault();
              }
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
<!-- aQUI PODRAN PONER LAS OPCIONES DEL SIDEBAR SI NESESITAN MAS DE UNA YA SABEN UN FOREACH O VFOR PARA IR CREANDOLAS o solamente copian y pegan segun lo nesesiten --> 
  

  <li class="nav-item has-treeview">
    <a :href="url_versalones+'?idsalon='+idsalon" class="nav-link">
      <i class="nav-icon fas fa-edit"></i>
      <p>
       Volver al salón 
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li> 



 

@endsection

