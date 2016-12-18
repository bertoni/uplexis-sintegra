<?php $bodyid = 'pagelogin'; ?>

@extends('base')

@section('body')
<div class="container">
    @include('flash-message')

    <form class="form-signin" method="POST" action="{{ url('/autenticar') }}">
        <h2 class="form-signin-heading">Informe seu usuário e senha</h2>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label for="inputUsername" class="sr-only">Usuário</label>
        <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Usuário" required="" autofocus="">

        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Senha" required="">

        <button class="btn btn-lg btn-primary btn-block" type="submit">Logar</button>
    </form>
</div>
@endsection
