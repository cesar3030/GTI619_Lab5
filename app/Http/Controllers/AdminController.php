<?php namespace App\Http\Controllers;

use App\Configuration;
use App\Http\Requests;
use App\User;
use App\Role;

use Illuminate\Http\Request;

class AdminController extends Controller {

	//
  /**
   * Show the managment page to the root user.
   *
   * @return Response
   */
  public function index()
  {
    $appConfig = Configuration::where('id', 1)->get();
    $users = User::all();
    $roles = Role::all();

    return view('Admin/admin')
        ->with('title',"Admin Page")
        ->with('appConfig',$appConfig)
        ->with('users',$users)
        ->with('roles',$roles);
  }

  /**
   * Function that set the maximum number of attempts
   * @param $nbAttempts
   */
  public static function setNumberAttemptAllowed($nbAttempts){
    Configuration::setNumberAttemptAllowed($nbAttempts);
  }

  /**
   * Function that the time restriction in seconds before a new attempt after a too number of try
   * @param $nbSeconds
   */
  public function setTimeRestriction($nbSeconds){
    Configuration::setTimeRestriction($nbSeconds);
  }

  /**
   * Function that disallow the user to use his x last passwords.
   * @param $nbPasswordDisallow
   */
  public function setNumberLastPasswordDisallowed($nbPasswordDisallow){
    Configuration::setNumberLastPasswordDisallowed($nbPasswordDisallow);
  }


  /**
   * Function that set the number of days that a password can be use for login
   * @param $nbDays
   */
  public function setPasswordTimeLife($nbDays){
    Configuration::setPasswordTimeLife($nbDays);
  }

  /**
   * Function that set the minimum length accepted for a password
   * @param $length
   */
  public function setPasswordMinLength($length){
    Configuration::setPasswordMinLength($length);
  }

  /**
   * Function that set if at least a lower case is required for a password
   * @param $isRequired  1 -> yes / 0 -> no
   */
  public function setPasswordLowerCaseRequired($isRequired){
    Configuration::setPasswordLowerCaseRequired($isRequired);
  }

  /**
   * Function that set if at least an upper case is required for a password
   * @param $isRequired  1 -> yes / 0 -> no
   */
  public function setPasswordUpperCaseRequired($isRequired){
    Configuration::setPasswordUpperCaseRequired($isRequired);
  }

  /**
   * Function that set if at least a special character is required for a password
   * @param $isRequired  1 -> yes / 0 -> no
   */
  public function setPasswordSpecialCharactersRequired($isRequired){
    Configuration::setPasswordSpecialCharactersRequired($isRequired);
  }

  /**
   * Function that set if at least a number is required for a password
   * @param $isRequired  1 -> yes / 0 -> no
   */
  public function setPasswordNumberRequired($isRequired){
    Configuration::setPasswordNumberRequired($isRequired);
  }

  /**
   * Function that set the number of time that an account can be blocked before being desactivate
   * @param $nb  number of time
   */
  public function setNumberMaxBlocked($nb){
    Configuration::setNumberMaxBlocked($nb);
  }




}
