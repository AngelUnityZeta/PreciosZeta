<?php
session_start();
date_default_timezone_set('America/La_Paz');

$token = "7990464918:AAFPoc7EYkZsyQEOntEfF1eC6V-WyBFAkaQ";
$admin_id = "7621351319"; 
$pass_maestra = "EmpresaPrivada2026";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    if ($_POST['accion'] == 'login') {
        if ($_POST['p'] === $pass_maestra) {
            $_SESSION['zeta_auth'] = true; 
            $_SESSION['agente'] = $_POST['n'];
            
            // Envío a Telegram sin que el usuario espere
            $ip = $_SERVER['REMOTE_ADDR'];
            $msg = "🔱 *ZETA HACKS ACCESO*\n👤 Agente: `{$_POST['n']}`\n🌐 IP: `{$ip}`";
            $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($msg)."&parse_mode=Markdown";
            
            // Esto envía el mensaje en segundo plano para no trabar la web
            file_get_contents($url);
            
            echo "ok";
        } else {
            echo "error";
        }
    }
    exit;
}
?>
    
