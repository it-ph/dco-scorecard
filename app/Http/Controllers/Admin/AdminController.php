<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use App\Position;
use App\Department;
use App\HrPortalEmployees;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('role','ASC')->get();
        $departments = Department::orderBy('department','ASC')->get();
        $positions = Position::orderBy('position','ASC')->get();
        $users = User::whereNotIn('role', ['superadmin'])->orderBy('id','ASC')->get();
        $supervisors = User::where('role','supervisor')->orderBy('name','ASC')->get();
        $managers = User::where('role','manager')->orderBy('name','ASC')->get();

        return view('admin.users.list',compact(
            'users',
            'roles',
            'departments',
            'positions',
            'supervisors',
            'managers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'emp_id'    => 'required',
                'name'       => 'required|min:2',
                'email'     => 'required|email|regex:/(.*)personiv\.com$/i|unique:users,email',
                'position_id' => ['required'],
                'role' => ['required'],
                'password' => ['required', 'string', 'min:6'],
                'supervisor' => ( $request['role']=='designer' || $request['role']=='proofer' || $request['role']=='wml' ) ? 'required' : '',
                'manager' => ( $request['role']=='designer' || $request['role']=='proofer' || $request['role']=='wml' ) ? 'required' : '',
            ],
                $messages = array('emp_id.required' => 'Employee ID is Required!',
                'name.required' => 'Username is Required!',
                'email.regex'       => 'Please use @personiv.com only',
                'position_id.required' => 'Position is Required!',
                'emp_id.unique' => 'Employee cannot have the same Employee ID!',
                )
            );

            $request['password'] = Hash::make( $request['password']);
            $user = User::create($request->all());
            return redirect()->back()->with('with_success', 'Account for ' . strtoupper($user->name) .' created succesfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $user = User::findorfail($id);
       return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
            'emp_id'       => 'required',
            'name'       => 'required|min:2',
            'email'     => ($id ? 'nullable' : 'required') . '|email|regex:/(.*)personiv\.com$/i',Rule::unique('users')->ignore($id),
            'role' => ['required'],
        ],
            $messages = array('name.required' => 'Username is Required!',
            'email.regex'   => 'Please use @personiv.com only'),
        );
        $user = User::findorfail($id);
        if(empty( $request['password']))
        {
            $user->update($request->except('password'));
        }else{
            $request['password'] = Hash::make( $request['password']);
            $user->update($request->all() );
        }
        return redirect()->back()->with('with_success', 'Account for ' . strtoupper($user->name) .' was Updated succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::findorfail($id);
        $user->delete();

        return redirect()->back()->with('with_success', strtoupper($user->name) .'\'s Account was Deleted succesfully!');

    }

    public function getHrPortalEmployeesAPI(Request $request)
    {
        $employee =  HrPortalEmployees::where('emp_code',$request['search_key'])->first();

        if($employee)
        {
            return response()->json([
                'found'=>true,
                'emp_code' => strtoupper($employee->emp_code),
                'first_name' => strtoupper($employee->fullname),
                'middle_name' => strtoupper($employee->middle_name),
                'last_name' => strtoupper($employee->last_name  . " " . $employee->suffix_name)]);
        }else{
            return response()->json(['found' => false]);
        }

    }
}
