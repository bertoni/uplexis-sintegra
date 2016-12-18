<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\PanelAuth;
use GuzzleHttp\Client;
use App\Sintegra;
use App\Usuario;

class PanelRestrictController extends Controller {

    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->middleware('panelAuth');
	}

    /**
     * Show my consults page
     *
     * @param Request $request
     *
     * @return Response
     */
    public function minhasConsultas(Request $request)
    {
        $data = [];

        $consultas = Sintegra::whereRaw('idusuario = ?', [PanelAuth::getLoggedUser($request)->id])->get();
		if (count($consultas)) {
			$data['consultas'] = $consultas;
		}

        return view('consultas', $data);
    }

    /**
     * Show new consult page
     *
     * @param Request $request
     *
     * @return Response
     */
    public function novaConsulta(Request $request)
    {
        $data = [];

        if ($request->isMethod('post')) {
            $cnpj = $request->input('cnpj', '');
            if (strlen($cnpj)) {
                $client = new Client();
                try {
                    $ApiResponse = $client->request(
                        'GET',
                        'http://localhost:9000/api/consult/es/' . preg_replace('/[^0-9]/', '', $cnpj),
                        [
                            'headers' => [
                                'user' => PanelAuth::getLoggedUser($request)->usuario,
                                'key' => PanelAuth::getLoggedUser($request)->senha
                            ]
                        ]
                    );
                    if ($ApiResponse->getStatusCode() == 200) {
                        $responseJson    = json_decode($ApiResponse->getBody());
                        $responseJson    = json_decode($responseJson->data);
                        $data['cnpj']    = $cnpj;
                        $data['consult'] = $responseJson;
                    }
                } catch (\Exception $e) {
                }

                if (!count($data)) {
                    flash('CNPJ informado não encontrado', 'warning');
                }
            }
        }

        return view('nova-consulta', $data);
    }

    /**
     * Remove specific consult
     *
     * @param integer $id
     * @param Request $request
     *
     * @return jsonResponse
     */
    public function removerConsulta($id, Request $request)
    {
        try {
            $consulta = Sintegra::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
	            'message' => 'Consulta não encontrada'
	        ], 404);
        }

        $consulta->delete();

        return response()->json([
            'message' => 'Consulta removida com sucesso'
        ], 200);
    }

    /**
     * Show consult page
     *
     * @param integer $id
     * @param Request $request
     *
     * @return Response
     */
    public function verConsulta($id, Request $request)
    {
        try {
            $consulta = Sintegra::findOrFail($id);
        } catch (\Exception $e) {
            flash('Consulta não encontrada', 'warning');
            return redirect('/minhas-consultas');
        }

        $consulta->resultado_json = json_decode($consulta->resultado_json);

        return view('ver-consulta', ['consulta' => $consulta]);
    }
}
