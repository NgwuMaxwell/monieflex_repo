<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $pageTitle = 'Notices Management';
        $notices = Notice::ordered()->paginate(getPaginate());
        return view('admin.notices.index', compact('pageTitle', 'notices'));
    }

    public function create()
    {
        $pageTitle = 'Add New Notice';
        return view('admin.notices.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'status' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $notice = new Notice();
        $notice->title = $request->title;
        $notice->content = $request->content;
        $notice->status = $request->has('status');
        $notice->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            $notice->image = fileUploader($request->image, 'assets/images/notice', null, $notice->image);
        }

        $notice->save();

        $notify[] = ['success', 'Notice created successfully'];
        return redirect()->route('admin.notices.index')->withNotify($notify);
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Notice';
        $notice = Notice::findOrFail($id);
        return view('admin.notices.edit', compact('pageTitle', 'notice'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'status' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $notice = Notice::findOrFail($id);
        $notice->title = $request->title;
        $notice->content = $request->content;
        $notice->status = $request->has('status');
        $notice->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            $notice->image = fileUploader($request->image, 'assets/images/notice', null, $notice->image);
        }

        $notice->save();

        $notify[] = ['success', 'Notice updated successfully'];
        return redirect()->route('admin.notices.index')->withNotify($notify);
    }

    public function delete($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->image) {
            fileManager()->removeFile('assets/images/notice/' . $notice->image);
        }

        $notice->delete();

        $notify[] = ['success', 'Notice deleted successfully'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->status = !$notice->status;
        $notice->save();

        $notify[] = ['success', 'Notice status updated successfully'];
        return back()->withNotify($notify);
    }
}
