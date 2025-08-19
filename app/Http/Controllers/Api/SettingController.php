<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function getSheetUrl()
    {
        $url = Setting::getValue('google_sheet_url', '');
        return response()->json(['url' => $url]);
    }

    public function setSheetUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
        ]);
        Setting::setValue('google_sheet_url', $request->url);
        return response()->json(['message' => 'URL saved']);
    }
}
