<?php
session_start();
date_default_timezone_set('America/La_Paz');

$token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
$admin_id = "7621351319";
$pass_maestra = "EmpresaPrivada2026";

function getIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    return $_SERVER['REMOTE_ADDR'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $ip = getIP();
    
    if ($_POST['accion'] == 'login') {
        if ($_POST['p'] === $pass_maestra) {
            $_SESSION['zeta_auth'] = true;
            $_SESSION['agente'] = $_POST['n'];
            $msg = "🔱 *SISTEMA ZETA: ACCESO DETECTADO*\n👤 *AGENTE:* `{$_POST['n']}`\n🌐 *IP:* `{$ip}`\n⏰ *HORA:* " . date('H:i:s');
            @file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($msg)."&parse_mode=Markdown");
            echo "ok";
        }
    }
    
    if ($_POST['accion'] == 'comprobante' && isset($_FILES['foto'])) {
        $agente = $_SESSION['agente'] ?? 'Desconocido';
        $caption = "📸 *PAGO RECIBIDO*\n👤 *DE:* `{$agente}`\n🌐 *ORIGEN:* `{$ip}`";
        $foto = $_FILES['foto']['tmp_name'];
        
        $ch = curl_init("https://api.telegram.org/bot$token/sendPhoto");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'chat_id' => $admin_id,
            'photo' => new CURLFile($foto),
            'caption' => $caption,
            'parse_mode' => 'Markdown'
        ]);
        curl_exec($ch);
        curl_close($ch);
        echo "ok";
    }
    exit;
}
?>
