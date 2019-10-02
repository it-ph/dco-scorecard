<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingController extends Controller
{
    public function index()
    {

        $towerhead = Setting::where('setting','towerhead')->first();
        return view('admin.settings',compact('towerhead'));
    }

    public function updateTowerHead(Request $request)
    {
        $towerhead = Setting::updateOrInsert(
            ['setting' => 'towerhead'],
            ['value' => $request['value']]
        );
        
        return redirect()->back()->with('with_success','Tower Head updated succesfully!');   
    }
}
