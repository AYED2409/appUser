@extends('layouts.app')

@section('nav')
    @if(Auth::user()->type == 'normal')
        <a class="navbar-brand" href="{{ url('/home/show') }}">My section</a>
                
    @elseif(Auth::user()->type == 'advanced')
        <a class="navbar-brand" href="{{ url('/advanced') }}">My section</a>
    @else
        <a class="navbar-brand" href="{{ url('/admin') }}">My section</a>
    @endif
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    @if(!auth()->user()->hasVerifiedEmail())
                    <a href="{{ url('email/verify') }}">Verificar</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
