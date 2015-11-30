<?php namespace App\Http\Middleware;

use Closure;
use Auth;

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

            return view('auth.reset_confirm_old_password')
                ->with('token', Auth::user()->remember_token)
                ->withErrors([
                    'Password' => "You need to reset your password",
                ]);
		}

		if($request->user()->isPasswordTooOld()){

            return view('auth.reset_confirm_old_password')
                ->with('token', Auth::user()->remember_token)
                ->withErrors([
                    'Password' => "Your password is too old, you need to change it !",
                ]);

		}

		return $next($request);
	}

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getResetPasswordForm()
    {
        return view('auth.reset');
    }



}
