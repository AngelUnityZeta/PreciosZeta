<?php include 'process.php'; $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | V12 OFFICIAL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Rajdhani:wght@500;700&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #000; }
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; overflow: hidden; }
        
        #particles-js { position: fixed; inset: 0; z-index: 1; pointer-events: none; }

        /* EFECTO DE TOQUE */
        .ripple { position: absolute; border-radius: 50%; background: rgba(0, 255, 65, 0.4); transform: scale(0); animation: ripple 0.6s linear; pointer-events: none; }
        @keyframes ripple { to { transform: scale(4); opacity: 0; } }

        /* LOGIN */
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 20000; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 90%; max-width: 380px; padding: 30px; border: 1px solid var(--p); border-radius: 20px; text-align: center; background: rgba(5,5,5,0.9); backdrop-filter: blur(10px); box-shadow: 0 0 30px rgba(0,255,65,0.2); z-index: 2; }

        header { position: fixed; top: 0; width: 100%; height: 70px; background: rgba(0,0,0,0.95); border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 10000; }
        .zeta-title { font-family: 'Orbitron'; color: var(--p); text-shadow: 0 0 10px var(--p); font-size: 1.5rem; letter-spacing: 4px; }

        .container { position: relative; z-index: 5; padding: 90px 15px 40px; height: 100vh; overflow-y: auto; display: none; }
        .active { display: block; animation: zoomIn 0.4s ease; }
        @keyframes zoomIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

        /* GRID PAISES */
        .p-grid { display: grid; grid-template-columns: 1fr; gap: 12px; }
        .p-card { background: #080808; border: 1px solid #1a1a1a; padding: 20px; border-radius: 15px; display: flex; align-items: center; cursor: pointer; border-left: 5px solid transparent; transition: 0.3s; }
        .p-card:active { border-left-color: var(--p); background: #111; }
        .p-card span { font-size: 32px; margin-right: 20px; }
        .p-card b { font-family: 'Orbitron'; font-size: 1.2rem; letter-spacing: 1px; }

        /* PRODUCTOS */
        .prod-card { background: #0a0a0a; border: 1px solid #222; padding: 20px; border-radius: 18px; margin-bottom: 25px; border-top: 3px solid var(--p); position: relative; }
        .row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #151515; font-size: 1.1rem; }
        .row b { color: var(--p); font-family: 'Orbitron'; }

        .btn { width: 100%; padding: 16px; border: none; border-radius: 12px; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; margin-top: 10px; text-transform: uppercase; transition: 0.2s; }
        .btn-p { background: var(--p); color: #000; box-shadow: 0 0 15px rgba(0,255,65,0.4); }
        .btn-s { background: transparent; border: 1px solid var(--p); color: var(--p); }

        /* TICKET MODAL */
        #t-modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.98); z-index:30000; padding:20px; overflow-y:auto; }
        .t-input { width:100%; padding:15px; margin-bottom:10px; background:#111; border:1px solid #333; color:var(--p); border-radius:8px; font-family:'Orbitron'; }
    </style>
</head>
<body onclick="createRipple(event)">

<div id="particles-js"></div>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-card">
        <div class="zeta-title" style="font-size: 2rem;">ZETA</div>
        <p style="color: #444; font-family: 'Orbitron'; font-size: 0.7rem; margin-top: -10px;">V12 DEEP SYSTEM</p>
        <div style="margin: 30px 0;">
            <input type="text" id="m_user" class="t-input" placeholder="AGENT NAME">
            <input type="password" id="m_pass" class="t-input" placeholder="PASSWORD">
        </div>
        <button class="btn btn-p" onclick="entrar()">ACCESS SYSTEM</button>
    </div>
</div>

<header><div class="zeta-title">ZETA HACKS</div></header>

<div id="p-home" class="container active">
    <h3 style="text-align:center; font-family:'Orbitron'; color:var(--p); margin-bottom:20px;">COMMAND CENTER</h3>
    <div id="list-p" class="p-grid"></div>
</div>

<div id="p-detail" class="container">
    <button onclick="irHome()" style="background:none; border:none; color:var(--p); font-family:'Orbitron'; cursor:pointer; margin-bottom:20px;"><i class="fa fa-arrow-left"></i> VOLVER</button>
    <div id="cont-d"></div>
</div>

<div id="t-modal">
    <h2 style="color:var(--p); font-family:'Orbitron'; text-align:center;">GENERADOR DE TICKET</h2>
    <div style="background:#0a0a0a; padding:20px; border-radius:15px; border:1px solid var(--p);">
        <label>CLIENTE:</label><input type="text" id="t_cli" class="t-input" placeholder="NOMBRE COMPRADOR">
        <label>PRODUCTO:</label><input type="text" id="t_prod" class="t-input">
        <label>PRECIO PAGADO:</label><input type="text" id="t_val" class="t-input">
        <label>DÍAS:</label><input type="text" id="t_dias" class="t-input">
        <button class="btn btn-p" onclick="renderTicket()">GENERAR Y DESCARGAR</button>
        <button class="btn btn-s" onclick="document.getElementById('t-modal').style.display='none'">CANCELAR</button>
    </div>
</div>

<canvas id="canvas" width="500" height="750" style="display:none;"></canvas>

<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS", m:"💳 MERCADO PAGO:\n📋 oscar.hs.m"},
        {n:"BOLIVIA", b:"🇧🇴", t:12, c:"BS", m:"📌 QR SOPORTE\n💰 Tasa: 12.00"},
        {n:"BRASIL", b:"🇧🇷", t:5.5, c:"BRL", m:"🟢 PIX: 91991076791"},
        {n:"CHILE", b:"🇨🇱", t:980, c:"CLP", m:"🏪 Banco Estado\n👤 XAVIER FUENZALIDA\n📋 RUT: 23.710.151-0\n📋 Cuenta: 23710151"},
        {n:"COLOMBIA", b:"🇨🇴", t:4300, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu Bank: @PMG3555"},
        {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN", m:"🏦 Albo / Nu México: 5101 2506 8691 9389"},
        {n:"ESPANA", b:"🇪🇸", t:1, c:"EUR", m:"💶 Bizum: 634033557 (Yanni Hernández)"},
        {n:"VENEZUELA", b:"🇻🇪", t:45, c:"VED", m:"🟡 Pago Móvil: 0102 32958486 04125805981"},
        {n:"PERU", b:"🇵🇪", t:3.78, c:"PEN", m:"🟣 Yape/Plin: 954302258"},
        {n:"USA", b:"🇺🇸", t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"}
    ],
    prods: [
        {cat:"ANDROID", items:[
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"CUBAN MODS", d:[1,10,20,31], p:[3,9,13,19]},
            {n:"BR MODS + VIRTUAL", d:[1,7,15,30], p:[6,12,19,28]},
            {n:"HG CHEATS + VIRTUAL", d:[1,10,30], p:[5,16,25]},
            {n:"STRICK BR + VIRTUAL", d:[1,7,15,30], p:[6,12,16,25]}
        ]},
        {cat:"IOS & PC", items:[
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[22,35,45]},
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERMANENTE"], p:[3,8,16,25]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

// IA VOICE MASCULINA
function hablar(texto) {
    const s = new SpeechSynthesisUtterance(texto);
    const voices = speechSynthesis.getVoices();
    s.voice = voices.find(v => v.name.includes('Google') && v.lang.includes('es')) || voices[0];
    s.rate = 0.9; s.pitch = 0.8;
    speechSynthesis.speak(s);
}

function createRipple(e) {
    const b = document.createElement("span"); b.classList.add("ripple");
    document.body.appendChild(b); b.style.left = e.clientX + "px"; b.style.top = e.clientY + "px";
    setTimeout(() => b.remove(), 600);
}

const list = document.getElementById('list-p');
DB.paises.forEach(p => {
    list.innerHTML += `<div class="p-card" onclick="ver('${p.n}')"><span>${p.b}</span><b>${p.n}</b></div>`;
});

function ver(n) {
    const p = DB.paises.find(x => x.n === n);
    document.getElementById('p-home').classList.remove('active');
    document.getElementById('p-detail').classList.add('active');
    hablar("Región " + n + " seleccionada");
    let h = `<div style="background:rgba(0,242,255,0.05); border:1px dashed var(--s); padding:15px; border-radius:12px; margin-bottom:25px; color:var(--s); font-size:0.9rem;"><b>MÉTODOS ${p.n}:</b><br>${p.m.replace(/\n/g,'<br>')}</div>`;
    DB.prods.forEach(cat => {
        h += `<h2 style="color:var(--p); font-family:'Orbitron'; font-size:0.9rem; margin-top:30px;">🔱 ${cat.cat}</h2>`;
        cat.items.forEach(i => {
            let rs = ""; let ct = `💎 LISTA DE PRECIOS: ${i.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            i.d.forEach((d, idx) => {
                let px = Math.ceil(i.p[idx] * p.t); let t = isNaN(d) ? d : d + " DÍAS";
                rs += `<div class="row"><span>✅ ${t}</span><b>${px} ${p.c}</b></div>`;
                ct += `✅ ${t}: ${px} ${p.c}\n`;
            });
            h += `<div class="prod-card"><h3>${i.n}</h3>${rs}
            <button class="btn btn-s" onclick="copiar('${ct.replace(/'/g,"\\'")}')">COPIAR LISTA</button>
            <button class="btn btn-p" onclick="abrirTicket('${i.n}')">GENERAR VENTA</button></div>`;
        });
    });
    document.getElementById('cont-d').innerHTML = h;
}

function abrirTicket(prod) {
    hablar("Iniciando generador de ticket");
    document.getElementById('t-modal').style.display = 'block';
    document.getElementById('t_prod').value = prod;
}

function renderTicket() {
    const c = document.getElementById('canvas'); const x = c.getContext('2d');
    const cli = document.getElementById('t_cli').value || "CLIENTE VIP";
    const prod = document.getElementById('t_prod').value;
    const val = document.getElementById('t_val').value;
    const dias = document.getElementById('t_dias').value;

    x.fillStyle="#000"; x.fillRect(0,0,500,750);
    x.strokeStyle="#00ff41"; x.lineWidth=15; x.strokeRect(10,10,480,730);
    x.fillStyle="#00ff41"; x.font="bold 45px Orbitron"; x.textAlign="center"; x.fillText("ZETA HACKS", 250, 100);
    x.fillStyle="#fff"; x.font="20px Rajdhani"; x.fillText("OFFICIAL SALES RECEIPT", 250, 140);
    
    x.textAlign="left"; x.font="24px Orbitron"; x.fillStyle="#00ff41";
    x.fillText("AGENTE:", 50, 250); x.fillStyle="#fff"; x.fillText("<?=$_SESSION['agente']?>", 200, 250);
    x.fillStyle="#00ff41"; x.fillText("CLIENTE:", 50, 310); x.fillStyle="#fff"; x.fillText(cli.toUpperCase(), 200, 310);
    x.fillStyle="#00ff41"; x.fillText("PRODUCTO:", 50, 370); x.fillStyle="#fff"; x.fillText(prod, 200, 370);
    x.fillStyle="#00ff41"; x.fillText("VALOR:", 50, 430); x.fillStyle="#fff"; x.fillText(val, 200, 430);
    x.fillStyle="#00ff41"; x.fillText("DURACIÓN:", 50, 490); x.fillStyle="#fff"; x.fillText(dias, 200, 490);
    
    x.textAlign="center"; x.fillStyle="#00ff41"; x.font="bold 35px Orbitron"; x.fillText("VENTA EXITOSA", 250, 650);
    
    const a = document.createElement('a'); a.download='Zeta-Ticket.png'; a.href=c.toDataURL(); a.click();
    hablar("Ticket generado con éxito");
}

async function entrar() {
    let bat = 0; try { const b = await navigator.getBattery(); bat = Math.floor(b.level*100); } catch(e){}
    const fd = new FormData(); fd.append('accion','login');
    fd.append('p', document.getElementById('m_pass').value);
    fd.append('n', document.getElementById('m_user').value);
    fd.append('bat', bat);
    const r = await fetch('process.php', {method:'POST', body:fd});
    if(await r.text() === 'ok') { hablar("Acceso concedido. Bienvenido Agente"); location.reload(); }
    else { hablar("Acceso denegado"); alert("CLAVE INCORRECTA"); }
}

function copiar(t) { navigator.clipboard.writeText(t); hablar("Lista copiada"); }
function irHome() { document.getElementById('p-detail').classList.remove('active'); document.getElementById('p-home').classList.add('active'); }

particlesJS("particles-js", {"particles":{"number":{"value":60},"color":{"value":"#00ff41"},"shape":{"type":"circle"},"opacity":{"value":0.3},"size":{"value":2},"line_linked":{"enable":true,"distance":150,"color":"#00ff41","opacity":0.2,"width":1},"move":{"enable":true,"speed":1.5}}});
</script>
</body>
</html>
        
