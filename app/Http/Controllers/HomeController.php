<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryPostRepository;
use App\Repositories\CategoryProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PostRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    protected $brandRepo;
    protected $cateProductRepo;
    protected $catePostRepo;
    protected $productRepo;
    protected $postRepo;
    protected $orderRepo;

    public function __construct(
        BrandRepository $brandRepository,
        CategoryPostRepository $categoryPostRepository,
        CategoryProductRepository $categoryProductRepository,
        ProductRepository $productRepository,
        PostRepository $postRepository,
        OrderRepository $orderRepository,
    ) {
        $this->brandRepo = $brandRepository;
        $this->catePostRepo = $categoryPostRepository;
        $this->cateProductRepo = $categoryProductRepository;
        $this->productRepo = $productRepository;
        $this->postRepo = $postRepository;
        $this->orderRepo = $orderRepository;
    }

    public function index()
    {
        $categories_product = $this->cateProductRepo->all(['id', 'name']);
        $brands = $this->brandRepo->all(['id', 'name']);
        $categories_post = $this->catePostRepo->all(['id', 'name']);
        $products = $this->productRepo->all();
        return view('user.homepage', compact('brands', 'categories_product', 'categories_post'));
    }

    public function getProductByCategory(string $slug = '', Request $request)
    {
        $products = $this->productRepo->getProductByCategory($slug, $request->all());
        $categories_product = $this->cateProductRepo->all(['id', 'name', 'slug']);
        $brands = $this->brandRepo->all(['id', 'name', 'slug']);
        $categorySelected = $this->cateProductRepo->search($slug, 'slug');
        $priceArr = $request->sort_price ?? [];
        $categoryArr = $request->category_slug ?? [];
        $brandArr = $request->brand_slug ?? [];

        return view('user.product.index', compact('categorySelected', 'products', 'categories_product', 'brands', 'priceArr', 'categoryArr', 'brandArr'));
    }

    public function getProductDetail(string $slug)
    {
        $product = $this->productRepo->search($slug, 'slug', ['comments', 'productImages']);
        $product->increment('views');
        $relate_products = $this->productRepo->getRelateProduct($product);
        return view('user.product.detail_product', compact('product', 'relate_products'));
    }

    public function getNews(Request $request)
    {
        $categories_news = $this->catePostRepo->all();
        $news = !empty($request->all()) ? $this->postRepo->getPostFilter($request->all())
            : $this->postRepo->paginate();
        return view('user.news.index', compact('news', 'categories_news'));
    }

    public function getNewsDetail(string $slug)
    {
        $news = $this->postRepo->search($slug, 'slug');
        $news->increment('views');
        $relate_news = $this->postRepo->getRelateNews($news);
        return view('user.news.detail_news', compact('news', 'relate_news'));
    }

    public function managerAccount(User $user)
    {
        if (!isCurrentUser($user->id)) {
            abort(404);
        }
        return view('user.auth.manager_account', compact('user'));
    }

    public function managerOrder(User $user)
    {
        if (!isCurrentUser($user->id)) {
            abort(404);
        }
        $orders = $this->orderRepo->getOrderOfUser($user);
        return view('user.auth.manager_order', compact('user', 'orders'));
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $products = $keywords ? $this->productRepo->searchProduct($keywords)
            : [];
        return view('user.product.search', compact('products'));
    }
}
