<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $settings = Setting::all();
        return view('backend.setting.index', compact('settings'));
    }

    function settingInsert(Request $request)
    {
        $request->validate([
            'parameter' => 'required',
            'value' => 'required|numeric'
        ]);
        Setting::insert([
            'parameter' =>  $request->parameter,
            'value' =>  $request->value,
        ]);
        return back()->with('status', 'Shipping addede successfully!!');
    }

    function settingEdit($setting_id)
    {
        $setting_info = Setting::findOrFail($setting_id);
        return view('backend.setting.edit', compact('setting_info'));
    }

    function settingUpdate(Request $request, $id)
    {
        Setting::findOrFail($request->id)->update([
            'parameter' => $request->parameter,
            'value' => $request->value,
        ]);
        return redirect('admin/setting')->withEditstatus('Shipping Edited successfully!!');
    }

    function settingDelete($setting_id)
    {
        Setting::findOrFail($setting_id)->delete();
        return back()->with('deletestatus', 'Shipping deleted successfully!!');
    }

}
