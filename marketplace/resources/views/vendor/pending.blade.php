@extends('layouts.vendor')

@section('page-title', 'Pending Approval')

@section('content')
    @php($supportEmail = config('mail.from.address', 'support@example.com'))
    <section class="rounded-2xl bg-white p-8 text-center shadow">
        <div class="mx-auto max-w-2xl space-y-4">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v4m0 4h.01M3.404 5.318a2.25 2.25 0 0 1 1.924-1.068h13.344a2.25 2.25 0 0 1 1.924 1.068l2.652 4.42a2.25 2.25 0 0 1 0 2.325l-2.652 4.42a2.25 2.25 0 0 1-1.924 1.068H5.328a2.25 2.25 0 0 1-1.924-1.068L.752 12.063a2.25 2.25 0 0 1 0-2.325l2.652-4.42Z" />
                </svg>
            </div>
            <h1 class="text-3xl font-semibold text-gray-900">Your vendor account is under review</h1>
            <p class="text-sm text-gray-600">
                Thanks for submitting your shop information. Our marketplace team reviews each vendor to keep the catalog high-quality.
                You can prepare products and update settings, but sales and order management will unlock once we approve your shop.
            </p>
            <div class="rounded-xl border border-dashed border-amber-200 bg-amber-50 px-4 py-3 text-left text-sm text-amber-900">
                <p class="font-semibold">What happens next?</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    <li>Admins verify your business details and catalog readiness.</li>
                    <li>We'll email {{ auth()->user()->email }} as soon as a decision is made.</li>
                    <li>Need to speed things up? Contact support with any missing documents.</li>
                </ul>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('vendor.dashboard') }}" class="rounded-full border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-700 hover:border-gray-300">Back to dashboard</a>
                <a href="mailto:{{ $supportEmail }}" class="rounded-full bg-emerald-600 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Contact support</a>
            </div>
        </div>
    </section>
@endsection
