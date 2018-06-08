<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Enregistrement | Lotis Plast</title>
  <link rel="shortcut icon" href="{{ asset('logo.png') }}">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.2 -->
  <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- Font Awesome Icons -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="{{ asset('dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- iCheck -->
  <link href="{{ asset('plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />
  <!-- Toastr -->
  <link href="{{ asset('toastr/toastr.min.css') }}" rel="stylesheet">
  <script src="{{ asset('toastr/less.js') }}"></script>

</head>
<body class="login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Lotis</b>Plast</a>
    </div>
    <div class="login-box-body">
      <p class="login-box-msg">Enregistrement</p>

      <form action="{{ route('submitRegister') }}" method="post">
        @csrf

        <div class="form-group">

          <div class="has-feedback">
            <input type="text" class="form-control" placeholder="Nom" name="nom" value="{{ old('nom') }}" required />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>

          <div class="has-feedback">
            <input type="text" class="form-control" placeholder="Prenom" name="prenom" value="{{ old('prenom') }}"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>

        </div>

        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required />
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Mot de passe" name="password" value="" required />
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Confirmation de mot de passe" name="password2" value="" required />
          <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>

        <div class="row">
          <!--div class="col-xs-8"><div class="checkbox icheck"><label><input type="checkbox"> Remember Me</label></div></div-->
          <div class="col-xs-6 col-xs-offset-3">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Enregistrer</button>
          </div>
        </div>
      </form>

      <a href="{{ route('login') }}" class="text-center">s'authentifier</a>

    </div>
  </div>

  <!-- jQuery 2.1.3 -->
  <script src="{{ asset('plugins/jQuery/jQuery-2.1.3.min.js') }}"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
  <!-- iCheck -->
  <script src="{{ asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
  <script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>

<!--Toastr -->
<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script src="{{ asset('toastr/toastr.init.js') }}"></script>

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

</body>
</html>
