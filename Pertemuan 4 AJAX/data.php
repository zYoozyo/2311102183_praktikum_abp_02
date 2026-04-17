<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$profil = [
    'nama' => 'Muhammad Ragiel Prastyo',
    'pekerjaan' => 'Design Graphic',
    'lokasi' => 'Purwokerto'
];

echo json_encode($profil);
?>