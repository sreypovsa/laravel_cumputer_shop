<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    private array $defaultSettings = [
        'store_name' => 'QuickTech Cambodia',
        'store_phone' => '015 646 581 / 012 646 581',
        'store_email' => 'support@cccomputerkh.com',
        'store_address' => 'Phnom Penh, Cambodia',
        'store_telegram' => 'https://t.me/QUICKTECHCAM',
        'aba_account_name' => 'QuickTech Cambodia',
        'aba_account_no' => '001 646 581 (USD)',
        'acleda_account_name' => 'QuickTech Cambodia',
        'acleda_account_no' => '1800-0156-4658 (USD)',
        'wing_account_name' => 'QuickTech Cambodia',
        'wing_account_no' => '0345 8899 (USD)',
        'phnom_penh_shipping' => '1.50',
        'provincial_shipping' => '2.50',
    ];

    public function index(): View
    {
        $dbSettings = Setting::getAll();
        $settings = array_merge($this->defaultSettings, $dbSettings);

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_phone' => 'required|string|max:100',
            'store_email' => 'required|email|max:150',
            'store_telegram' => 'nullable|string|max:255',
            'store_address' => 'required|string|max:255',
            'aba_account_name' => 'nullable|string|max:150',
            'aba_account_no' => 'nullable|string|max:100',
            'acleda_account_name' => 'nullable|string|max:150',
            'acleda_account_no' => 'nullable|string|max:100',
            'wing_account_name' => 'nullable|string|max:150',
            'wing_account_no' => 'nullable|string|max:100',
            'phnom_penh_shipping' => 'required|numeric|min:0',
            'provincial_shipping' => 'required|numeric|min:0',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, (string) $value);
        }

        return redirect()->back()->with('success', 'Store settings and Cambodian banking accounts saved successfully!');
    }
}
