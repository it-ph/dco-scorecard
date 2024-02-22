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
        $profit = Setting::where('setting','profit')->first();
        $engagement = Setting::where('setting','engagement')->first();
        $behavior = Setting::where('setting','behavior')->first();
        $partnership = Setting::where('setting','partnership')->first();
        $priority = Setting::where('setting','priority')->first();
        return view('admin.settings',compact('towerhead','target','quality','productivity','reliability','profit','engagement','behavior','partnership','priority'));
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
        $profit = Setting::updateOrInsert(
            ['setting' => 'profit'],
            ['value' => $request['profit']]
        );
        $engagement = Setting::updateOrInsert(
            ['setting' => 'engagement'],
            ['value' => $request['engagement']]
        );
        $behavior = Setting::updateOrInsert(
            ['setting' => 'behavior'],
            ['value' => $request['behavior']]
        );
        $partnership = Setting::updateOrInsert(
            ['setting' => 'partnership'],
            ['value' => $request['partnership']]
        );
        $priority = Setting::updateOrInsert(
            ['setting' => 'priority'],
            ['value' => $request['priority']]
        );

        return redirect()->back()->with('with_success', 'Weightage updated succesfully!');
    }


}
