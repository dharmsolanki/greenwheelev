<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
class SettingsController extends Controller {
    public function index() {
        $settings = Setting::pluck('value','key');
        return view('admin.settings', compact('settings'));
    }
    public function update(Request $request) {
        foreach($request->except('_token') as $key=>$value) Setting::set($key,$value);
        return back()->with('success','Settings saved!');
    }
}
