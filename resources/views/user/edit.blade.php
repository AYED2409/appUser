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
<form action="{{url('/home/update')}}" method="POST" class="border">
    @csrf
    @method('put')   
        @if(session('message'))
            <div class="alert alert-success mt-3" role="alert">
                 {{session('message')}}
            </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger mt-3" role="alert">
                 {{session('error')}}
        </div>
        @endif
        
        @error('name')
            <div class="alert alert-danger" role="alert">
                Debe introducir un nombre de Usuario 
            </div>
        @enderror
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Nombre:</label>
            <input type="input" class="form-control" id="name" name="name" value="{{$user->name}}">
        </div>
        
        @error('email')
            <div class="alert alert-danger" role="alert">
                Debe introducir un email 
            </div>
        @enderror
        <div class="mb-3">
            <label for="email" class="form-label">Dirección de Email:</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{$user->email}}">
            
        </div>
        
        
        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        
         @error('passwordActual')
            <div class="alert alert-danger" role="alert">
                Contraseña Actual obligatoria
            </div>
        @enderror
        <div class="mb-3">
            <label for="passwordActual" class="form-label">Contraseña Actual:</label>
            <input type="password" class="form-control" id="passwordActual" name="passwordActual">
        </div>
        
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection