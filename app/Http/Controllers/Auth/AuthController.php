<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Password;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function postLogin(Request $request)
	{
		// check si le compte est bloque + log fail / check si delais d'attente encore actif  + log fail / check si tentatives > au nombre max  + log fail
		if(!$this->isAccountBanished($request) && !$this->isAccountBlocked($request) && $this->isValidNumberOfTentative($request)){
			//Verification du mot de passe  + log fail



	      $this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
			]);

			$credentials = $request->only('email', 'password');

			if ($this->auth->attempt($credentials, $request->has('remember')))
			{
				//reset stats
				return redirect()->intended($this->redirectPath());
			}



			return redirect($this->loginPath())
					->withInput($request->only('email', 'remember'))
					->withErrors([
							'email' => $this->getFailedLoginMessage(),
					]);
		}

		return redirect($this->loginPath())
				->withInput($request->only('email', 'remember'))
				->withErrors([
						'email' => "Email Error",//message affich/ a la vue
				]);

	}

	/**
	 * La notre ! :
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{

		//On check si les criteres de secu sont respectes
		//isValidPassword($request);
		/*si non
			$this->throwValidationException(
				$request, $validator
			);
		*/
		$validator = $this->registrar->validator($request->all());
		
		if($this->isValidPassword($request)){

			

			if ($validator->fails())
			{
				$this->throwValidationException(
						$request, $validator
				);
			}

			$this->auth->login($this->registrar->create($request->all()));

			return redirect($this->redirectPath());

		}
		else
		{
			
				$this->throwValidationException(
						$request, $validator
				);

		}
		
	}


	/**
	 * Method who returns true if the account is activated
	 * and not banished do to an number of bloked session too high
	 *
	 * @param  \Illuminate\Http\Request  $request
	 *	@return boolean
	 */
	public function isAccountBanished(Request $request){
		return false;
	}

	/**
	 * Method that returns true is the account is blocked
	 * caused by a too much unsuccessful connexion try
	 *
	 * @param  \Illuminate\Http\Request  $request
	 *	@return boolean
	 */
	public function isAccountBlocked(Request $request){
		return false;
	}


	/**
	 * Method that returns true if the number of try is lower
	 * than the maximum accepted.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 *	@return boolean
	 */
	public function isValidNumberOfTentative(Request $request){
		return true;
	}

	private function isValidCredentials($request){
		$passwordFromDb = Password::getCurrentPassword($request->input('email'));
		$passwordFromRequest = $request->input('password');

		if(strcmp($passwordFromDb,$passwordFromRequest) == 0){
			return true;
		}

		return false;
	}

	/**
	* Method who returns true if the password matches with the required security settings
	*
	* @param  \Illuminate\Http\Request  $request
	*	@return boolean
	*/
	public function isValidPassword(Request $request){
		return true;
	}


}
