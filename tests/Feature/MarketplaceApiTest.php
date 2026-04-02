<?php

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Profiles;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

function createUser(array $overrides = []): User
{
    return User::query()->create(array_merge([
        'name' => 'User Test',
        'email' => 'user'.uniqid().'@example.com',
        'password' => 'secret123',
        'role' => 'user',
    ], $overrides));
}

// Anggota 1 - Modul User & Profile

test('post users creates new user', function () {
    $payload = [
        'name' => 'Budi',
        'email' => 'budi@example.com',
        'password' => 'secret123',
        'role' => 'user',
    ];

    $response = $this->postJson('/api/users', $payload);

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.data.email', 'budi@example.com');
});

test('get users returns list', function () {
    createUser(['email' => 'list-user@example.com']);

    $response = $this->getJson('/api/users');

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => ['data'],
        ]);
});

test('get user by id returns user detail', function () {
    $user = createUser(['email' => 'detail-user@example.com']);

    $response = $this->getJson("/api/users/{$user->id}");

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.id', $user->id);
});

test('post profiles creates profile', function () {
    $user = createUser(['email' => 'profile-create@example.com']);

    $response = $this->postJson('/api/profiles', [
        'user_id' => $user->id,
        'name' => 'Budi Santoso',
        'address' => 'Jakarta',
        'phone' => '08123456789',
    ]);

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.user_id', $user->id);
});

test('get profiles returns list', function () {
    $user = createUser(['email' => 'profile-list@example.com']);
    Profiles::query()->create([
        'user_id' => $user->id,
        'name' => 'Profile A',
        'address' => 'Bandung',
        'phone' => '0811111111',
    ]);

    $response = $this->getJson('/api/profiles');

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => ['data'],
        ]);
});

test('get profile by id returns detail', function () {
    $user = createUser(['email' => 'profile-detail@example.com']);
    $profile = Profiles::query()->create([
        'user_id' => $user->id,
        'name' => 'Profile Detail',
        'address' => 'Yogyakarta',
        'phone' => '0833333333',
    ]);

    $response = $this->getJson("/api/profiles/{$profile->id}");

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.id', $profile->id);
});

test('get users with profiles returns relation data', function () {
    $user = createUser(['email' => 'with-profile@example.com']);
    Profiles::query()->create([
        'user_id' => $user->id,
        'name' => 'Profile Relasi',
        'address' => 'Surabaya',
        'phone' => '0822222222',
    ]);

    $response = $this->getJson('/api/profiles/users');

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);
});

// Anggota 2 - Modul Product

test('post products creates product', function () {
    $user = createUser(['email' => 'product-create@example.com']);

    $response = $this->postJson('/api/products', [
        'user_id' => $user->id,
        'name' => 'Keyboard Mechanical',
        'price' => 250000,
        'stock' => 10,
    ]);

    $response->assertCreated()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.name', 'Keyboard Mechanical');
});

test('get products returns list', function () {
    $user = createUser(['email' => 'product-list@example.com']);
    Product::query()->create([
        'user_id' => $user->id,
        'name' => 'Mouse Wireless',
        'price' => 150000,
        'stock' => 5,
    ]);

    $response = $this->getJson('/api/products');

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);
});

test('get product by id returns detail', function () {
    $user = createUser(['email' => 'product-detail@example.com']);
    $product = Product::query()->create([
        'user_id' => $user->id,
        'name' => 'Headset',
        'price' => 300000,
        'stock' => 7,
    ]);

    $response = $this->getJson("/api/products/{$product->id}");

    $response->assertOk()
        ->assertJsonPath('data.id', $product->id);
});

// Anggota 3 - Modul Category

test('post categories creates category', function () {
    $response = $this->postJson('/api/categories', [
        'name' => 'Fashion',
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.name', 'Fashion');
});

test('get categories returns success', function () {
    Category::query()->create(['name' => 'Elektronik']);

    $response = $this->getJson('/api/categories');

    $response->assertOk()
        ->assertJsonFragment(['name' => 'Elektronik']);
});

test('get category by id returns category', function () {
    $category = Category::query()->create(['name' => 'Olahraga']);

    $response = $this->getJson("/api/categories/{$category->id}");

    $response->assertOk()
        ->assertJsonPath('name', 'Olahraga');
});

test('post categories without name is blocked by middleware', function () {
    $response = $this->postJson('/api/categories', []);

    $response->assertStatus(400)
        ->assertJsonPath('message', 'Nama kategori wajib diisi!');
});

// Anggota 4 - Modul Order & OrderItem

test('post orders creates order with items', function () {
    $user = createUser(['email' => 'order-create@example.com']);
    $product = Product::query()->create([
        'user_id' => $user->id,
        'name' => 'Kursi',
        'price' => 500000,
        'stock' => 10,
    ]);

    $response = $this->postJson('/api/orders', [
        'user_id' => $user->id,
        'items' => [
            [
                'product_id' => $product->id,
                'quantity' => 2,
            ],
        ],
    ]);

    $response->assertCreated()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.user_id', $user->id);
});

test('get orders returns list', function () {
    $user = createUser(['email' => 'order-list@example.com']);
    Order::query()->create([
        'user_id' => $user->id,
        'total_price' => 150000,
    ]);

    $response = $this->getJson('/api/orders');

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);
});

test('get order by id returns detail', function () {
    $user = createUser(['email' => 'order-detail@example.com']);
    $order = Order::query()->create([
        'user_id' => $user->id,
        'total_price' => 200000,
    ]);

    $response = $this->getJson("/api/orders/{$order->id}");

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.id', $order->id);
});

// Anggota 5 - Modul Tag & ProductTag

test('post tags creates tag', function () {
    $response = $this->postJson('/api/tags', [
        'name' => 'Gaming',
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.name', 'Gaming');
});

test('put products tag endpoint attaches tag to product', function () {
    $user = createUser(['email' => 'attach-tag@example.com']);
    $product = Product::query()->create([
        'user_id' => $user->id,
        'name' => 'Monitor',
        'price' => 1200000,
        'stock' => 3,
    ]);
    $tag = Tag::query()->create(['name' => 'Office']);

    $response = $this->putJson("/api/products/{$product->id}/tag/{$tag->id}");

    $response->assertOk()
        ->assertJsonPath('message', 'Tag berhasil ditambahkan ke produk')
        ->assertJsonFragment(['name' => 'Office']);
});

test('get products by id returns product with attached tags', function () {
    $user = createUser(['email' => 'tagged-product@example.com']);
    $product = Product::query()->create([
        'user_id' => $user->id,
        'name' => 'Laptop',
        'price' => 12000000,
        'stock' => 4,
    ]);
    $tag = Tag::query()->create(['name' => 'Baru']);
    $product->tags()->attach($tag->id);

    $response = $this->getJson("/api/products/{$product->id}");

    $response->assertOk()
        ->assertJsonPath('data.id', $product->id)
        ->assertJsonFragment(['name' => 'Baru']);
});
