<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
	public function login(Request $request)
	{
		if (\Auth::attempt(['username' => $request->username, 'password' => $request->password]))
		{
			return redirect('/home');
			
		}
		return redirect('/')->with('error', 'Invalid Email address or Password');
	}
	
	public function logout(Request $request)
	{
		if(\Auth::check())
		{
			\Auth::logout();
			$request->session()->invalidate();
		}
		return  redirect('/');
	}
}
