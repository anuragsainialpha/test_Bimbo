<?php
  
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\OrderImport;
use Maatwebsite\Excel\Facades\Excel;
  
class OrderController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order', array('Uploaded' => '0'));
    }
   
	public function importOrders() 
    {
        Excel::import(new OrderImport,request()->file('orders'));
        return view('order', array('Uploaded' => '1'));
    }
}