<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
class Password extends Model {

	/**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'password';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['password', 'user_id','is_used','salt'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['password', 'user_id','is_used','salt'];

  /**
  * Function that return the current password linked to a user
  * @var $email The user's email
  */
  public static function getCurrentPassword($email)
  {
    //$result = DB::select( DB::raw("SELECT p.password from password p, users u where u.id=p.user_id and u.email='"+$email+"'' and p.is_used=1 order by p.created_at desc limit 1;") );
    $result="testtest";
    return $result;
  }




}
