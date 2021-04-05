<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;


$factory->define(\App\Supplier::class, function (Faker $faker) {

       // unique() forces providers to return unique values
        $values = array();
        for ($i = 0; $i < 10; $i++) {
        // get a random digit, but always a new one, to avoid duplicates
        $values []= $faker->unique()->randomDigitNotNull;
        }

        return [
            'supplier_id' => 'SP000'.$values,
            'nama_supplier' => $faker->company,
            'telepon' => $faker->phoneNumber,
            'alamat' => $faker->address,
        ];
});
