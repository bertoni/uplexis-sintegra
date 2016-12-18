<?php

Route::get('/api/consult/es/{cnpj}', 'SintegraEsController@getCnpjData');

Route::get('/login', 'PanelController@login');

Route::get('/logout', 'PanelController@logout');

Route::post('/autenticar', 'PanelController@autenticar');

Route::get('/minhas-consultas', 'PanelRestrictController@minhasConsultas');

Route::match(['get', 'post'], '/nova-consulta', 'PanelRestrictController@novaConsulta');

Route::delete('/remover-consulta/{id}', 'PanelRestrictController@removerConsulta');

Route::get('/ver-consulta/{id}', 'PanelRestrictController@verConsulta');
