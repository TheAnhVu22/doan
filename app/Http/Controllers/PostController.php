<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Repositories\CategoryPostRepository;
use App\Repositories\PostRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected $postRepo;
    protected $cateRepo;

    public function __construct(
        PostRepository $postRepository,
        CategoryPostRepository $categoryPostRepository,
    ) {
        $this->postRepo = $postRepository;
        $this->cateRepo = $categoryPostRepository;
    }

    public function index()
    {
        $posts =  $this->postRepo->all(['*'], ['categoryPost']);
        return view('admin.post.index', compact('posts'));
    }


    public function create()
    {
        $catePosts =  $this->cateRepo->all();
        $post = $this->postRepo->newInstance();
        return view('admin.post.create', compact('post', 'catePosts'));
    }

    public function store(PostStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();

            $get_image = $params['image'] ?? null;

            if ($get_image) {
                $path = 'images/authors/';
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);

                $params['image'] = $new_image;
            }
            $this->postRepo->create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('post.index')->with('status', 'Tạo Bài Viết Thành Công');
    }

    public function show(Post $post)
    {   

    }

    public function edit(Post $post)
    {
        $catePosts =  $this->cateRepo->all();
        return view('admin.post.edit', compact('post', 'catePosts'));
    }


    public function update(PostUpdateRequest $request, Post $post)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();

            $get_image = $params['image'] ?? '';
            if ($get_image) {
                if ($post->image) {
                    $path = 'images/authors/' . $post->image;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $path = 'images/authors/';
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);

                $params['image'] = $new_image;
            }

            $this->postRepo->update($post, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('post.index')->with('status', 'Cập Nhật Bài Viết Thành Công');
    }

    public function destroy(Post $post)
    {
        try {
            $this->postRepo->delete($post);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('post.index')->with('status', 'Xóa Bài Viết Thành Công');
    }
}
