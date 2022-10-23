<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function select_gallery(Request $request)
    {
        $product_id = $request->product_id;
        $images = ProductImage::where('product_id', $product_id)->get();
        return view('admin.product.list_image', compact('images', 'product_id'));
    }

    public function insert_gallery(Request $request, $product_id)
    {
        $get_image = $request->file('file');
        if ($get_image) {
            foreach ($get_image as $key) {
                $path = 'uploads/product_images/';
                $name_image = 'product_' . $product_id ."_";
                $new_image = $name_image . rand(0, 99) . '.' . $key->getClientOriginalExtension();
                $key->move($path, $new_image);
                $gallery = new ProductImage();
                $gallery->image = $new_image;
                $gallery->name = $new_image;
                $gallery->product_id = $product_id;
                $gallery->save();
            }
        }
        return redirect()->back()->with('status', 'Thêm thành công');
    }

    public function update_name(Request $request)
    {
        $image_id = $request->image_id;
        $image_name = $request->image_name;
        $gallery = ProductImage::findOrFail($image_id);
        $gallery->name = $image_name;
        $gallery->save();
    }

    public function delete_image(Request $request)
    {
        $image_id = $request->image_id;

        $gallery = ProductImage::find($image_id);
        unlink('uploads/product_images/' . $gallery->image);
        $gallery->forceDelete();
    }

    public function update_gallery(Request $request)
    {
        $get_image = $request->file('file');
        $image_id = $request->image_id;

        if ($get_image) {
            $path = 'uploads/product_images/';
            $name_image = 'product_' . $request->product_id ."_";
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            $gallery = ProductImage::find($image_id);
            unlink('uploads/product_images/' . $gallery->image);
            $gallery->name = $new_image;
            $gallery->image = $new_image;
            $gallery->save();
        }
    }
}
