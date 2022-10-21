<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\BrandProduct;
use App\Repositories\BrandRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class BrandProductController extends Controller
{
    protected $brandRepo;

    public function __construct(
        BrandRepository $brandRepository
    ) {
        $this->brandRepo = $brandRepository;
    }

    public function index()
    {
        $brands =  $this->brandRepo->all();
        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        $brand = $this->brandRepo->newInstance();
        return view('admin.brand.create', compact('brand'));
    }

    public function store(BrandStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->brandRepo->create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('brand.index')->with('status', 'Thêm Thương Hiệu Thành Công');
    }

    public function show(BrandProduct $brand)
    {

    }

    public function edit(BrandProduct $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(BrandUpdateRequest $request, BrandProduct $brand)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->brandRepo->update($brand, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('brand.index')->with('status', 'Cập Nhật Thương Hiệu Thành Công');
    }

    public function destroy(BrandProduct $brand)
    {
        try {
            $this->brandRepo->delete($brand);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('brand.index')->with('status', 'Xóa Thương Hiệu Thành Công');
    }
}
