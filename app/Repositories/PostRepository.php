<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Base\BaseRepository;

class PostRepository extends BaseRepository
{
    public function model()
    {
        return Post::class;
    }

    public function newInstance()
    {
        return new Post();
    }

    public function paginate(int $page = 10, array $relation = [])
    {
        return $this->model->with($relation)->ofIsActive()->latest()->paginate($page);
    }

    public function getPostFilter($request)
    {
        $news = $this->model->with('categoryPost');
        $news->whereHas('categoryPost', function ($query) use ($request) {
            return $query->when(isset($request['category_slug']), function ($query) use ($request) {
                return $query->where('slug', $request['category_slug']);
            });
        });

        if (isset($request['type_sort'])) {
            $request['type_sort'] == 1 ? $news->latest() : $news->orderBy('views', 'DESC');
        }

        if (isset($request['keyword'])) {
            $news->where('name', 'LIKE', '%' . $request['keyword'] . '%')
                ->orWhere('author_name', 'LIKE', '%' . $request['keyword'] . '%');
        }

        return $news->ofIsActive()->paginate(10);
    }

    public function getRelateNews($news)
    {
        $news = $this->model->with('categoryPost')
            ->when($news, function ($query) use ($news) {
                return $query->where('category_id', $news->category_id);
            })->ofIsActive()->take(6)->get()->except($news->id);

        return $news;
    }

    public function getPostNewest($slug = null)
    {
        return $this->model->with('categoryPost')
            ->whereHas('categoryPost', function ($query) use ($slug) {
                return $query->when(isset($slug), function ($query) use ($slug) {
                    return $query->where('slug', $slug);
                });
            })->orderBy('id', 'DESC')->take(6)->get();
    }
}
