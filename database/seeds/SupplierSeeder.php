<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
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

            $supplier_id = auto_id('supplier','supplier_id','SP');

            DB::table('supplier')->insert([
                'supplier_id' => $supplier_id,
                'nama_supplier' => $faker->company,
                'telepon' => $faker->phoneNumber,
                'alamat' => $faker->address,
            ]);

        endfor;
    }
}
