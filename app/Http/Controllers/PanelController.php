<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\PanelAuth;
use App\Sintegra;
use App\Usuario;

class PanelController extends Controller {

    /**
	 * Show login page
     *
     * @param Request $request
	 *
	 * @return Response
	 */
	public function login(Request $request)
	{
        return view('login');
    }

    /**
	 * Show logout page
     *
     * @param Request $request
	 *
	 * @return Response
	 */
	public function logout(Request $request)
	{
        PanelAuth::registerLogout($request);
        return redirect('/login');
    }

    /**
     * Process login
     *
     * @param Request $request
     *
     * @return Response
     */
    public function autenticar(Request $request)
    {
        $redirect_fail    = '/login';
        $redirect_success = '/minhas-consultas';

        $usuario = $request->input('username', '');
        if (!strlen($usuario)) {
            flash('Usuário não informado', 'warning');
            return redirect($redirect_fail);
        }

        $senha = $request->input('password', '');
        if (!strlen($senha)) {
            flash('Senha não informada', 'warning');
            return redirect($redirect_fail);
        }

        $usuarios = Usuario::whereRaw('usuario = ? AND senha = ?', [$usuario, $senha])->get();
		if (!count($usuarios)) {
			flash('Usuário ou senha inválido', 'warning');
            return redirect($redirect_fail);
		}

        PanelAuth::registerLogin($usuarios[0], $request);

        flash('Olá ' . $usuarios[0]->usuario . ', bem vindo!', 'success');
        return redirect($redirect_success);
    }

}
