<?php

namespace App\Http\Controllers\Admin;

use App\Models\CarouselSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarouselSettingController extends Controller
{
    public function index()
    {
        $pageTitle = 'Carousel Settings';
        $settings = CarouselSetting::getSettings();
        return view('admin.carousel.settings', compact('pageTitle', 'settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'animation_type' => 'required|in:slide,fade',
            'direction' => 'required|in:left,right,up,down',
            'display_duration' => 'required|integer|min:1|max:60'
        ]);

        $settings = CarouselSetting::getSettings();
        $settings->update($request->all());

        $notify[] = ['success', 'Carousel settings updated successfully'];
        return back()->withNotify($notify);
    }
}