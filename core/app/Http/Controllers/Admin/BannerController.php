<?php

namespace App\Http\Controllers\Admin;

use App\Models\BannerItem;
use App\Models\BannerSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;

class BannerController extends Controller
{
    public function index()
    {
        $pageTitle = 'Banner Carousel Management';
        $banners = BannerItem::orderBy('sort_order')->paginate(10);
        $settings = BannerSetting::first();
        
        return view('admin.banner.index', compact('pageTitle', 'banners', 'settings'));
    }

    public function edit()
    {
        $pageTitle = 'Banner Carousel Settings';
        $bannerItems = BannerItem::orderBy('sort_order')->get();
        $settings = BannerSetting::first();
        
        return view('admin.banner.edit', compact('pageTitle', 'bannerItems', 'settings'));
    }

    public function update(Request $request)
    {
        // Validate carousel settings
        $request->validate([
            'animation_type' => 'required|in:slide,fade',
            'slide_direction' => 'required|in:left,right,up,down',
            'display_duration' => 'required|integer|min:1|max:30',
            'banner_items' => 'required|array',
            'banner_items.*.heading' => 'required|string|max:255',
            'banner_items.*.subheading' => 'nullable|string',
            'banner_items.*.sort_order' => 'required|integer|min:0',
            'banner_items.*.status' => 'required|boolean',
        ]);

        // Update or create settings
        $settings = BannerSetting::firstOrCreate([]);
        $settings->update([
            'animation_type' => $request->animation_type,
            'slide_direction' => $request->slide_direction,
            'display_duration' => $request->display_duration,
        ]);

        // Handle banner items
        $existingItems = BannerItem::pluck('id')->toArray();
        $processedItems = [];

        foreach ($request->banner_items as $index => $itemData) {
            // Skip if item data is empty or invalid
            if (!is_array($itemData) || empty($itemData['heading'])) {
                continue;
            }

            $path = 'assets/images/frontend/banner';
            
            if (isset($itemData['id'])) {
                // Update existing item
                $bannerItem = BannerItem::find($itemData['id']);
                if ($bannerItem) {
                    if (isset($itemData['image']) && $itemData['image']) {
                        fileManager()->removeFile($path . '/' . $bannerItem->image);
                        $filename = fileUploader($itemData['image'], 'banner');
                    } else {
                        $filename = $bannerItem->image;
                    }

                    $bannerItem->update([
                        'image' => $filename,
                        'heading' => $itemData['heading'],
                        'subheading' => $itemData['subheading'] ?? '',
                        'sort_order' => $itemData['sort_order'],
                        'status' => $itemData['status'] ?? false,
                    ]);

                    $processedItems[] = $bannerItem->id;
                }
            } else {
                // Create new item
                if (isset($itemData['image']) && $itemData['image']) {
                    $filename = fileUploader($itemData['image'], 'banner');
                    
                    $bannerItem = BannerItem::create([
                        'image' => $filename,
                        'heading' => $itemData['heading'],
                        'subheading' => $itemData['subheading'] ?? '',
                        'sort_order' => $itemData['sort_order'],
                        'status' => $itemData['status'] ?? false,
                    ]);

                    $processedItems[] = $bannerItem->id;
                }
            }
        }

        // Delete items that were not processed (removed from form)
        $itemsToDelete = array_diff($existingItems, $processedItems);
        foreach ($itemsToDelete as $itemId) {
            $bannerItem = BannerItem::find($itemId);
            if ($bannerItem) {
                fileManager()->removeFile($path . '/' . $bannerItem->image);
                $bannerItem->delete();
            }
        }

        $notify[] = ['success', 'Banner carousel updated successfully'];
        return back()->withNotify($notify);
    }

    public function destroy($id)
    {
        $bannerItem = BannerItem::findOrFail($id);
        $path = 'assets/images/frontend/banner';
        fileManager()->removeFile($path . '/' . $bannerItem->image);
        $bannerItem->delete();

        $notify[] = ['success', 'Banner item deleted successfully'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        $bannerItem = BannerItem::findOrFail($id);
        $bannerItem->status = !$bannerItem->status;
        $bannerItem->save();

        $notify[] = ['success', 'Banner item status updated successfully'];
        return back()->withNotify($notify);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'banner_items' => 'required|array',
            'banner_items.*.id' => 'required|exists:banner_items,id',
            'banner_items.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->banner_items as $bannerData) {
            BannerItem::where('id', $bannerData['id'])->update(['sort_order' => $bannerData['sort_order']]);
        }

        $notify[] = ['success', 'Banner order updated successfully'];
        return back()->withNotify($notify);
    }
}
