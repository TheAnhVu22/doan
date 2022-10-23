<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeeShipStoreRequest;
use App\Models\City;
use App\Models\District;
use App\Models\FeeShip;
use App\Models\Shipping;
use App\Models\Ward;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    public function index()
    {
       
        $feeShips = FeeShip::all();
        return view('admin.shipping.index', compact('feeShips'));
    }

    public function create(Request $request)
    {
        $cities = City::all();
        $districts = [];
        $wards = [];

        if ($request->ajax()) {
            $data = $request->all();

            if ($data['action']) {
                if ($data['action'] === "city") {
                    $districts = District::where('city_id', $data['id'])->get();
                    return view('admin.layouts.select_district', compact('districts'));
                } else {
                    $wards = Ward::where('district_id', $data['id'])->get();
                    return view('admin.layouts.select_ward', compact('wards'));
                }
            }
        }
        return view('admin.shipping.create', compact('cities', 'districts', 'wards'));
    }

    public function store(FeeShipStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            FeeShip::create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('shipping.index')->with('status', 'Thêm Phí Vận Chuyển Thành Công');
    }

    public function show(Shipping $shipping)
    {
        //
    }

    public function edit(Shipping $shipping)
    {
        //
    }

    public function update(Request $request, Shipping $shipping)
    {
        //
    }

    public function destroy($shipping)
    {
        try {
            $fee = FeeShip::findOrFail($shipping);
            $fee->delete();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('shipping.index')->with('status', 'Xóa Phí Vận Chuyển Thành Công');
    }

    public function updateFee(Request $request)
    {
        try {
            $parrams = $request->all();
            $fee = FeeShip::findOrFail($parrams['feeId']);
            $fee->fee_ship = $parrams['text'];
            $fee->save();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return $fee;
    }
}
