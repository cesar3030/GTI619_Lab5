<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Input;
use Auth;
use Hash;
use App\Password;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Function that renew a password that was too old or because of the admin
	 */
	public function renewPassword(){

		$oldPassword= Input::get('old_password');//$request->input("old_password");
		$user=Auth::user();
		$newPassword =Input::get('password');// $request->input("password");



		/*$this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);*/


		if(Hash::check($user->salt.$oldPassword, Auth::user()->password)){

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

		return view('auth.reset_confirm_old_password')
				->with('token', Auth::user()->remember_token)
				->withErrors([
						'Old password' => "The old password given was not correct",
				]);
	}

}
