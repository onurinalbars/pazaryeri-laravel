@extends('layouts.vendor')

@section('page-title', 'Başvurunuz İnceleniyor')

@section('content')
    @if(session('status'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
            {{ session('status') }}
        </div>
    @endif
    <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-6 shadow">
        <h2 class="text-xl font-semibold text-gray-900">Vendor hesabınız onay bekliyor</h2>
        <p class="mt-2 text-sm text-gray-700">
            Başvurunuz admin ekibimize iletildi. Onaylandığında size e-posta ile bilgi verilecek ve paneldeki tüm özellikleri kullanabileceksiniz.
        </p>
        <p class="mt-4 text-sm text-gray-600">
            Bu arada mağaza bilgilerinizi hazırlamaya devam edebilirsiniz. Güncelleme yapmak için <a href="{{ route('vendor.shop.edit') }}" class="font-semibold text-emerald-700 hover:underline">mağaza ayarlarını</a> düzenleyebilirsiniz.
        </p>
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('home') }}" class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-emerald-700 shadow hover:bg-emerald-50">Anasayfaya Dön</a>
            <span class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-800">
                Başvuru Durumu: Beklemede
            </span>
        </div>
    </div>
@endsection
