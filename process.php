<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    if ($_POST['accion'] == 'login') {
        $_SESSION['zeta_auth'] = true;
        $_SESSION['agente'] = $_POST['n'];
        
        $token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
        $admin_id = "7621351319";
        $msg = "🔱 *ZETA HACKS ACCESO*\n👤 Agente: `{$_POST['n']}`\n🌐 IP: `{$_SERVER['REMOTE_ADDR']}`";
        @file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($msg)."&parse_mode=Markdown");
        echo "ok";
    }
    exit;
}
?>
    
