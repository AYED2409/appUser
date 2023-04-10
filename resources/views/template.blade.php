<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-fluid bg-dark justify-content-between ">
      <nav class="navbar bg-dark  ">
        <div class="mx-4 d-flex bg-dark ">
          
          <a class="navbar-brand text-light" href="{{url('/')}}">Home</a>
          
          @yield('menu')
          
        </div>
        <div class="dropdown-center px-3">
          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Mi Perfil
          </button>
          <ul class="dropdown-menu">
            @yield('perfil')
            <!--<li><a class="dropdown-item" href="#">Action</a></li>-->
          </ul>
        </div>
      </nav>
      
    </div>
    <div class="container d-flex justify-content-center mt-4">
        <div class="row col-6">
            @yield('contenido')
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    @yield('scripts')
  </body>
</html>
