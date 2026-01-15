<?php
session_start();
// Solo tú entras con este enlace: zeta-master.php?access=7621351319
if (@$_GET['access'] !== "7621351319") { header("Location: index.php"); exit; }
include 'process.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>SISTEMA CENTRAL | ZETA</title>
    <style>
        body { background: #000; color: #00ff41; font-family: 'Orbitron', sans-serif; padding: 40px; text-align: center; }
        .panel { border: 2px solid #1a1a1a; padding: 30px; background: #050505; display: inline-block; border-radius: 20px; }
        table { border-collapse: collapse; margin-top: 20px; width: 400px; }
        td, th { border: 1px solid #222; padding: 15px; }
    </style>
</head>
<body>
    <h1>🔱 TERMINAL DE CONTROL ZETA</h1>
    <div class="panel">
        <h3>AGENTES ENCRIPTADOS EN CÓDIGO</h3>
        <table>
            <tr><th>AGENTE</th><th>USER</th><th>PASS</th></tr>
            <?php foreach($agentes as $a): ?>
            <tr><td><?= $a['n'] ?></td><td><?= $a['u'] ?></td><td><?= $a['p'] ?></td></tr>
            <?php endforeach; ?>
        </table>
        <p style="font-size: 0.7rem; color: #444; margin-top: 20px;">Para modificar agentes, edita directamente 'process.php' en GitHub.</p>
    </div>
</body>
</html>
