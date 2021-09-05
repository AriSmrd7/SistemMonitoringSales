<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ChangePasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('pages.changePassword');
    }

    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        Admin::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        Session::flash('admin_change_password','Password berhasil diganti.');
        // alihkan halaman ke halaman pelanggan
        return redirect('/admin/change-password');

    }
}
