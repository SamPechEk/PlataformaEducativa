@extends('app.Blank')

@section('tittle')
<title>Plataform LogIn</title>
@endsection
@section('contenidoopcional')


  
  <div id="epp" class="container">
    <div class="login-logo">
      <b class="titulos">Identificate</b>
    </div>
    <div class="row">
      <div class="col-md-4 col-md-offset-4 ">
        <div class="dark panel panel-default ">
          <div class="panel-heading dark">
            <h1 class="panel-title titulos">Inicia sesion en la plataforma</h1>
          </div>
          <div class="panel-body">
          @if(session()->has('erro'))
          <div class="boton alert alert-danger" role="alert">{{session('erro')}}</div>
          @endif
          {!!$errors->first('error',' <div class="boton alert alert-danger" role="alert">:message</div>')!!}
          <form  class="" action="{{action('Auth\LoginController@login')}}" method="POST">
            {{csrf_field()}}
              <div class="form-group" id="div_inpute">
                <label class="letras" for="email">Email</label>
                <input id="input_email" v-model="input_email" type="email" name="email" class="form-control" placeholder="Ingresa tu email" value="{{old('email')}}">
                <span v-if="estado_datos!=0 && input_email==''" class="help-block">@{{message_email}}</span>
              </div>
              <div class="form-group " id="div_inputp">
                <label class="letras" for="password">Password</label>
                <input id="input_password" v-model="input_password" type="password" name="password" class="form-control " placeholder="Ingresa tu password">
               <span v-if="estado_datos!=0 && input_password==''" class="help-block">@{{message_password}}</span>
              </div>
              <button @click="validar($event)" class="btn btn-primary btn-block boton">Acceder</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('codigosopcional')
 
  <!-- importante no borren esto o n o funcionara jsjs -->
  <script>
  new Vue({
    el:'#epp',
    data:{
      input_email:'',
      input_password:'',
      bandera_pagina:0,
      estado_datos:0,
      message_email:"Porfavor introduce tu correo.",
      message_password:"Porfavor introduce tu password."
    }
    ,methods:{
      validar:function(event) {
              this.estado_datos=1;
              this.bandera_pagina=0;
              if (this.input_email==="") {
                this.bandera_pagina=1;
                var bandera = 0;
                const da = document.getElementById('input_email')
                const de = document.getElementById('div_inpute')
                for (let i = 0; i <= da.classList.length; i++) {
                    if (da.classList[i]=='is-invalid'){
                      bandera =1;
                    }
                  }
                  if (bandera!=1) {
                    da.classList.toggle('is-invalid')
                    de.classList.toggle('has-error')
                  } 
                
              }else{
                var bandera = 0;
                const da = document.getElementById('input_email')
                const de = document.getElementById('div_inpute')
                for (let i = 0; i <= da.classList.length; i++) {
                    if (da.classList[i]=='is-invalid'){
                      bandera =1;
                    }
                  }
                  if (bandera==1) {
                    da.classList.toggle('is-invalid')
                    de.classList.toggle('has-error')
                  } 
              }

              if (this.input_password==="") {
                this.bandera_pagina=1;
                var bandera = 0;
                const da = document.getElementById('input_password')
                const de = document.getElementById('div_inputp')
                for (let i = 0; i <= da.classList.length; i++) {
                    if (da.classList[i]=='is-invalid'){
                      bandera =1;
                    }
                  }
                  if (bandera!=1) {
                    da.classList.toggle('is-invalid')
                    de.classList.toggle('has-error')
                  } 
              }else{
                var bandera = 0;
                const da = document.getElementById('input_password')
                const de = document.getElementById('div_inputp')
                for (let i = 0; i <= da.classList.length; i++) {
                    if (da.classList[i]=='is-invalid'){
                      bandera =1;
                    }
                  }
                  if (bandera==1) {
                    da.classList.toggle('is-invalid')
                    de.classList.toggle('has-error')
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
