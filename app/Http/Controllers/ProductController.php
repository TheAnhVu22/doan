<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryProductRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $productRepo;
    protected $cateRepo;
    protected $brandRepo;
    protected $tagRepo;

    public function __construct(
        ProductRepository $productRepository,
        CategoryProductRepository $categoryProductRepository,
        BrandRepository $brandRepository,
        TagRepository $tagRepository
    ) {
        $this->productRepo = $productRepository;
        $this->cateRepo = $categoryProductRepository;
        $this->brandRepo = $brandRepository;
        $this->tagRepo = $tagRepository;
    }

    public function index()
    {
        $products =  $this->productRepo->all(['*'], ['category', 'brand']);
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $cateProducts =  $this->cateRepo->all(['id', 'name']);
        $brandProducts =  $this->brandRepo->all(['id', 'name']);
        $tags =  $this->tagRepo->all(['id', 'name']);
        $product = $this->productRepo->newInstance();
        $tagsId = [];
        return view('admin.product.create', compact('product', 'cateProducts', 'brandProducts', 'tags', 'tagsId'));
    }

    public function store(ProductStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->productRepo->storeProduct($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return redirect()->route('product.index')->with('status', 'Tạo Sản Phẩm Thành Công');
    }

    public function show(Product $product)
    {
        $images = [];
        return view('admin.product.images', compact('product', 'images'));
    }

    public function edit(Product $product)
    {
        $cateProducts =  $this->cateRepo->all(['id', 'name']);
        $brandProducts =  $this->brandRepo->all(['id', 'name']);
        $tags =  $this->tagRepo->all(['id', 'name']);
        $tagsId = [];
        foreach ($product->tags as $tag){
            $tagsId[] = $tag->pivot->tag_id;
        }  
        return view('admin.product.edit', compact('product', 'cateProducts', 'brandProducts', 'tags', 'tagsId'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->productRepo->updateProduct($product, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return redirect()->route('product.index')->with('status', 'Cập Nhật Sản Phẩm Thành Công');
    }

    public function destroy(Product $product)
    {
        try {
            $this->productRepo->delete($product);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('product.index')->with('status', 'Xóa Sản Phẩm Thành Công');
    }
}