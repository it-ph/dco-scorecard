<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::orderby('department','ASC')
        ->get();
        
        return view('admin.departments.list',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'department'       => 'required|unique:departments,department',
          
        ],
            $messages = array('department.required' => 'Department is Required!',
            'department.unique' => 'Duplicate Record found!')
        );
       
        $department = Department::create($request->all());
        return redirect()->back()->with('with_success', 'Department : ' . strtoupper($department->department) .' created succesfully!'); 
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
        //
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
            'department'       => 'required|unique:departments,department',
          
        ],
            $messages = array('department.required' => 'Department is Required!',
            'department.unique' => 'Duplicate Record found!')
        );

        $department = Department::findorfail($id);
        $department->update(['department' => $request['department']]);

       return redirect()->back()->with('with_success', strtoupper($department->department) .' was Updated succesfully!');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::findorfail($id);
        $department->delete();
        return redirect()->back()->with('with_success', strtoupper($department->department) .' was Deleted succesfully!');   
    }
}
