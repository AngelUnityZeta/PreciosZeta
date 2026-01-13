<?php session_start(); $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | ELITE V12</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Rajdhani:wght@500;700&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #000; }
        * { box-sizing: border-box; outline: none; -webkit-tap-highlight-color: transparent; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; }

        /* LOGIN CON EFECTO ESCANEO */
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 99999; display: flex; align-items: center; justify-content: center; }
        .login-card { 
            width: 90%; max-width: 380px; padding: 40px; border: 1px solid #222; border-radius: 20px; 
            background: #080808; text-align: center; position: relative; overflow: hidden;
        }
        .login-card::after {
            content: ''; position: absolute; top: -100%; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to bottom, transparent, var(--p), transparent);
            animation: scan 3s linear infinite; opacity: 0.2; pointer-events: none;
        }
        @keyframes scan { 0% { top: -100%; } 100% { top: 100%; } }

        .z-input { width: 100%; padding: 15px; margin: 10px 0; background: #000; border: 1px solid #333; color: var(--p); border-radius: 10px; font-family: 'Orbitron'; text-align: center; font-size: 0.9rem; }
        .zeta-logo { font-family: 'Orbitron'; font-weight: 900; font-size: 2rem; color: var(--p); text-shadow: 0 0 10px var(--p); margin-bottom: 20px; }

        .btn { width: 100%; padding: 16px; border: none; border-radius: 12px; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; text-transform: uppercase; transition: 0.3s; }
        .btn-p { background: var(--p); color: #000; }
        .btn-s { background: transparent; border: 1px solid var(--s); color: var(--s); }

        header { position: fixed; top: 0; width: 100%; height: 70px; background: rgba(0,0,0,0.9); border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(10px); }
        .container { padding: 90px 15px 40px; display: none; max-width: 600px; margin: 0 auto; }
        .active { display: block; animation: fadeIn 0.4s; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .p-card { background: #0d0d0d; border: 1px solid #222; padding: 18px; border-radius: 15px; display: flex; align-items: center; margin-bottom: 12px; cursor: pointer; border-left: 5px solid var(--p); }
        .p-card:hover { transform: scale(1.02); background: #151515; }
        .p-card span { font-size: 30px; margin-right: 15px; }

        .prod-box { background: #080808; border: 1px solid #1a1a1a; padding: 20px; border-radius: 20px; margin-bottom: 20px; border-top: 4px solid var(--p); }
        .row-v { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #111; font-size: 1.1rem; }
        .row-v b { color: var(--p); font-family: 'Orbitron'; }

        .fab { position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; background: var(--p); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000; font-size: 25px; box-shadow: 0 0 20px var(--p); z-index: 5000; cursor: pointer; }
        #t-modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.95); z-index:30000; align-items:center; justify-content:center; padding:20px; }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-card">
        <div class="zeta-logo">ZETA HACKS</div>
        <div id="step1">
            <input type="password" id="m_pass" class="z-input" placeholder="CONTRASEÑA MAESTRA">
            <button class="btn btn-p" onclick="checkP1()">CONTINUAR</button>
        </div>
        <div id="step2" style="display:none;">
            <input type="text" id="m_user" class="z-input" placeholder="NOMBRE DE VENDEDOR">
            <input type="tel" id="m_wa" class="z-input" placeholder="WHATSAPP">
            <button class="btn btn-p" onclick="acceder()">INICIALIZAR SISTEMA</button>
        </div>
    </div>
</div>

<header><div class="zeta-logo" style="font-size:1.5rem; margin:0;">ZETA HACKS</div></header>

<div id="p-home" class="container active">
    <div id="list-p"></div>
</div>

<div id="p-detail" class="container">
    <button onclick="irHome()" class="btn btn-s" style="width:auto; padding:5px 20px; margin-bottom:20px;"><i class="fa fa-arrow-left"></i> VOLVER</button>
    <div id="cont-d"></div>
</div>

<div class="fab" onclick="document.getElementById('file-in').click()"><i class="fa fa-upload"></i></div>
<input type="file" id="file-in" style="display:none;" onchange="subir(this)">

<div id="t-modal">
    <div style="background:#0a0a0a; border:2px solid var(--p); padding:25px; border-radius:20px; width:100%; max-width:400px;">
        <h3 style="color:var(--p); font-family:Orbitron; text-align:center;">TICKET DE VENTA</h3>
        <input type="text" id="t_cli" class="z-input" placeholder="NOMBRE CLIENTE">
        <input type="text" id="t_val" class="z-input" placeholder="MONTO TOTAL">
        <input type="text" id="t_dias" class="z-input" placeholder="DURACIÓN">
        <input type="hidden" id="t_prod">
        <button class="btn btn-p" onclick="descargarTicket()">DESCARGAR TICKET</button>
        <button class="btn btn-s" onclick="document.getElementById('t-modal').style.display='none'" style="margin-top:10px;">CANCELAR</button>
    </div>
</div>

<canvas id="canvas" width="500" height="750" style="display:none;"></canvas>

<script>
const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS", m:"💳 MERCADO PAGO:\n📋 oscar.hs.m"},
        {n:"BOLIVIA", b:"🇧🇴", t:12, c:"BS", m:"📌 QR SOPORTE (Escanea el código enviado por soporte)\n💰 Tasa: 12.00 por Dólar"},
        {n:"BRASIL", b:"🇧🇷", t:5.5, c:"BRL", m:"🟢 PIX: 91991076791"},
        {n:"CHILE", b:"🇨🇱", t:980, c:"CLP", m:"🏪 Banco Estado (Caja Vecina)\n👤 XAVIER FUENZALIDA\n📋 RUT: 23.710.151-0\n📋 CuentaRUT: 23710151"},
        {n:"COLOMBIA", b:"🇨🇴", t:4300, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu Bank: @PMG3555"},
        {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD", m:"🟨 Banco Pichincha: 2207195565"},
        {n:"ESPANA", b:"🇪🇸", t:1, c:"EUR", m:"💶 Bizum: 634033557\n👤 Yanni Hernández"},
        {n:"USA", b:"🇺🇸", t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.8, c:"GTQ", m:"🟩 Banrural: 4431164091"},
        {n:"HONDURAS", b:"🇭🇳", t:24.7, c:"HNL", m:"🔵 Bampais: 216400100524"},
        {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN", m:"🏦 Albo (Transferencias)\n🏪 Nu México (OXXO): 5101 2506 8691 9389"},
        {n:"NICARAGUA", b:"🇳🇮", t:36.5, c:"NIO", m:"🏦 BAC Nicaragua: 371674409"},
        {n:"PANAMA", b:"🇵🇦", t:1, c:"USD", m:"🟠 Punto Pago Wally: +584128975265\n🟣 Zinli: chauran2001@gmail.com"},
        {n:"PARAGUAY", b:"🇵🇾", t:7600, c:"PYG", m:"🏦 Banco Itau: 300406285 (Diego Leiva)\n💳 Billetera Personal: 0993363424"},
        {n:"PERU", b:"🇵🇪", t:3.78, c:"PEN", m:"🟣 Yape/Plin: 954302258"},
        {n:"DOMINICANA", b:"🇩🇴", t:60, c:"DOP", m:"🟦 Banreservas: 9601546622\n🔴 Banco Popular: 837147719"},
        {n:"VENEZUELA", b:"🇻🇪", t:45, c:"VED", m:"🟡 Pago Móvil: 0102 32958486 04125805981"}
    ],
    prods: [
        {cat:"ANDROID", items:[
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"CUBAN MODS", d:[1,10,20,31], p:[3,9,13,19]},
            {n:"BR MODS + VIRTUAL", d:[1,7,15,30], p:[6,12,19,28]},
            {n:"BR MODS MOBILE", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"HG CHEATS", d:[1,10,30], p:[3,12,18]},
            {n:"HG CHEATS + VIRTUAL", d:[1,10,30], p:[5,16,25]},
            {n:"STRICK BR", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"STRICK BR + VIRTUAL", d:[1,7,15,30], p:[6,12,16,25]}
        ]},
        {cat:"IOS", items:[
            {n:"CERTIFICADOS GBOX", d:["12 MESES"], p:[18]},
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[22,35,45]},
            {n:"FLOURITE SOLO", d:[1,7,30], p:[4,16,26]},
            {n:"PANEL IOS", d:[7,30], p:[12,19]}
        ]},
        {cat:"PC", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERMANENTE"], p:[3,8,16,25]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

function hablar(txt) {
    const s = new SpeechSynthesisUtterance(txt);
    s.lang = 'es-ES'; s.pitch = 0.8; s.rate = 1;
    window.speechSynthesis.speak(s);
}

function checkP1() {
    if(document.getElementById('m_pass').value === "EmpresaPrivada2026") {
        document.getElementById('step1').style.display='none';
        document.getElementById('step2').style.display='block';
        hablar("Acceso verificado. Ingrese sus datos de agente.");
    } else { alert("ERROR"); }
}

function acceder() {
    const n = document.getElementById('m_user').value;
    const w = document.getElementById('m_wa').value;
    if(!n || !w) return alert("COMPLETE LOS DATOS");
    const fd = new FormData(); fd.append('accion','login'); fd.append('n',n); fd.append('w',w);
    fetch('process.php', {method:'POST', body:fd});
    document.getElementById('bloqueo').style.display='none';
    hablar("Bienvenido Agente " + n + ". El sistema ZETA HACKS está listo.");
    renderHome();
}

function renderHome() {
    const list = document.getElementById('list-p');
    list.innerHTML = '<p style="text-align:center; color:#555; font-size:0.8rem;">SOPORTE: +591 69591926</p>';
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        list.innerHTML += `<div class="p-card" onclick="verP('${p.n}')"><span>${p.b}</span><b>${p.n}</b></div>`;
    });
}

function verP(n) {
    const p = DB.paises.find(x => x.n === n);
    document.getElementById('p-home').classList.remove('active');
    document.getElementById('p-detail').classList.add('active');
    hablar("Región " + n + " activada");
    let h = `<div style="background:rgba(0,255,65,0.05); border:1px solid var(--p); padding:15px; border-radius:12px; margin-bottom:20px; color:var(--s); font-size:0.9rem;"><b>METODOS DE PAGO:</b><br>${p.m.replace(/\n/g,'<br>')}</div>`;
    
    DB.prods.forEach(cat => {
        h += `<h2 style="color:var(--p); font-family:Orbitron; font-size:0.9rem; margin-top:25px;">🔱 ${cat.cat}</h2>`;
        cat.items.forEach(i => {
            let row = ""; let clip = `💎 LISTA DE PRECIOS: ${i.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            i.d.forEach((d, idx) => {
                let precio = Math.ceil(i.p[idx] * p.t);
                let tag = isNaN(d) ? d : d + " DÍA" + (d>1?"S":"");
                row += `<div class="row-v"><span>✅ ${tag}</span><b>${precio} ${p.c}</b></div>`;
                clip += `✅ ${tag}: ${precio} ${p.c}\n`;
            });
            h += `<div class="prod-box"><h3>${i.n}</h3>${row}
            <div style="display:flex; gap:10px; margin-top:15px;">
                <button class="btn btn-s" style="flex:1" onclick="copiar(this, \`${clip}\`)">COPIAR</button>
                <button class="btn btn-p" style="flex:2" onclick="abrirT('${i.n}')">VENDER</button>
            </div></div>`;
        });
    });
    document.getElementById('cont-d').innerHTML = h;
}

function copiar(btn, txt) {
    const el = document.createElement('textarea'); el.value = txt;
    document.body.appendChild(el); el.select(); document.execCommand('copy');
    document.body.removeChild(el);
    const old = btn.innerText; btn.innerText = "¡COPIADO!";
    hablar("Copiado al portapapeles");
    setTimeout(() => btn.innerText = old, 2000);
}

function subir(input) {
    if(!input.files[0]) return;
    const fd = new FormData(); fd.append('accion','comprobante'); fd.append('foto',input.files[0]);
    fetch('process.php', {method:'POST', body:fd}).then(() => {
        hablar("Comprobante enviado a soporte");
        alert("ENVIADO A TELEGRAM ✅");
    });
}

function abrirT(p) { document.getElementById('t-modal').style.display='flex'; document.getElementById('t_prod').value = p; }

function descargarTicket() {
    const c = document.getElementById('canvas'); const x = c.getContext('2d');
    const cli = document.getElementById('t_cli').value || "CLIENTE";
    const ag = document.getElementById('m_user').value;
    
    x.fillStyle="#000"; x.fillRect(0,0,500,750);
    x.strokeStyle="#00ff41"; x.lineWidth=5; x.strokeRect(10,10,480,730);
    x.fillStyle="#00ff41"; x.font="900 45px Orbitron"; x.textAlign="center"; x.fillText("ZETA HACKS", 250, 100);
    
    x.textAlign="left"; x.font="22px Orbitron"; x.fillStyle="#00ff41";
    x.fillText("VENDEDOR:", 50, 250); x.fillStyle="#fff"; x.fillText(ag.toUpperCase(), 200, 250);
    x.fillStyle="#00ff41"; x.fillText("CLIENTE:", 50, 320); x.fillStyle="#fff"; x.fillText(cli.toUpperCase(), 180, 320);
    x.fillStyle="#00ff41"; x.fillText("PRODUCTO:", 50, 390); x.fillStyle="#fff"; x.fillText(document.getElementById('t_prod').value, 200, 390);
    x.fillStyle="#00ff41"; x.fillText("MONTO:", 50, 460); x.fillStyle="#fff"; x.fillText(document.getElementById('t_val').value, 160, 460);
    x.fillStyle="#00ff41"; x.fillText("VALIDEZ:", 50, 530); x.fillStyle="#fff"; x.fillText(document.getElementById('t_dias').value, 180, 530);

    const a = document.createElement('a'); a.download=`Ticket_${cli}.png`; a.href=c.toDataURL(); a.click();
    hablar("Venta finalizada. Ticket generado.");
}

function irHome() { document.getElementById('p-detail').classList.remove('active'); document.getElementById('p-home').classList.add('active'); }
if("<?=$auth?>") renderHome();
</script>
</body>
</html>
