<?php
session_start();
$file = 'agentes.json';

// Si el archivo no existe, lo creamos con permisos totales
if (!file_exists($file)) {
    file_put_contents($file, json_encode([["u"=>"admin","p"=>"7621351319","n"=>"ADMINISTRADOR","w"=>"59169591926","ip"=>"0.0.0.0"]]));
    chmod($file, 0666);
}

// Seguridad de acceso por URL
if (!isset($_SESSION['zeta_master'])) {
    if (@$_GET['key'] === "7621351319") { $_SESSION['zeta_master'] = true; } 
    else { die("🛰️ [ZETA-SHIELD]: ACCESO REGROUND RESTRINGIDO."); }
}

$data = json_decode(file_get_contents($file), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $data[] = ["u"=>$_POST['u'], "p"=>$_POST['p'], "n"=>$_POST['n'], "w"=>$_POST['w'], "ip"=>"Sin acceso"];
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
<html>
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZETA | ADMIN</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&display=swap');
        body { background: #020202; color: #00ff41; font-family: sans-serif; padding: 15px; }
        .card { background: #0a0a0a; border: 1px solid #1a1a1a; padding: 20px; border-radius: 12px; margin-bottom: 20px; border-top: 3px solid #00ff41; }
        h2 { font-family: 'Orbitron'; text-shadow: 0 0 10px #00ff41; text-align: center; }
        input { background: #000; border: 1px solid #222; color: #00ff41; padding: 12px; margin: 5px 0; width: 100%; box-sizing: border-box; border-radius: 5px; }
        button { background: #00ff41; color: #000; border: none; padding: 12px; width: 100%; border-radius: 5px; font-weight: bold; font-family: 'Orbitron'; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 0.8rem; }
        th, td { border: 1px solid #1a1a1a; padding: 10px; text-align: left; }
        .ip { color: #00f2ff; }
        .del { background: #ff003c; color: #fff; padding: 5px; font-size: 0.6rem; width: auto; }
    </style>
</head>
<body>
    <div style="max-width:800px; margin:auto;">
        <h2>🔱 PANEL DE GESTIÓN ZETA</h2>
        <div class="card">
            <form method="POST">
                <input type="text" name="u" placeholder="Usuario" required>
                <input type="text" name="p" placeholder="Contraseña" required>
                <input type="text" name="n" placeholder="Nombre Real" required>
                <input type="text" name="w" placeholder="WhatsApp" required>
                <button type="submit" name="add">CREAR VENDEDOR</button>
            </form>
        </div>
        <div class="card" style="overflow-x:auto;">
            <table>
                <tr><th>NOMBRE</th><th>USER</th><th>PASS</th><th>IP ACCESO</th><th>ACCIÓN</th></tr>
                <?php foreach($data as $id => $a): ?>
                <tr>
                    <td><?= $a['n'] ?></td>
                    <td><?= $a['u'] ?></td>
                    <td><?= $a['p'] ?></td>
                    <td class="ip"><?= $a['ip'] ?></td>
                    <td>
                        <?php if($a['u'] !== 'admin'): ?>
                        <form method="POST"><input type="hidden" name="id" value="<?= $id ?>"><button type="submit" name="del" class="del">ELIMINAR</button></form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
