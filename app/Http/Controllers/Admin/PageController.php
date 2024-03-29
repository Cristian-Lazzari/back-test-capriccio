<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slot;
use App\Models\Time;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function dashboard() {

        return view ('admin.dashboard');
    }
    public function setting() {
        $settings = Setting::all();

        return view ('admin.setting', compact('settings', ));
    }

}
