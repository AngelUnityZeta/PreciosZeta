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
    
    // LOGIN DINÁMICO DESDE JSON
    if ($_POST['accion'] == 'login') {
        $u = $_POST['u']; 
        $p = $_POST['p'];
        $data = json_decode(file_get_contents('agentes.json'), true);
        $found = false;

        foreach ($data as $key => $a) {
            if ($a['u'] === $u && $a['p'] === $p) {
                $_SESSION['zeta_auth'] = true;
                $_SESSION['agente'] = $a['n'];
                
                // Actualizar IP del agente en el JSON
                $data[$key]['ip'] = $ip;
                file_put_contents('agentes.json', json_encode($data, JSON_PRETTY_PRINT));
                
                // Notificar a tu Telegram
                $msg = "🔱 *CONEXIÓN EXITOSA*\n👤 Agente: `{$a['n']}`\n🌐 IP: `{$ip}`\n📱 WA: `{$a['w']}`";
                file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($msg)."&parse_mode=Markdown");
                
                echo "ok";
                $found = true;
                break;
            }
        }
        if(!$found) echo "error";
    }
    
    // ENVÍO DE COMPROBANTES
    if ($_POST['accion'] == 'comprobante' && isset($_FILES['foto'])) {
        $ag = $_SESSION['agente'] ?? 'Desconocido';
        $post = [
            'chat_id' => $admin_id,
            'photo' => new CURLFile($_FILES['foto']['tmp_name']),
            'caption' => "📄 *NUEVO COMPROBANTE*\n👤 Por: `{$ag}`\n🌐 IP: `{$ip}`",
            'parse_mode' => 'Markdown'
        ];
        $ch = curl_init("https://api.telegram.org/bot$token/sendPhoto");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch); curl_close($ch);
        echo "ok";
    }
    exit;
}

