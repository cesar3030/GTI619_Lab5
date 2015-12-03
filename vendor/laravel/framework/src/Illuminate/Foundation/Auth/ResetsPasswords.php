<?php namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Configuration;
use App\User;
trait ResetsPasswords {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * The password broker implementation.
	 *
	 * @var PasswordBroker
	 */
	protected $passwords;

	/**
	 * Display the form to request a password reset link.
	 *
	 * @return Response
	 */
	public function getEmail()
	{
		return view('auth.password');
	}

	/**
	 * Send a reset link to the given user.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function postEmail(Request $request)
	{
		$this->validate($request, ['email' => 'required|email']);

		$response = $this->passwords->sendResetLink($request->only('email'), function($m)
		{
			$m->subject($this->getEmailSubject());
		});

		switch ($response)
		{
			case PasswordBroker::RESET_LINK_SENT:
				return redirect()->back()->with('status', trans($response));

			case PasswordBroker::INVALID_USER:
				return redirect()->back()->withErrors(['email' => trans($response)]);
		}
	}

	/**
	 * Get the e-mail subject line to be used for the reset link email.
	 *
	 * @return string
	 */
	protected function getEmailSubject()
	{
		return isset($this->subject) ? $this->subject : 'Your Password Reset Link';
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token))
		{
			throw new NotFoundHttpException;
		}

		return view('auth.reset')->with('token', $token);
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function postReset(Request $request)
	{
		$this->validate($request, [
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|confirmed|regex:'.Configuration::getPasswordCriteria(),
		]);

		$credentials = $request->only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$user2=User::where('email',$request->input("email"))->first();

		if($user2->canPasswordBeUse($request->input("password"))){

			$response = $this->passwords->reset($credentials, function($user, $password)
			{
				$user->password = bcrypt($user->salt.$password);
				$user->need_reset_password=0;
				$user->save();
				$this->log->alert($user->email." has reset his password");
				$this->auth->login($user);
			});

			switch ($response)
			{
				case PasswordBroker::PASSWORD_RESET:
					return redirect($this->redirectPath());

				default:
					return redirect()->back()
								->withInput($request->only('email'))
								->withErrors(['email' => trans($response)]);
			}
		}
		$config = Configuration::where("id",1)->first();
		return redirect()->back()
				->withInput($request->only('email'))
				->withErrors([
						'Not authorized' => "The password can't be one of your ".$config->number_last_password_disallowed." lasts.",
				]);

	}

	/**
	 * Get the post register / login redirect path.
	 *
	 * @return string
	 */
	public function redirectPath()
	{
		if (property_exists($this, 'redirectPath'))
		{
			return $this->redirectPath;
		}

		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
	}

}
