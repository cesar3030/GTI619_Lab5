<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SquareController extends Controller {

	//
  /**
   * Show the Square page to the user with root or square role.
   *
   * @return Response
   */
  public function index()
  {
    return view('Square/square')->with('title',"Square Page");
  }
}
