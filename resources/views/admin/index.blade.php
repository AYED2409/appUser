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
    @if(session('message'))
            <div class="alert alert-success" role="alert">
                {{session('message')}}
            </div>
    @endif
    <table class="table">
        <thead>
            <th scope="col">#</th>
            <th scope="col">NAME</th>
            <th scope="col">EMAIL</th>
            <th scope="col">TYPE</th>
            <th scope="col">SHOW</th>
            <th scope="col">EDIT</th>
            <th scope="col">DELETE</th>
        </th>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->type}}</td>
                <td>
                    <a class="btn btn-info" href="{{url('admin/'.$user->id)}}">Show</a></button>
                </td>
                <td>
                    <a class="btn btn-warning" href="{{url('admin/'.$user->id.'/edit')}}">Edit</a>
                </td>
                <td>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete"
                    data-name="{{$user->name}}" data-url="{{'admin/'.$user->id}}">
                      Delete
                    </button>
                </td>
            </tr>
        @endforeach
    </table>
    <!-- Modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Delete</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <p>Confirm delete <span id="deleteUser">XXX</span>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <form id="modalDeleteResourceForm" action="" method="post">
                @method('delete')
                @csrf
            <input type="submit" class="btn btn-primary" value="Delete User"/>
        </form>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
<script src="{{ url('assets/js/user-modal-delete.js') }}"></script>
@endsection