<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $admin = User::create([
            "username" => "admin",
            "password" => bcrypt("123456")
        ]);

        $barang = [
            [
            'user_id' => 1,
            'nama_barang' => "Lemari Baju",
            "harga" => 400000,
            'tanggal_pembelian' => "2023-10-01"
            ],
            [
                'user_id' => 1,
                'nama_barang' => "Kasur Lipat",
                "harga" => 120000,
                'tanggal_pembelian' => "2023-08-01"
            ],
            [
                'user_id' => 1,
                'nama_barang' => "Speaker",
                "harga" => 200000,
                'tanggal_pembelian' => "2023-01-01"
            ],
            [
                'user_id' => 1,
                'nama_barang' => "Keyboard",
                "harga" => 250000,
                'tanggal_pembelian' => "2023-07-10"
            ],
        ];

        $insert_barang = DB::table('barang')->insert($barang);

        $kriteria = [
            [
                'user_id' => 1,
                'nama_kriteria' => "Harga Barang",
                'deskripsi' => null,
            ],
            [
                'user_id' => 1,
                'nama_kriteria' => "Kondisi Barang",
                'deskripsi' => null,
            ],
            [
                'user_id' => 1,
                'nama_kriteria' => "Tanggal Pembelian",
                'deskripsi' => null,
            ],
            [
                'user_id' => 1,
                'nama_kriteria' => "Kebutuhan Finansial",
                'deskripsi' => null,
            ],
            [
                'user_id' => 1,
                'nama_kriteria' => "Kebutuhan Orang Lain",
                'deskripsi' => null,
            ],
            [
                'user_id' => 1,
                'nama_kriteria' => "Ruang Penyimpanan",
                'deskripsi' => null,
            ],
        ];

        $insert_kriteria = DB::table('kriteria')->insert($kriteria);
    }
}
