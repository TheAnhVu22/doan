<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
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
        $comments = Comment::whereNull('comment_parent_id')->get();
        $comments_response = Comment::whereNotNull('comment_parent_id')->get();
        return view('admin.comment.index', compact('comments', 'comments_response'));
    }

    public function create()
    {
    }

    public function store(CommentStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
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
        return view('admin.comment.create', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        return view('admin.comment.edit', compact('comment'));
    }

    public function update(CommentStoreRequest $request, Comment $comment)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
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
