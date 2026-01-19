<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DashboardLink;
use Illuminate\Http\Request;

class DashboardLinkController extends Controller
{
    public function serviceLinks()
    {
        $pageTitle = 'Service Links';
        $links = DashboardLink::service()->ordered()->paginate(getPaginate());
        return view('admin.dashboard_links.index', compact('pageTitle', 'links'));
    }

    public function contactLinks()
    {
        $pageTitle = 'Contact Developers Links';
        $links = DashboardLink::contact()->ordered()->paginate(getPaginate());
        return view('admin.dashboard_links.index', compact('pageTitle', 'links'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:500',
            'icon' => 'nullable|string|max:255',
            'type' => 'required|in:service,contact',
            'order' => 'nullable|integer'
        ]);

        DashboardLink::create([
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'type' => $request->type,
            'status' => $request->has('status') ? 1 : 0,
            'order' => $request->order ?? 0
        ]);

        $notify[] = ['success', 'Dashboard link created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:500',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer'
        ]);

        $link = DashboardLink::findOrFail($id);
        
        $link->update([
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'status' => $request->has('status') ? 1 : 0,
            'order' => $request->order ?? $link->order
        ]);

        $notify[] = ['success', 'Dashboard link updated successfully'];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $link = DashboardLink::findOrFail($id);
        $link->delete();

        $notify[] = ['success', 'Dashboard link deleted successfully'];
        return back()->withNotify($notify);
    }

    public function toggleStatus($id)
    {
        $link = DashboardLink::findOrFail($id);
        $link->status = !$link->status;
        $link->save();

        $notify[] = ['success', 'Link status updated successfully'];
        return back()->withNotify($notify);
    }
}
