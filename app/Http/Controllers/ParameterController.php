<?php
  
namespace App\Http\Controllers;
  
use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Auth;
  
class ParameterController extends Controller
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
        return view('parameter.index');
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parameter.create');
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
            'parameter' => 'required',
            'value' => 'required',
        ]);
  		
		$parameter = new Parameter;
		
		Parameter::create([
            'parameter' => $request->parameter,
			'value' => $request->value,
			'create_user' => Auth::User()->username,
			'create_date' => date('Y-m-d H:i'),
        ]);
   
        return redirect()->route('parameter.index')
                        ->with('success','Parameter created successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function show(Parameter $parameter)
    {
        //return view('parameter.show',compact('parameter'));
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function edit(Parameter $parameter)
    {
        return view('parameter.edit',compact('parameter'));
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parameter $parameter)
    {
        $request->validate([
            'parameter' => 'required',
            'value' => 'required',
        ]);
  
		$parameter->parameter = $request->parameter;
		$parameter->value = $request->value;
		$parameter->mod_user = Auth::User()->username;
		$parameter->mod_date = date('Y-m-d H:i');
		
		$parameter->save();
  
        return redirect()->route('parameter.index')
                        ->with('success','Parameter updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parameter $parameter)
    {
        $parameter->delete();
  
        return redirect()->route('parameter.index')
                        ->with('success','Parameter deleted successfully');
    }
	
	/**
     * Create datatable grid
     *
     * 
     * @return \Illuminate\Http\Datatable
     */
	public function grid()
    {
	   $info_Parameters = Parameter::All();
	   return Datatables::of($info_Parameters)
		->addColumn('edit', function ($info_Parameters) {
				 return '<div class="btn-group btn-group-action">
								<a class="btn btn-info" style="margin-right:2px;" href="'.url('/parameter/'.$info_Parameters->id.'/edit').'" title="Edit Data"><i class="fa fa-pencil"></i></a> 
								<a class="btn btn-danger" href="javascript(0)" title="Delete Data" id="btnDelete" name="btnDelete" data-remote="/parameter/' . $info_Parameters->id . '"><i class="fa fa-trash"></i></a>
						</div>';
        })
		->escapeColumns([])
		->removeColumn('type')
		->make(true);
    }
}