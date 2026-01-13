<?php
session_start();
date_default_timezone_set('America/La_Paz');

$token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
$admin_id = "7621351319"; 
$pass_maestra = "EmpresaPrivada2026";
$db_file = 'zeta_database.json';

if (!file_exists($db_file)) { file_put_contents($db_file, json_encode(['tickets' => []])); }

function enviarTelegram($msg, $foto = null) {
    global $token, $admin_id;
    $url = "https://api.telegram.org/bot$token/" . ($foto ? "sendPhoto" : "sendMessage");
    $data = ['chat_id' => $admin_id, ($foto ? 'caption' : 'text') => $msg, 'parse_mode' => 'Markdown'];
    if ($foto) { $data['photo'] = new CURLFile(realpath($foto)); }
    $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch); curl_close($ch);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if ($accion == 'login') {
        if ($_POST['p'] === $pass_maestra) {
            $_SESSION['zeta_auth'] = true; 
            $_SESSION['agente'] = $_POST['n'];
            
            $ip = $_SERVER['REMOTE_ADDR'];
            $bat = $_POST['bat'] ?? '??';
            $loc = $_POST['loc'] ?? 'No permitida';
            
            $reporte = "🔱 *ZETA HACKS: SESIÓN INICIADA*\n\n";
            $reporte .= "👤 *Agente:* `{$_POST['n']}`\n";
            $reporte .= "🌐 *IP:* `{$ip}`\n";
            $reporte .= "🔋 *Bat:* `{$bat}%` 🔋\n";
            $reporte .= "📍 *Ubicación:* [{$loc}](https://www.google.com/maps?q={$loc})";
            
            enviarTelegram($reporte);
            echo "ok";
        } else { echo "error"; }
    }

    if ($accion == 'subir_pago') {
        $id = "ZETA-" . strtoupper(substr(md5(time()), 0, 6));
        $ruta = "uploads/".$id.".jpg";
        if (!is_dir('uploads')) mkdir('uploads', 0777, true);
        move_uploaded_file($_FILES['comprobante']['tmp_name'], $ruta);
        
        $db = json_decode(file_get_contents($db_file), true);
        $db['tickets'][$id] = ['status' => 'PENDIENTE', 'agente' => $_SESSION['agente'], 'pais' => $_POST['pais']];
        file_put_contents($db_file, json_encode($db));
        
        $msg = "📢 *PAGO ENVIADO*\n🆔 ID: `{$id}`\n👤 Agente: `{$_SESSION['agente']}`\n🌍 País: `{$_POST['pais']}`\n📦 Producto: `{$_POST['monto']}`";
        enviarTelegram($msg, $ruta);
        echo $id;
    }

    if ($accion == 'verificar_ticket') {
        $db = json_decode(file_get_contents($db_file), true);
        echo $db['tickets'][$_POST['id']]['status'] ?? 'PENDIENTE';
    }
    exit;
}
?>
