<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SintegraEsController extends Controller {

    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->middleware('restAuth');
	}

    /**
	 * Consulting a CNPJ into Sintegra
	 *
	 * @return Response
	 */
	public function getCnpjData($cnpj, Request $request)
	{
        if (!preg_match('/[0-9]{13,14}/', $cnpj)) {
            return response()->json([
	            'message' => 'cnpj informed is invalid'
	        ], 400);
        }

        return response()->json([
            'message' => 'cnpj ' . $cnpj . ' consulted with success'
        ], 200);
	}

}
