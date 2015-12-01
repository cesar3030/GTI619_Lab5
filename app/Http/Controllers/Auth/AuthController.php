<?php namespace App\Http\Controllers\Auth;

use Illuminate\Log\Writer;
use App\Configuration;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
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
	public function __construct(Guard $auth, Registrar $registrar, Writer $log)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;
		$this->log = $log;

		//Variable used to retrieve an error message to the view
		$this->errorMessage = "";

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * @param Request $request
	 * @return $this|\Illuminate\Http\RedirectResponse
     */
	public function postLogin(Request $request)
	{
		$email = $request->input('email');

		if($this->doesUserHaveAccess($email)){
			//Verification du mot de passe  + log fail

	      	$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
			]);

			$user = User::where('email',$email)->first();
			$passwordFromForm = $request->input('password');
			$password = $user->salt.$passwordFromForm;

			//$credentials = $request->only('email', 'password');

			$credentials = ['email'=> $email,'password'=>$password];

			if ($this->auth->attempt($credentials, $request->has('remember')))
			{
				//We reset the connexion stats (set number of attempts to 0, update last_success and last_try to now)
				$user->loginWithSuccess();

				$this->log->notice($user->email." just logged in !!");
				//reset stats
				return redirect()->intended($this->redirectPath());
			}

			$this->log->notice($user->email." failed to login");

			return redirect($this->loginPath())
					->withInput($request->only('email', 'remember'))
					->withErrors([
							'email' => $this->getFailedLoginMessage(),
					]);
		}

		return redirect($this->loginPath())
				->withInput($request->only('email', 'remember'))
				->withErrors([
						'email' => "Email Error",
						'Danger: ' => $this->errorMessage//message affich/ a la vue
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

	/*
	 * Function that check is the user follow all the rules required by the application configuration
	 *
	 * @param User $user the user trying to sign in
	 * @return true: the user can sign in / false: the user is not allowed to sign in
	 */
	public function doesUserHaveAccess($email){

		$config = Configuration::where('id',1)->first();

		User::updateUserAccountValidity($config,$email);

		$user = User::where('email',$email)->first();

		if($this->isAccountDesactivate($user)){
			$this->log->error($user->email." tried to login but his account is desactivate !!");
			return false;
		}

		if($this->isAccountBlocked($user)){
			$this->log->error($user->email." tried to login but his account is blocked !!");
			return false;
		}

		User::newAttempt($email);
		$user = User::where('email',$email)->first();

		if(!$this->isValidNumberOfTentative($config,$user)){
			//we set the account to not valid
			$user->setAccountValidity(1);
			$this->log->error($user->email." tried to login but he failed, too many attempts !!");
			return false;
		}

		return true;
	}
	/**
	 * Method who returns true if the account is activated
	 * and not banished do to an number of bloked session too high
	 *
	 * @param User $user
	 *	@return boolean
	 */
	public function isAccountDesactivate(User $user){

		if($user->desactivated === 0){
			return false;
		}

		$this->errorMessage="Your account is desactivate, KEEP CALM AND CALL THE ADMIN :) ";
		return true;

	}

	/**
	 * Method that returns true is the account is blocked
	 * caused by a too much unsuccessful connexion try
	 *
	 * @param User $user
	 *	@return boolean
	 */
	public function isAccountBlocked(User $user){

		//0: the account is not blocked
		if($user->is_valid_account === 0){
			return false;
		}

		$this->errorMessage=" You need to wait, your account is blocked for now !";
		return true;
	}


	/**
	 * Method that returns true if the number of try is lower
	 * than the maximum accepted.
	 *
	 * @param User $user
	 *	@return boolean
	 */
	public function isValidNumberOfTentative(Configuration $config,User $user){

		if($user->attempt_number >= $config->number_attempt_allowed ){
			$this->errorMessage=" Too much attempts, the account is blocked for ".$config->time_restriction." seconds.";
			return false;
		}

		return true;
	}

	private function isValidCredentials($request,User $user){
		$passwordFromRequest = $request->input('password');

		if(strcmp($user->password,$passwordFromRequest) == 0){
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
