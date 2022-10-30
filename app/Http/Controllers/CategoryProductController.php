<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryProductStoreRequest;
use App\Http\Requests\CategoryProductUpdateRequest;
use App\Models\CategoryProduct;
use App\Repositories\CategoryProductRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryProductController extends Controller
{
    protected $categoryProductRepo;

    public function __construct(
        CategoryProductRepository $categoryProductRepository
    ) {
        $this->categoryProductRepo = $categoryProductRepository;
    }

    public function index()
    {
        $categoryProducts =  $this->categoryProductRepo->all();
        return view('admin.category_product.index', compact('categoryProducts'));
    }

    public function create()
    {
        $categoryProduct = $this->categoryProductRepo->newInstance();
        return view('admin.category_product.create', compact('categoryProduct'));
    }

    public function store(CategoryProductStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $get_image = $params['image'] ?? '';
            if ($get_image) {
                $path = 'images/categories_product/';
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);

                $params['image'] = $new_image;
            }
            $this->categoryProductRepo->create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('category_product.index')->with('status', 'Thêm Danh Mục Sản Phẩm Thành Công');
    }

    public function show(CategoryProduct $categoryProduct)
    {
    }

    public function edit(CategoryProduct $categoryProduct)
    {
        return view('admin.category_product.edit', compact('categoryProduct'));
    }

    public function update(CategoryProductUpdateRequest $request, CategoryProduct $categoryProduct)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $get_image = $params['image'] ?? '';
            if ($get_image) {
                if ($categoryProduct->image) {
                    $path = 'images/categories_product/' . $categoryProduct->image;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $path = 'images/categories_product/';
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);

                $params['image'] = $new_image;
            }
            $this->categoryProductRepo->update($categoryProduct, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('category_product.index')->with('status', 'Cập Nhật Danh Mục Sản Phẩm Thành Công');
    }

    public function destroy(CategoryProduct $categoryProduct)
    {
        try {
            $this->categoryProductRepo->delete($categoryProduct);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('category_product.index')->with('status', 'Xóa Danh Mục Sản Phẩm Thành Công');
    }
}
