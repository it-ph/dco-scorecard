<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();


        return view('admin.user.list',compact('users'));
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
                'name'       => 'required|min:2',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'role' => ['required'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ],
                $messages = array('name.required' => 'Username is Required!')
            );
           
            $request['password'] = Hash::make( $request['password']);

            $user = User::create($request->all());
            return redirect()->back()->with('with_success', 'Account for ' . strtoupper($user->name) .' was created succesfully!');   
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
            'name'       => 'required|min:2',
            'email' => ['required', 'string', 'email'],
            'role' => ['required'],

        ],
            $messages = array('name.required' => 'Username is Required!')
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
}
