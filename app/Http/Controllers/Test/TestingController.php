<?php

namespace App\Http\Controllers\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class TestingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            'username' => 'admin',
            'password'=>Hash::make('admin'),
            'name' => 'admin',
            'contact' => '12321321321',
            'email' => 'admin@admin.com',
            'status' => 'active',
        ];

        // $admin = Admin::create([
        //     'username' => 'admin',
        //     'password'=>Hash::make('admin'),
        //     'name' => 'admin',
        //     'contact' => '12321321321',
        //     'email' => 'admin@admin.com',
        //     'status' => 'active',
        // ]);
    }
}
