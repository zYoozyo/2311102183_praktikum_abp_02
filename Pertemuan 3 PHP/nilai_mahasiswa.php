<?php
/*
 * Tugas Pertemuan 3 - PHP: Sistem Penilaian Mahasiswa
 * NIM  : 2311102183
 * Nama : Muhammad Ragiel Prastyo
 */

// Data mahasiswa (array asosiatif)
$dataMahasiswa = [
    ["nama" => "Agus Lapar", "nim" => "123456789", "nilai_tugas" => 85, "nilai_uts" => 78, "nilai_uas" => 80],
    ["nama" => "Budi Kupret", "nim" => "234567890", "nilai_tugas" => 60, "nilai_uts" => 55, "nilai_uas" => 50],
    ["nama" => "Citra Lotion", "nim" => "345678901", "nilai_tugas" => 92, "nilai_uts" => 88, "nilai_uas" => 95],
    ["nama" => "Dina Dimana", "nim" => "456789012", "nilai_tugas" => 70, "nilai_uts" => 65, "nilai_uas" => 72],
    ["nama" => "Ucup Kecup", "nim" => "567890123", "nilai_tugas" => 45, "nilai_uts" => 50, "nilai_uas" => 40],
];

// Function: hitung nilai akhir dengan bobot Tugas 30%, UTS 35%, UAS 35%
function hitungNilaiAkhir($tugas, $uts, $uas)
{
    return round(($tugas * 0.30) + ($uts * 0.35) + ($uas * 0.35), 2);
}

// Function: tentukan grade dari nilai akhir
function tentukanGrade($nilai)
{
    if ($nilai >= 85)
        return "A";
    elseif ($nilai >= 75)
        return "B";
    elseif ($nilai >= 65)
        return "C";
    elseif ($nilai >= 50)
        return "D";
    else
        return "E";
}

// Function: tentukan status lulus atau tidak
function tentukanStatus($nilai)
{
    return ($nilai >= 60) ? "Lulus" : "Tidak Lulus";
}

// Proses data menggunakan loop foreach
$hasilMahasiswa = [];
$kumpulanNilai = [];

foreach ($dataMahasiswa as $mhs) {
    $nilaiAkhir = hitungNilaiAkhir($mhs["nilai_tugas"], $mhs["nilai_uts"], $mhs["nilai_uas"]);
    $hasilMahasiswa[] = [
        "nama" => $mhs["nama"],
        "nim" => $mhs["nim"],
        "nilai_tugas" => $mhs["nilai_tugas"],
        "nilai_uts" => $mhs["nilai_uts"],
        "nilai_uas" => $mhs["nilai_uas"],
        "nilai_akhir" => $nilaiAkhir,
        "grade" => tentukanGrade($nilaiAkhir),
        "status" => tentukanStatus($nilaiAkhir),
    ];
    $kumpulanNilai[] = $nilaiAkhir;
}

// Hitung statistik kelas
$jumlahMahasiswa = count($kumpulanNilai);
$rataRata = round(array_sum($kumpulanNilai) / $jumlahMahasiswa, 2);
$nilaiTertinggi = max($kumpulanNilai);

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penilaian Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .wrapper {
            max-width: 900px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .info-box {
            background-color: #eaf4fb;
            border-left: 4px solid #3498db;
            padding: 10px 14px;
            font-size: 13px;
            color: #333;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        /* Kartu statistik */
        .stats {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-box {
            flex: 1;
            background-color: #f0f8ff;
            border: 1px solid #b8d9f0;
            border-radius: 6px;
            padding: 14px;
            text-align: center;
        }

        .stat-box .label {
            font-size: 12px;
            color: #666;
            margin-bottom: 6px;
        }

        .stat-box .value {
            font-size: 26px;
            font-weight: bold;
            color: #2c3e50;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        table caption {
            font-weight: bold;
            font-size: 15px;
            text-align: left;
            padding-bottom: 8px;
            color: #2c3e50;
        }

        table th {
            background-color: #3498db;
            color: white;
            padding: 10px 12px;
            text-align: center;
        }

        table td {
            padding: 9px 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #eef6fd;
        }

        /* Status */
        .lulus {
            color: #27ae60;
            font-weight: bold;
        }

        .tidak-lulus {
            color: #e74c3c;
            font-weight: bold;
        }

        /* Grade */
        .grade {
            font-weight: bold;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <h2>Sistem Penilaian Mahasiswa</h2>
        <p class="subtitle">Tugas Pertemuan 3 &mdash; PHP &nbsp;|&nbsp; NIM: 2311102183 &nbsp;|&nbsp; Muhammad Ragiel
            Prastyo</p>

        <div class="info-box">
            <strong>Rumus:</strong> Nilai Akhir = (Tugas &times; 30%) + (UTS &times; 35%) + (UAS &times; 35%)
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <strong>Lulus</strong> jika Nilai Akhir &ge; 60
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <strong>Grade:</strong> A(&ge;85) &nbsp; B(&ge;75) &nbsp; C(&ge;65) &nbsp; D(&ge;50) &nbsp; E(&lt;50)
        </div>

        <!-- Statistik Kelas -->
        <div class="stats">
            <div class="stat-box">
                <div class="label">Jumlah Mahasiswa</div>
                <div class="value"><?= $jumlahMahasiswa ?></div>
            </div>
            <div class="stat-box">
                <div class="label">Rata-rata Kelas</div>
                <div class="value"><?= $rataRata ?></div>
            </div>
            <div class="stat-box">
                <div class="label">Nilai Tertinggi</div>
                <div class="value"><?= $nilaiTertinggi ?></div>
            </div>
        </div>

        <!-- Tabel Data Mahasiswa -->
        <table>
            <caption>Data Nilai Mahasiswa</caption>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Nilai Tugas</th>
                    <th>Nilai UTS</th>
                    <th>Nilai UAS</th>
                    <th>Nilai Akhir</th>
                    <th>Grade</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($hasilMahasiswa as $hasil):
                    $statusClass = ($hasil["status"] === "Lulus") ? "lulus" : "tidak-lulus";
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td style="text-align:left"><?= htmlspecialchars($hasil["nama"]) ?></td>
                        <td><?= htmlspecialchars($hasil["nim"]) ?></td>
                        <td><?= $hasil["nilai_tugas"] ?></td>
                        <td><?= $hasil["nilai_uts"] ?></td>
                        <td><?= $hasil["nilai_uas"] ?></td>
                        <td><strong><?= $hasil["nilai_akhir"] ?></strong></td>
                        <td class="grade"><?= $hasil["grade"] ?></td>
                        <td class="<?= $statusClass ?>"><?= $hasil["status"] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="footer">
            &copy; <?= date("Y") ?> &mdash; Sistem Penilaian Mahasiswa &mdash; Tugas PHP Pertemuan 3
        </div>

    </div>

</body>

</html>