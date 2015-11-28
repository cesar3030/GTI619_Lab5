<?php namespace App;
require '../vendor/autoload.php';

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name','password', 'email','is_valid_account','last_success','nb_times_bloked','desactivated'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password','role_id'];


	public function role()
	{
		//return $this->hasOne('App\Role', 'id', 'role_id');
		return $this->hasOne('App\Role', 'role_id', 'role_id');
	}


	public function hasRole($roles)
	{
		$this->have_role = $this->getUserRole();

		// Check if the user is a root account
		if($this->have_role->name == 'Root') {
			return true;
		}

		if(is_array($roles)){
			foreach($roles as $need_role){
				if($this->checkIfUserHasRole($need_role)) {
					return true;
				}
			}
		} else{
			return $this->checkIfUserHasRole($roles);
		}
		return false;
	}




	private function getUserRole()
	{
		return $this->role()->getResults();
	}




	private function checkIfUserHasRole($need_role)
	{
		return (strtolower($need_role)==strtolower($this->have_role->name)) ? true : false;
	}

	/**
	* Function that create a new user in the DB
	*	@var $name user's name
	* @var $email user'email
	* @var $password user's password
	*/
	public static function createUser($name,$email,$password){
		return true;
	}

	/**
	 * Function that reset the login attempts to 0 and set the last_success to now
	 */
	private function loginWithSuccess(){
		User::where('id',$this->id)
			->update(
					['attempt_number' => 0],
					['last_success'=>Carbon::now()]);
	}

	/**
	 * Function that increase the number of attempt to the account which is linked to the given email
	 * @var $email user'email
	 */
	public static function addAttempt($email){
		User::where('email',$email)->increment('attempt_number');
	}

	/**
	 * Function that change the validity of the account. It means that the account can not be use
	 * for a certain time (time depending of the configuration of the application).
	 * When the account is set to not valid, the number of time that the account has been blocked is incremented
	 * @param $value 1 -> Account not valid / 0 -> Valid account
	 */
	private function setAccountValidity($value)
	{
		User::where('id',$this->id)
				->update(['is_valid_account' => $value]);

		//we update the nb_times_blocked
		if($value===1){
			User::where('id',$this->id)->increment('nb_times_bloked');
		}
	}

	/**
	 * Function that active or not the account. It means that the account can not be use until the admin fix it
	 * When the account desactivate, the number of time that the account has been blocked is et to 0
	 * @param $value 1 -> Account not valid / 0 -> Valid account
	 */
	public function setAccountDesactivate($value)
	{
		User::where('id',$this->id)
				->update(['desactivated' => $value]);

		//we update the nb_times_blocked
		if($value===0){
			User::where('id',$this->id)->update(['nb_times_bloked' => 0]);
		}
	}
}
