<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Library') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/now-ui-kit.css?v=1.3.0') }}" rel="stylesheet">
    <style type="text/css">
      body { background-color: #ffffff; }
    </style>

    @yield('css')
    
</head>

<body class="index-page sidebar-collapse">
  <nav class="navbar navbar-expand-lg bg-primary fixed-top">
    <div class="container">
      <div class="navbar-translate">
        <a class="navbar-brand" href="{{ route('home') }}">
          <h3 style="margin-bottom: 0">E-Library</h3>
        </a>
        <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar top-bar"></span>
          <span class="navbar-toggler-bar middle-bar"></span>
          <span class="navbar-toggler-bar bottom-bar"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse justify-content-end" id="navigation" data-nav-image="{{ asset('img/blurred-image-1.jpg') }}">
        @if(!Request::is('/'))
        <form class="form-inline mr-auto" method="GET" action="{{ route('documents.search') }}">
          <div class="input-group" style=" margin-bottom: 0;">
            <input class="form-control" id="q" name="q" type="search" placeholder="Search documents" aria-label="Search" style="background-color: #fff;">
            <div class="input-group-append">
              <span class="input-group-text"><i class="now-ui-icons ui-1_zoom-bold"></i></span>
            </div>
          </div>
        </form>
        @endif
        <ul class="navbar-nav">

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{{ route('documents.list') }}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <p>Categories</p>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="{{ route('documents.category', 'publication') }}">Publication</a>
              <a class="dropdown-item" href="{{ route('documents.category', 'raster') }}">Raster</a>
              <a class="dropdown-item" href="{{ route('documents.category', 'vector') }}">Vector</a>
            </div>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{{ route('documents.list') }}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <p>Types</p>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="{{ route('documents.list') }}">All</a>
              <a class="dropdown-item" href="{{ route('documents.list', 'document') }}">Document</a>
              <a class="dropdown-item" href="{{ route('documents.list', 'audio') }}">Audio</a>
              <a class="dropdown-item" href="{{ route('documents.list', 'image') }}">Image</a>
              <a class="dropdown-item" href="{{ route('documents.list', 'module') }}">Module</a>
              <a class="dropdown-item" href="{{ route('documents.list', 'map') }}">Map</a>
              <a class="dropdown-item" href="{{ route('documents.list', 'video') }}">Video</a>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('gallery.index') }}">
              <p>Galleries</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-neutral" href="#">
              <p>Login</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  @yield('content')

  <footer class="footer footer-default fixed-bottom">
    <div class=" container ">
      <div class="copyright" id="copyright">
        &copy;
        <script>
          document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
        </script>, Designed by
        <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by
        <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>. Developed by
        <a href="https://www.piarea.co.id" target="_blank">PI AREA</a>.
      </div>
    </div>
  </footer>

</body>


<div class="modal fade" id="modalspinner" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered modal-default">
    <div class="modal-content" style="color: #fff; border: 3px solid #fff; background-color: #bcbcbc;">
      <div class="modal-body d-flex justify-content-center">
          <span class="spinner-border" role="status" aria-hidden="true"></span>
          <h3 style="margin-bottom: 5px;margin-left: 25px;">Please wait...</h3>
      </div>
    </div>
  </div>
</div>
<div class="modal fade modal-mini modal-info" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-body">
        <input type="hidden" id="modal-success-id"/>
        <p id="body-text">Gallery has been saved successfully</p>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-link btn-neutral btn-success-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-mini modal-danger" id="modalError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p id="body-text-error">Error while saving gallery!</p>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-link btn-neutral" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/now-ui-kit.js') }}"></script>

@yield('js')
