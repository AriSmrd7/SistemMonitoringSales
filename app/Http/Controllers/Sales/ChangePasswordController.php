<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;
use App\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ChangePasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sales');
    }

    public function index()
    {
        return view('pages.sales.changePassword');
    }

    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        Sales::find(auth()->user()->id_sales)->update(['password'=> Hash::make($request->new_password)]);
        Session::flash('sales_change_password','Password berhasil diganti.');
        // alihkan halaman ke halaman pelanggan
        return redirect('/sales/change-password');

    }
}
