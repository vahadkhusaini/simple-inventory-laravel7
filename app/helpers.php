<?php

function auto_id($table, $id_table, $first_id){
     // Get the last id
        $lastId = DB::table($table)
        ->select(DB::raw('RIGHT('.$id_table.', 4) AS kode'))
        ->latest($id_table)->first();
        $kode = $lastId == null ? 1 : intval($lastId->kode)+1;

        $kode_akhir = str_pad($kode, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0

        return $auto_kode = $first_id.$kode_akhir;
}