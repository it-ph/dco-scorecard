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
        $target = Setting::where('setting','target')->first();
        $quality = Setting::where('setting','quality')->first();
        $productivity = Setting::where('setting','productivity')->first();
        $reliability = Setting::where('setting','reliability')->first();
        return view('admin.settings',compact('towerhead','target','quality','productivity','reliability'));
    }

    public function updateTowerHead(Request $request)
    {
        $towerhead = Setting::updateOrInsert(
            ['setting' => 'towerhead'],
            ['value' => $request['value']]
        );

        return redirect()->back()->with('with_success','Tower Head updated succesfully!');
    }

    public function updateTarget(Request $request)
    {
        $target = Setting::updateOrInsert(
            ['setting' => 'target'],
            ['value' => $request['target']]
        );

        return redirect()->back()->with('with_success', 'Target updated succesfully!');
    }

    public function updateWeightage(Request $request)
    {
        $quality = Setting::updateOrInsert(
            ['setting' => 'quality'],
            ['value' => $request['quality']]
        );
        $productivity = Setting::updateOrInsert(
            ['setting' => 'productivity'],
            ['value' => $request['productivity']]
        );
        $reliability = Setting::updateOrInsert(
            ['setting' => 'reliability'],
            ['value' => $request['reliability']]
        );

        return redirect()->back()->with('with_success', 'Weightage updated succesfully!');
    }


}
