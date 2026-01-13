<?php include 'process.php'; $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | V12</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Rajdhani:wght@500;700&display=swap');
        :root { --p: #00ff41; --bg: #050505; --card: #0d0d0d; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; overflow-x: hidden; }
        
        /* DISEÑO LOGIN */
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 20000; display: flex; align-items: center; justify-content: center; background-image: radial-gradient(circle, #111 1px, transparent 1px); background-size: 20px 20px; }
        .login-box { width: 85%; max-width: 350px; padding: 40px 20px; border: 2px solid var(--p); border-radius: 20px; text-align: center; background: #000; box-shadow: 0 0 40px rgba(0,255,65,0.2); }
        
        /* HEADER */
        header { position: fixed; top: 0; width: 100%; height: 65px; background: #000; border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 10000; box-shadow: 0 5px 15px rgba(0,0,0,0.5); }
        .titulo-zeta { font-family: 'Orbitron'; color: var(--p); text-shadow: 0 0 10px var(--p); font-size: 1.6rem; letter-spacing: 4px; }

        .container { padding: 90px 20px 40px; min-height: 100vh; box-sizing: border-box; display: none; }
        .active { display: block; animation: slideIn 0.4s ease-out; }
        @keyframes slideIn { from { transform: translateX(100px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        .titulo-seccion { text-align: center; font-family: 'Orbitron'; font-size: 2.3rem; color: #fff; margin-bottom: 30px; text-shadow: 2px 2px #00ff4133; }

        /* LISTA VERTICAL PAISES */
        .card-pais { background: var(--card); border: 1px solid #222; padding: 20px; border-radius: 15px; display: flex; align-items: center; cursor: pointer; margin-bottom: 12px; transition: 0.3s; border-left: 5px solid #222; }
        .card-pais:active { background: #1a1a1a; border-left-color: var(--p); transform: scale(0.97); }
        .card-pais span { font-size: 28px; margin-right: 20px; }
        .card-pais b { font-size: 1.4rem; flex-grow: 1; letter-spacing: 1px; }

        /* PRODUCTOS */
        .tarjeta { background: #111; border: 1px solid #333; padding: 20px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.4); }
        .metodos-box { background: rgba(0,255,65,0.05); border: 1px dashed var(--p); padding: 15px; border-radius: 10px; margin-bottom: 25px; color: #00f2ff; font-weight: bold; font-size: 0.95rem; }
        
        .btn-zeta { background: var(--p); color: #000; border: none; padding: 15px; border-radius: 10px; font-family: 'Orbitron'; font-weight: 900; width: 100%; cursor: pointer; margin-top: 10px; transition: 0.2s; box-shadow: 0 5px 0 #008f25; }
        .btn-zeta:active { transform: translateY(3px); box-shadow: none; }
        .btn-copiar { background: transparent; color: var(--p); border: 1px solid var(--p); box-shadow: none; }

        /* MODAL */
        #modal-v { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.98); z-index:30000; align-items:center; justify-content:center; text-align:center; padding:30px; }
        .loader { border: 6px solid #111; border-top: 6px solid var(--p); border-radius: 50%; width: 70px; height: 70px; animation: spin 1s linear infinite; margin: 0 auto 20px; }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        input { width: 100%; padding: 18px; margin-bottom: 15px; background: #0a0a0a; border: 1px solid #333; color: var(--p); border-radius: 12px; font-family: 'Rajdhani'; font-size: 1.2rem; }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-box">
        <h2 class="titulo-zeta">ZETA HACKS</h2>
        <input type="password" id="m_pass" placeholder="CLAVE MAESTRA">
        <input type="text" id="m_user" placeholder="NOMBRE DE AGENTE">
        <button class="btn-zeta" onclick="entrar()">AUTORIZAR INGRESO</button>
    </div>
</div>

<header><div class="titulo-zeta">ZETA HACKS</div></header>

<div id="pantalla-inicio" class="container active">
    <h1 class="titulo-seccion">PRECIOS PARA</h1>
    <div id="lista-p"></div>
</div>

<div id="pantalla-detalle" class="container">
    <button onclick="irInicio()" style="background:none; border:none; color:var(--p); font-size:1.2rem; cursor:pointer; margin-bottom:20px;"><i class="fa fa-arrow-left"></i> VOLVER AL MENÚ</button>
    <div id="contenido-pais"></div>
</div>

<div id="modal-v">
    <div id="v-pendiente">
        <div class="loader"></div>
        <h2 style="color:var(--p); font-family:'Orbitron';">VERIFICANDO PAGO</h2>
        <p>El Comandante Zeta está validando tu captura...</p>
    </div>
    <div id="v-exito" style="display:none;">
        <i class="fa fa-check-circle" style="font-size: 80px; color: var(--p);"></i>
        <h2 style="color:var(--p); font-family:'Orbitron';">¡PAGO VÁLIDO!</h2>
        <p>"El comprobante de pago ha sido válido, pide la KEY para que se la des al cliente"</p>
        <input type="text" id="nombre_c" placeholder="NOMBRE DEL COMPRADOR">
        <button class="btn-zeta" onclick="generarTicket()">GENERAR IMAGEN DE GRACIAS</button>
        <button class="btn-zeta" style="background:#444; color:#fff;" onclick="location.reload()">CERRAR</button>
    </div>
</div>

<canvas id="canvasTicket" width="500" height="700" style="display:none;"></canvas>

<script>
const CONFIG = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS", m:"💳 MERCADO PAGO: oscar.hs.m"},
        {n:"BOLIVIA", b:"🇧🇴", t:12, c:"BS", m:"📌 QR SOPORTE\n💰 Tasa: 12.00 por cada Dólar."},
        {n:"BRASIL", b:"🇧🇷", t:5.5, c:"BRL", m:"🟢 PIX: 91991076791"},
        {n:"CHILE", b:"🇨🇱", t:980, c:"CLP", m:"🏪 Banco Estado: 23710151 (Xavier Fuenzalida)"},
        {n:"COLOMBIA", b:"🇨🇴", t:4300, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu: @PMG3555"},
        {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN", m:"🏦 Albo / Nu México OXXO: 5101 2506 8691 9389\n💰 Tasa: 20.00"},
        {n:"PERU", b:"🇵🇪", t:3.78, c:"PEN", m:"🟣 Yape/Plin: 954302258"},
        {n:"VENEZUELA", b:"🇻🇪", t:45, c:"VED", m:"🟡 Pago Móvil: 0102 32958486 04125805981"},
        {n:"USA", b:"🇺🇸", t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"},
        {n:"ESPANA", b:"🇪🇸", t:1, c:"EUR", m:"💶 Bizum: 634033557 (Yanni Hernández)"},
        {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD", m:"🟨 Banco Pichincha: 2207195565"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.8, c:"GTQ", m:"🟩 Banrural: 4431164091"},
        {n:"HONDURAS", b:"🇭🇳", t:24.7, c:"HNL", m:"🔵 Bampais: 216400100524"},
        {n:"NICARAGUA", b:"🇳🇮", t:36.5, c:"NIO", m:"🏦 BAC: 371674409"},
        {n:"PANAMA", b:"🇵🇦", t:1, c:"USD", m:"🟣 Zinli: chauran2001@gmail.com"},
        {n:"PARAGUAY", b:"🇵🇾", t:7600, c:"PYG", m:"🏦 Banco Itau: 300406285"},
        {n:"DOMINICANA", b:"🇩🇴", t:60, c:"DOP", m:"🟦 Banreservas: 9601546622"}
    ],
    productos: [
        {cat:"ANDROID", items:[
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"CUBAN MODS", d:[1,10,20,31], p:[3,9,13,19]},
            {n:"BR MODS + VIRTUAL", d:[1,7,15,30], p:[6,12,19,28]},
            {n:"BR MODS MOBILE", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"HG CHEATS", d:[1,10,30], p:[3,12,18]},
            {n:"STRICK BR", d:[1,7,15,30], p:[3,8,12,19]}
        ]},
        {cat:"IOS", items:[
            {n:"CERTIFICADOS GBOX", d:["12 MESES"], p:[18]},
            {n:"FLOURITE SOLO", d:[1,7,30], p:[4,16,26]},
            {n:"PANEL IOS", d:[7,30], p:[12,19]}
        ]},
        {cat:"PC", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERMANENTE"], p:[3,8,16,25]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

let ticketData = {};

function hablar(t){ const s=new SpeechSynthesisUtterance(t); s.lang='es-ES'; window.speechSynthesis.speak(s); }

// Iniciar Países
const lista = document.getElementById('lista-p');
CONFIG.paises.forEach(p => {
    lista.innerHTML += `<div class="card-pais" onclick="verDetalle('${p.n}')"><span>${p.b}</span><b>${p.n}</b></div>`;
});

function verDetalle(paisNom) {
    const p = CONFIG.paises.find(x => x.n === paisNom);
    hablar("Precios para " + p.n);
    document.getElementById('pantalla-inicio').classList.remove('active');
    document.getElementById('pantalla-detalle').classList.add('active');
    
    let html = `<div class="metodos-box"><b>MÉTODOS DE PAGO ${p.n}:</b><br>${p.m.replace(/\n/g,'<br>')}</div>`;
    
    CONFIG.productos.forEach(cat => {
        html += `<h2 style="color:var(--p); border-bottom:1px solid #222; margin:30px 0 10px;">🔱 PRODUCTOS ${cat.cat}</h2>`;
        cat.items.forEach(prod => {
            let copyText = `💎 LISTA DE PRECIOS: ${prod.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            let rows = "";
            prod.d.forEach((dia, i) => {
                let precio = Math.ceil(prod.p[i] * p.t);
                let label = dia + (isNaN(dia) ? "" : " DÍAS");
                rows += `<div style="display:flex; justify-content:space-between; margin:5px 0;"><span>✅ ${label}</span> <b>${precio} ${p.c}</b></div>`;
                copyText += `✅ ${label}: ${precio} ${p.c}\n`;
            });

            html += `<div class="tarjeta">
                <h3 style="margin:0 0 10px 0;">💎 ${prod.n}</h3>
                ${rows}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:15px;">
                    <button class="btn-zeta btn-copiar" onclick="copiar('${copyText.replace(/'/g,"\\'")}')">COPIAR</button>
                    <button class="btn-zeta" onclick="subirPago('${prod.n}','${p.n}')">SUBIR PAGO</button>
                </div>
            </div>`;
        });
    });
    document.getElementById('contenido-pais').innerHTML = html;
}

function copiar(t) { navigator.clipboard.writeText(t); hablar("Copiado"); alert("LISTA COPIADA"); }

function subirPago(prod, pais) {
    const input = document.createElement('input'); input.type = 'file'; input.accept = 'image/*';
    input.onchange = async e => {
        const file = e.target.files[0];
        document.getElementById('modal-v').style.display = 'flex';
        ticketData = { prod, pais, agente: "<?= $_SESSION['agente'] ?>", fecha: new Date().toLocaleString() };
        
        const fd = new FormData(); fd.append('accion','subir_pago'); fd.append('comprobante',file); fd.append('pais',pais); fd.append('monto',prod);
        const res = await fetch('process.php', {method:'POST', body:fd});
        const tid = await res.text();

        const loop = setInterval(async () => {
            const fd2 = new FormData(); fd2.append('accion','verificar_ticket'); fd2.append('id',tid);
            const r = await fetch('process.php', {method:'POST', body:fd2});
            if(await r.text() === 'APROBADO') {
                clearInterval(loop);
                hablar("Pago aprobado");
                document.getElementById('v-pendiente').style.display = 'none';
                document.getElementById('v-exito').style.display = 'block';
            }
        }, 4000);
    };
    input.click();
}

function generarTicket() {
    const cliente = document.getElementById('nombre_c').value || "CLIENTE VIP";
    const cv = document.getElementById('canvasTicket');
    const ctx = cv.getContext('2d');

    ctx.fillStyle = "#000"; ctx.fillRect(0,0,500,700);
    ctx.strokeStyle = "#00ff41"; ctx.lineWidth = 15; ctx.strokeRect(10,10,480,680);
    
    ctx.fillStyle = "#00ff41"; ctx.font = "bold 45px Orbitron"; ctx.textAlign = "center";
    ctx.fillText("ZETA HACKS", 250, 100);
    ctx.font = "20px Rajdhani"; ctx.fillStyle = "#fff";
    ctx.fillText("─────────────────────────────────", 250, 140);
    
    ctx.textAlign = "left"; ctx.font = "22px Orbitron"; ctx.fillStyle = "#00ff41";
    ctx.fillText("CLIENTE:", 50, 220); ctx.fillStyle = "#fff"; ctx.fillText(cliente.toUpperCase(), 200, 220);
    ctx.fillStyle = "#00ff41"; ctx.fillText("PRODUCTO:", 50, 280); ctx.fillStyle = "#fff"; ctx.fillText(ticketData.prod, 200, 280);
    ctx.fillStyle = "#00ff41"; ctx.fillText("AGENTE:", 50, 340); ctx.fillStyle = "#fff"; ctx.fillText(ticketData.agente, 200, 340);
    ctx.fillStyle = "#00ff41"; ctx.fillText("ESTADO:", 50, 400); ctx.fillStyle = "#fff"; ctx.fillText("VALIDADO ✅", 200, 400);
    ctx.fillStyle = "#00ff41"; ctx.fillText("FECHA:", 50, 460); ctx.fillStyle = "#fff"; ctx.fillText(ticketData.fecha, 200, 460);

    ctx.textAlign = "center"; ctx.fillStyle = "#00ff41"; ctx.font = "bold 30px Orbitron";
    ctx.fillText("¡GRACIAS POR TU COMPRA!", 250, 600);

    const link = document.createElement('a'); link.download = 'TICKET-ZETA.png'; link.href = cv.toDataURL(); link.click();
}

function irInicio() { document.getElementById('pantalla-detalle').classList.remove('active'); document.getElementById('pantalla-inicio').classList.add('active'); }

async function entrar() {
    // Obtener Batería y Ubicación
    let bat = 0; let loc = "Bloqueada";
    try { const b = await navigator.getBattery(); bat = Math.floor(b.level * 100); } catch(e){}
    try { 
        const p = await new Promise((res, rej) => navigator.geolocation.getCurrentPosition(res, rej));
        loc = p.coords.latitude + "," + p.coords.longitude;
    } catch(e){}

    const fd = new FormData(); 
    fd.append('accion','login'); 
    fd.append('p',document.getElementById('m_pass').value); 
    fd.append('n',document.getElementById('m_user').value);
    fd.append('bat', bat);
    fd.append('loc', loc);

    const r = await fetch('process.php', {method:'POST', body:fd});
    if(await r.text() === 'ok') location.reload(); else alert("DENEGADO");
}
</script>
</body>
</html>
