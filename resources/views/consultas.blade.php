<?php $bodyid = 'pagemyconsults'; ?>

@extends('base-internal')

@section('content')
    <h1 class="page-header">Minhas Consultas</h1>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>CNPJ</th>
                    <th>Data Consulta</th>
                    <th>Data Atualização</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($consultas) && count($consultas) > 0)
                    @foreach ($consultas as $i=>$consulta)
                    <tr>
                        <td>{{ ($i+1) }}</td>
                        <td>{{ $consulta->cnpj }}</td>
                        <td>{{ $consulta->created_at }}</td>
                        <td>{{ $consulta->updated_at }}</td>
                        <td>
                            <a href="{{ url('/ver-consulta/' . $consulta->id) }}" title="Visualizar"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;
                            <a href="{{ url('/remover-consulta/' . $consulta->id) }}" title="Remover"><i class="glyphicon glyphicon-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <script>
    $(document).ready(function(){
        $('a[title="Remover"]').click(function(e){
            e.preventDefault();
            var btn = $(this);
            $.ajax({
                method: 'DELETE',
                url: btn.attr('href'),
                data: '_token=' + $('input[type="hidden"][name="_token"]').val(),
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(msg) {
                    btn.parents('tr').remove();
                    alert(msg.message);
                },
                error: function(msg){
                    alert(JSON.parse(msg.responseText).message);
                },
                complete: function() {
                }
            });
        });
    });
    </script>
@endsection
