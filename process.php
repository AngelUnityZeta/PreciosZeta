<?php
session_start();
date_default_timezone_set('America/La_Paz');
$file = 'agentes.json';
$token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
$admin_id = "7621351319";

function getIP() {
    return $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $ip = getIP();
    
    if ($_POST['accion'] == 'login') {
        $u = $_POST['u']; 
        $p = $_POST['p'];
        
        @chmod($file, 0666);
        $content = @file_get_contents($file);
        $data = $content ? json_decode($content, true) : [];
        $found = false;

        foreach ($data as $key => $a) {
            if ($a['u'] === $u && $a['p'] === $p) {
                $_SESSION['zeta_auth'] = true;
                $_SESSION['agente'] = $a['n'];
                
                $data[$key]['ip'] = $ip;
                @file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
                
                $msg = "🔱 *LOGIN DETECTADO*\n👤 Agente: `{$a['n']}`\n🌐 IP: `{$ip}`";
                @file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($msg)."&parse_mode=Markdown");
                
                echo "ok";
                $found = true;
                break;
            }
        }
        if(!$found) echo "error";
    }
    
    if ($_POST['accion'] == 'comprobante' && isset($_FILES['foto'])) {
        $ag = $_SESSION['agente'] ?? 'Desconocido';
        $post = [
            'chat_id' => $admin_id,
            'photo' => new CURLFile($_FILES['foto']['tmp_name']),
            'caption' => "📄 *PAGO RECIBIDO*\n👤 Agente: `{$ag}`\n🌐 IP: `{$ip}`",
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

