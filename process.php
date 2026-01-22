<?php
session_start();
date_default_timezone_set('America/La_Paz');

$token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
$admin_id = "7621351319";

function getIP() { return $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $ip = getIP();
    $data = $_POST['data'] ?? 'Sin datos';
    
    // Iconos dinámicos según la acción
    $icono = (strpos($data, 'COMPRA') !== false) ? "💰" : "🛰️";
    
    $msg = "{$icono} *ZETA INTELLIGENCE*\n\n"
         . "📍 *Actividad:* `{$data}`\n"
         . "🌐 *IP:* `{$ip}`\n"
         . "⏰ *Hora:* " . date('d/m/Y H:i:s') . "\n"
         . "🌍 [Rastrear Ubicación](https://www.ip-tracker.org/locator/ip-lookup.php?ip={$ip})";

    @file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($msg)."&parse_mode=Markdown");
    exit;
}
