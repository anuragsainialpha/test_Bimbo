<?php
  
namespace App\Http\Controllers;
  
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Auth;
  
class UserController extends Controller
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
        return view('users.index');
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
  		
		$user = new User;
		
		User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
			'role_id' => $request->role_id == "" ? 1 : $request->role_id,
			'facility_code' => $request->facility_code,
			'label_designer_code' => $request->label_designer_code,
			'printer_name' => $request->printer_name,
			'is_admin' => $request->is_admin,
			'create_user' => Auth::User()->username,
			'create_date' => date('Y-m-d H:i'),
        ]);
   
        return redirect()->route('users.index')
                        ->with('success','User created successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //return view('users.show',compact('user'));
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required',
        ]);
  
		$user->username = $request->username;
		if($request->password !="")
			$user->password = Hash::make($request->password);
		$user->role_id = $request->role_id == "" ? 1 : $request->role_id;
		$user->facility_code = $request->facility_code;
		$user->label_designer_code = $request->label_designer_code;
		$user->printer_name = $request->printer_name;
		$user->is_admin = $request->is_admin;
		$user->mod_user = Auth::User()->username;
		$user->mod_date = date('Y-m-d H:i');
		
		$user->save();
  
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
  
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
	
	/**
     * Create datatable grid
     *
     * 
     * @return \Illuminate\Http\Datatable
     */
	public function grid()
    {
	   $info_Users = User::All();
	   return Datatables::of($info_Users)
		->addColumn('edit', function ($info_Users) {
				 return '<div class="btn-group btn-group-action">
								<a class="btn btn-info" style="margin-right:2px;" href="'.url('/users/'.$info_Users->id.'/edit').'" title="Edit Data"><i class="fa fa-pencil"></i></a> 
								<a class="btn btn-danger" href="javascript(0)" title="Delete Data" id="btnDelete" name="btnDelete" data-remote="/users/' . $info_Users->id . '"><i class="fa fa-trash"></i></a>
						</div>';
        })
		->escapeColumns([])
		->removeColumn('type')
		->make(true);
    }
}