<?php namespace App\Http\Middleware;

use Closure;
use App\Usuario;

class RestAuth {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = $request->header('user', null);
		if (is_null($user)) {
			return response()->json([
	            'message' => 'user not informed'
	        ], 401);
        }

		$key = $request->header('key', null);
		if (is_null($key)) {
			return response()->json([
	            'message' => 'key not informed'
	        ], 401);
        }

		$usuarios = Usuario::whereRaw('usuario = ? AND senha = ?', [$user, $key])->get();
		if (!count($usuarios)) {
			return response()->json([
	            'message' => 'user or key informed are invalid'
	        ], 401);
		}

		$request->attributes->add(['idusuario' => $usuarios[0]->id]);

		return $next($request);
	}

}
