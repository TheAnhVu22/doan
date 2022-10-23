<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Repositories\CommentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    protected $commentRepo;

    public function __construct(
        CommentRepository $commentRepository
    ) {
        $this->commentRepo = $commentRepository;
    }

    public function index()
    {
        $comments =  $this->commentRepo->all();
        return view('admin.comment.index', compact('comments'));
    }

    public function create()
    {
        $comment = $this->commentRepo->newInstance();
        return view('admin.comment.create', compact('comment'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            $this->commentRepo->create($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('comment.index')->with('status', 'Thêm Phản Hồi Thành Công');
    }

    public function show(Comment $comment)
    {

    }

    public function edit(Comment $comment)
    {
        return view('admin.comment.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            $this->commentRepo->update($comment, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('comment.index')->with('status', 'Cập Nhật Phản Hồi Thành Công');
    }

    public function destroy(Comment $comment)
    {
        try {
            $this->commentRepo->delete($comment);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('comment.index')->with('status', 'Xóa Phản Hồi Thành Công');
    }
}
