<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryPostStoreRequest;
use App\Http\Requests\CategoryPostUpdateRequest;
use App\Models\CategoryPost;
use App\Repositories\CategoryPostRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryPostController extends Controller
{
    protected $categoryPostRepo;

    public function __construct(
        CategoryPostRepository $categoryPostRepository
    ) {
        $this->categoryPostRepo = $categoryPostRepository;
    }

    public function index()
    {
        $categoryPosts =  $this->categoryPostRepo->all();
        return view('admin.category_post.index', compact('categoryPosts'));
    }

    public function create()
    {
        $categoryPost = $this->categoryPostRepo->newInstance();
        return view('admin.category_post.create', compact('categoryPost'));
    }

    public function store(CategoryPostStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->categoryPostRepo->create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('category_post.index')->with('status', 'Thêm Danh Mục Bài Viết Thành Công');
    }

    public function show(CategoryPost $categoryPost)
    {

    }

    public function edit(CategoryPost $categoryPost)
    {
        return view('admin.category_post.edit', compact('categoryPost'));
    }

    public function update(CategoryPostUpdateRequest $request, CategoryPost $categoryPost)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->categoryPostRepo->update($categoryPost, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('category_post.index')->with('status', 'Cập Nhật Danh Mục Bài Viết Thành Công');
    }

    public function destroy(CategoryPost $categoryPost)
    {
        try {
            $this->categoryPostRepo->delete($categoryPost);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('category_post.index')->with('status', 'Xóa Danh Mục Bài Viết Thành Công');
    }
}
