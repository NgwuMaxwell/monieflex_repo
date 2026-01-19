<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $pageTitle = 'News & Blog';
        $blogs = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->paginate(getPaginate(10));
        return view($this->activeTemplate . 'user.blog.index', compact('pageTitle', 'blogs'));
    }

    public function detail($id)
    {
        $pageTitle = 'Blog Details';
        $blog = Frontend::where('data_keys', 'blog.element')->findOrFail($id);
        
        // Get approved comments
        $comments = BlogComment::with('user')->where('blog_id', $id)->approved()->orderBy('created_at', 'desc')->get();
        
        // Get related blogs
        $relatedBlogs = Frontend::where('data_keys', 'blog.element')
            ->where('id', '!=', $id)
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();
        
        return view($this->activeTemplate . 'user.blog.detail', compact('pageTitle', 'blog', 'relatedBlogs', 'comments'));
    }

    public function postComment(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:frontends,id',
            'comment' => 'required|string|max:1000'
        ]);

        BlogComment::create([
            'user_id' => auth()->id(),
            'blog_id' => $request->blog_id,
            'comment' => $request->comment,
            'status' => 1 // Auto-approve comments
        ]);

        $notify[] = ['success', 'Comment posted successfully'];
        return back()->withNotify($notify);
    }
}
