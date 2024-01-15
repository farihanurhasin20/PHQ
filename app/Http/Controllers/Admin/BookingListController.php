<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class BookingListController extends Controller
{
    public function index(){
        $users = User::where('role',1)->get();
        // dd($users);
        return view('admin.users.list',compact('users'));

    }

    public function edit($id){
        $users = User::where('id',$id)->get()->first();
        // dd($users);
        return view('admin.users.edit',compact('users'));

    }
}
