<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Helper;
use App\Models\AdminSetting;

class LeaderboardSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $admin_setting = AdminSetting::where('type', Helper::$admin_setting_type['leaderboard_switch'])
                    ->first();

        return view('backend.admin-setting.edit', [
            'admin_setting' => $admin_setting ?? [],
        ]);
    }

    public function edit(Request $request, $id)
    {
        $is_on = 0;
        if(isset($request->switch)){
            $is_on = 1;
        }

        $updateData = [
            'switch' => $is_on,
        ];

        $setting=AdminSetting::findOrFail($id);

        if($setting){
            $setting->fill($updateData)->save();
            request()->session()->flash('success','Leaderboard Setting successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->back();
    }

}
