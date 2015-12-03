<?php namespace App\Http\Controllers;

use App\Configuration;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Input;
use Auth;
use Hash;
use Validator;
use App\Password;

class UserController extends Controller {


	/**
	 * Update the user's role.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateRole($userId,$roleId)
	{
		User::where('id',$userId)
			->update(['role_id' => $roleId]);
	}

	/**
	 * Change the table of a user to ask a new password when the next visit of his home page.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function resetPassword($userId)
	{
		User::where('id',$userId)
				->update(['need_reset_password' => 1]);
	}

	/**
	 * Update the user's role.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function accountActivation($userId,$value)
	{	$user = new User;
		$user->id=$userId;
		$user->setAccountDesactivate($value);
	}


	/**
	 * Function that renew a password that was too old or because of the admin
	 */
	public function renewPassword(Request $request){

		$oldPassword= Input::get('old_password');//$request->input("old_password");
		$user=Auth::user();
		$newPassword =Input::get('password');// $request->input("password");






		if(Hash::check($user->salt.$oldPassword, Auth::user()->password)){
			//dd($request->all());
			$validator = $this->validator($request->all());
			//dd($validator->fails());
			if ($validator->fails())
			{

				return view('auth.reset_confirm_old_password')
						->with('token', Auth::user()->remember_token)
						->withErrors([
								'Wrong password' => "The password don't match what the application required !",
						]);
			}

			if($user->canPasswordBeUse($newPassword)){

                User::where("id",$user->id)
                    ->update(
                        [	"password" => bcrypt($user->salt.$newPassword),
                            "need_reset_password" => 0
                        ]);

                //We create a new password in the password history table
                $password = new Password;
                $password->password = bcrypt($user->salt.$newPassword);
                $password->user_id=$user->id;
                $password->save();

                return redirect('/auth/logout');
            }

            $config = Configuration::where("id",1)->first();

            return view('auth.reset_confirm_old_password')
                ->with('token', Auth::user()->remember_token)
                ->withErrors([
                    'Not authorized' => "The password can't be one of your ".$config->number_last_password_disallowed." lasts.",
                ]);
		}

		return view('auth.reset_confirm_old_password')
				->with('token', Auth::user()->remember_token)
				->withErrors([
						'Old password' => "The old password given was not correct",
				]);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator($data)
	{
		return Validator::make($data, [
				'password' => 'required|confirmed|regex:'.Configuration::getPasswordCriteria(),
		]);
	}

}
