<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>{{ $title or 'Gestion de stock' }} | Lotis Plast</title>
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.png') }}">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.2 -->
  <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="{{ asset('dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- AdminLTE Skins. Choose a skin from the css/skins         folder instead of downloading all of them to reduce the load. -->
  <link href="{{ asset('dist/css/skins/skin-purple.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- Toastr -->
  <link href="{{ asset('toastr/toastr.min.css') }}" rel="stylesheet">
  <script src="{{ asset('toastr/less.js') }}"></script>
  <!-- dataTables
  <link href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />-->
  <link href="{{ asset('plugins/datatables2/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

  @yield('styles')
</head>

<body class="skin-purple layout-top-nav">

  <div class="wrapper">

    <header class="main-header">

      <nav class="navbar navbar-static-top">
        <div class="container-fluid">

          <div class="navbar-header">
            <a href="#" class="navbar-brand"><b>Lotis </b>Plast</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="navbar-collapse">

            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Accueil<span class="sr-only">(current)</span></a></li>
              <li><a href="#">Link</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Create <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">addCategorie</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                  <li class="divider"></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-danger">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <ul class="menu">
                      <li><a href="#"><i class="fa fa-users text-aqua"></i> 5 new members joined today</a></li>
                      <li><a href="#"><i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems</a></li>
                      <li><a href="#"><i class="fa fa-users text-red"></i> 5 new members joined</a></li>
                      <li><a href="#"><i class="fa fa-shopping-cart text-green"></i> 25 sales made</a></li>
                      <li><a href="#"><i class="fa fa-user text-red"></i> You changed your username</a></li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </li>

              <li>
                <a data-toggle="modal" data-original-title="Profile" data-placement="bottom" href="#modalUpdateProfile">
                  <i class="fa fa-user-o"  data-toggle="tooltip" data-original-title="Profile" data-placement="bottom" class="btn btn-metis-1 btn-sm"></i>
                </a>
              </li>

              <li>
                <a href="{{ route('logout') }}" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
                  <i class="fa fa-power-off"></i>
                </a>
              </li>
            </ul>

          </div>
        </div>
      </nav>
    </header>


    <div class="content-wrapper">
      <div class="container-fluid">

        <section class="content-header">

          @yield('contentHeader')

        </section>

        <section class="content">

          @yield('content')

        </section>

      </div>

      @yield('modals')


      {{-- *****************************    update Profile   ********************************************** --}}
      <div class="modal fade" id="modalUpdateProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Form update profil --}}
        <form method="POST" action="{{ route('updateProfile') }}">
          @csrf
          <input type="hidden" name="id" value="{{ Session::get('id_user') }}">

          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Profile</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-5">
                    {{-- Nom --}}
                    <div class="form-group has-feedback">
                      <label>Nom</label>
                      <input type="text" class="form-control" placeholder="Nom" name="nom" value="{{ Session::get('nom') }}" required>
                    </div>
                  </div>
                  <div class="col-md-5">
                    {{-- Prenom --}}
                    <div class="form-group has-feedback">
                      <label>Prenom</label>
                      <input type="text" class="form-control" placeholder="Prenom" name="prenom" value="{{ Session::get('prenom') }}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    {{-- Email --}}
                    <div class="form-group has-feedback">
                      <label>Email</label>
                      <input type="text" class="form-control" placeholder="Login" name="login" value="{{ Session::get('email') }}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    {{-- Password --}}
                    <div class="form-group has-feedback">
                      <label>Password</label>
                      <input type="text" class="form-control" placeholder="Password" name="password">
                      <small>laissez vide pour garder votre ancien mot de passe.</small>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Modifier</button>
              </div>

            </div>
          </div>

        </form>
      </div>

    </div>


    <footer class="main-footer">
      <div class="container-fluid">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2018 <a href="mailto: amine.laghlabi@gmail.com">Amine Laghlabi</a>.</strong> All rights reserved.
      </div><!-- /.container -->
    </footer>


  </div><!-- ./wrapper -->

  <!-- jQuery 2.1.3 -->
  <script src="{{ asset('plugins/jQuery/jQuery-2.1.3.min.js') }}"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
  <!-- SlimScroll
  <script src="plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>-->
  <!-- FastClick
  <script src='plugins/fastclick/fastclick.min.js'></script>-->
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/app.min.js') }}" type="text/javascript"></script>
  <!-- AdminLTE for demo purposes
  <script src="dist/js/demo.js" type="text/javascript"></script> -->

  <!--Toastr -->
  <script src="{{ asset('toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('toastr/toastr.init.js') }}"></script>
  <!-- DATA TABES SCRIPT -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>


  <script>
  var options = {
    "closeButton": true, "debug": false, "newestOnTop": true, "progressBar": true, "positionClass": "toast-top-center",
    "preventDuplicates": false, "showDuration": "0", "hideDuration": "1000", "timeOut": "0", "extendedTimeOut": "1000",
    "showEasing": "swing", "hideEasing": "linear", "showMethod": "fadeIn", "hideMethod": "fadeOut"
  };
  {{-- ********************************************************************** --}}
  {{-- alert info --}}
  @if(session('alert_info'))
  toastr.info("{!! session('alert_info') !!}",'', options );
  @elseif(isset($alert_info))
  toastr.info("{!! $alert_info !!}",'', options );
  @endif
  {{-- /.alert info --}}
  {{-- ********************************************************************** --}}
  {{-- alert success --}}
  @if(session('alert_success'))
  toastr.success("{!! session('alert_success') !!}",'', options );
  @elseif(isset($alert_success))
  toastr.success("{!! $alert_success !!}",'', options );
  @endif
  {{-- /.alert success --}}
  {{-- ********************************************************************** --}}
  {{-- alert warning --}}
  @if(session('alert_warning'))
  toastr.warning("{!! session('alert_warning') !!}",'', options );
  @elseif(isset($alert_warning))
  toastr.warning("{!! $alert_warning !!}",'', options );
  @endif
  {{-- /.alert warning --}}
  {{-- ********************************************************************** --}}
  {{-- alert danger --}}
  @if(session('alert_danger'))
  toastr.error("{!! session('alert_danger') !!}",'', options );
  @elseif(isset($alert_danger))
  toastr.error("{!! $alert_danger !!}",'', options );
  @endif
  {{-- /.alert danger --}}
  {{-- ********************************************************************** --}}
</script>

@yield('scripts')
</body>
</html>






{{--

<!-- Toastr -->
<link href="{{ asset('public/css/lib/toastr/toastr.min.css') }}" rel="stylesheet">
<script src="{{ asset('public/assets/less/less.js') }}"></script>



<!--jQuery -->
<script src="{{ asset('public/assets/lib/jquery/jquery.js') }}"></script>
<!--Bootstrap -->
<script src="{{ asset('public/assets/lib/bootstrap/js/bootstrap.js') }}"></script>
<!-- MetisMenu -->
<script src="{{ asset('public/assets/lib/metismenu/metisMenu.js') }}"></script>
<!-- onoffcanvas -->
<script src="{{ asset('public/assets/lib/onoffcanvas/onoffcanvas.js') }}"></script>
<!-- Screenfull -->
<script src="{{ asset('public/assets/lib/screenfull/screenfull.js') }}"></script>
<!-- Metis core scripts -->
<script src="{{ asset('public/assets/js/core.js') }}"></script>
<!-- Metis demo scripts -->
<script src="{{ asset('public/assets/js/app.js') }}"></script>
<!-- switcher -->
<script src="{{ asset('public/assets/js/style-switcher.js') }}"></script>
<!--Toastr -->
<script src="{{ asset('public/js/lib/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('public/js/lib/toastr/toastr.init.js') }}"></script>
<!-- Bootstrap-Select -->
<script src="{{ asset('public/bootstrap-select/bootstrap-select.min.js') }}"></script>

--}}
