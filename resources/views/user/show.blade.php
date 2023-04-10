@extends('template')

@section('menu')
    <!--<a class="navbar-brand text-light" href="{{url('home/show')}}">Ver Datos</a>-->
    <!--<a class="navbar-brand text-light" href="{{url('home/edit')}}">Editar Datos</a>-->
    
@endsection

@section('perfil')
    <li><a class="dropdown-item" href="{{url('home/show')}}">Mis datos</a></li>
    <li><a class="dropdown-item" href="{{url('home/edit')}}">Modificar datos</a></li>
@endsection

@section('contenido')
    <div class="card text-bg-light mb-3" style="max-width: 26rem;">
      <div class="card-header card-title"> <h2 class="card-title">Datos de Usuario:</h2></div>
      <div class="card-body">
        <div class="mt-3">
            <h5 class="card-title d-inline">Id: </h5><p class="card-text d-inline">{{$user->id}}</p>
        </div>
        
        <div class="mt-3">
            <h5 class="card-title d-inline">Nombre: </h5><p class="card-text d-inline">{{$user->name}}</p>
        </div>
        
        <div class="mt-3">
            <h5 class="card-title d-inline">Email: </h5><p class="card-text d-inline">{{$user->email}}</p>
        </div>
        
        <div class="mt-3">
            <h5 class="card-title d-inline">Tipo: </h5><p class="card-text d-inline">{{$user->type}}</p>
        </div>
        
      </div>
    </div>
@endsection