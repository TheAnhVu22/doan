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

    public function getProductByCategory(string $slug, $request)
    {
        $products = $this->model->with('brand', 'category', 'productImages', 'comments', 'tags')
            ->whereHas('category', function ($query) use ($slug) {
                return $query->where('slug', $slug);
            });

        if (isset($request['brand_slug'])) {
            $products->whereHas('brand', function ($query) use ($request) {
                return $query->whereIn('slug', $request['brand_slug']);
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

        return $products->ofIsActive()->paginate(12);
    }

    public function searchProduct(string $key, array $relation = [])
    {
        return $this->model->join('brand_products', 'products.brand_id', '=', 'brand_products.id')
            ->join('category_products', 'products.category_id', '=', 'category_products.id')
            ->where(function ($query) use ($key) {
                $query->where('products.name', 'LIKE', '%' . $key . '%')
                    ->where('products.is_active', 1);
            })
            ->orWhere(function ($query) use ($key) {
                $query->where('category_products.name', 'LIKE', '%' . $key . '%')
                    ->where('category_products.is_active', 1);
            })
            ->orWhere(function ($query) use ($key) {
                $query->where('brand_products.name', 'LIKE', '%' . $key . '%')
                    ->where('brand_products.is_active', 1);
            })
            ->get('products.*');
    }

    public function search(string $key, string $column, array $relation = [])
    {
        return $this->model->with($relation)->where($column, $key)->first();
    }
}