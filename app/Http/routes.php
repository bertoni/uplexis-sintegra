<?php

Route::get('/', 'WelcomeController@index');

/**
 * Consulting a CNPJ into Sintegra
 */
Route::get('/api/consult/{cnpj}', 'SintegraEsController@getCnpjData');

/*Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/
