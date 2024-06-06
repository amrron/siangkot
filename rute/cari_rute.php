<?php
// File: search_route.php

// Baca file JSON
$json_data = file_get_contents('../data/lintasan.json');
$rute_angkot = json_decode($json_data, true);

// Ambil parameter wilayah dari request
$wilayah_dicari = isset($_GET['wilayah']) ? $_GET['wilayah'] : '';
$hasil_pencarian = [];

// Cari rute angkot yang melalui wilayah yang dicari
if ($wilayah_dicari !== '') {
    foreach ($rute_angkot as $nomor => $data) {
        foreach ($data['lintasan'] as $lintasan) {
            if (stripos($lintasan, $wilayah_dicari) !== false) {
                $hasil_pencarian[$nomor] = $data;
                break; // Hentikan pencarian setelah menemukan kecocokan pertama untuk rute ini
            }
        }
    }
}

if (!isset($_GET['wilayah']) || $_GET['wilayah'] == '') {
    $hasil_pencarian = $rute_angkot;
}

// Kirim hasil pencarian dalam format JSON
header('Content-Type: application/json');
echo json_encode($hasil_pencarian);
?>
