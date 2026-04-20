<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\WebsiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        $settings = WebsiteSetting::current();

        return view('contact', [
            'settings' => $settings,
            'mapsEmbedUrl' => config('site.google_maps_embed_url'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $serviceKeys = ['branding', 'identity', 'campaign', 'packaging', 'digital', 'other'];

        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'message' => ['required', 'string', 'max:5000'],
            'services' => ['nullable', 'array'],
            'services.*' => ['string', Rule::in($serviceKeys)],
        ])->validate();

        $services = array_values(array_intersect($validated['services'] ?? [], $serviceKeys));
        unset($validated['services']);

        $preface = '';
        if ($services !== []) {
            $labels = array_map(fn (string $key) => __('site.contact_service_'.$key), $services);
            $preface = __('site.contact_services_prefix').implode(', ', $labels)."\n\n";
        }

        ContactMessage::query()->create([
            ...$validated,
            'message' => $preface.$validated['message'],
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->route('contact')
            ->with('status', __('site.contact_success'));
    }
}
