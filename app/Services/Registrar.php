<?php namespace App\Services;

use App\User;
use App\Password;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

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
			'password' => 'required|confirmed|min:6',
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
		$pass=bcrypt($data['password']);
		$user = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => $pass,
		]);

		$password = new Password;
		$password->password = $pass;
		$password->user_id=$user->id;
		$password->save();



		



		//User::createUser($data['name'],$data['email'],$data['password']);
		return $user;
	}

}
