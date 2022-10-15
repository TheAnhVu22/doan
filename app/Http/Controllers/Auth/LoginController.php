<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectTo = '/admin/orders';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->withErrors('Tên Đăng Nhập Hoặc Mật Khẩu Không Đúng');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect()->route('login');
    }
}
