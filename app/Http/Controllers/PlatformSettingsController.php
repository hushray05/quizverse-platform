<?php

namespace App\Http\Controllers;

use App\Models\PlatformSetting;
use App\Services\AuditService;
use Illuminate\Http\Request;

class PlatformSettingsController extends Controller
{
    public function index()
    {
        $settingsByGroup = PlatformSetting::all()->groupBy('group');
        return view('pages.admin.settings.index', compact('settingsByGroup'));
    }

    public function update(Request $request)
    {
        $settings = $request->input('settings', []);

        foreach ($settings as $key => $value) {
            $setting = PlatformSetting::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => (string) $value]);
            }
        }

        AuditService::log('platform_settings_updated', 'warning', 'PlatformSetting', null, [
            'updated_keys' => array_keys($settings),
        ]);

        return back()->with('success', 'Platform settings applied and committed to runtime configuration.');
    }
}
