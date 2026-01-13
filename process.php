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
            $ip = $_SERVER['REMOTE_ADDR'];
            $msg = "🔱 *ZETA HACKS: ACCESO CONCEDIDO*\n👤 Agente: `{$_POST['n']}`\n🌐 IP: `{$ip}`\n📅 Fecha: ".date('d/m/Y H:i');
            file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$admin_id&text=".urlencode($msg)."&parse_mode=Markdown");
            echo "ok";
        } else { echo "error"; }
    }
    exit;
}
?>
