<?php
session_start();
date_default_timezone_set('America/La_Paz');

$token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
$admin_id = "7621351319"; 
$pass_maestra = "EmpresaPrivada2026";
$db_file = 'zeta_core_v12.json';

if(!file_exists($db_file)) {
    file_put_contents($db_file, json_encode(['ventas' => [], 'accesos' => []]));
}
$db = json_decode(file_get_contents($db_file), true);

// 🔍 FUNCIÓN MAESTRA PARA CAPTURAR IP REAL EN RENDER/PROXYS
function obtenerIP() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function enviarTelegram($msg) {
    global $token, $admin_id;
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = ['chat_id' => $admin_id, 'text' => $msg, 'parse_mode' => 'Markdown'];
    $options = ['http' => ['method' => 'POST', 'header' => "Content-type: application/x-www-form-urlencoded\r\n", 'content' => http_build_query($data)]];
    @file_get_contents($url, false, stream_context_create($options));
}

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $ip_cliente = obtenerIP(); // <--- Capturamos la IP aquí
    
    if ($accion == 'login') {
        $p = trim($_POST['p']); $n = trim($_POST['n']);
        if ($p === $pass_maestra || $p === $admin_id) {
            $_SESSION['zeta_auth'] = true; $_SESSION['agente'] = $n;
            
            // Notificación con IP y ubicación aproximada
            $msg = "🟢 *ZETA HACKS ONLINE*\n";
            $msg .= "👤 *Agente:* `$n` ha iniciado sesión.\n";
            $msg .= "🌐 *IP:* `{$ip_cliente}`\n";
            $msg .= "🔗 *Link:* [Rastrear IP](https://ip-api.com/#{$ip_cliente})";
            
            enviarTelegram($msg);
            echo "ok";
        } else { 
            // Reportar intento fallido con IP
            enviarTelegram("⚠️ *INTENTO DE ACCESO DENEGADO*\n🌐 *IP:* `{$ip_cliente}`\n🔑 *Clave usada:* `{$p}`");
            echo "error"; 
        }
    }
    
    if ($accion == 'reportar_copiado' && isset($_SESSION['zeta_auth'])) {
        enviarTelegram("📋 *REPORTE DE COTIZACIÓN*\n👤 Agente: `{$_SESSION['agente']}`\n🌐 IP: `{$ip_cliente}`\n\n" . $_POST['info']);
    }
    
    if ($accion == 'registrar_ticket' && isset($_SESSION['zeta_auth'])) {
        $nueva_venta = [
            'fecha' => date('d/m H:i'),
            'agente' => $_SESSION['agente'],
            'cliente' => $_POST['c'],
            'producto' => $_POST['p'],
            'monto' => $_POST['m'],
            'ip' => $ip_cliente
        ];
        array_unshift($db['ventas'], $nueva_venta);
        file_put_contents($db_file, json_encode($db));
        enviarTelegram("🎫 *VENTA REGISTRADA*\n👤 Agente: `{$_SESSION['agente']}`\n👤 Cliente: `{$_POST['c']}`\n💰 Total: `{$_POST['m']}`\n🌐 IP: `{$ip_cliente}`");
    }
    
    if ($accion == 'obtener_historial') {
        echo json_encode($db['ventas']);
    }
    exit;
}
if (isset($_GET['salir'])) { session_destroy(); header("Location: index.php"); exit; }
?>
