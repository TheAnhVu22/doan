<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Models\Coupon;
use App\Repositories\CouponRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    protected $couponRepo;

    public function __construct(
        CouponRepository $couponRepository
    ) {
        $this->couponRepo = $couponRepository;
    }

    public function index()
    {
        $coupons =  $this->couponRepo->all();
        return view('admin.coupon.index', compact('coupons'));
    }

    public function create()
    {
        $coupon = $this->couponRepo->newInstance();
        return view('admin.coupon.create', compact('coupon'));
    }

    public function store(CouponStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->couponRepo->create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('coupon.index')->with('status', 'Thêm Mã Giảm Giá Thành Công');
    }

    public function show(Coupon $coupon)
    {

    }

    public function edit(Coupon $coupon)
    {
        return view('admin.Coupon.edit', compact('coupon'));
    }

    public function update(CouponUpdateRequest $request, Coupon $coupon)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->couponRepo->update($coupon, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('coupon.index')->with('status', 'Cập Nhật Mã Giảm Giá Thành Công');
    }

    public function destroy(Coupon $coupon)
    {
        try {
            $this->couponRepo->delete($coupon);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('coupon.index')->with('status', 'Xóa Mã Giảm Giá Thành Công');
    }
}
