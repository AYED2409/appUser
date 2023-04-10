@extends('template')

@section('menu')
    <a class="navbar-brand text-light" href="{{url('advanced')}}">Advanced Area</a>
    <a class="navbar-brand text-light" href="{{url('advanced/create')}}">Crear</a>
    
@endsection

@section('perfil')
    <li><a class="dropdown-item" href="{{url('advanced/'.$myUser->id)}}">Mis datos</a></li>
    <li><a class="dropdown-item" href="{{url('advanced/'.$myUser->id .'/edit')}}">Modificar datos</a></li>
    <li><a class="dropdown-item" href="{{url('salir')}}">Salir</a></li>
@endsection

@section('contenido')
    <h1>Crear Usuario:</h1>
    
            @if(session('message'))
            <div class="alert alert-danger" role="alert">
                {{session('message')}}
            </div>
            @endif
            
        @if(session('error'))
        <div class="alert alert-danger mt-3" role="alert">
                 {{session('error')}}
        </div>
        @endif
            
    <form action="{{url('advanced')}}" method="POST">
        @csrf
        
        @error('name')
            <div class="alert alert-danger" role="alert">
                Debe introducir un nombre de Usuario 
            </div>
        @enderror
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Nombre:</label>
            <input type="input" class="form-control" id="name" name="name" value="{{old('name')}}">
        </div>
        
        @error('email')
            <div class="alert alert-danger" role="alert">
                Campo email es obligatorio y unico
            </div>
        @enderror
        <div class="mb-3">
            <label for="email" class="form-label">Dirección de Email:</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{old('email')}}">
            
        </div>
        
        @error('type')
            <div class="alert alert-danger" role="alert">
                error en el tipo de usuario
            </div>
        @enderror
        
        <div class="mb-3">
            <label for="type" class="form-label">Tipo de Usuario:</label>
            <select class="form-select" name="type" id="type" aria-label="Default select example">
                @foreach($types as $type)
                <option value="{{$type}}">{{$type}}</option>
                @endforeach
            </select>
        </div>
        
        @error('password')
            <div class="alert alert-danger" role="alert">
                debe asignar una contraseña
            </div>
        @enderror
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
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