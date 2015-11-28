<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
    return view('Admin/admin')->with('title',"Admin Page");
  }
}
