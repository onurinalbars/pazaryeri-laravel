<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Platform Admin',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'vendor_status' => null,
            ]
        );

        $categoryNames = [
            'Elektronik' => ['Telefonlar', 'Bilgisayarlar'],
            'Moda' => ['Kadın', 'Erkek'],
            'Ev & Yaşam' => ['Mobilya', 'Mutfak'],
        ];

        $categories = collect();
        foreach ($categoryNames as $parent => $children) {
            $parentCategory = Category::create([
                'name' => $parent,
                'slug' => Str::slug($parent),
                'is_active' => true,
            ]);
            $categories->push($parentCategory);

            foreach ($children as $child) {
                $categories->push(Category::create([
                    'name' => $child,
                    'slug' => Str::slug($child),
                    'parent_id' => $parentCategory->id,
                    'is_active' => true,
                ]));
            }
        }

        $vendors = collect([
            ['name' => 'DoğaMix', 'email' => 'vendor1@example.com'],
            ['name' => 'Dora Dijital', 'email' => 'vendor2@example.com'],
        ])->map(function ($data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => User::ROLE_VENDOR,
                    'vendor_status' => User::VENDOR_STATUS_APPROVED,
                ]
            );

            return Shop::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(4)),
                    'description' => $data['name'].' için örnek açıklama.',
                    'is_active' => true,
                ]
            );
        });

        foreach ($vendors as $shop) {
            foreach (range(1, 3) as $i) {
                Product::create([
                    'shop_id' => $shop->id,
                    'category_id' => $categories->random()->id,
                    'name' => $shop->name." Ürün {$i}",
                    'slug' => Str::slug($shop->name." product {$i}").'-'.Str::random(4),
                    'description' => 'Şık ve kaliteli bir ürün.',
                    'price' => rand(150, 900),
                    'stock' => rand(5, 30),
                    'is_active' => true,
                ]);
            }

            foreach (range(1, 2) as $i) {
                Listing::create([
                    'user_id' => $shop->owner->id,
                    'shop_id' => $shop->id,
                    'category_id' => $categories->random()->id,
                    'title' => $shop->name." İlan {$i}",
                    'slug' => Str::slug($shop->name." ilan {$i}").'-'.Str::random(4),
                    'description' => 'İkinci el durumunda, temiz kullanılmıştır.',
                    'price' => rand(200, 750),
                    'location' => 'İstanbul',
                    'is_active' => true,
                ]);
            }
        }

        Slider::create([
            'title' => 'Çok Kanallı Pazaryeri',
            'subtitle' => 'Binlerce ürün, tek platformda.',
            'image_path' => 'https://via.placeholder.com/1200x500.png?text=Slider',
            'link_url' => '/',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Banner::create([
            'title' => 'Yıl Sonu Kampanyası',
            'image_path' => 'https://via.placeholder.com/600x300.png?text=Banner',
            'link_url' => '/',
            'position' => 'home_top',
            'is_active' => true,
        ]);

        $customer = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('password'),
                'role' => User::ROLE_USER,
                'vendor_status' => null,
            ]
        );

        $firstShop = $vendors->first();
        if ($firstShop) {
            $product = $firstShop->products()->first();

            if ($product) {
                $order = Order::create([
                    'user_id' => $customer->id,
                    'shop_id' => $firstShop->id,
                    'total_amount' => $product->price * 2,
                    'status' => 'processing',
                    'payment_status' => 'paid',
                    'transaction_id' => Str::upper(Str::random(12)),
                    'shipping_address' => [
                        'full_name' => 'Demo Customer',
                        'phone' => '+90 555 111 22 33',
                        'address' => 'İstiklal Cd. No:5',
                        'city' => 'İstanbul',
                    ],
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => 2,
                    'price' => $product->price,
                ]);
            }
        }
    }
}
