<?php namespace App\Http\Middleware;

use Closure;

class passwordCheck {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if($request->user()->needToResetPassword()){

            return response([
                'error' => [
                    'code' => 'Error Password',
                    'description' => 'Password need to be reset.'
                ]
            ], 401);
		}

		if($request->user()->isPasswordTooOld()){

            return response([
                'error' => [
                    'code' => 'Error Password',
                    'description' => 'Password too old.'
                ]
            ], 401);

		}

		return $next($request);
	}



}
