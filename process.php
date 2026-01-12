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

function notify($msg) {
    global $token, $admin_id;
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = ['chat_id' => $admin_id, 'text' => $msg, 'parse_mode' => 'Markdown'];
    $options = ['http' => ['method' => 'POST', 'header' => "Content-type: application/x-www-form-urlencoded\r\n", 'content' => http_build_query($data)]];
    @file_get_contents($url, false, stream_context_create($options));
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == 'login') {
        $p = trim($_POST['p']); $n = trim($_POST['n']);
        if ($p === $pass_maestra || $p === $admin_id) {
            $_SESSION['zeta_auth'] = true; $_SESSION['agente'] = $n;
            notify("🟢 *ZETA HACKS ONLINE*\n👤 Agente: `$n` conectado.");
            echo "ok";
        } else { echo "err"; }
    }
    if ($action == 'log_copy' && isset($_SESSION['zeta_auth'])) {
        notify("📋 *REPORTE COTIZACIÓN*\n👤 Agente: `{$_SESSION['agente']}`\n\n" . $_POST['info']);
    }
    if ($action == 'log_ticket' && isset($_SESSION['zeta_auth'])) {
        $nueva_venta = [
            'f' => date('d/m H:i'),
            'a' => $_SESSION['agente'],
            'c' => $_POST['c'],
            'p' => $_POST['p'],
            'm' => $_POST['m']
        ];
        array_unshift($db['ventas'], $nueva_venta);
        if(count($db['ventas']) > 50) array_pop($db['ventas']);
        file_put_contents($db_file, json_encode($db));
        notify("🎫 *VENTA REGISTRADA*\n👤 Agente: `{$_SESSION['agente']}`\n👤 Cliente: `{$_POST['c']}`\n💰 Total: `{$_POST['m']}`");
    }
    if ($action == 'get_history') {
        echo json_encode($db['ventas']);
    }
    exit;
}
if (isset($_GET['logout'])) { session_destroy(); header("Location: index.php"); exit; }
?>
