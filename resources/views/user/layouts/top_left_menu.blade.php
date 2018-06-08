<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav">
    <li><a href="{{ route('admin') }}">Accueil</a></li>
    <li><a href="{{ route('articles') }}">Articles</a></li>
    @if(App\Models\Site::all()!=null)
      <li class='dropdown'>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Sites <b class="caret">{{-- App\Models\Site::all()->count() --}}</b></a>
        <ul class="dropdown-menu">
          @foreach(App\Models\Site::all() as $site)
            <li><a href="{{ route('site',[$site->id_site]) }}">{{ $site->libelle }}</a></li>
          @endforeach
        </ul>
      </li>
    @endif
    <li><a href="{{ route('inventaires') }}">Inventaire</a></li>
  </ul>
</div>
