<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class AdminSettingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $admins=Admin::where('status', Admin::$status['active'])->get();
        // return $category;


        return view('backend.admin.index')->with('admins',$admins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin_status = Admin::$status;
        $admin_role = Admin::$role;

        return view('backend.admin.create', [
            'admin_role' => $admin_role,
            'admin_status' => $admin_status,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = static::adminStoreValidation($request);

        $admin = Admin::create([
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'contact' => $data['contact'],
            'email' => $data['email'],
            'role' => $data['role'],
            'status' => $data['status'],

        ]);

        if($admin){
            request()->session()->flash('success','Admin successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('admin-setting.index');
    }

    public static function adminStoreValidation($request){

        $data[] = $request->validate([
            'email' => ['required',
            function ($attribute, $value, $fail) {
                $admin_name = Admin::where('email', $value)->first();
                if ($admin_name) {
                    $fail('email is exists');
                }
            }
            ],
            'password' => ['required'],
            'confirm_password' => ['same:password'],
            'name' => ['required'],
            'contact' => ['required'],
            'status' => ['required'],
            'role' => ['required'],
        ]);

        $validated = [];
        foreach ($data as $value) {
            $validated = array_merge($validated, $value);
        }
        
        return $validated;
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
        $admin=Admin::findOrFail($id);

        return view('backend.admin.edit', [
            'admin' => $admin,
            'admin_role' => Admin::$role,
            'admin_status' => Admin::$status,
        ]);
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
        
        // return $request->all();
        $data = static::adminUpdateValidation($request, $id);

        $updateData = [
            'name' => $data['name'],
            'contact' => $data['contact'],
            'role' => $data['role'],
            'status' => $data['status'],
        ];

        if(isset($data['email'])){
            $updateData = [
                'email' => $data['email'],
            ];
        }

        if(isset($data['password'])){
            $updateData = [
                'password' => Hash::make($data['password']),
            ];
        }

        $admin=Admin::findOrFail($id);

        if($admin){
            $admin->fill($updateData)->save();
            request()->session()->flash('success','Admin successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('admin-setting.index');
    }

    public static function adminUpdateValidation($request, $id){

        $data[] = $request->validate([
            'name' => ['required'],
            'contact' => ['required'],
            'email' => ['required'],
            'status' => ['required'],
            'role' => ['required'],
        ]);

        $admin = Admin::select('email')
                        ->where('id', $id)
                        ->first();

        if($request->email != $admin->email){
            $data[] = $request->validate([
                'email' => ['required',
                function ($attribute, $value, $fail) {
                    $admin_name = Admin::where('email', $value)->first();
                    if ($admin_name) {
                        $fail('email has exist');
                    }
                }
                ],
            ]);
        }

        if($request->password != null){
            $data[] = $request->validate([
                'password' => ['required'],
                'confirm_password' => ['same:password'],
            ]);
        }

        $validated = [];
        foreach ($data as $value) {
            $validated = array_merge($validated, $value);
        }
        
        return $validated;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin=Admin::findOrFail($id);

        if($admin){
            // return $child_cat_id;
            $admin = Admin::where('id', $id)->update([
                'status' => Admin::$status['inactive'],
            ]);

            request()->session()->flash('success','Admin successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting admin');
        }
        return redirect()->route('admin-setting.index');
    }
}
