<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Models\Tag;
use App\Repositories\TagRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    protected $tagRepo;

    public function __construct(
        TagRepository $tagRepository
    ) {
        $this->tagRepo = $tagRepository;
    }

    public function index()
    {
        $tags =  $this->tagRepo->all();
        return view('admin.tag.index', compact('tags'));
    }

    public function create()
    {
        $tag = $this->tagRepo->newInstance();
        return view('admin.tag.create', compact('tag'));
    }

    public function store(TagStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->tagRepo->create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('tag.index')->with('status', 'Thêm Tag Sản Phẩm Thành Công');
    }

    public function show(Tag $tag)
    {
        //
    }

    public function edit(Tag $tag)
    {
        return view('admin.tag.edit', compact('tag'));
    }

    public function update(TagUpdateRequest $request, Tag $tag)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->tagRepo->update($tag, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('tag.index')->with('status', 'Cập Nhật Tag sản phẩm Thành Công');
    }

    public function destroy(Tag $tag)
    {
        try {
            $this->tagRepo->delete($tag);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('tag.index')->with('status', 'Xóa Tag sản phẩm Thành Công');
    }
}
