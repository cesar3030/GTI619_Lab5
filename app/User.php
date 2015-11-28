<?php namespace App;

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
	protected $fillable = ['name','password', 'email'];

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
}
