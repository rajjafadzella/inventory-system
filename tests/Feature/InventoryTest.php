<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase; // Membersihkan database otomatis setelah selesai ditest

    protected function setUp(): void
    {
        parent::setUp();

        // Siapkan data Role bawaan untuk testing
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Staff']);
        Role::create(['name' => 'Manager']);
    }

    /**
     * Uji apakah Admin/Staff bisa menambahkan barang baru.
     */
    public function test_admin_can_create_product(): void
    {
        // 1. Buat user dengan role Admin
        $adminRole = Role::where('name', 'Admin')->first();
        $admin = User::factory()->create(['role_id' => $adminRole->id]);

        // 2. Buat Kategori
        $category = Category::create(['name' => 'Elektronik']);

        // 3. Kirim request POST untuk simpan barang
        $response = $this->actingAs($admin)->post('/products', [
            'code' => 'BRG-001',
            'name' => 'Laptop ThinkPad',
            'category_id' => $category->id,
            'stock' => 10,
            'location' => 'Gudang A',
            'condition' => 'Bagus',
        ]);

        // 4. Pastikan diarahkan kembali ke halaman list barang (redirect)
        $response->assertRedirect('/products');

        // 5. Pastikan data barang masuk ke database
        $this->assertDatabaseHas('products', [
            'code' => 'BRG-001',
            'name' => 'Laptop ThinkPad',
            'stock' => 10,
        ]);
    }

    /**
     * Uji apakah stok berkurang saat peminjaman dilakukan.
     */
    public function test_borrowing_decrements_product_stock(): void
    {
        // 1. Buat user Admin untuk login, dan user Staff/Anggota sebagai peminjam
        $adminRole = Role::where('name', 'Admin')->first();
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $member = User::factory()->create(['role_id' => Role::where('name', 'Staff')->first()->id]);

        // 2. Buat barang dengan stok awal 5
        $category = Category::create(['name' => 'Elektronik']);
        $product = Product::create([
            'code' => 'BRG-002',
            'name' => 'Mouse Logitech',
            'category_id' => $category->id,
            'stock' => 5,
            'location' => 'Gudang B',
            'condition' => 'Bagus',
        ]);

        // 3. Lakukan peminjaman sebanyak 2 unit
        $response = $this->actingAs($admin)->post('/borrowings', [
            'user_id' => $member->id,
            'product_id' => $product->id,
            'qty' => 2,
            'borrow_date' => now()->format('Y-m-d'),
        ]);

        // 4. Pastikan transaksi sukses (redirect)
        $response->assertRedirect('/borrowings');

        // 5. Pastikan stok barang berkurang dari 5 menjadi 3 di database
        $this->assertEquals(3, $product->fresh()->stock);
    }
}
