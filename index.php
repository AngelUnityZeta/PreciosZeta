<?php include 'process.php'; $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | V12 OFFICIAL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Rajdhani:wght@300;700&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #030303; }
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; overflow-x: hidden; }
        #particles-js { position: fixed; inset: 0; z-index: 1; pointer-events: none; }

        /* ACCESO EN DOS PASOS */
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 20000; display: flex; align-items: center; justify-content: center; }
        .login-card { 
            width: 90%; max-width: 400px; padding: 40px; border-radius: 20px; background: rgba(10,10,10,0.95); 
            border: 2px solid var(--p); box-shadow: 0 0 40px rgba(0, 255, 65, 0.2); text-align: center; z-index: 5;
        }
        .z-input { 
            width: 100%; padding: 15px; margin: 12px 0; background: #000; border: 1px solid #333; 
            color: var(--p); border-radius: 10px; font-family: 'Orbitron'; text-align: center; font-size: 1rem;
        }
        .zeta-logo-main { font-family: 'Orbitron'; font-weight: 900; font-size: 2.2rem; color: var(--p); text-shadow: 0 0 15px var(--p); margin-bottom: 20px; }

        /* HEADER Y CONTENEDORES */
        header { position: fixed; top: 0; width: 100%; height: 75px; background: rgba(0,0,0,0.9); border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 10000; backdrop-filter: blur(10px); }
        .container { position: relative; z-index: 10; padding: 100px 15px 40px; display: none; max-width: 600px; margin: 0 auto; }
        .active { display: block; animation: fadeIn 0.5s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* DISEÑO DE TARJETAS */
        .p-card { background: rgba(20,20,20,0.8); border: 1px solid #222; padding: 20px; border-radius: 15px; display: flex; align-items: center; margin-bottom: 15px; cursor: pointer; transition: 0.3s; border-left: 5px solid var(--p); }
        .p-card:active { transform: scale(0.95); background: #111; }
        .p-card span { font-size: 32px; margin-right: 20px; }
        .p-card b { font-family: 'Orbitron'; font-size: 1.1rem; }

        .prod-box { background: #080808; border: 1px solid #1a1a1a; padding: 20px; border-radius: 20px; margin-bottom: 25px; border-top: 4px solid var(--p); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .row-p { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #151515; font-size: 1.1rem; }
        .row-p b { color: var(--p); font-family: 'Orbitron'; }

        .btn { width: 100%; padding: 16px; border: none; border-radius: 12px; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; margin-top: 10px; text-transform: uppercase; letter-spacing: 1px; }
        .btn-p { background: var(--p); color: #000; box-shadow: 0 0 20px rgba(0,255,65,0.4); }
        .btn-s { background: transparent; border: 1px solid var(--s); color: var(--s); }

        #t-modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.95); z-index:30000; align-items:center; justify-content:center; padding:20px; }
    </style>
</head>
<body>

<div id="particles-js"></div>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-card">
        <div class="zeta-logo-main">ZETA HACKS</div>
        <div id="step-1">
            <p style="color: #666; font-size: 0.7rem; letter-spacing: 3px;">INGRESE CLAVE DE ACCESO</p>
            <input type="password" id="m_pass" class="z-input" placeholder="••••••••">
            <button class="btn btn-p" onclick="verificarClave()">SIGUIENTE</button>
        </div>
        <div id="step-2" style="display:none;">
            <p style="color: var(--s); font-size: 0.7rem; letter-spacing: 3px;">CLAVE ACEPTADA - NOMBRE DE AGENTE</p>
            <input type="text" id="m_user" class="z-input" placeholder="NOMBRE DEL AGENTE">
            <button class="btn btn-p" onclick="finalizarAcceso()">INICIALIZAR SISTEMA</button>
        </div>
    </div>
</div>

<header><div class="zeta-logo-main" style="font-size: 1.5rem; margin:0;">ZETA HACKS</div></header>

<div id="p-home" class="container active">
    <h2 style="text-align:center; font-family:'Orbitron'; color:var(--s); font-size:1rem; margin-bottom:30px;">CENTRAL DE REGIONES</h2>
    <div id="list-p"></div>
</div>

<div id="p-detail" class="container">
    <button onclick="irHome()" style="background:none; border:none; color:var(--p); font-family:'Orbitron'; cursor:pointer; margin-bottom:20px;"><i class="fa fa-arrow-left"></i> VOLVER AL PANEL</button>
    <div id="cont-d"></div>
</div>

<div id="t-modal">
    <div style="background:#0a0a0a; border:1px solid var(--s); padding:25px; border-radius:20px; width:100%; max-width:400px;">
        <h3 style="color:var(--s); font-family:'Orbitron'; text-align:center;">DATOS DE VENTA</h3>
        <input type="text" id="t_cli" class="z-input" placeholder="CLIENTE">
        <input type="text" id="t_val" class="z-input" placeholder="PRECIO TOTAL">
        <input type="text" id="t_dias" class="z-input" placeholder="DURACIÓN">
        <input type="hidden" id="t_prod">
        <button class="btn btn-p" onclick="generar()">DESCARGAR TICKET</button>
        <button class="btn btn-s" onclick="document.getElementById('t-modal').style.display='none'">CANCELAR</button>
    </div>
</div>

<canvas id="canvas" width="500" height="700" style="display:none;"></canvas>

<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
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
        {n:"PARAGUAY", b:"🇵🇾", t:7600, c:"PYG", m:"🏦 Itau: 300406285 (Diego Leiva)\n💳 Personal: 0993363424"},
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
    s.pitch = 0.8; s.rate = 0.9;
    speechSynthesis.speak(s);
}

function verificarClave() {
    if(document.getElementById('m_pass').value === "EmpresaPrivada2026") {
        document.getElementById('step-1').style.display='none';
        document.getElementById('step-2').style.display='block';
        hablar("Clave correcta. Identifíquese Agente.");
    } else { alert("ERROR"); hablar("Acceso denegado"); }
}

async function finalizarAcceso() {
    const n = document.getElementById('m_user').value;
    const p = document.getElementById('m_pass').value;
    if(!n) return alert("NOMBRE REQUERIDO");
    const fd = new FormData(); fd.append('accion','login'); fd.append('n',n); fd.append('p',p);
    const r = await fetch('process.php', {method:'POST', body:fd});
    if(await r.text()==='ok') { hablar("Bienvenido Agente "+n); location.reload(); }
}

const list = document.getElementById('list-p');
DB.paises.forEach(p => {
    list.innerHTML += `<div class="p-card" onclick="ver('${p.n}')"><span>${p.b}</span><b>${p.n}</b></div>`;
});

function ver(n) {
    const p = DB.paises.find(x => x.n === n);
    document.getElementById('p-home').classList.remove('active');
    document.getElementById('p-detail').classList.add('active');
    hablar("Región " + n);
    let h = `<div style="background:rgba(0,242,255,0.05); border:1px dashed var(--s); padding:15px; border-radius:12px; margin-bottom:25px; color:var(--s);"><b>MÉTODOS ${p.n}:</b><br>${p.m.replace(/\n/g,'<br>')}</div>`;
    DB.prods.forEach(cat => {
        h += `<h2 style="color:var(--p); font-family:'Orbitron'; font-size:0.9rem; margin-top:30px;">🔱 ${cat.cat}</h2>`;
        cat.items.forEach(i => {
            let row = ""; let copy = `💎 LISTA DE PRECIOS: ${i.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            i.d.forEach((d, idx) => {
                let px = Math.ceil(i.p[idx] * p.t);
                let tag = isNaN(d) ? d : d + " DÍAS";
                row += `<div class="row-p"><span>✅ ${tag}</span><b>${px} ${p.c}</b></div>`;
                copy += `✅ ${tag}: ${px} ${p.c}\n`;
            });
            h += `<div class="prod-box"><h3>${i.n}</h3>${row}
            <div style="display:flex; gap:10px; margin-top:15px;">
                <button class="btn btn-s" style="flex:1" onclick="copiar('${copy.replace(/'/g,"\\'")}')">COPIAR</button>
                <button class="btn btn-p" style="flex:2" onclick="abrirT('${i.n}')">GENERAR VENTA</button>
            </div></div>`;
        });
    });
    document.getElementById('cont-d').innerHTML = h;
}

function abrirT(p) { document.getElementById('t-modal').style.display='flex'; document.getElementById('t_prod').value = p; hablar("Preparando ticket"); }

function generar() {
    const c = document.getElementById('canvas'); const x = c.getContext('2d');
    const cli = document.getElementById('t_cli').value || "CLIENTE";
    const prod = document.getElementById('t_prod').value;
    const val = document.getElementById('t_val').value;
    const dias = document.getElementById('t_dias').value;

    x.fillStyle="#000"; x.fillRect(0,0,500,700);
    x.strokeStyle="#00ff41"; x.lineWidth=10; x.strokeRect(10,10,480,680);
    x.fillStyle="#00ff41"; x.font="bold 45px Orbitron"; x.textAlign="center"; x.fillText("ZETA HACKS", 250, 100);
    x.textAlign="left"; x.font="24px Orbitron"; x.fillStyle="#00ff41";
    x.fillText("CLIENTE:", 50, 260); x.fillStyle="#fff"; x.fillText(cli.toUpperCase(), 200, 260);
    x.fillStyle="#00ff41"; x.fillText("PRODUCTO:", 50, 330); x.fillStyle="#fff"; x.fillText(prod, 200, 330);
    x.fillStyle="#00ff41"; x.fillText("VALOR:", 50, 400); x.fillStyle="#fff"; x.fillText(val, 160, 400);
    x.fillStyle="#00ff41"; x.fillText("DÍAS:", 50, 470); x.fillStyle="#fff"; x.fillText(dias, 140, 470);
    x.fillStyle="#00ff41"; x.fillText("AGENTE:", 50, 540); x.fillStyle="#fff"; x.fillText("<?=$_SESSION['agente']?>", 170, 540);
    
    const a = document.createElement('a'); a.download=`Ticket-${cli}.png`; a.href=c.toDataURL(); a.click();
    hablar("Ticket descargado");
}

function copiar(t) { navigator.clipboard.writeText(t); hablar("Copiado"); alert("COPIADO"); }
function irHome() { document.getElementById('p-detail').classList.remove('active'); document.getElementById('p-home').classList.add('active'); }
particlesJS("particles-js", {"particles":{"number":{"value":80},"color":{"value":"#00ff41"},"shape":{"type":"circle"},"opacity":{"value":0.5},"size":{"value":3},"line_linked":{"enable":true,"distance":150,"color":"#00ff41","opacity":0.4,"width":1},"move":{"enable":true,"speed":2}}});
</script>
</body>
</html>
