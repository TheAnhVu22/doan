<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Order;
use App\Models\Post;
use App\Models\Rating;
use App\Models\Slide;
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
        $categories_product = $this->cateProductRepo->all();
        $brands = $this->brandRepo->getBrand();
        $newest_products = $this->productRepo->getProductNewest();
        $phones = $this->productRepo->getProduct('dien-thoai', ['type_sort' => 2, 'notPaginate' => true], 'category');
        $laptops = $this->productRepo->getProduct('may-tinh', ['type_sort' => 2, 'notPaginate' => true], 'category');
        $headphones = $this->productRepo->getProduct('tai-nghe', ['type_sort' => 2, 'notPaginate' => true], 'category');
        $tivis = $this->productRepo->getProduct('tivi', ['type_sort' => 2, 'notPaginate' => true], 'category');
        $watchs = $this->productRepo->getProduct('dong-ho', ['type_sort' => 2, 'notPaginate' => true], 'category');
        $slides = Slide::all('name', 'image');
        $news_discount = $this->postRepo->getPostNewest('khuyen-mai');
        return view('user.homepage', compact('brands', 'categories_product', 'slides', 'newest_products', 'phones', 'laptops', 'headphones', 'tivis', 'watchs', 'news_discount'));
    }

    public function getProductByCategory(string $slug = '', Request $request)
    {
        $products = $this->productRepo->getProduct($slug, $request->all(), 'category');
        $categories_product = $this->cateProductRepo->all(['id', 'name', 'slug']);
        $brands = $this->brandRepo->all(['id', 'name', 'slug']);
        $categorySelected = $this->cateProductRepo->search($slug, 'slug');
        $priceArr = $request->sort_price ?? [];
        $categoryArr = $request->category_slug ?? [];
        $brandArr = $request->brand_slug ?? [];
        $isCate = true;

        return view('user.product.index', compact('categorySelected', 'products', 'categories_product', 'brands', 'priceArr', 'categoryArr', 'brandArr', 'isCate'));
    }

    public function getProductByBrand($slug, Request $request)
    {
        $products = $this->productRepo->getProduct($slug, $request->all(), 'brand');
        $categories_product = $this->cateProductRepo->all(['id', 'name', 'slug']);
        $brands = $this->brandRepo->all(['id', 'name', 'slug']);
        $brandSelected = $this->brandRepo->search($slug, 'slug');
        $priceArr = $request->sort_price ?? [];
        $categoryArr = $request->category_slug ?? [];
        $brandArr = $request->brand_slug ?? [];

        return view('user.product.index', compact('brandSelected', 'products', 'categories_product', 'brands', 'priceArr', 'categoryArr', 'brandArr'));
    }

    public function getProductDetail(string $slug)
    {
        $product = $this->productRepo->search($slug, 'slug', ['comments', 'productImages']);
        $product ? $product->increment('views') : '';
        $relate_products = $this->productRepo->getRelateProduct($product);
        $rating = Rating::where('product_id', $product->id)->avg('rating');
        $rating1 = round($rating, 1);
        $rating = round($rating);
        $comments = Comment::where('product_id', $product->id)->whereNull('comment_parent_id')->orderBy('id', 'DESC')->get();
        $comments_response = Comment::where('product_id', $product->id)->whereNotNull('comment_parent_id')->orderBy('id', 'ASC')->get();

        return view('user.product.detail_product', compact('product', 'relate_products', 'rating1', 'rating', 'comments', 'comments_response'));
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

    public function contact()
    {
        return view('user.contact.index');
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
        $parrams = $request->all();
        $products = $parrams['keywords'] ? $this->productRepo->searchProduct($parrams)
            : [];
        $categories_product = $this->cateProductRepo->all(['id', 'name', 'slug']);
        $brands = $this->brandRepo->all(['id', 'name', 'slug']);
        $priceArr = $request->sort_price ?? [];
        $categoryArr = $request->category_slug ?? [];
        $brandArr = $request->brand_slug ?? [];
        return view('user.product.search', compact('products', 'categories_product', 'brands', 'priceArr', 'categoryArr', 'brandArr'));
    }

    public function rating(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'rating' => 'required|in:1,2,3,4,5',
                'phone' => 'required|numeric|digits_between: 10,11',
                'product_id' => 'required|exists:products,id'
            ],
            [
                'rating.required' => 'chọn sao đánh giá',
                'rating.in' => 'Sao đánh giá không hợp lệ',
                'phone.digits_between' => 'Số điện thoại không hợp lệ'
            ]
        );

        if ($validator->passes()) {
            Rating::create($request->all());
            $rating = Rating::where('product_id', $request->product_id)->avg('rating');
            $rating1 = round($rating, 1);
            $rating = round($rating);
            return view('user.product.rating', compact('rating', 'rating1'));
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function comment(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'comment_parent_id' => 'nullable|exists:comments,id',
                'name' => 'required|string|max:50',
                'content' => 'required|string|max:500',
                'product_id' => 'required|exists:products,id'
            ],
            [
                'name.required' => 'Nhập tên',
                'name.string' => 'Tên không hợp lệ',
                'name.max' => 'Tên tối đa 50 ký tự',
                'content.required' => 'Nhập nội dung bình luận',
                'content.string' => 'Nội dung không hợp lệ',
                'content.max' => 'Nội dung tối đa 500 ký tự',
            ]
        );

        if ($validator->passes()) {
            Comment::create($request->all());
            $comments = Comment::where('product_id', $request->product_id)->whereNull('comment_parent_id')->orderBy('id', 'DESC')->get();
            $comments_response = Comment::where('product_id', $request->product_id)->whereNotNull('comment_parent_id')->orderBy('id', 'ASC')->get();
            return view('user.product.comment', compact('comments', 'comments_response'));
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function detailOrder($order_code)
    {
        $order = $this->orderRepo->search($order_code, 'order_code', ['orderDetails', 'shipping', 'orderDetails.product', 'coupon']);
        if (!$order || !isCurrentUser($order->user_id)) {
            abort(404);
        }
        return view('user.auth.detail_order', compact('order'));
    }

    public function countCart()
    {
        $carts = \Session::get('cart');
        if ($carts) {
            return count($carts);
        }
        return 0;
    }
}
