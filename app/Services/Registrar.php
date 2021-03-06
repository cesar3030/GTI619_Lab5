<?php namespace App\Services;

use App\Configuration;
use App\User;
use App\Password;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Illuminate\Log\Writer;

class Registrar implements RegistrarContract {



	public function __construct(Writer $log)
	{
		$this->log = $log;
	}


	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|regex:'.Configuration::getPasswordCriteria(),
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
        //We generate a random string to be use as a salt
		$salt = str_random(60);
        //We encrypt the password mixed up with the salt
		$pass=bcrypt($salt.$data['password']);
        //We create the user with all his given information and his salt
		$user = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => $pass,
			'salt'=> $salt
		]);

        //We create a new password in the password history table
		$password = new Password;
		$password->password = $pass;
		$password->user_id=$user->id;
		$password->save();

		$this->log->warning('New account created with the email: '.$data['email']);

		return $user;
	}

}
