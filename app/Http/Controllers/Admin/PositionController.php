<?php

namespace App\Http\Controllers\Admin;

use App\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::orderby('position','ASC')
        ->get();
        
        return view('admin.positions.list',compact('positions'));
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
            'position'       => 'required|unique:positions,position',
          
        ],
            $messages = array('position.required' => 'Position is Required!',
            'position.unique' => 'Duplicate Record found!')
        );
       
        $position = Position::create($request->all());
        return redirect()->back()->with('with_success', 'Position : ' . strtoupper($position->position) .' created succesfully!'); 
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
            'position'       => 'required|unique:positions,position',
          
        ],
            $messages = array('role.required' => 'Role is Required!',
            'position.unique' => 'Duplicate Record found!')
        );

        $position = Position::findorfail($id);
        $position->update(['position' => $request['position']]);

       return redirect()->back()->with('with_success', strtoupper($position->position) .' was Updated succesfully!');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position = Position::findorfail($id);
        $position->delete();
        return redirect()->back()->with('with_success', strtoupper($position->position) .' was Deleted succesfully!');   
    }
}
