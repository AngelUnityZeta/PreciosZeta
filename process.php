<?php
session_start();
date_default_timezone_set('America/La_Paz');

$token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
$admin_id = "7621351319";

function getIP() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
    elseif (isset($_SERVER['HTTP_CLIENT_IP'])) { $ip = $_SERVER['HTTP_CLIENT_IP']; }
    return $ip;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $ip = getIP();
    
    if ($_POST['accion'] == 'login') {
        $_SESSION['zeta_auth'] = true;
        $_SESSION['agente'] = $_POST['n'];
        
        $msg = "🛰 *SISTEMA DE ACCESO ZETA HACKS*\n";
        $msg .= "────────────────────\n";
        $msg .= "👤 *AGENTE:* `{$_POST['n']}`\n";
        $msg .= "🌐 *IP:* `{$ip}`\n";
        $msg .= "📅 *FECHA:* " . date('d/m/Y') . "\n";
        $msg .= "⏰ *HORA:* " . date('H:i:s') . "\n";
        $msg .= "────────────────────";
        
        @file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($msg)."&parse_mode=Markdown");
        echo "ok";
    }
    
    if ($_POST['accion'] == 'comprobante' && isset($_FILES['foto'])) {
        $agente = $_SESSION['agente'] ?? 'Desconocido';
        $caption = "📥 *NUEVO COMPROBANTE RECIBIDO*\n";
        $caption .= "👤 *ENVIADO POR:* `{$agente}`\n";
        $caption .= "🌐 *IP ORIGEN:* `{$ip}`";
        
        $foto = $_FILES['foto']['tmp_name'];
        $url = "https://api.telegram.org/bot$token/sendPhoto";
        $post_fields = [
            'chat_id' => $admin_id,
            'photo' => new CURLFile($foto),
            'caption' => $caption,
            'parse_mode' => 'Markdown'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
        echo "ok";
    }
    exit;
}
?>
    
