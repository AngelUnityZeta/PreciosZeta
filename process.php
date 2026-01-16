<?php
session_start();
date_default_timezone_set('America/La_Paz');

$token = "8474739152:AAF8T6-YIonvsmwe6Oc2BX5ePwdLZnwbCAE";
$admin_id = "7621351319";

// 🔱 BASE DE DATOS DE AGENTES (Permanentes en código)
$agentes = [
    ["u" => "admin", "p" => "7621351319", "n" => "ZETA MASTER"],
    ["u" => "vendedor1", "p" => "zeta2026", "n" => "ALPHA_V"],
     ["u" => "Zeta", "p" => "Vergon", "n" => "ZetaGay"],
    // Añade más aquí: ["u" => "usuario", "p" => "clave", "n" => "nombre"],
];

function getIP() { return $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $ip = getIP();
    if ($_POST['accion'] == 'login') {
        foreach ($agentes as $a) {
            if ($a['u'] === $_POST['u'] && $a['p'] === $_POST['p']) {
                $_SESSION['zeta_auth'] = true; $_SESSION['agente'] = $a['n'];
                $msg = "🔱 *ACCESO DETECTADO*\n👤 Agente: `{$a['n']}`\n🌐 IP: `{$ip}`";
                @file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($msg)."&parse_mode=Markdown");
                echo "ok"; exit;
            }
        }
        echo "error";
    }
    if ($_POST['accion'] == 'comprobante' && isset($_FILES['foto'])) {
        $ag = $_SESSION['agente'] ?? 'Desconocido';
        $post = ['chat_id' => $admin_id, 'photo' => new CURLFile($_FILES['foto']['tmp_name']), 'caption' => "📄 *PAGO ZETA*\n👤 Agente: `{$ag}`\n🌐 IP: `{$ip}`", 'parse_mode' => 'Markdown'];
        $ch = curl_init("https://api.telegram.org/bot$token/sendPhoto");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch); curl_close($ch); echo "ok";
    }
    exit;
}

