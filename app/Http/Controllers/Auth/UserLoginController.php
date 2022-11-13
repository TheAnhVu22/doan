<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Mail\MailNotify;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Mail;

class UserLoginController extends Controller
{
    protected $redirectTo = '/checkout';

    public function __construct()
    {
        $this->middleware('guest')->except('userLogout');
    }

    public function showUserLoginForm()
    {
        return view('user.auth.login');
    }

    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|max:50',
            'password' => 'required|max:255'
        ]);
        if (Auth::guard('user')->attempt($credentials)) {
            return redirect()->intended('/');
        } else {
            return redirect()->route('user_login')->withErrors('Tên Đăng Nhập Hoặc Mật Khẩu Sai');
        }
    }

    public function showUserRegisterForm()
    {
        return view('user.auth.register');
    }

    public function userRegister(UserStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            User::create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('user_login')->with('status', 'Đăng Ký Tài Khoản Thành Công');
    }

    public function userLogout()
    {
        Auth::guard('user')->logout();

        return redirect()->route('user_login');
    }

    public function forgetPassword()
    {
        return view('user.auth.forget_password');
    }

    public function forgetPasswordHandle(Request $request)
    {
        $parrams = $request->validate([
            'email' => 'required|email|max:50'
        ]);
        $user = User::where('email', $parrams['email'])->first();
        if ($user) {
            $email = $user->email;
            $token = \Str::random();
            $linkResetPassword = url('/change-password?email=' . $email . '&token=' . $token);
            session()->put('token_reset_password', $token);
            $emailInfo = array(
                'email' => $user->email,
                'link' => $linkResetPassword,
            );
            Mail::to($email)->send(new MailNotify($emailInfo));
            return back()->with('status', "Thông tin đã được gửi qua email!");
        } else {
            return back()->withErrors("Thông tin email không chính xác");
        }
    }

    public function changePassword()
    {
        return view('user.auth.change_password');
    }

    public function changePasswordHandle(Request $request)
    {
        $data = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:8|confirmed',
                'token' => 'required'
            ]
        );

        $sessionToken = session()->has('token_reset_password') ? session()->get('token_reset_password') : null;
        $user = User::where('email', $data['email'])->first();

        if ($user && $sessionToken === $data['token']) {
            $user->password = $data['password'];
            $user->save();
            session()->forget('token_reset_password');
            return redirect()->route('user_login')->with('status', 'Thay đổi mật khẩu thành công');
        }
        return redirect()->route('forget_password')->withErrors('Link đã quá hạn. Vui lòng nhập lại email!');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $this->_registerOrLoginUser($user);
        return redirect()->route('homepage');
    }

    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)->first();

        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->save();
        } else {
            $user->provider_id = $data->id;
            $user->save();
        }

        Auth::login($user);
    }
}
