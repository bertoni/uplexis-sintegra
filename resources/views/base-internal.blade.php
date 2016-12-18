@extends('base')

@section('body')
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="{{ url('/minhas-consultas') }}">Minhas Consultas</a></li>
                <li><a href="{{ url('/nova-consulta') }}">Nova Consulta</a></li>
                <li><a href="{{ url('/logout') }}">Sair</a></li>
            </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            @include('flash-message')

            @yield('content')
        </div>
    </div>

</div>
@endsection
