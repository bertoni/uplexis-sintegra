<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SintegraEspiritoSanto;
use App\Sintegra;

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

        $SintegraEspiritoSanto = new SintegraEspiritoSanto();
        try {
            $json = $SintegraEspiritoSanto->getInfoByCnpj($cnpj);
        } catch (\Exception $e) {
            return response()->json([
	            'message' => $e->getMessage()
	        ], 400);
        }

        $sintegras = Sintegra::whereRaw('cnpj = ? AND idusuario = ?', [$cnpj, $request->get('idusuario')])->get();
		if (!count($sintegras)) {
            $Sintegra                 = new Sintegra;
            $Sintegra->idusuario      = $request->get('idusuario');
            $Sintegra->cnpj           = $cnpj;
            $Sintegra->resultado_json = $json;
        } else {
            $Sintegra = $sintegras[0];
            $Sintegra->resultado_json = $json;
        }
        $Sintegra->save();

        return response()->json([
            'message' => 'cnpj ' . $cnpj . ' consulted with success',
            'data'    => $json
        ], 200);
	}

}
