<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @yield('tittle','aqui va el titulo')
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{asset('public/img/AdminLTELogo.png')}}" type="image/png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('public/darkmode/styles.css')}}"> 
  <link rel="stylesheet" href="{{asset('public/blank/styles.css')}}"> 
  <link rel="stylesheet" href="{{asset('public/blank/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/blank/bootstrap.css')}}">  
   
  <!-- Ionicons -->
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('public/blank/adminlte.min.css')}}"> 
  <!-- Google Font: Source Sans Pro -->
</head>
<body id="body" class="hold-transition layout-top-nav">

  <!-- solo se muestra si el usuario a iniciado sesion--><!-- solo se muestra si el usuario a iniciado sesion--><!-- solo se muestra si el usuario a iniciado sesion--><!-- solo se muestra si el usuario a iniciado sesion--><!-- solo se muestra si el usuario a iniciado sesion--><!-- solo se muestra si el usuario a iniciado sesion--><!-- solo se muestra si el usuario a iniciado sesion-->

  <div class="wrapper dark" id="app">
    <div  >
      @if(!is_null(auth()->user()))
      <div>
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 dark">
          <!-- Brand Logo -->
          
          <!-- Sidebar -->
          <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                <img src="@yield('foto','aqui va la direccion de la foto del usuario')" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                @yield('usuario','aqui va el nombre email o algo del ususario')
              </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                  with font-awesome or any other icon font library -->
                  @yield('sidebarcontent','aqui va el titulo de la opcion del sidebar')
              </ul>
              
            </nav>
            <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
        </aside>
      </div>


      <!-- paginaaaaaa -->
      <div class="content-wrapper dark">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="letras">@yield('titulopagina','aqui va el titulo otra vez de la pagina jsjs')</h1>
              </div>
            
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          @yield('contenido','aqui va el cuerpo de la pagina')
                
        </section>
        <!-- /.content -->
      </div>
      <!-- paginaaaaaa -->
      @endif
    </div>



    
    <!-- Navbar -->
    <nav class="dark main-header navbar navbar-expand-md navbar-light navbar-white">
      <div class="container">
        <div id="logoo" class="">
          <img src="{{asset('public/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
              style="opacity: .8">
          <span class=" font-weight-light titulos">PlataformaEDU</span>
        </div>
        
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
          
        </div>
        <!-- darkMode -->
        <div class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
          <div class="navbar-brand">
            <button class="interruptor" id="interruptor">
              <span class="span"><img src="{{asset('public/darkmode/sol.png')}}" class="span"></span>
              <span class="span"><img src="{{asset('public/darkmode/luna.png')}}" class="span"></span>
            </button>
            
          </div>
          @if(!is_null(auth()->user()))
          <div class="navbar-brand">
           <form method="POST" action="{{route('logout')}}">
              {{csrf_field()}}
              <button class="btn btn-danger boton">Cerrar sesión </button>
           </form>
            @endif
          </div>
        </div>
      <!-- darkMode -->
      </div>
    </nav>
  </div>
  <!-- /.navbar -->



  <!-- sin sesiion activa-->
  @yield('contenidoopcional','')

  <!-- darkMode -->
  <script src="{{asset('public/vue.js')}}"></script>
  <!-- sin sesiion activa--><!-- sin sesiion activa--><!-- sin sesiion activa--><!-- sin sesiion activa-->
  @yield('codigosopcional','')
  <script src="{{asset('public/darkmode/ambiente.js')}}"></script>
  <!-- darkMode -->
  <!-- jQuery -->
 <script src="{{asset('public/blank/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('public/blank/bootstrap.bundle.min.js')}}"></script>
 <script src="{{asset('public/blank/bootstrap.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('public/blank/adminlte.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('public/blank/demo.js')}}"></script>
</body>
</html>
