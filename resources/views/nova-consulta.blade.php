<?php $bodyid = 'pagenewconsult'; ?>

@extends('base-internal')

@section('content')
    <h1 class="page-header">Nova Consulta</h1>

    <form method="POST" action="">
        <h2>Informe o CNPJ a ser consultado</h2>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label for="inputCnpj" class="sr-only">CNPJ</label>
        <input type="text" name="cnpj" id="inputCnpj" class="form-control" placeholder="CPNJ" required="" autofocus="" value="@if (isset($cnpj)){{$cnpj}}@endif">

        <button class="btn btn-lg btn-primary btn-block" type="submit">Pesquisar</button>
    </form>

    @if (isset($consult))

    <ul>
        @foreach ($consult as $k=>$v)
        <li><strong>{{ $k }}</strong>: {{ $v }}</li>
        @endforeach
    </ul>

    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.3/jquery.mask.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#inputCnpj').mask('00.000.000/0000-00');
    });
    </script>

@endsection
