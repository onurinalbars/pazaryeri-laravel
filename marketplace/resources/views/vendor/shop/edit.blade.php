@extends('layouts.vendor')

@section('page-title', 'Shop Settings')

@section('content')
    <section class="rounded-2xl bg-white p-6 shadow">
        <div class="flex flex-col gap-2">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Brand profile</p>
            <h1 class="text-2xl font-semibold text-gray-900">Update shop information</h1>
            <p class="text-sm text-gray-500">Keep your storefront details consistent across the marketplace.</p>
        </div>

        <form method="POST" action="{{ route('vendor.shop.update') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 md:grid-cols-2">
                <label class="text-sm font-semibold text-gray-700">
                    Shop name
                    <input type="text" name="name" value="{{ old('name', $shop->name) }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                </label>
                <label class="text-sm font-semibold text-gray-700">
                    Public slug
                    <input type="text" name="slug" value="{{ old('slug', $shop->slug) }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                    <span class="mt-1 block text-xs text-gray-400">Used in the shop URL ({{ url('/magaza/'.$shop->slug) }}).</span>
                </label>
            </div>

            <label class="block text-sm font-semibold text-gray-700">
                Description
                <textarea name="description" rows="4" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $shop->description) }}</textarea>
            </label>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-gray-700">
                        Logo (square)
                        <input type="file" name="logo" class="mt-1 w-full rounded-lg border border-dashed border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                    </label>
                    @if($shop->logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($shop->logo) }}" alt="Shop logo" class="mt-3 h-20 w-20 rounded-full border border-gray-200 object-cover">
                    @endif
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">
                        Banner (1200 x 300)
                        <input type="file" name="banner" class="mt-1 w-full rounded-lg border border-dashed border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                    </label>
                    @if($shop->banner)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($shop->banner) }}" alt="Shop banner" class="mt-3 h-24 w-full rounded-xl border border-gray-200 object-cover">
                    @endif
                </div>
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold text-gray-600">
                <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" @checked(old('is_active', $shop->is_active))>
                Shop is active and visible
            </label>

            <div class="flex justify-end">
                <button type="submit" class="rounded-full bg-emerald-600 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Save changes</button>
            </div>
        </form>
    </section>
@endsection
