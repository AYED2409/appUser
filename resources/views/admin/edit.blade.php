@extends('template')

@section('menu')
    <a class="navbar-brand text-light" href="{{url('admin')}}">Admin Area</a>
    <a class="navbar-brand text-light" href="{{url('admin/create')}}">Crear</a>
@endsection

@section('perfil')
    <li><a class="dropdown-item" href="{{url('admin/'.$myUser->id)}}">Mis datos</a></li>
    <li><a class="dropdown-item" href="{{url('admin/'.$myUser->id.'/edit')}}">Modificar datos</a></li>
     <li><a class="dropdown-item" href="{{url('salir')}}">Salir</a></li>
@endsection

@section('contenido')
 <h1>Editar Usuario:</h1>
<form action="{{url('admin/'.$user->id)}}" method="POST" class="border">
    @csrf
    @method('put')   
        @if(session('message'))
            <div class="alert alert-success" role="alert">
                 {{session('message')}}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
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
                error en email 
            </div>
        @enderror
        <div class="mb-3">
            <label for="email" class="form-label">Dirección de Email:</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{$user->email}}">
            
        </div>
        
        @error('type')
            <div class="alert alert-danger" role="alert">
                error en el tipo de usuario 
            </div>
        @enderror
        <div class="mb-3">
            <label for="type" class="form-label">Tipo de Usuario:</label>
            <select class="form-select" name="type" id="type" aria-label="Default select example">
                <option value="{{$user->type}}">{{$user->type}}</option>
                @foreach($types as $type)
                    @if($type !== $user->type)
                        <option value="{{$type}}">{{$type}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        
        
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        
        @error('passwordActual')
            <div class="alert alert-danger" role="alert">
                Contraseña de Autorización obligatoria
            </div>
        @enderror
        <div class="mb-3">
            <label for="passwordActual" class="form-label">Contraseña de Autorización:</label>
            <input type="password" class="form-control" id="passwordActual" name="passwordActual">
        </div>
        
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection