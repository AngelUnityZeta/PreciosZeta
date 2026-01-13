<?php
session_start();
date_default_timezone_set('America/La_Paz');

$token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
$admin_id = "7621351319"; 
$pass_maestra = "EmpresaPrivada2026";

function enviarTelegram($msg, $foto = null) {
    global $token, $admin_id;
    $url = "https://api.telegram.org/bot$token/" . ($foto ? "sendPhoto" : "sendMessage");
    $data = ['chat_id' => $admin_id, ($foto ? 'caption' : 'text') => $msg, 'parse_mode' => 'Markdown'];
    if ($foto) { $data['photo'] = new CURLFile(realpath($foto)); }
    $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch); curl_close($ch);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    if ($_POST['accion'] == 'login') {
        if ($_POST['p'] === $pass_maestra) {
            $_SESSION['zeta_auth'] = true; $_SESSION['agente'] = $_POST['n'];
            $ip = $_SERVER['REMOTE_ADDR'];
            enviarTelegram("🔱 *ZETA HACKS ACCESO*\n👤 Agente: `{$_POST['n']}`\n🌐 IP: `{$ip}`\n🔋 Batería: `{$_POST['bat']}%`\n📱 Disp: `{$_SERVER['HTTP_USER_AGENT']}`");
            echo "ok";
        } else { echo "error"; }
    }
    if ($_POST['accion'] == 'reportar_pago') {
        $id = "ZH-".rand(1000,9999);
        $msg = "📢 *NOTIFICACIÓN DE PAGO*\n🆔 ID: `{$id}`\n👤 Agente: `{$_SESSION['agente']}`\n🌍 Pais: `{$_POST['pais']}`\n📦 Prod: `{$_POST['prod']}`";
        enviarTelegram($msg); echo "ok";
    }
    exit;
}
?>
