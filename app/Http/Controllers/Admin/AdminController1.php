<?php

namespace App\Http\Controllers;

use App\aircraft;
use Illuminate\Http\Request;

class AircraftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->search = ltrim(rtrim($request->input('search', '%')));


        $aircraft = aircraft::orderby('id','DESC')

        ->where('aircraft_type','like', '%' .$this->search .'%')
        ->orWhere('aircraft_num','like', '%' .$this->search .'%')
        ->paginate(25);
        $aircraft->setPath('aircraft');

        $search = ($this->search=='%')?'': $this->search;
        
        return view('pages.aircraft.home',compact('aircraft','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.aircraft.add');
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
                // 'aircraft_type'        => 'required|min:1',
                'aircraft_num'       => 'required|min:1',
                'bc_f_load'       => 'required|numeric',
                'ec_f_load'       => 'required|numeric',
            ],
                $messages = array('aircraft_type.required' => 'Aircraft type is required!',
                    'aircraft_num.required' => 'Aircraft # is required!',
                    'bc_f_load.required' => 'Business Class Full Load is required!',
                    'bc_f_load.numeric' => 'Business Class Full Load must be a number!',
                    'ec_f_load.required' => 'Economy Full Load is required!',
                    'ec_f_load.numeric' => 'Economy Full Load must be a number!')
            );

       $request['encoded_by'] =\Auth::user()->name;
       $aircraft = aircraft::create($request->all());
       $this->logs('Add new Aircraft ' .$aircraft->aircraft_type);

        return redirect('aircraft')->with([
            'flash_message' => "New Aircraft succesfully Added!"
        ]);
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
        $aircraft = aircraft::findorfail($id);
        return view('pages.aircraft.edit',compact('aircraft'));
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
                // 'aircraft_type'        => 'required|min:1',
                'aircraft_num'       => 'required|min:1',
                'bc_f_load'       => 'required|numeric',
                'ec_f_load'       => 'required|numeric',
            ],
                $messages = array('aircraft_type.required' => 'Aircraft type is required!',
                    'aircraft_num.required' => 'Aircraft # is required!',
                    'bc_f_load.required' => 'Business Class Full Load is required!',
                    'bc_f_load.numeric' => 'Business Class Full Load must be a number!',
                    'ec_f_load.required' => 'Economy Full Load is required!',
                    'ec_f_load.numeric' => 'Economy Full Load must be a number!')
            );

           
        $aircraft = aircraft::findorfail($id);
        $this->logs('Update Aircraft ' .$aircraft->aircraft_type ." to " . $request->aircraft_type );

        $request['updated_by'] =\Auth::user()->name;
        $aircraft->update( $request->all() );

        return redirect('aircraft')->with([
            'flash_message' => $aircraft->aircraft_type. ' Successfully Updated!'
        ]);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aircraft = aircraft::findorfail($id);
        $this->logs("Deleted id # " .$aircraft->id . " Aircraft Type " . $aircraft->aircraft_type );
        $aircraft->delete();

        return redirect('aircraft')->with([
            'flash_message' => 'Deleted Successfully'
        ]);
    }

    /**
     * @return Add Action performed to log file
     * @param $action
     */
    public function logs($action)
    {
        $logs = new LogsController;
        $logs->logs(\Auth::user()->name,$action);
    }
}
