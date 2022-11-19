<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->userRepo = $userRepository;
    }

    public function index()
    {
        $users =  $this->userRepo->all(['*']);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $user = $this->userRepo->newInstance();
        return view('admin.user.create', compact('user'));
    }

    public function store(UserStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->userRepo->create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('user.index')->with('status', 'Tạo Khách Hàng Thành Công');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->userRepo->update($user, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('user.index')->with('status', 'Cập Nhật Khách Hàng Thành Công');
    }

    public function destroy(User $user)
    {
        try {
            $this->userRepo->delete($user);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('user.index')->with('status', 'Xóa Khách Hàng Thành Công');
    }

    public function updateUserInfo(User $user)
    {
        $meta_description = "Cập nhật tài khoản ATVSHOP";
        $meta_title = "Cập nhật tài khoản ATVSHOP";
        $url_canonical = \URL::current();
        $meta_image = asset('images/No_avatar.png');

        if (!isCurrentUser($user->id)) {
            abort(404);
        }
        return view('user.auth.edit', compact(
            'user',
            'meta_description',
            'meta_title',
            'url_canonical',
            'meta_image'
        ));
    }

    public function updateAccount(UserUpdateRequest $request, User $user)
    {
        if (!isCurrentUser($user->id)) {
            abort(404);
        }

        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->userRepo->update($user, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return back()->with('status', 'Cập Nhật Thông Tin Tài Khoản Thành Công');
    }
}
