<?php
include('../koneksi.php');

// Fungsi kirimWA yang lebih robust
function kirimWA($nomor, $pesan) {
    $config = [
        'api_url' => 'https://api.fonnte.com/send',
        'token' => 'VnNbhmFAwwLUAum3v9RV'
    ];

    $data = [
        'target' => $nomor,
        'message' => $pesan,
        'delay' => '2-5',
        'countryCode' => '62'
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $config['api_url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "Authorization: " . $config['token'],
            "Content-Type: application/json"
        ],
        CURLOPT_TIMEOUT => 15
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    // Log hasil pengiriman
    $log_message = date('[Y-m-d H:i:s]') . " | Nomor: $nomor | ";
    $log_message .= $error ? "Error: $error" : "Response: $response";
    
    file_put_contents('../wa_notification.log', $log_message . PHP_EOL, FILE_APPEND);
    
    return !$error;
}

// Proses pengecekan absensi
$tanggal = date('Y-m-d');
$query = mysqli_prepare($coneksi, 
    "SELECT s.id_siswa, s.nama_siswa, s.no_wa, a.jam_masuk 
     FROM siswa s
     LEFT JOIN absen a ON s.id_siswa = a.id_siswa AND a.tanggal = ?");
mysqli_stmt_bind_param($query, "s", $tanggal);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);

while ($row = mysqli_fetch_assoc($result)) {
    $no_wa = preg_replace('/[^0-9]/', '', $row['no_wa']);
    
    if (empty($no_wa)) continue;
    
    if (is_null($row['jam_masuk'])) {
        // Belum absen
        $pesan = "📢 Hi {$row['nama_siswa']}, Anda belum absen hari ini ($tanggal). Segera lakukan absen!";
        kirimWA($no_wa, $pesan);
    } elseif ($row['jam_masuk'] > '08:00:00') {
        // Terlambat
        $pesan = "⚠️ {$row['nama_siswa']}, Anda terlambat absen (jam {$row['jam_masuk']}). Jangan diulangi lagi!";
        kirimWA($no_wa, $pesan);
    }
}
?>