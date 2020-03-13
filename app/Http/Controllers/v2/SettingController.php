<?php

namespace App\Http\Controllers\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\v2\Metric;

class SettingController extends Controller
{
    public function metrics()
    {
        return view('admin.metrics.list');
    }
}
