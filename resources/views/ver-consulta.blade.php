<?php $bodyid = 'pageviewconsult'; ?>

@extends('base-internal')

@section('content')
    <h1 class="page-header">Consulta {{ $consulta->id }}</h1>

    <ul>
        @foreach ($consulta->resultado_json as $k=>$v)
        <li><strong>{{ $k }}</strong>: {{ $v }}</li>
        @endforeach
    </ul>


@endsection
