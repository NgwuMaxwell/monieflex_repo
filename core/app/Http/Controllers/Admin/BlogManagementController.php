<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use Illuminate\Http\Request;

class BlogManagementController extends Controller
{
    public function allPosts()
    {
        $pageTitle = 'All Blog Posts';
        $blogs = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.blog.all_posts', compact('pageTitle', 'blogs'));
    }

    public function deletePost($id)
    {
        $blog = Frontend::where('data_keys', 'blog.element')->findOrFail($id);
        
        // Delete image if exists
        if($blog->data_values->image) {
            $imagePath = getFilePath('blog') . '/' . $blog->data_values->image;
            if(file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }
        
        $blog->delete();
        
        $notify[] = ['success', 'Blog post deleted successfully'];
        return back()->withNotify($notify);
    }

    public function comments()
    {
        $pageTitle = 'Blog Comments';
        $comments = \App\Models\BlogComment::with(['user', 'blog'])->orderBy('created_at', 'desc')->paginate(getPaginate(20));
        return view('admin.blog.comments', compact('pageTitle', 'comments'));
    }

    public function deleteComment($id)
    {
        $comment = \App\Models\BlogComment::findOrFail($id);
        $comment->delete();
        
        $notify[] = ['success', 'Comment deleted successfully'];
        return back()->withNotify($notify);
    }
}
