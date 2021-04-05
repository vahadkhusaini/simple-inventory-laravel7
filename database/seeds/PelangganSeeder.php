<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PelangganSeeder extends Seeder
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

            $pelanggan_id = auto_id('pelanggan','pelanggan_id','PL');

            DB::table('pelanggan')->insert([
                'pelanggan_id' => $pelanggan_id,
                'nama_pelanggan' => $faker->name,
                'telepon' => $faker->phoneNumber,
                'alamat' => $faker->address,
            ]);

        endfor;
    }
}
