<?php
session_start();
$file = 'agentes.json';

// SEGURIDAD: Solo tú entras con tu Telegram ID como llave en la URL
// Ejemplo: tu-sitio.com/admin.php?key=7621351319
if (!isset($_SESSION['zeta_master'])) {
    if (@$_GET['key'] === "7621351319") {
        $_SESSION['zeta_master'] = true;
    } else {
        die("🛰️ [ZETA-SHIELD]: ACCESO RESTRINGIDO. IDENTIFÍQUESE.");
    }
}

$data = json_decode(file_get_contents($file), true);

// Lógica para añadir/eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $data[] = [
            "u" => $_POST['u'], 
            "p" => $_POST['p'], 
            "n" => $_POST['n'], 
            "w" => $_POST['w'], 
            "ip" => "Nunca"
        ];
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }
    if (isset($_POST['del'])) {
        array_splice($data, $_POST['id'], 1);
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }
    header("Location: admin.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZETA | TERMINAL ADMIN</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&display=swap');
        body { background: #020202; color: #00ff41; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        h1 { font-family: 'Orbitron'; text-shadow: 0 0 15px #00ff41; text-align: center; }
        .card { background: #0a0a0a; border: 1px solid #1a1a1a; padding: 25px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 0 20px rgba(0,255,65,0.1); }
        input { background: #000; border: 1px solid #333; color: #00ff41; padding: 12px; margin: 8px 0; width: 100%; border-radius: 5px; box-sizing: border-box; }
        input:focus { border-color: #00ff41; outline: none; }
        button { background: #00ff41; color: #000; border: none; padding: 15px; width: 100%; border-radius: 5px; font-weight: 900; font-family: 'Orbitron'; cursor: pointer; transition: 0.3s; }
        button:hover { background: #fff; box-shadow: 0 0 20px #fff; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #050505; }
        th, td { padding: 15px; border-bottom: 1px solid #1a1a1a; text-align: left; }
        th { font-family: 'Orbitron'; color: #888; font-size: 0.8rem; }
        .status-on { color: #00f2ff; font-family: monospace; }
        .btn-del { background: #ff003c; color: #fff; padding: 8px; width: auto; font-size: 0.7rem; }
    </style>
</head>
<body>
    <div class="container">
        <h1>SISTEMA DE GESTIÓN ZETA</h1>
        
        <div class="card">
            <h3>🛡️ ALTA DE NUEVO AGENTE</h3>
            <form method="POST">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <input type="text" name="u" placeholder="Usuario (Login)" required>
                    <input type="text" name="p" placeholder="Contraseña" required>
                    <input type="text" name="n" placeholder="Nombre Completo" required>
                    <input type="text" name="w" placeholder="WhatsApp (Con código)" required>
                </div>
                <button type="submit" name="add" style="margin-top: 15px;">DESPLEGAR AGENTE</button>
            </form>
        </div>

        <div class="card">
            <h3>📊 MONITOREO DE FUERZAS</h3>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>AGENTE</th>
                            <th>USUARIO</th>
                            <th>PASSWORD</th>
                            <th>ÚLTIMA IP ACCESO</th>
                            <th>ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data as $id => $a): ?>
                        <tr>
                            <td><b><?= $a['n'] ?></b></td>
                            <td>`<?= $a['u'] ?>`</td>
                            <td>`<?= $a['p'] ?>`</td>
                            <td class="status-on"><?= $a['ip'] ?></td>
                            <td>
                                <?php if($a['u'] !== 'admin'): ?>
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <button type="submit" name="del" class="btn-del">ELIMINAR</button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

