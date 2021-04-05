<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 50; $i++):

            $barang_id = auto_id('barang','barang_id','BRG');

            DB::table('barang')->insert([
                'barang_id' => $barang_id,
                'barcode' => $faker->isbn13,
                'nama_barang' => 'Barang'.$i,
                'harga_beli' => 0,
                'harga_jual' => 0,
                'stok' => 0,
                'supplier_id' => $faker->numberBetween($min = 1, $max = 50),
            ]);

        endfor;
    }
}
