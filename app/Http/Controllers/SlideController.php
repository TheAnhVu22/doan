<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlideStoreRequest;
use App\Models\Slide;
use Exception;
use Illuminate\Support\Facades\DB;

class SlideController extends Controller
{

    public function index()
    {
        $slides =  Slide::all();
        return view('admin.slide.index', compact('slides'));
    }

    public function create()
    {
        $slide = new Slide();
        return view('admin.slide.create', compact('slide'));
    }

    public function store(SlideStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $get_image = $params['image'] ?? '';
            if ($get_image) {
                $path = 'images/slides/';
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);

                $params['image'] = $new_image;
            }
            Slide::create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('slide.index')->with('status', 'Thêm Slide Thành Công');
    }

    public function show(Slide $slide)
    {
    }

    public function edit(Slide $slide)
    {
        return view('admin.slide.edit', compact('slide'));
    }

    public function update(SlideStoreRequest $request, Slide $slide)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $get_image = $params['image'] ?? '';
            if ($get_image) {
                if ($slide->image) {
                    $path = 'images/slides/' . $slide->image;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $path = 'images/slides/';
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);

                $params['image'] = $new_image;
            }
            $slide->update($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('slide.index')->with('status', 'Cập Nhật Slide Thành Công');
    }

    public function destroy(Slide $slide)
    {
        try {
            if ($slide->image) {
                $path = 'images/slides/' . $slide->image;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $slide->delete();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('slide.index')->with('status', 'Xóa Slide Thành Công');
    }
}
