<?php
/*
 * ============================================================
 *  PROGRAM: Sistem Penilaian Mahasiswa
 *  Deskripsi: Menampilkan data mahasiswa, menghitung nilai akhir,
 *             menentukan grade, dan status kelulusan.
 * ============================================================
 *
 *  ALUR PROGRAM (Pseudocode):
 *  1. Definisikan data mahasiswa dalam array asosiatif
 *  2. Definisikan fungsi-fungsi pembantu:
 *       - hitungNilaiAkhir()  → hitung nilai dengan bobot
 *       -enentukanGrade()    → tentukan grade A-E dari nilai akhir
 *       - tentukanStatus()    → tentukan Lulus/Tidak Lulus
 *  3. Loop seluruh data mahasiswa → proses tiap mahasiswa
 *  4. Hitung statistik kelas (rata-rata, nilai tertinggi)
 *  5. Tampilkan semua hasil dalam tabel HTML
 * ============================================================
 */

// ============================================================
// BAGIAN 1: DATA MAHASISWA
// Array asosiatif berisi minimal 3 mahasiswa
// ============================================================
$dataMahasiswa = [
    [
        "nama"        => "Andi Pratama",
        "nim"         => "2021001",
        "nilai_tugas" => 85,
        "nilai_uts"   => 78,
        "nilai_uas"   => 80,
    ],
    [
        "nama"        => "Budi Santoso",
        "nim"         => "2021002",
        "nilai_tugas" => 60,
        "nilai_uts"   => 55,
        "nilai_uas"   => 50,
    ],
    [
        "nama"        => "Citra Dewi",
        "nim"         => "2021003",
        "nilai_tugas" => 92,
        "nilai_uts"   => 88,
        "nilai_uas"   => 95,
    ],
    [
        "nama"        => "Dina Rahayu",
        "nim"         => "2021004",
        "nilai_tugas" => 70,
        "nilai_uts"   => 65,
        "nilai_uas"   => 72,
    ],
    [
        "nama"        => "Eka Putra",
        "nim"         => "2021005",
        "nilai_tugas" => 45,
        "nilai_uts"   => 50,
        "nilai_uas"   => 40,
    ],
];

// ============================================================
// BAGIAN 2: FUNGSI — Hitung Nilai Akhir
// Bobot: Tugas 30% | UTS 35% | UAS 35%
// Operator aritmatika: perkalian (*) dan penjumlahan (+)
// ============================================================
function hitungNilaiAkhir($tugas, $uts, $uas) {
    $bobotTugas = 0.30;
    $bobotUTS   = 0.35;
    $bobotUAS   = 0.35;

    // Nilai akhir = (tugas × 30%) + (uts × 35%) + (uas × 35%)
    $nilaiAkhir = ($tugas * $bobotTugas) + ($uts * $bobotUTS) + ($uas * $bobotUAS);

    return round($nilaiAkhir, 2); // Bulatkan 2 desimal
}

// ============================================================
// BAGIAN 3: FUNGSI — Tentukan Grade
// Gunakan if/else untuk membandingkan nilai akhir
// Operator perbandingan: >= (lebih dari sama dengan)
// ============================================================
function tentukanGrade($nilaiAkhir) {
    if ($nilaiAkhir >= 85) {
        return "A";         // Sangat Baik
    } elseif ($nilaiAkhir >= 75) {
        return "B";         // Baik
    } elseif ($nilaiAkhir >= 65) {
        return "C";         // Cukup
    } elseif ($nilaiAkhir >= 50) {
        return "D";         // Kurang
    } else {
        return "E";         // Tidak Lulus
    }
}

// ============================================================
// BAGIAN 4: FUNGSI — Tentukan Status Kelulusan
// Lulus jika nilai akhir >= 60 (grade minimal D ke atas)
// ============================================================
function tentukanStatus($nilaiAkhir) {
    // Operator perbandingan: >= (lebih dari atau sama dengan)
    if ($nilaiAkhir >= 60) {
        return "Lulus";
    } else {
        return "Tidak Lulus";
    }
}

// ============================================================
// BAGIAN 5: PROSES DATA — Loop seluruh mahasiswa
// Hitung nilai akhir, grade, dan status tiap mahasiswa
// Kumpulkan semua nilai akhir untuk statistik kelas
// ============================================================
$hasilMahasiswa  = [];  // Menyimpan hasil olahan tiap mahasiswa
$kumpulanNilai   = [];  // Untuk menghitung statistik kelas

foreach ($dataMahasiswa as $mhs) {
    // Hitung nilai akhir menggunakan fungsi
    $nilaiAkhir = hitungNilaiAkhir(
        $mhs["nilai_tugas"],
        $mhs["nilai_uts"],
        $mhs["nilai_uas"]
    );

    // Tentukan grade dan status
    $grade  = tentukanGrade($nilaiAkhir);
    $status = tentukanStatus($nilaiAkhir);

    // Simpan ke array hasil
    $hasilMahasiswa[] = [
        "nama"        => $mhs["nama"],
        "nim"         => $mhs["nim"],
        "nilai_akhir" => $nilaiAkhir,
        "grade"       => $grade,
        "status"      => $status,
    ];

    // Kumpulkan nilai untuk statistik
    $kumpulanNilai[] = $nilaiAkhir;
}

// ============================================================
// BAGIAN 6: STATISTIK KELAS
// Hitung rata-rata dan nilai tertinggi
// ============================================================
$jumlahMahasiswa = count($kumpulanNilai);                        // Jumlah mahasiswa
$totalNilai      = array_sum($kumpulanNilai);                    // Total semua nilai akhir
$rataRata        = round($totalNilai / $jumlahMahasiswa, 2);     // Rata-rata kelas
$nilaiTertinggi  = max($kumpulanNilai);                          // Nilai tertinggi di kelas

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penilaian Mahasiswa</title>
    <style>
        /* ===== RESET & BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            color: #2d3748;
            padding: 40px 20px;
            min-height: 100vh;
        }

        /* ===== CONTAINER ===== */
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* ===== HEADER ===== */
        .header {
            text-align: center;
            margin-bottom: 36px;
        }
        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1a365d;
            letter-spacing: -0.5px;
        }
        .header p {
            color: #718096;
            margin-top: 6px;
            font-size: 0.95rem;
        }

        /* ===== TABLE CARD ===== */
        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 28px;
        }
        .card-title {
            background: #2b6cb0;
            color: white;
            padding: 14px 24px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead th {
            background: #ebf4ff;
            color: #2b6cb0;
            padding: 14px 18px;
            text-align: left;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            border-bottom: 2px solid #bee3f8;
        }
        tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: background 0.15s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f7fafc; }
        tbody td {
            padding: 14px 18px;
            font-size: 0.92rem;
            vertical-align: middle;
        }

        /* ===== GRADE BADGE ===== */
        .badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .badge-A { background: #c6f6d5; color: #22543d; }
        .badge-B { background: #bee3f8; color: #1a365d; }
        .badge-C { background: #fefcbf; color: #744210; }
        .badge-D { background: #fed7d7; color: #742a2a; }
        .badge-E { background: #e2e8f0; color: #4a5568; }

        /* ===== STATUS BADGE ===== */
        .status-lulus    { color: #276749; font-weight: 600; }
        .status-tidak    { color: #9b2c2c; font-weight: 600; }

        /* ===== NILAI AKHIR ===== */
        .nilai { font-weight: 700; font-size: 1rem; color: #2d3748; }

        /* ===== STATISTIK KELAS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 22px 24px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            border-left: 4px solid #2b6cb0;
        }
        .stat-label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #718096;
            margin-bottom: 6px;
        }
        .stat-value {
            font-size: 1.9rem;
            font-weight: 800;
            color: #1a365d;
            line-height: 1;
        }
        .stat-card:nth-child(2) { border-left-color: #38a169; }
        .stat-card:nth-child(3) { border-left-color: #d69e2e; }

        /* ===== BOBOT INFO ===== */
        .bobot-info {
            background: #ebf4ff;
            border: 1px solid #bee3f8;
            border-radius: 10px;
            padding: 14px 20px;
            margin-bottom: 28px;
            font-size: 0.87rem;
            color: #2b6cb0;
        }
        .bobot-info strong { color: #1a365d; }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            color: #a0aec0;
            font-size: 0.82rem;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h1>📋 Sistem Penilaian Mahasiswa</h1>
        <p>Rekap nilai akhir, grade, dan status kelulusan mahasiswa</p>
    </div>

    <!-- INFO BOBOT PENILAIAN -->
    <div class="bobot-info">
        📌 <strong>Formula Nilai Akhir:</strong>
        (Nilai Tugas × 30%) + (Nilai UTS × 35%) + (Nilai UAS × 35%)
        &nbsp;|&nbsp;
        <strong>Lulus</strong> jika Nilai Akhir ≥ 60
        &nbsp;|&nbsp;
        <strong>Grade:</strong> A ≥85 &nbsp; B ≥75 &nbsp; C ≥65 &nbsp; D ≥50 &nbsp; E &lt;50
    </div>

    <!-- STATISTIK KELAS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Jumlah Mahasiswa</div>
            <div class="stat-value"><?= $jumlahMahasiswa ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Rata-rata Nilai Kelas</div>
            <div class="stat-value"><?= $rataRata ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Nilai Tertinggi Kelas</div>
            <div class="stat-value"><?= $nilaiTertinggi ?></div>
        </div>
    </div>

    <!-- TABEL DATA MAHASISWA -->
    <div class="card">
        <div class="card-title">📊 Data Nilai Mahasiswa</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Nilai Akhir</th>
                    <th>Grade</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // ============================================================
                // BAGIAN 7: TAMPILKAN DATA — Loop hasil mahasiswa ke tabel HTML
                // ============================================================
                $no = 1; // Nomor urut
                foreach ($hasilMahasiswa as $hasil):
                    // Tentukan class CSS untuk status
                    $statusClass = ($hasil["status"] === "Lulus") ? "status-lulus" : "status-tidak";
                    $statusIcon  = ($hasil["status"] === "Lulus") ? "✅" : "❌";

                    // Tentukan class badge grade
                    $gradeClass = "badge badge-" . $hasil["grade"];

                    // Tandai nilai tertinggi
                    $isTertinggi = ($hasil["nilai_akhir"] == $nilaiTertinggi) ? " 🏆" : "";
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><strong><?= htmlspecialchars($hasil["nama"]) ?></strong><?= $isTertinggi ?></td>
                    <td><?= htmlspecialchars($hasil["nim"]) ?></td>
                    <td class="nilai"><?= $hasil["nilai_akhir"] ?></td>
                    <td><span class="<?= $gradeClass ?>"><?= $hasil["grade"] ?></span></td>
                    <td class="<?= $statusClass ?>"><?= $statusIcon ?> <?= $hasil["status"] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">Program Penilaian Mahasiswa &mdash; PHP &copy; <?= date("Y") ?></div>

</div><!-- /container -->

</body>
</html>
