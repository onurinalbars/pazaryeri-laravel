<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Settings\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function __construct(private readonly SettingService $settings)
    {
    }

    public function editSite()
    {
        $defaults = [
            'title' => config('app.name', 'Marketplace'),
            'logo_path' => null,
            'meta_description' => '',
            'meta_keywords' => '',
        ];

        $site = $this->settings->get('site', $defaults) + $defaults;

        return view('admin.settings.site', compact('site'));
    }

    public function updateSite(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $site = $this->settings->get('site', [
            'title' => config('app.name', 'Marketplace'),
            'logo_path' => null,
            'meta_description' => '',
            'meta_keywords' => '',
        ]);

        if ($request->hasFile('logo')) {
            if (! empty($site['logo_path'])) {
                Storage::disk('public')->delete($site['logo_path']);
            }

            $site['logo_path'] = $request->file('logo')->store('site', 'public');
        }

        $site['title'] = $data['title'];
        $site['meta_description'] = $data['meta_description'] ?? '';
        $site['meta_keywords'] = $data['meta_keywords'] ?? '';

        $this->settings->put('site', $site);

        return back()->with('success', 'Site ayarları güncellendi.');
    }

    public function editPayment()
    {
        $defaults = [
            'provider' => 'iyzico',
            'merchant_id' => '',
            'terminal_id' => '',
            'api_key' => '',
            'secret_key' => '',
            'callback_url' => config('app.url') . '/webhook/payment',
            'test_mode' => true,
        ];

        $payment = $this->settings->get('payment', $defaults) + $defaults;

        return view('admin.settings.payment', compact('payment'));
    }

    public function updatePayment(Request $request)
    {
        $data = $request->validate([
            'provider' => ['required', 'string', 'max:120'],
            'merchant_id' => ['nullable', 'string', 'max:255'],
            'terminal_id' => ['nullable', 'string', 'max:255'],
            'api_key' => ['nullable', 'string', 'max:255'],
            'secret_key' => ['nullable', 'string', 'max:255'],
            'callback_url' => ['nullable', 'url', 'max:255'],
            'test_mode' => ['nullable', 'boolean'],
        ]);

        $data['test_mode'] = $request->boolean('test_mode');

        $this->settings->put('payment', $data);

        return back()->with('success', 'Ödeme ayarları kaydedildi.');
    }
}
