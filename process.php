<?php
session_start();
date_default_timezone_set('America/La_Paz');

$token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
$admin_id = "7621351319";

function getIP() { 
    return $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $ip = getIP();
    
    if ($_POST['accion'] == 'track_client') {
        $info = $_POST['data'];
        $msg = "🛍️ *ZETA STORE: INTERÉS DETECTADO*\n📍 Acción: `{$info}`\n🌐 IP: `{$ip}`\n🌍 Ubicación sugerida por IP: [Ver Mapa](https://www.ip-tracker.org/locator/ip-lookup.php?ip={$ip})";
        @file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($msg)."&parse_mode=Markdown");
    }
    exit;
}
