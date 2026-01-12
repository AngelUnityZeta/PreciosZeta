<?php include 'process.php'; $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | OVERLORD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;700&family=Orbitron:wght@600;900&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #050505; --card: rgba(15,15,15,0.95); }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Fira Code', monospace; overflow: hidden; height: 100vh; }
        canvas#matrix { position: fixed; inset: 0; z-index: -1; opacity: 0.2; }
        
        .wsp-float { position: fixed; bottom: 25px; right: 25px; background: #25d366; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; color: #fff; z-index: 15000; box-shadow: 0 0 20px rgba(37,211,102,0.5); text-decoration: none; animation: pulse 2s infinite; }
        @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }

        #lock { position: fixed; inset: 0; background: #000; z-index: 20000; display: flex; align-items: center; justify-content: center; }
        .login-box { width: 85%; max-width: 380px; padding: 40px; background: var(--card); border: 2px solid var(--p); text-align: center; }
        
        header { position: fixed; top: 0; width: 100%; height: 70px; background: #000; border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: space-between; padding: 0 25px; z-index: 10000; }
        .neon { font-family: 'Orbitron'; color: var(--p); text-shadow: 0 0 10px var(--p); }

        .sidebar { position: fixed; left: -100%; top: 0; width: 280px; height: 100%; background: #000; border-right: 2px solid var(--p); transition: 0.4s; z-index: 11000; padding-top: 100px; }
        .sidebar.active { left: 0; }
        .sidebar a { display: block; padding: 20px 30px; color: #888; text-decoration: none; border-bottom: 1px solid #111; }

        .container { display: none; padding: 100px 20px 80px; max-width: 800px; margin: 0 auto; height: 100vh; overflow-y: auto; }
        .container.active { display: block; }

        .card { background: var(--card); border: 1px solid #222; padding: 20px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid var(--p); }
        input { width: 100%; padding: 15px; margin-bottom: 15px; background: #000; border: 1px solid #333; color: var(--p); font-family: 'Fira Code'; }
        .btn-zeta { width: 100%; padding: 15px; background: var(--p); color: #000; border: none; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; }
        .price-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #111; font-size: 13px; }
    </style>
</head>
<body>
<canvas id="matrix"></canvas>
<a href="https://wa.me/59169591926" class="wsp-float" target="_blank"><i class="fab fa-whatsapp"></i></a>

<div id="lock" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-box">
        <h1 class="neon">ZETA HACKS</h1>
        <div id="step1"><input type="password" id="m_pass" placeholder="MASTER KEY"><button class="btn-zeta" onclick="next()">VALIDAR</button></div>
        <div id="step2" style="display:none;"><input type="text" id="m_user" placeholder="AGENTE"><button class="btn-zeta" onclick="login()">INFILTRARSE</button></div>
    </div>
</div>

<header>
    <div onclick="toggleMenu()" style="cursor:pointer; color:var(--p); font-size:25px;"><i class="fa fa-bars"></i></div>
    <div class="neon" style="font-size:16px;">ZETA HACKS</div>
    <div id="reloj" style="color:var(--s);">00:00:00</div>
</header>

<nav class="sidebar" id="nav">
    <a onclick="go('inicio')">DASHBOARD</a>
    <a onclick="go('market')">COTIZADOR</a>
    <a onclick="go('ticket')">GENERAR TICKET</a>
    <a onclick="loadHistory()">HISTORIAL VENTAS</a>
    <a href="?logout=1" style="color:red;">LOGOUT</a>
</nav>

<section id="inicio" class="container active">
    <div style="text-align:center; margin-top:20vh;">
        <h1 class="neon" style="font-size:60px;">ZETA</h1>
        <p>AGENTE ACTIVO: <span style="color:var(--p);"><?= $_SESSION['agente'] ?? 'S/N' ?></span></p>
    </div>
</section>

<section id="market" class="container">
    <input type="text" id="busq" placeholder="INTRODUCE EL PAÍS..." onkeyup="render()">
    <div id="market_content"></div>
</section>

<section id="ticket" class="container">
    <div class="card">
        <h3 class="neon" style="text-align:center;">COMPROBANTE V.12</h3>
        <input id="tk_c" placeholder="CLIENTE"><input id="tk_p" placeholder="PRODUCTO"><input id="tk_d" placeholder="DURACIÓN"><input id="tk_m" placeholder="VALOR TOTAL">
        <button class="btn-zeta" onclick="genTicket()">GENERAR Y REGISTRAR</button>
        <canvas id="tCanvas" width="500" height="750" style="display:none;"></canvas>
    </div>
</section>

<section id="historial" class="container">
    <h2 class="neon">HISTORIAL RECIENTE</h2>
    <div id="h_content"></div>
</section>

<script>
const DATA = {
    rates: {
        "BOLIVIA": {t:12, c:"BS", m:"📌 Escanee el código QR que le mande el número soporte.\n💰 Tasa: 12.00"},
        "MEXICO": {t:20, c:"MXN", m:"🏦 Albo (Transferencias)\n🏪 Nu México (Depósito OXXO): 5101 2506 8691 9389\n💰 Tasa: 20.00"},
        "ARGENTINA": {t:1500, c:"ARS", m:"📋 Mercado Pago: oscar.hs.m"},
        "BRASIL": {t:5.2, c:"BRL", m:"🟢 PIX: 91991076791"},
        "CHILE": {t:970, c:"CLP", m:"🏪 Banco Estado: RUT 23.710.151-0 (Titular: XAVIER FUENZALIDA)"},
        "COLOMBIA": {t:4300, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu Bank: @PMG3555"},
        "ECUADOR": {t:1, c:"USD", m:"🟨 Banco Pichincha: 2207195565"},
        "ESPAÑA": {t:1, c:"EUR", m:"💶 Bizum: 634033557 (Yanni Hernández)"},
        "USA": {t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"},
        "GUATEMALA": {t:7.8, c:"GTQ", m:"🟩 Banrural: 4431164091"},
        "HONDURAS": {t:24.7, c:"HNL", m:"🔵 Bampais: 216400100524"},
        "NICARAGUA": {t:38, c:"NIO", m:"🏦 BAC Nicaragua: 371674409"},
        "PANAMA": {t:1, c:"USD", m:"🟠 Punto Pago Wally: +584128975265\n🟣 Zinli: chauran2001@gmail.com"},
        "PARAGUAY": {t:7300, c:"PYG", m:"🏦 Banco Itau: 300406285 (Diego Leiva)\n💳 Billetera Personal: 0993363424"},
        "PERU": {t:3.75, c:"PEN", m:"🟣 Yape/Plin: 954302258"},
        "DOMINICANA": {t:60, c:"DOP", m:"🟦 Banreservas: 9601546622\n🔴 Banco Popular: 837147719"},
        "VENEZUELA": {t:279, c:"VES", m:"🟡 Pago Móvil: 0102 32958486 04125805981"}
    },
    prods: [
        {cat:"ANDROID", items:[
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"CUBAN MODS", d:[1,10,20,31], p:[3,9,13,19]},
            {n:"BR MODS + VIRTUAL", d:[1,6,15,30], p:[6,12,19,28]},
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

function toggleMenu(){ document.getElementById('nav').classList.toggle('active'); }
function go(id){ document.querySelectorAll('.container').forEach(c=>c.classList.remove('active')); document.getElementById(id).classList.add('active'); toggleMenu(); }
function next(){ document.getElementById('step1').style.display='none'; document.getElementById('step2').style.display='block'; }

async function login(){
    const fd=new FormData(); fd.append('action','login'); fd.append('p',document.getElementById('m_pass').value); fd.append('n',document.getElementById('m_user').value);
    const r=await fetch('process.php', {method:'POST', body:fd});
    if(await r.text()==='ok') location.reload(); else alert("DENEGADO");
}

function render(){
    const q=document.getElementById('busq').value.toUpperCase().trim();
    const d=document.getElementById('market_content'); d.innerHTML='';
    if(!DATA.rates[q]) return;
    const rt=DATA.rates[q];
    let h=`<div class="card"><b>💳 PAGOS ${q}:</b><br><small style="white-space:pre-line;">${rt.m}</small></div>`;
    DATA.prods.forEach(c=>{
        h+=`<h2 class="neon" style="font-size:14px; margin-top:25px;">📂 ${c.cat}</h2>`;
        c.items.forEach(it=>{
            let card=`<div class="card"><b>💎 ${it.n}</b>`;
            let raw=`💎 *ZETA HACKS - ${it.n}*\n📍 *Región: ${q}*\n───────────────────\n`;
            it.d.forEach((day, i)=>{
                let v=Math.ceil(it.p[i]*rt.t).toLocaleString();
                let lb=typeof day === 'number' ? day + " DÍAS" : day;
                card+=`<div class="price-row"><span>✅ ${lb}</span> <b>${v} ${rt.c}</b></div>`;
                raw+=`✅ ${lb}: ${v} ${rt.c}\n`;
            });
            raw+=`\n💳 *MÉTODOS:* ${rt.m}`;
            h+=card+`<button class="btn-zeta" style="padding:10px; font-size:10px; margin-top:10px;" onclick="copy('${btoa(unescape(encodeURIComponent(raw)))}')">CLONAR INFO</button></div>`;
        });
    });
    d.innerHTML=h;
}

function copy(b){
    const txt=decodeURIComponent(escape(atob(b))); navigator.clipboard.writeText(txt);
    const fd=new FormData(); fd.append('action', 'log_copy'); fd.append('info', txt);
    fetch('process.php', {method:'POST', body:fd});
    alert("INFORMACIÓN COPIADA Y REPORTADA");
}

async function loadHistory(){
    const r=await fetch('process.php?action=get_history', {method:'POST', body:new FormData()});
    const v=await r.json();
    let h='';
    v.forEach(x=> h+=`<div class="card" style="font-size:12px;"><b>${x.f}</b> | Agente: ${x.a}<br>📦 ${x.p} -> ${x.c}<br><b style="color:var(--p)">${x.m}</b></div>`);
    document.getElementById('h_content').innerHTML = h || 'SIN VENTAS';
    go('historial');
}

function genTicket(){
    const c=document.getElementById('tCanvas'); const ctx=c.getContext('2d');
    const cli=document.getElementById('tk_c').value.toUpperCase() || 'CLIENTE';
    const prd=document.getElementById('tk_p').value.toUpperCase();
    const dur=document.getElementById('tk_d').value.toUpperCase();
    const mon=document.getElementById('tk_m').value.toUpperCase();
    const tid="ZH-"+Math.floor(Math.random()*90000+10000);
    const fecha=new Date().toLocaleDateString();

    ctx.fillStyle="#0a0a0a"; ctx.fillRect(0,0,500,750);
    ctx.strokeStyle="#00ff41"; ctx.lineWidth=10; ctx.strokeRect(10,10,480,730);
    ctx.fillStyle="#00ff41"; ctx.textAlign="center"; ctx.font="bold 25px Orbitron";
    ctx.fillText("━━━━━━━━━━━━━━━━━━━━━", 250, 60);
    ctx.font="bold 35px Orbitron"; ctx.fillText("🔥 ZETA HACKS 🔥", 250, 100);
    ctx.font="bold 20px Orbitron"; ctx.fillText("🧾 COMPROBANTE OFICIAL 🧾", 250, 140);
    ctx.font="bold 25px Orbitron"; ctx.fillText("━━━━━━━━━━━━━━━━━━━━━", 250, 175);

    ctx.textAlign="left"; ctx.font="20px Fira Code"; ctx.fillStyle="#fff";
    ctx.fillText("👤 CLIENTE:   "+cli, 50, 250);
    ctx.fillText("📦 PRODUCTO:  "+prd, 50, 300);
    ctx.fillText("⏳ DURACIÓN:  "+dur, 50, 350);
    ctx.fillStyle="#00f2ff"; ctx.font="bold 30px Fira Code"; ctx.fillText("💰 VALOR:     "+mon, 50, 420);
    ctx.fillStyle="#666"; ctx.font="16px Fira Code"; ctx.fillText("🆔 ID TRANS:  "+tid, 50, 500);
    ctx.fillText("📅 FECHA:     "+fecha, 50, 530);

    ctx.fillStyle="#00ff41"; ctx.textAlign="center"; ctx.font="bold 25px Orbitron";
    ctx.fillText("━━━━━━━━━━━━━━━━━━━━━", 250, 580);
    ctx.font="14px Fira Code"; ctx.fillText("✅ Este ticket valida su compra", 250, 615);
    ctx.fillText("en nuestro sistema privado.", 250, 635);
    ctx.font="bold 25px Orbitron"; ctx.fillText("━━━━━━━━━━━━━━━━━━━━━", 250, 670);
    ctx.fillStyle="#fff"; ctx.font="bold 18px Orbitron"; ctx.fillText("🙏 GRACIAS POR SU COMPRA 🙏", 250, 710);

    const link=document.createElement('a'); link.download=`Ticket_Zeta_${cli}.png`; link.href=c.toDataURL(); link.click();
    const fd=new FormData(); fd.append('action','log_ticket'); fd.append('c',cli); fd.append('p',prd); fd.append('m',mon);
    fetch('process.php', {method:'POST', body:fd});
    alert("TICKET DESCARGADO Y REGISTRADO");
}

// MATRIX BG
const mC=document.getElementById('matrix'); const mCtx=mC.getContext('2d');
mC.width=window.innerWidth; mC.height=window.innerHeight;
const l="ZETAHACKS01"; const fs=18; const cls=mC.width/fs; const drp=Array(Math.floor(cls)).fill(1);
function draw(){
    mCtx.fillStyle="rgba(0,0,0,0.05)"; mCtx.fillRect(0,0,mC.width,mC.height);
    mCtx.fillStyle="#0f0"; mCtx.font=fs+"px monospace";
    drp.forEach((y, i)=>{
        mCtx.fillText(l[Math.floor(Math.random()*l.length)], i*fs, y*fs);
        if(y*fs>mC.height && Math.random()>0.975) drp[i]=0; drp[i]++;
    });
}
setInterval(draw, 50);
setInterval(()=>document.getElementById('reloj').innerText=new Date().toLocaleTimeString(),1000);
</script>
</body>
</html>
