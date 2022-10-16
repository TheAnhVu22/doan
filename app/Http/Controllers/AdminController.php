<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Admin;
use App\Repositories\RoleRepository;
use App\Repositories\AdminRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    protected $adminRepo;
    protected $roleRepo;

    public function __construct(
        AdminRepository $adminRepository,
        RoleRepository $roleRepository,
    ) {
        $this->adminRepo = $adminRepository;
        $this->roleRepo = $roleRepository;
    }

    public function index()
    {
        $admins =  $this->adminRepo->all(['*'], ['role']);
        return view('admin.admin.index', compact('admins'));
    }


    public function create()
    {
        $roles = $this->roleRepo->all(['id', 'name']);
        $admin = $this->adminRepo->newInstance();
        return view('admin.admin.create', compact('admin', 'roles'));
    }

    public function store(AdminStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();

            $get_image = $params['avatar'] ?? '';
            if ($get_image) {
                $path = 'images/admin/';
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);

                $params['avatar'] = $new_image;
            }
            $this->adminRepo->create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('admin.index')->with('status', 'Tạo Người Dùng Thành Công');
    }

    public function show(Admin $admin)
    {
        //
    }

    public function edit(Admin $admin)
    {
        $roles = $this->roleRepo->all(['id', 'name']);
        return view('admin.admin.edit', compact('admin', 'roles'));
    }


    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();

            $get_image = $params['avatar'] ?? '';
            if ($get_image) {
                if ($admin->avatar) {
                    $path = 'images/admin/' . $admin->avatar;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $path = 'images/admin/';
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);

                $params['avatar'] = $new_image;
            }

            $this->adminRepo->update($admin, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('admin.index')->with('status', 'Cập Nhật Người Dùng Thành Công');
    }

    public function destroy(Admin $admin)
    {
        try {
            $this->adminRepo->delete($admin);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('admin.index')->with('status', 'Xóa Người Dùng Thành Công');
    }
}
