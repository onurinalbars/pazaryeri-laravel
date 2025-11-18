@extends('layouts.vendor')

@section('page-title', 'Create Product')

@section('content')
    <section class="rounded-2xl bg-white p-6 shadow">
        <div class="flex flex-col gap-2">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Product Management</p>
            <h1 class="text-2xl font-semibold text-gray-900">Create a new product</h1>
            <p class="text-sm text-gray-500">Add product details, upload gallery images, and configure variants before publishing.</p>
        </div>

        <form method="POST" action="{{ route('vendor.products.store') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
            @csrf
            @include('vendor.products._form')

            <div class="flex flex-wrap justify-end gap-3">
                <a href="{{ route('vendor.products.index') }}" class="rounded-full border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-700 hover:border-gray-300">Cancel</a>
                <button type="submit" class="rounded-full bg-emerald-600 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Save product</button>
            </div>
        </form>
    </section>
@endsection
