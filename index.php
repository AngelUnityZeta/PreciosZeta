<?php session_start(); $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS V12</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Rajdhani:wght@500;700&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #000; }
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; overflow-x: hidden; }
        
        /* LOGIN MEJORADO */
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 99999; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 90%; max-width: 380px; padding: 40px; border: 2px solid var(--p); border-radius: 20px; background: #050505; text-align: center; box-shadow: 0 0 30px rgba(0,255,65,0.3); }
        .z-input { width: 100%; padding: 15px; margin: 10px 0; background: #000; border: 1px solid #333; color: var(--p); border-radius: 10px; font-family: 'Orbitron'; text-align: center; font-size: 1rem; outline: none; }
        .zeta-logo { font-family: 'Orbitron'; font-weight: 900; font-size: 2rem; color: var(--p); text-shadow: 0 0 10px var(--p); margin-bottom: 20px; }

        header { position: fixed; top: 0; width: 100%; height: 70px; background: #000; border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 10000; }
        .container { padding: 90px 15px 40px; display: none; max-width: 600px; margin: 0 auto; }
        .active { display: block; }

        /* LISTA DE PAISES */
        .p-card { background: #0a0a0a; border: 1px solid #1a1a1a; padding: 18px; border-radius: 15px; display: flex; align-items: center; margin-bottom: 12px; cursor: pointer; border-left: 5px solid var(--p); }
        .p-card span { font-size: 32px; margin-right: 15px; }
        .p-card b { font-family: 'Orbitron'; font-size: 1.1rem; }

        .prod-box { background: #080808; border: 1px solid #222; padding: 20px; border-radius: 18px; margin-bottom: 20px; border-top: 4px solid var(--p); }
        .row-v { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #111; }
        .row-v b { color: var(--p); font-family: 'Orbitron'; }

        .btn { width: 100%; padding: 15px; border: none; border-radius: 10px; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; margin-top: 10px; text-transform: uppercase; }
        .btn-p { background: var(--p); color: #000; }
        .btn-s { background: transparent; border: 1px solid var(--s); color: var(--s); }

        #t-modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.95); z-index:30000; align-items:center; justify-content:center; padding:20px; }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-card">
        <div class="zeta-logo">ZETA HACKS</div>
        <div id="div_pass">
            <p style="color:#666; font-size:0.8rem;">SISTEMA PRIVADO - INGRESE CLAVE</p>
            <input type="password" id="m_pass" class="z-input" placeholder="••••••••">
            <button class="btn btn-p" onclick="checkPass()">SIGUIENTE</button>
        </div>
        <div id="div_user" style="display:none;">
            <p style="color:var(--s); font-size:0.8rem;">CLAVE ACEPTADA - IDENTIFÍQUESE</p>
            <input type="text" id="m_user" class="z-input" placeholder="NOMBRE AGENTE">
            <button class="btn btn-p" onclick="accederYa()">INTRAR</button>
        </div>
    </div>
</div>

<header><div class="zeta-logo" style="font-size:1.4rem; margin:0;">ZETA HACKS</div></header>

<div id="p-home" class="container active">
    <div id="list-p"></div>
</div>

<div id="p-detail" class="container">
    <button onclick="irHome()" class="btn btn-s" style="width:auto; margin-bottom:20px;"><i class="fa fa-arrow-left"></i> VOLVER</button>
    <div id="cont-d"></div>
</div>

<div id="t-modal">
    <div style="background:#0a0a0a; border:1px solid var(--s); padding:20px; border-radius:20px; width:100%;">
        <h3 style="color:var(--s); font-family:'Orbitron'; text-align:center;">TICKET DE VENTA</h3>
        <input type="text" id="t_cli" class="z-input" placeholder="CLIENTE">
        <input type="text" id="t_val" class="z-input" placeholder="PRECIO">
        <input type="text" id="t_dias" class="z-input" placeholder="DÍAS">
        <input type="hidden" id="t_prod">
        <button class="btn btn-p" onclick="descargar()">DESCARGAR TICKET</button>
        <button class="btn btn-s" onclick="document.getElementById('t-modal').style.display='none'">CANCELAR</button>
    </div>
</div>

<canvas id="canvas" width="500" height="700" style="display:none;"></canvas>

<script>
const CLAVE_MAESTRA = "EmpresaPrivada2026";

const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS", m:"💳 MERCADO PAGO:\n📋 oscar.hs.m"},
        {n:"BOLIVIA", b:"🇧🇴", t:12, c:"BS", m:"📌 QR SOPORTE\n💰 Tasa: 12.00 por Dólar"},
        {n:"BRASIL", b:"🇧🇷", t:5.5, c:"BRL", m:"🟢 PIX: 91991076791"},
        {n:"CHILE", b:"🇨🇱", t:980, c:"CLP", m:"🏪 Banco Estado\n👤 XAVIER FUENZALIDA\n📋 RUT: 23.710.151-0\n📋 Cuenta: 23710151"},
        {n:"COLOMBIA", b:"🇨🇴", t:4300, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu Bank: @PMG3555"},
        {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD", m:"🟨 Banco Pichincha: 2207195565"},
        {n:"ESPANA", b:"🇪🇸", t:1, c:"EUR", m:"💶 Bizum: 634033557 (Yanni Hernández)"},
        {n:"USA", b:"🇺🇸", t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.8, c:"GTQ", m:"🟩 Banrural: 4431164091"},
        {n:"HONDURAS", b:"🇭🇳", t:24.7, c:"HNL", m:"🔵 Bampais: 216400100524"},
        {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN", m:"🏦 Albo (Transferencias)\n🏪 Nu México: 5101 2506 8691 9389 (Tasa 20)"},
        {n:"NICARAGUA", b:"🇳🇮", t:36.5, c:"NIO", m:"🏦 BAC Nicaragua: 371674409"},
        {n:"PANAMA", b:"🇵🇦", t:1, c:"USD", m:"🟠 Punto Pago Wally: +584128975265\n🟣 Zinli: chauran2001@gmail.com"},
        {n:"PARAGUAY", b:"🇵🇾", t:7600, c:"PYG", m:"🏦 Itau: 300406285\n💳 Personal: 0993363424"},
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

function hablar(t) {
    const s = new SpeechSynthesisUtterance(t);
    s.pitch = 0.7; s.rate = 0.9;
    speechSynthesis.speak(s);
}

function checkPass() {
    if(document.getElementById('m_pass').value === CLAVE_MAESTRA) {
        document.getElementById('div_pass').style.display='none';
        document.getElementById('div_user').style.display='block';
        hablar("Clave correcta. Identifíquese.");
    } else { alert("DENEGADO"); }
}

function accederYa() {
    const n = document.getElementById('m_user').value;
    if(!n) return alert("PON TU NOMBRE");
    const fd = new FormData(); fd.append('accion','login'); fd.append('n',n); fd.append('p',CLAVE_MAESTRA);
    fetch('process.php', {method:'POST', body:fd}); // Se envía al fondo
    document.getElementById('bloqueo').style.display='none';
    hablar("Bienvenido Agente " + n);
    renderPaises();
}

function renderPaises() {
    const list = document.getElementById('list-p');
    list.innerHTML = '<h3 style="text-align:center; color:var(--s); font-family:Orbitron;">REGIONES DISPONIBLES</h3>';
    DB.paises.forEach(p => {
        list.innerHTML += `<div class="p-card" onclick="ver('${p.n}')"><span>${p.b}</span><b>${p.n}</b></div>`;
    });
}

function ver(n) {
    const p = DB.paises.find(x => x.n === n);
    document.getElementById('p-home').classList.remove('active');
    document.getElementById('p-detail').classList.add('active');
    hablar("País " + n);
    let h = `<div style="color:var(--s); border:1px dashed var(--s); padding:15px; margin-bottom:20px;"><b>METODOS ${p.n}:</b><br>${p.m.replace(/\n/g,'<br>')}</div>`;
    DB.prods.forEach(cat => {
        h += `<h2 style="color:var(--p); font-family:Orbitron; font-size:1rem; margin-top:25px;">🔱 ${cat.cat}</h2>`;
        cat.items.forEach(i => {
            let rs = ""; let ct = `💎 LISTA DE PRECIOS: ${i.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            i.d.forEach((d, idx) => {
                let px = Math.ceil(i.p[idx] * p.t); let tag = isNaN(d)?d:d+" DÍAS";
                rs += `<div class="row-v"><span>✅ ${tag}</span><b>${px} ${p.c}</b></div>`;
                ct += `✅ ${tag}: ${px} ${p.c}\n`;
            });
            h += `<div class="prod-box"><h3>${i.n}</h3>${rs}
            <div style="display:flex; gap:10px; margin-top:10px;">
                <button class="btn btn-s" style="flex:1" onclick="copiar('${ct.replace(/'/g,"\\'")}')">COPIAR</button>
                <button class="btn btn-p" style="flex:2" onclick="abrirT('${i.n}')">TICKET</button>
            </div></div>`;
        });
    });
    document.getElementById('cont-d').innerHTML = h;
}

function abrirT(p) { document.getElementById('t-modal').style.display='flex'; document.getElementById('t_prod').value=p; }

function descargar() {
    const c = document.getElementById('canvas'); const x = c.getContext('2d');
    const cli = document.getElementById('t_cli').value || "CLIENTE";
    x.fillStyle="#000"; x.fillRect(0,0,500,700);
    x.strokeStyle="#00ff41"; x.lineWidth=10; x.strokeRect(10,10,480,680);
    x.fillStyle="#00ff41"; x.font="bold 45px Orbitron"; x.textAlign="center"; x.fillText("ZETA HACKS", 250, 100);
    x.textAlign="left"; x.font="22px Orbitron"; x.fillStyle="#fff";
    x.fillText("CLIENTE: " + cli.toUpperCase(), 50, 250);
    x.fillText("PRODUCTO: " + document.getElementById('t_prod').value, 50, 320);
    x.fillText("PRECIO: " + document.getElementById('t_val').value, 50, 390);
    x.fillText("AGENTE: " + document.getElementById('m_user').value, 50, 460);
    const a = document.createElement('a'); a.download='Ticket.png'; a.href=c.toDataURL(); a.click();
    hablar("Ticket generado");
}

function copiar(t) { navigator.clipboard.writeText(t); hablar("Copiado"); alert("LISTA COPIADA"); }
function irHome() { document.getElementById('p-detail').classList.remove('active'); document.getElementById('p-home').classList.add('active'); }
if("<?=$auth?>") renderPaises();
</script>
</body>
</html>
