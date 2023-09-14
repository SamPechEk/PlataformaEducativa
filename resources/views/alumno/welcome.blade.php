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
                <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                          <th class="titulos" style="width: 70px !important;">Asignatura </th>
                          <th  v-if="isset_m" v-for="momento in momentos" :style="momento.style" class="titulos" >@{{momento.nombre}} <br><strong class="letras">@{{momento.estado}}</strong></th>
                                
                      </tr>
                    </thead>
                
                    <tbody>
                      <tr rol="row" class="" v-for="elemento in data">
                        <td class="titulos">
                          <strong class="letras">@{{elemento.nombre}} </strong>
                        </td>
                        
                      
                        <td v-for="momento in elemento.calificaciones" class="titulos" >
                          <div v-if="momento.isset">
                            Calificación: @{{momento.valor}} 
                              <br>Detalle: @{{momento.nota}} <br>
                              <div v-if="momento.disputa"><a v-if="momento.editar" href="{{action('Alumno\AlumnoController@ver_chats')}}" class="letras">Has abierto una discusion, siguela en tus mensajes.</a></div>
                              <div v-if="!momento.disputa">
                              <a v-if="momento.editar" :href="url_disputa+'?idcalificasion='+momento.idcalificasion" class="letras">Inconforme con tu calificación?</a>
                              </div>
                              
                          </div>
                          <div v-if="!momento.isset">
                            Aun no tenemos esta calificacion :C
                          </div>

                        </td>
                      </tr>
                    </tbody>
                  </table> 
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
        data:<?php echo json_encode($data);?>,
        momentos:<?php echo json_encode($momento);?>,
        e_interaccion:'{{$message}}',
        objeto:'',
        bandera_interaccion:false,
        tipo:0,
        input_:'',
        isset_m:'{{$isset_m}}',
        url_disputa:'{{action('Alumno\AlumnoController@disputa')}}',
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
<!-- aQUI PODRAN PONER LAS OPCIONES DEL SIDEBAR SI NESESITAN MAS DE UNA YA SABEN UN FOREACH O VFOR PARA IR CREANDOLAS o solamente copian y pegan segun lo nesesiten --> 
 
  <li class="nav-item has-treeview">
    <a  href="{{action('Alumno\AlumnoController@ver_chats')}}" class="nav-link">
      <i class="nav-icon fas fa-envelope"></i>
      <p>
     Mensajes<span v-if="ism" data-toggle="tooltip" title="3 New Messages" class="badge bg-success">Hay nuevos mensajes</span>
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li>  

@endsection

