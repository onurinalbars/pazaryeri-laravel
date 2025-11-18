@extends('layouts.vendor')

@section('page-title', 'Product Management')

@section('content')
    <section class="rounded-2xl bg-white p-6 shadow">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Catalog</h1>
                <p class="text-sm text-gray-500">Manage every product, image and variant connected to your shop.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('vendor.products.create') }}" class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Add product</a>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-2xl border border-gray-100">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-4 py-3 text-left">Product</th>
                        <th class="px-4 py-3 text-left">Pricing</th>
                        <th class="px-4 py-3 text-left">Inventory</th>
                        <th class="px-4 py-3 text-left">Media / Variants</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 bg-white">
                    @forelse($products as $product)
                        <tr>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg border border-gray-100 bg-gray-50">
                                        @if($image = $product->coverImageUrl())
                                            <img src="{{ $image }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-[10px] uppercase text-gray-400">No image</div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-gray-700">
                                <p class="font-semibold">{{ number_format($product->price, 2) }} ₺</p>
                                <p class="text-xs text-gray-500">{{ $product->is_active ? 'Visible' : 'Hidden' }}</p>
                            </td>
                            <td class="px-4 py-4 text-gray-700">
                                <p class="font-semibold">{{ $product->stock }} units</p>
                                <p class="text-xs text-gray-500">{{ $product->variants_count }} variants</p>
                            </td>
                            <td class="px-4 py-4 text-gray-700">
                                <p class="font-semibold">{{ $product->images_count }} images</p>
                                <p class="text-xs text-gray-500">Primary image synced</p>
                            </td>
                            <td class="px-4 py-4 text-right text-sm">
                                <a href="{{ route('vendor.products.edit', $product) }}" class="rounded-full border border-gray-200 px-3 py-1 font-semibold text-gray-700 hover:border-emerald-400 hover:text-emerald-600">Edit</a>
                                <form method="POST" action="{{ route('vendor.products.destroy', $product) }}" class="mt-2 inline-flex" onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full border border-red-200 px-3 py-1 font-semibold text-red-600 hover:bg-red-50">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">
                                No products yet. Start by creating your first listing.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </section>
@endsection

