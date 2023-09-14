@extends('app.Blank')
@section('tittle')
<title >Editar elemento</title>
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
Vamos a editar a {{$a_editar->nombre}}
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
               
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form v-if="tipo!=0" enctype="multipart/form-data" role="form" action="{{action('Institucion\InstitucionController@editar')}}" method="POST">
                {{csrf_field()}}
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1" class="titulos">Nombre</label>
                    <input name="tipo" type="hidden" class="form-control" :value="tipo">
                    <input name="operacion" type="hidden" class="form-control" value="paso2">
                    <input name="ideditar" type="hidden" class="form-control" :value="input_ideditar">
                    <input type="hidden" name="matricula" class="form-control" :value="input_matricula">
                    <input id="input_nombre" v-model="input_nombre" name="nombre" type="text" class="form-control"  placeholder="Inserte el nombre.">
                  </div>
                  <div v-if="tipo==1 || tipo==2 " class="form-group">
                    <label for="exampleInputEmail1" class="titulos">Email</label>
                    <input id="input_email" disabled=""  name="email" v-model="input_email" type="email" class="form-control"  placeholder="Inserte el email sera para iniciar sesion.">
                  </div>
                  <div v-if="tipo==2" class="form-group">
                    <label class="titulos">Salon del alumno</label>
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
                    <input  type="text" class="form-control" disabled=""  placeholder="El password no se puede editar, pero puedes consultarlo luego.">
                  </div>
                  <div  v-if="tipo==1 || tipo==2 " class="form-group">
                    <label for="exampleInputPassword1" class="titulos">Matricula</label>
                    <input  type="text" name="matricula" class="form-control" disabled=""  :value="input_matricula">
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

                    favor de colocar el archivo o hacer click <label class="form-label" id="carga_file" for="foto"><strong> Aqui</strong></label>
                    </div>
                    <div v-show="nombre_archivo!=''">
                      <span class="letras">@{{nombre_archivo}}</span><a class="boton" @click="remove" href="#">Quitar</a>
                    </div>
                  </div>
                  
                  
                  <button type="submit" @click="validar($event)" class="btn btn-primary boton">Modificar</button>
                  <img :src="url" width="100" alt="" class="img-circle elevation-2">
                <!-- /.card-body -->

                <div class="card-footer">
                  
                </div>
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
 
  <script src="{{asset('public/blank/collapsetogle.js')}}"></script>
  <!-- importante no borren esto o n o funcionara jsjs -->
  <script>
    new Vue({
      el:'#app',
      data:{
        a_editar:<?php echo json_encode($a_editar);?>,
        tipos_permitidos:['image/png','image/jpeg', 'image/jpg']
        ,url:"{{URL::to('/')}}/{{$a_editar->foto}}"
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
        tipo:{{$tipo}},
        input_nombre:'{{$a_editar->nombre}}',
        input_email:'{{$a_editar->email}}',
        input_ideditar:'{{$a_editar->ideditar}}',
        input_asignatura:'{{$a_editar->idasignatura}}',
        input_salon:'{{$a_editar->idsalon}}',
        input_matricula:'{{$a_editar->matricula}}',
        asignaturas:<?php echo json_encode($asignatura);?>,
        salones:<?php echo json_encode($salon);?>
        
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
								
							if (this.bandera_pagina==1) {
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

  <li class="nav-item has-treeview">
    <a href="{{action('Institucion\InstitucionController@miescuela')}}" class="nav-link">
      <i class="nav-icon fas fa-edit"></i>
      <p>
        Volver a los elementos de mi escuela
      <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    
  </li>  

@endsection

