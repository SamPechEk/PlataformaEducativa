@extends('app.Blank')
@section('tittle')
<title >Bienvenido administrador</title>
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
              <form v-if="tipo!=0" enctype="multipart/form-data" role="form" action="{{action('Institucion\InstitucionController@welcome')}}" method="POST">
                {{csrf_field()}}
                <div v-if="tipo!=5 && tipo!=6" class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1" class="titulos">Nombre @{{objeto}}</label>
                    <input id="" name="tipo" type="hidden" class="form-control" :value="tipo">
                    <input id="input_nombre" v-model="input_nombre" name="nombre" type="text" class="form-control"  placeholder="Inserte el nombre.">
                  </div>
                  <div v-if="tipo==1 || tipo==2 " class="form-group">
                    <label for="exampleInputEmail1" class="titulos">Email @{{objeto}}</label>
                    <input id="input_email" name="email" v-model="input_email" type="email" class="form-control"  placeholder="Inserte el email será para iniciar sesión.">
                  </div>
                  <div v-if="tipo==2" class="form-group">
                    <label class="titulos">Salón del alumno</label>
                    <select   id="input_salon" v-model="input_salon" name="idsalon" class="form-control titulos"  > 
                    <option class="titulos" v-for="elemento in salones"  :value="elemento.idsalon">@{{elemento.nombre}}</option>  
                    </select>
                  </div>
                  <div v-if="tipo==1" class="form-group">
                    <label class="titulos">Asignatura que imparte</label>
                    <select   id="input_asignatura" v-model="input_asignatura" name="idasignatura" class="form-control titulos" > 
                    <option class="titulos" v-for="elemento in asignaturas"  :value="elemento.idasignatura" >@{{elemento.nombre}}</option>  
                    </select>
                  </div>
                  <div  v-if="tipo==1 || tipo==2 " class="form-group">
                    <label for="exampleInputPassword1" class="titulos">Contraseña</label>
                    <input  type="text" class="form-control" disabled=""  placeholder="El password será generado automaticamente">
                  </div>
                  <div  v-if="tipo==1 || tipo==2 " class="form-group">
                    <label for="exampleInputPassword1" class="titulos">Matricula</label>
                    <input  type="text" class="form-control" disabled=""  placeholder="La matricula será generada automaticamente">
                  </div>
                
                  <div v-if="tipo==1 || tipo==2 " class="form-group">
                    <label class="form-label titulos" for="">Foto</label>
                    <input type="file"
                            name="foto"
                            ref="campo"
                            id="foto" 
                            @change="cambiar"
                            class="form-control">
                    <div id="dropzone"
                        @dragover="sobre($event)"
                        @dragleave="fuera($event)"
                        @drop="drop($event)"
                        class="dark titulos"
                        :class="clase"
                    >

                    Favor de colocar el archivo o hacer click <label class="form-label" id="carga_file" for="foto"><strong> Aquí </strong></label>
                    </div>
                    <div v-show="nombre_archivo!=''">
                      <span class="letras">@{{nombre_archivo}}</span><a class="boton" @click="remove" href="#">Quitar foto</a>
                    </div>
                  </div>
                  
                  
                  <button type="submit" @click="validar($event)" class="btn btn-primary boton">Registrar</button>
                  <img v-if="tipo==1 || tipo==2 " :src="url" width="100" alt="" class="img-circle elevation-2">
                <!-- /.card-body -->

              
              </form>
              
            </div>

            <div  v-if="tipo==5" class="form-group">  
              <form action="{{action('Institucion\InstitucionController@registrar_periodo')}}" method="POST">
                {{csrf_field()}} 

                <div class="form-group">
                  <label class="titulos">Inicio del periodo</label>
                  <vuejs-datepicker 
                  input-class="form-control"
                  :disabled-dates="{to: new Date()}"
                  id="input_inicioperiodo"
                  format="yyyy-MM-dd"
                  :language="lenguaje"
                  v-model="inicioperiodo"
                  NAME="inicioperiodo"

                  ></vuejs-datepicker>
                </div>
                <div class="form-group">
                  <label class="titulos">Fin del periodo</label>
                  <vuejs-datepicker 
                  input-class="form-control"
                  id="input_finperiodo"
                  format="yyyy-MM-dd"
                  clear-button
                  :language="lenguaje"
                  v-model="finperiodo"
                  NAME="finperiodo"
                  ></vuejs-datepicker>
                </div>
                <button type="submit" @click="validar($event)" class="btn btn-primary boton">Registrar</button>
              </form>
            </div>
            <div  v-if="tipo==6" class="form-group">  
              <form action="{{action('Institucion\InstitucionController@registrar_momento')}}" method="POST">
                {{csrf_field()}} 

                <div class="form-group">
                  <label class="titulos">Inicio del periodo</label>
                  <input class="form-control" type="text" v-model="input_momento" name="nombresmomentos" placeholder="Momento 1, Momento 2, Momento 3, Momento 4, Momento x" id="input_momento">
                </div>
               
                <button type="submit" @click="validar($event)" class="btn btn-primary boton">Iniciar periodo</button>
              </form>
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
          body: 'En el campo del texto escribe los momentos de evaluacion que se impartan en tu escuela cada uno separado por una ","(coma) DE PREFERENCIA SIN DEJAR ESPACIO ALGUNO DESPUES DE LAS COMAS Y SIN PUNTO FINAL, antes de enviar la informacion verifica que los datos sean correctos ya que solo se pueden modificar una vez. A continuacion te dejamos un ejemplo de como escribir los datos: Momento 1, Momento 2, Momento 3, Momento 4, Momento x',
          icon: 'fas fa-exclamation-triangle'
        })
      });
    });
  </script>
  
  <script src="{{asset('public/datapicker/vuejs-datepicker.min.js')}}"></script>
  <script src="{{asset('public/datapicker/es.js')}}"></script>
  <script src="{{asset('public/blank/collapsetogle.js')}}"></script>
  <!-- importante no borren esto o n o funcionara jsjs -->
  <script>
    new Vue({
      el:'#app',
      data:{
        tipos_permitidos:['image/png','image/jpeg', 'image/jpg']
        ,url:''
        ,nombre_archivo:''
        ,clase:{
          inactivo:true
          ,conarchivo:false
          ,leave:false
          ,invalido:false
        },
        mensaje:"",
        bandera_pagina:0,
        admin:<?php echo json_encode($admin);?>,
        rol:<?php echo json_encode($rol);?>,
        e_interaccion:'{{$message}}',
        objeto:'',
        bandera_interaccion:false,
        tipo:0,
        input_nombre:'',
        input_email:'',
        input_asignatura:'',
        input_salon:'',
        asignaturas:<?php echo json_encode($asignatura);?>,
        salones:<?php echo json_encode($salon);?>,
        periodo:<?php echo json_encode($periodo);?>,
        momento:<?php echo json_encode($momento);?>,
        
        lenguaje:vdp_translation_es.js,
        inicioperiodo:new Date(),
        finperiodo:'',
        isset:'{{$isset}}',
        input_momento:''
        
      }
      ,methods:{
        remove:function(){
          this.$refs.campo.value='';
          this.nombre_archivo='';
          this.url='';
          this.clase.leave=false;
          this.clase.inactivo=true;
        }
        ,cambiar:function(){
          ultimo=this.$refs.campo.files.length-1;
          if(this.tipos_permitidos.indexOf(this.$refs.campo.files[0].type)!=-1){
            this.nombre_archivo=this.$refs.campo.files[ultimo].name;
            this.url = URL.createObjectURL(this.$refs.campo.files[0]);
            this.clase.leave=true;
            this.clase.invalido=false;
          }
          else{
            this.clase.leave=true;
            this.clase.conarchivo=false;
            this.clase.inactivo=false;
            this.clase.invalido=true;

          }
          
        }
        ,sobre:function(event){
          event.preventDefault();
          this.clase.leave=true;
          this.clase.conarchivo=false;
          this.clase.inactivo=false;
          this.clase.invalido=false;
         
        }
        ,fuera:function(event){
          event.preventDefault();
          this.clase.leave=false;
          this.clase.conarchivo=false;
          this.clase.inactivo=true;
          this.clase.invalido=false;
          
        }
        ,drop:function(event){
          this.$refs.campo.files=event.dataTransfer.files;
          this.clase.leave=false;
          this.clase.conarchivo=true;
          this.clase.inactivo=false;
          this.clase.invalido=false;
          event.preventDefault();
          this.cambiar();
        },
        validar:function(event) {
								this.bandera_pagina=0;
								this.mensaje="";
                if (this.tipo!=5 && this.tipo!=6) {
                  if (this.input_nombre==="") {
                  this.bandera_pagina=1;
                  var bandera = 0;
	                const da = document.getElementById('input_nombre')
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
	                const da = document.getElementById('input_nombre')
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

                if (this.tipo==5) {
                  if (this.inicioperiodo==="") {
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_inicioperiodo')
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
                    const da = document.getElementById('input_inicioperiodo')
                    for (let i = 0; i <= da.classList.length; i++) {
                        if (da.classList[i]=='is-invalid'){
                          bandera =1;
                        }
                      }
                      if (bandera==1) {
                        da.classList.toggle('is-invalid')
                      } 
                  } 

                  if (this.finperiodo==="") {
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_finperiodo')
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
                    const da = document.getElementById('input_finperiodo')
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

                if (this.tipo==1 || this.tipo==2) {
                  if (this.input_email==="") {
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_email')
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
                    const da = document.getElementById('input_email')
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

                if (this.tipo==1) {
                  if (this.input_asignatura==="") {
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_asignatura')
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
                    const da = document.getElementById('input_asignatura')
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

                if (this.tipo==2) {
                  if (this.input_salon==="") {
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_salon')
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
                    const da = document.getElementById('input_salon')
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

                if (this.tipo==6) {
                  if (this.input_momento==="") {
                    this.bandera_pagina=1;
                    var bandera = 0;
                    const da = document.getElementById('input_momento')
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
                    const da = document.getElementById('input_momento')
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
								}else{
                  if(this.tipo==5) {
                    if (!confirm("PORFAVOR LEE CON CUIDADO: Al continuar se dara de alta un nuevo periodo, los alumnos deberan ser reasignados de forma manual a sus respectivos salones y toda calificacion no capturada con anterioridad ya no podra darse de alta, al igual que las ya registradas tampoco podran modificarse. Recuerda que igual deberas dar de alta alos nuevos alumnos.")) {
                        event.preventDefault();
                    }
                  }
                  if(this.tipo==6) {
                    if (!confirm("Estas seguro de que los datos son correctos? Por precaucion revisalos una vez mas de lo contrario tendras que contactar al equipo de soporte para su correccion.")) {
                        event.preventDefault();
                    }
                  }
                }
					},
        validar_act:function(event) {
          if (!confirm("Estas seguro de esta accion, recuerda que las calificasiones estan en juego.")) {
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
              this.objeto="del salón."
            break;
          
            default:
              break;
          }
          
        }
      },
      components:{
        vuejsDatepicker
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
  <li class="nav-item has-treeview menu-open">
    <a  @click="estado_interaccion('No olvides elegir que deseas hacer!',0)" href="#" class="nav-link">
      <i class="nav-icon far fa-plus-square"></i>
      <p>
        Click aqui para agregar
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
          <a href="#"  @click="estado_interaccion('Perfecto, vamos a agregar un Maestro.',1)" class="nav-link">
            <i class="fas fa-user-plus nav-icon"></i>
            <!-- ustedes deciden como cargar las opciones-->
            <p>Maestro</p>
          </a>
      </li>
      <li class="nav-item">
          <a href="#"  @click="estado_interaccion('Perfecto, vamos a agregar un Alumno.',2)" class="nav-link">
            <i class="fas fa-user-plus nav-icon"></i>
            <!-- ustedes deciden como cargar las opciones-->
            <p>Alumno</p>
          </a>
      </li>
      <li class="nav-item">
          <a href="#"  @click="estado_interaccion('Perfecto, vamos a agregar una materia.',3)" class="nav-link">
            <i class="fas fa-book nav-icon"></i>
            <!-- ustedes deciden como cargar las opciones-->
            <p>Materia</p>
          </a>
      </li>
      <li class="nav-item">
          <a href="#"  @click="estado_interaccion('Perfecto, vamos a agregar un salon.',4)" class="nav-link">
            <i class="fas fa-building nav-icon"></i>
            <!-- ustedes deciden como cargar las opciones-->
            <p>Salon</p>
          </a>
      </li>
    </ul>
  </li>  

  <li class="nav-item has-treeview">
    <a href="{{action('Institucion\InstitucionController@miescuela')}}" class="nav-link">
      <i class="nav-icon fas fa-eye"></i>
      <p>
        Ver elementos de mi escuela:
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li> 

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
          <button class="btn btn-success form-control boton" @click="estado_interaccion('A continuacion vamos a dar de alta un nuevo periodo escolar, ten en cuenta que luego de hacer esto deberas reorganizar los alumnos, desechar a los antiguos y registrar a los nuevos para generar sus credenciales de acceso. De igual forma los momentos de evaluacion seran dados de baja y toda calificasion ya registrada no podra modificarse.',5)">Dar de alta un nuevo periodo</button>
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
          <button v-if="!isset" class="btn btn-danger form-control boton toastsDefaultDanger" @click="estado_interaccion('A continuacion vamos a registrar los momentos a evaluar para nuestra escuela, ten en cuenta que esta accion solo pueder ser realizada una vez, es por eso te pedimos que leas con cuidado lo siguiente:',6)">Registrar los momentos a evaluar en nuestra escuela.</button>

          <li v-for="elemento in momento" class="nav-item">
             
              <button class="btn btn-info form-control boton disabled">@{{elemento.nombre}}-><strong>@{{elemento.estado}}</strong></button>
              
             
                <form action="{{action('Institucion\InstitucionController@manipular_momento')}}" method="POST">
                  {{csrf_field()}}
                  <input type="hidden" name="idmomento" :value="elemento.idmomento">
                  <input type="hidden" name="accion" :value="elemento.label">
                  <button @click="validar_act($event)" :class="elemento.class" class="btn form-control boton">@{{elemento.label}}</button>
                </form>
                
              
          </li>

        </ul>
      </li>  



    </ul>
  </li> 

@endsection

