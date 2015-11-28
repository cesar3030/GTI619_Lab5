<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CircleController extends Controller {

	/**
   * Show the cicle page to the user with root or circle role.
   *
   * @return Response
   */
  public function index()
  {
    return view('Circle/circle')->with('title',"Circle Page");
  }
}
