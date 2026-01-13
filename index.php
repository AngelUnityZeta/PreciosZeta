<?php include 'process.php'; $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | SYSTEM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Rajdhani:wght@500;700&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #050505; --card: #111; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; overflow-x: hidden; }
        
        /* EFECTO DE ESCANEO */
        body::after { content: ""; position: fixed; top: 0; left: 0; width: 100%; height: 2px; background: rgba(0, 255, 65, 0.1); z-index: 10000; animation: scan 3s linear infinite; pointer-events: none; }
        @keyframes scan { 0% { top: 0; } 100% { top: 100%; } }

        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 20000; display: flex; align-items: center; justify-content: center; flex-direction: column; }
        .login-box { width: 85%; max-width: 350px; padding: 30px; border: 1px solid var(--p); border-radius: 15px; text-align: center; background: #000; }
        
        header { position: fixed; top: 0; width: 100%; height: 60px; background: #000; border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 10000; }
        .titulo-zeta { font-family: 'Orbitron'; color: var(--p); text-shadow: 0 0 10px var(--p); font-size: 1.5rem; }

        .container { padding: 80px 20px 40px; min-height: 100vh; box-sizing: border-box; }
        .titulo-seccion { text-align: center; font-family: 'Orbitron'; font-size: 2.2rem; color: #fff; margin-bottom: 30px; text-transform: uppercase; }

        /* LISTA VERTICAL DE PAISES */
        .lista-paises { display: flex; flex-direction: column; gap: 15px; max-width: 500px; margin: 0 auto; }
        .card-pais { background: var(--card); border: 1px solid #222; padding: 25px; border-radius: 12px; display: flex; align-items: center; cursor: pointer; border-left: 6px solid #333; transition: 0.3s; }
        .card-pais:active { transform: scale(0.95); border-left-color: var(--p); background: #1a1a1a; }
        .card-pais i { font-size: 24px; color: var(--p); margin-right: 20px; }
        .card-pais b { font-size: 1.3rem; letter-spacing: 2px; }

        /* DETALLE DE PRECIOS */
        .tarjeta { background: var(--card); border: 1px solid #333; padding: 18px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid var(--p); }
        .metodos-pago { background: rgba(0,255,65,0.05); border: 1px dashed var(--p); padding: 15px; border-radius: 10px; margin-bottom: 25px; color: var(--s); font-weight: bold; }
        .btn-subir { background: var(--p); color: #000; border: none; padding: 15px; border-radius: 8px; font-family: 'Orbitron'; font-weight: 900; width: 100%; cursor: pointer; margin-top: 15px; box-shadow: 0 0 10px var(--p); }

        /* MODAL VALIDACIÓN */
        #modal-v { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.98); z-index:30000; align-items:center; justify-content:center; text-align:center; padding:30px; }
        .loader { border: 4px solid #111; border-top: 4px solid var(--p); border-radius: 50%; width: 60px; height: 60px; animation: spin 1s linear infinite; margin: 0 auto 20px; }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        input { width: 100%; padding: 15px; margin-bottom: 12px; background: #0a0a0a; border: 1px solid #333; color: var(--p); border-radius: 8px; font-family: 'Rajdhani'; font-size: 1.1rem; }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-box">
        <h2 class="titulo-zeta">ZETA HACKS</h2>
        <input type="password" id="m_pass" placeholder="CLAVE MAESTRA">
        <input type="text" id="m_user" placeholder="NOMBRE DE AGENTE">
        <button class="btn-subir" onclick="entrar()">ENTRAR AL SISTEMA</button>
    </div>
</div>

<header><div class="titulo-zeta">ZETA HACKS</div></header>

<div id="pantalla-inicio" class="container">
    <h1 class="titulo-seccion">PRECIOS PARA</h1>
    <div class="lista-paises" id="lista-p"></div>
</div>

<div id="pantalla-detalle" class="container" style="display:none;">
    <button onclick="irInicio()" style="background:none; border:none; color:var(--p); font-size:1.2rem; cursor:pointer; margin-bottom:20px;"><i class="fa fa-arrow-left"></i> VOLVER AL MENÚ</button>
    <div id="contenido-pais"></div>
</div>

<div id="modal-v">
    <div id="v-pendiente">
        <div class="loader"></div>
        <h2 style="color:var(--p); font-family:'Orbitron';">VALIDANDO PAGO...</h2>
        <p>Esperando confirmación del Comandante Zeta en Telegram.</p>
    </div>
    <div id="v-exito" style="display:none;">
        <i class="fa fa-check-circle" style="font-size: 80px; color: var(--p);"></i>
        <h2 style="color:var(--p); font-family:'Orbitron'; margin:20px 0;">¡PAGO ACEPTADO!</h2>
        <p style="font-size: 1.3rem; color:#fff;">"El comprobante de pago ha sido válido, pide la KEY para que se la des al cliente"</p>
        <button class="btn-subir" onclick="location.reload()">FINALIZAR</button>
    </div>
</div>

<script>
const DATA = {
    paises: ["ARGENTINA","BOLIVIA","BRASIL","CHILE","COLOMBIA","ECUADOR","ESPANA","USA","GUATEMALA","HONDURAS","MEXICO","NICARAGUA","PANAMA","PARAGUAY","PERU","DOMINICANA","VENEZUELA"],
    tasas: {
        "ARGENTINA": {t:1500, c:"ARS", m:"💳 MERCADO PAGO: oscar.hs.m"},
        "BOLIVIA": {t:12, c:"BS", m:"📌 QR SOPORTE (Tasa: 12.00)"},
        "BRASIL": {t:5.5, c:"BRL", m:"🟢 PIX: 91991076791"},
        "CHILE": {t:980, c:"CLP", m:"🏪 BANCO ESTADO: 23.710.151-0 (Xavier Fuenzalida)"},
        "COLOMBIA": {t:4300, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078"},
        "MEXICO": {t:20, c:"MXN", m:"🏦 ALBO / NU OXXO: 5101 2506 8691 9389 (Tasa 20)"},
        "PERU": {t:3.78, c:"PEN", m:"🟣 Yape/Plin: 954302258"},
        "VENEZUELA": {t:45, c:"VED", m:"🟡 Pago Móvil: 0102 32958486 04125805981"},
        "ESPANA": {t:1, c:"EUR", m:"💶 Bizum: 634033557 (Yanni Hernández)"},
        "USA": {t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"},
        "ECUADOR": {t:1, c:"USD", m:"🟨 Banco Pichincha: 2207195565"},
        "GUATEMALA": {t:7.8, c:"GTQ", m:"🟩 Banrural: 4431164091"},
        "HONDURAS": {t:24.7, c:"HNL", m:"🔵 Bampais: 216400100524"},
        "NICARAGUA": {t:36.5, c:"NIO", m:"🏦 BAC: 371674409"},
        "PANAMA": {t:1, c:"USD", m:"🟣 Zinli: chauran2001@gmail.com"},
        "PARAGUAY": {t:7600, c:"PYG", m:"🏦 Itau: 300406285"},
        "DOMINICANA": {t:60, c:"DOP", m:"🟦 Banreservas: 9601546622"}
    },
    productos: [
        {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
        {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,18]},
        {n:"CUBAN MODS", d:[1,10,20,31], p:[3,9,13,19]},
        {n:"BR MODS + VIRTUAL", d:[1,7,15,30], p:[6,12,19,28]},
        {n:"BR MODS MOBILE", d:[1,7,15,30], p:[3,8,12,19]},
        {n:"PANEL IOS", d:[7,30], p:[12,19]},
        {n:"CUBAN PANEL PC", d:[1,7,30,"PERM"], p:[3,8,16,25]}
    ]
};

function hablar(t){ const s=new SpeechSynthesisUtterance(t); s.lang='es-ES'; s.rate=0.9; window.speechSynthesis.speak(s); }

// Renderizar Países
const listaH = document.getElementById('lista-p');
DATA.paises.forEach(p => {
    listaH.innerHTML += `<div class="card-pais" onclick="verDetalle('${p}')"><i class="fa fa-terminal"></i><b>${p}</b></div>`;
});

function verDetalle(p) {
    hablar("Accediendo a precios de " + p);
    document.getElementById('pantalla-inicio').style.display = 'none';
    document.getElementById('pantalla-detalle').style.display = 'block';
    
    const info = DATA.tasas[p] || {t:1, c:"USD", m:"Soporte"};
    let html = `<div class="metodos-pago">💳 MÉTODOS ${p}:<br>${info.m.replace(/\n/g,'<br>')}</div>`;
    
    DATA.productos.forEach(prod => {
        html += `<div class="tarjeta"><h3>💎 ${prod.n}</h3><div style="border-top:1px solid #333; padding-top:10px;">`;
        prod.d.forEach((dia, i) => {
            let precioLocal = Math.ceil(prod.p[i] * info.t);
            html += `<div style="display:flex; justify-content:space-between; margin-bottom:5px;"><span>✅ ${dia} ${isNaN(dia)?'':'DÍAS'}</span> <b>${precioLocal} ${info.c}</b></div>`;
        });
        html += `</div><button class="btn-subir" style="font-size:0.8rem;" onclick="subirPago('${prod.n}','${p}')">SUBIR PAGO</button></div>`;
    });
    document.getElementById('contenido-pais').innerHTML = html;
}

function irInicio() { document.getElementById('pantalla-detalle').style.display='none'; document.getElementById('pantalla-inicio').style.display='block'; }

function subirPago(prod, p) {
    const input = document.createElement('input'); input.type = 'file'; input.accept = 'image/*';
    input.onchange = async e => {
        const file = e.target.files[0]; if(!file) return;
        hablar("Comprobante enviado. Espere validación.");
        document.getElementById('modal-v').style.display = 'flex';
        
        const fd = new FormData(); fd.append('accion','subir_pago'); fd.append('comprobante', file); fd.append('pais', p);
        const res = await fetch('process.php', {method:'POST', body:fd});
        const tid = await res.text();

        const check = setInterval(async () => {
            const fd2 = new FormData(); fd2.append('accion','verificar_ticket'); fd2.append('id',tid);
            const r = await fetch('process.php', {method:'POST', body:fd2});
            if(await r.text() === 'APROBADO') {
                clearInterval(check); hablar("Pago aprobado. Solicita la llave.");
                document.getElementById('v-pendiente').style.display = 'none';
                document.getElementById('v-exito').style.display = 'block';
            }
        }, 4000);
    };
    input.click();
}

async function entrar() {
    const fd = new FormData(); fd.append('accion','login'); fd.append('p',document.getElementById('m_pass').value); fd.append('n',document.getElementById('m_user').value);
    const r = await fetch('process.php', {method:'POST', body:fd});
    if(await r.text() === 'ok') { hablar("Bienvenido Comandante"); location.reload(); } else alert("ACCESO DENEGADO");
}
</script>
</body>
</html>
    
