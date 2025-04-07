<?php
$token = "7256740443:AAH2UBv6zdoBzqCp6rbnzbTel3uCiAum6sU"; // Bot token
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (isset($update["callback_query"])) {
    $callback = $update["callback_query"];
    $data = $callback["data"];
    $chat_id = $callback["message"]["chat"]["id"];

    list($action, $id_pengajuan) = explode(":", $data);

    if ($action === "setujui") {
        // Minta jumlah dari admin
        $text = "Masukkan jumlah pinjaman untuk ID #$id_pengajuan:\nKetik: `/jumlah_{$id_pengajuan}_1000000` (contoh)";
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'Markdown'
        ]));
    } elseif ($action === "tolak") {
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            'chat_id' => $chat_id,
            'text' => "Pengajuan #$id_pengajuan *DITOLAK*.",
            'parse_mode' => 'Markdown'
        ]));

        // Update status pengajuan di database (kalau ada DB)
    }
}

if (isset($update["message"]["text"])) {
    $text = $update["message"]["text"];
    if (preg_match('/\/jumlah_(\d+)_(\d+)/', $text, $match)) {
        $id_pengajuan = $match[1];
        $jumlah = $match[2];

        // Di sini update DB kalau pakai database

        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            'chat_id' => $update["message"]["chat"]["id"],
            'text' => "Pengajuan #$id_pengajuan *DISETUJUI* dengan jumlah Rp " . number_format($jumlah, 0, ',', '.'),
            'parse_mode' => 'Markdown'
        ]));
    }
}
?>
