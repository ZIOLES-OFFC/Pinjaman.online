<?php
// Ganti dengan token dan ID kamu
$token = "7256740443:AAH2UBv6zdoBzqCp6rbnzbTel3uCiAum6sU"; // TOKEN BOT
$admin_id = "7799140879"; // ID TELEGRAM ADMIN

$nama = $_POST['nama'];
$tenor = $_POST['tenor'];
$id_pengajuan = rand(1000,9999); // simulasi ID, seharusnya dari DB

$text = "Pengajuan Baru:\nNama: $nama\nTenor: $tenor bulan\nID: $id_pengajuan";

$keyboard = [
  'inline_keyboard' => [
    [
      ['text' => '✅ Setujui', 'callback_data' => "setujui:$id_pengajuan"],
      ['text' => '❌ Tolak', 'callback_data' => "tolak:$id_pengajuan"]
    ]
  ]
];

$data = [
  'chat_id' => $admin_id,
  'text' => $text,
  'reply_markup' => json_encode($keyboard)
];

file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data));

echo "Pengajuan dikirim ke admin Telegram!";
?>
