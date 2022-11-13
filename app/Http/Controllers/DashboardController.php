<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $posts_most_view = Post::orderBy('views', 'DESC')->take(5)->get();
        $products_most_view = Product::orderBy('views', 'DESC')->take(10)->get();
        $products_out_of_stock = Product::where('quantity', '<', 11)->orderBy('quantity', 'ASC')->get();
        return view('admin.dashboard', compact('products_most_view', 'products_out_of_stock', 'posts_most_view'));
    }

    public function statistical(Request $request)
    {
        $data = $request->all();
        $date = $data['type'] ?? 7;
        $period = Carbon::now('Asia/Ho_Chi_Minh')->subdays($date)->toDateString();

        $statistical = DB::table('orders')->whereNull('orders.deleted_at')
            ->whereDate('orders.created_at', '>=', $period)
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(
                DB::raw('sum(price) as totalPrice'),
                DB::raw('sum(sales_quantity) as totalProduct'),
                DB::raw('count(DISTINCT order_id) as totalOrder'),
                DB::raw('DATE(orders.created_at) as date'),
            )
            ->groupBy('date')->get();
        foreach ($statistical as $key => $value) {
            $chart_data[] = [
                'date' => $value->date,
                'totalOrder' => $value->totalOrder,
                'totalPrice' => $value->totalPrice,
                'totalProduct' => $value->totalProduct
            ];
        }
        return json_encode($chart_data);
    }
}
