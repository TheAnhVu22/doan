<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Base\BaseRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository
{

    public function model()
    {
        return Product::class;
    }

    public function newInstance()
    {
        return new Product();
    }

    public function storeProduct(array $input)
    {
        DB::beginTransaction();
        try {
            $product = $this->model->create($input);
            if (isset($input['tag_id'])) {
                $product->tags()->attach($input['tag_id']);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return $product;
    }

    public function updateProduct(Product $product, array $input)
    {
        DB::beginTransaction();
        try {
            $product->update($input);
            if (isset($input['tag_id'])) {
                $product->tags()->sync($input['tag_id']);
            } else {
                $product->tags()->detach();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return true;
    }

    public function querySearchProduct($products, $request)
    {
        if (isset($request['brand_slug'])) {
            $products->whereHas('brand', function ($query) use ($request) {
                return $query->whereIn('slug', $request['brand_slug']);
            });
        }

        if (isset($request['category_slug'])) {
            $products->whereHas('category', function ($query) use ($request) {
                return $query->whereIn('slug', $request['category_slug']);
            });
        }

        if (isset($request['sort_price'])) {
            $products->where(function ($query) use ($request) {
                foreach ($request['sort_price'] as $key => $value) {
                    switch ($value) {
                        case 1:
                            $query->where('price', '<', '2000000');
                            break;
                        case 2:
                            if ($key == 0) {
                                $query->whereBetween('price', ['2000000', '4000000']);
                            } else {
                                $query->orWhereBetween('price', ['2000000', '4000000']);
                            }
                            break;
                        case 3:
                            if ($key == 0) {
                                $query->whereBetween('price', ['4000000', '7000000']);
                            } else {
                                $query->orWhereBetween('price', ['4000000', '7000000']);
                            }
                            break;
                        case 4:
                            if ($key == 0) {
                                $query->whereBetween('price', ['7000000', '13000000']);
                            } else {
                                $query->orWhereBetween('price', ['7000000', '13000000']);
                            }
                            break;
                        case 5:
                            if ($key == 0) {
                                $query->whereBetween('price', ['13000000', '20000000']);
                            } else {
                                $query->orWhereBetween('price', ['13000000', '20000000']);
                            }
                            break;
                        case 6:
                            if ($key == 0) {
                                $query->where('price', '>', '20000000');
                            } else {
                                $query->orWhere('price', '>', '20000000');
                            }
                            break;
                    }
                }
            });
        }

        if (isset($request['type_sort'])) {
            switch ($request['type_sort']) {
                case 1:
                    $products->latest();
                    break;
                case 2:
                    $products->orderBy('views', 'DESC');
                    break;
                case 3:
                    $products->orderBy('price', 'DESC');
                    break;
                case 4:
                    $products->orderBy('price', 'ASC');
                    break;
            }
        }
    }

    public function getProduct(string $slug, $request, $type)
    {
        $products = $this->model->with('brand', 'category', 'productImages', 'comments', 'tags');

        if ($type === 'category') {
            $products->whereHas('category', function ($query) use ($slug) {
                return $query->where('slug', $slug);
            });
        } else if ($type === 'brand') {
            $products->whereHas('brand', function ($query) use ($slug) {
                return $query->where('slug', $slug);
            });
        }

        $this->querySearchProduct($products, $request);

        if (isset($request['notPaginate'])) {
            return $products->ofIsActive()->take(12)->get();
        }

        return $products->ofIsActive()->paginate(12);
    }

    public function searchProduct($request, array $relation = [])
    {
        $products = $this->model->join('brand_products', 'products.brand_id', '=', 'brand_products.id')
            ->join('category_products', 'products.category_id', '=', 'category_products.id')
            ->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('products.name', 'LIKE', '%' . $request['keywords'] . '%')
                        ->where('products.is_active', 1);
                })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('category_products.name', 'LIKE', '%' .  $request['keywords'] . '%')
                            ->where('category_products.is_active', 1);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('brand_products.name', 'LIKE', '%' .  $request['keywords'] . '%')
                            ->where('brand_products.is_active', 1);
                    });
            });

        $products->where(function ($query) use ($request, $products) {
            $this->querySearchProduct($products, $request);
        });

        return $products->select('products.*')->paginate(12);
    }

    public function search(string $key, string $column, array $relation = [])
    {
        return $this->model->with($relation)->where($column, $key)->first();
    }

    public function getRelateProduct($product)
    {
        $product = $this->model->with('brand', 'category', 'productImages', 'comments', 'tags')
            ->when($product, function ($query) use ($product) {
                return $query->where('category_id', $product->category_id);
            })->ofIsActive()->take(6)->get()->except($product->id);

        return $product;
    }

    public function getProductNewest()
    {
        return $this->model->latest()->paginate(12);
    }

    public function getAll()
    {
        return $this->model->ofIsActive()->where('quantity', '>=', 1)->get();
    }
}
