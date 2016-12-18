<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use App\Usuario;

class PanelAuth {

    protected static $session_name = 'usuario';

    /**
	 * Handle an incoming request.
	 *
	 * @param  Request   $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if (!$request->session()->has(self::$session_name)) {
            flash('Você precisa estar logado para acessar esta área', 'warning');
            return redirect('/login');
        }
        return $next($request);
    }

    /**
	 * Register login
	 *
	 * @param Usuario $usuario
     * @param Request $request
     *
     * @return void
	 */
	public static function registerLogin(Usuario $usuario, Request $request)
	{
        $request->session()->put(self::$session_name, $usuario);
    }

    /**
     * Register logout
     *
     * @param Request $request
     *
     * @return void
     */
    public static function registerLogout(Request $request)
    {
        $request->session()->forget(self::$session_name);
        $request->session()->flush();
    }

    /**
	 * Get logged user
	 *
     * @param Request $request
     *
     * @return Usuario
	 */
	public static function getLoggedUser(Request $request)
	{
        return $request->session()->get(self::$session_name);
    }

}
