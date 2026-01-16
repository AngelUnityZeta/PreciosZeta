<?php session_start(); $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | V12 ELITE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Rajdhani:wght@500;700&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #030303; }
        * { box-sizing: border-box; outline: none; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; }
        
        /* LOGIN CYBERPUNK */
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 99999; display: flex; align-items: center; justify-content: center; }
        .login-card { 
            width: 85%; max-width: 350px; padding: 40px; background: #080808; border: 1px solid #1a1a1a; 
            border-radius: 20px; text-align: center; position: relative; overflow: hidden;
            box-shadow: 0 0 30px rgba(0,255,65,0.1);
        }
        .login-card::after {
            content: ''; position: absolute; top: -100%; left: 0; width: 100%; height: 4px;
            background: var(--p); box-shadow: 0 0 15px var(--p);
            animation: scan 4s linear infinite; opacity: 0.5;
        }
        @keyframes scan { 0% { top: 0%; } 100% { top: 100%; } }

        .z-input { width: 100%; padding: 15px; margin: 10px 0; background: #000; border: 1px solid #222; color: var(--p); border-radius: 10px; font-family: 'Orbitron'; text-align: center; font-size: 0.8rem; }
        .btn { width: 100%; padding: 16px; border: none; border-radius: 12px; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; text-transform: uppercase; transition: 0.3s; }
        .btn-p { background: var(--p); color: #000; box-shadow: 0 0 20px rgba(0,255,65,0.4); }

        header { position: fixed; top: 0; width: 100%; height: 70px; background: rgba(0,0,0,0.9); border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(10px); }
        .container { padding: 90px 15px 40px; display: none; max-width: 600px; margin: 0 auto; }
        .active { display: block; animation: fadeIn 0.5s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .p-card { background: #0d0d0d; border: 1px solid #1a1a1a; padding: 18px; border-radius: 15px; display: flex; align-items: center; margin-bottom: 12px; cursor: pointer; border-left: 5px solid var(--p); transition: 0.2s; }
        .p-card:active { transform: scale(0.95); }
        .p-card span { font-size: 30px; margin-right: 15px; }

        .prod-box { background: #080808; border: 1px solid #151515; padding: 20px; border-radius: 20px; margin-bottom: 25px; border-top: 4px solid var(--p); }
        .row-v { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #111; }
        .row-v b { color: var(--p); font-family: 'Orbitron'; }
        
        .fab { position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; background: var(--p); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000; font-size: 25px; box-shadow: 0 0 20px var(--p); z-index: 5000; cursor: pointer; }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-card">
        <h2 style="font-family:'Orbitron'; color:var(--p); letter-spacing:3px;">PRECIOS ZETA</h2>
        <p style="color:#555; font-size:0.7rem;">SISTEMA DE ACCESO RESTRINGIDO</p>
        <input type="text" id="m_u" class="z-input" placeholder="USUARIO">
        <input type="password" id="m_p" class="z-input" placeholder="CONTRASEÑA">
        <button class="btn btn-p" onclick="login()">AUTENTICAR</button>
    </div>
</div>

<header><div style="font-family:'Orbitron'; font-weight:900; color:var(--p); font-size:1.4rem;">PRECIOS ZETA</div></header>

<div id="p-home" class="container active">
    <div id="list-p"></div>
</div>

<div id="p-detail" class="container">
    <button onclick="irHome()" class="btn" style="background:#111; color:var(--s); width:auto; padding:8px 20px; margin-bottom:20px; border:1px solid #222">VOLVER</button>
    <div id="cont-d"></div>
</div>

<div class="fab" onclick="document.getElementById('file-in').click()"><i class="fa fa-camera"></i></div>
<input type="file" id="file-in" style="display:none;" onchange="subir(this)" accept="image/*">

<script>
const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS", m:"💳 MERCADO PAGO Y UALA: 0000007900203350273548 | Alias: C.CORREA1315.UALA"},
        {n:"BOLIVIA", b:"🇧🇴", t:12, c:"BS", m:"📌 QR SOPORTE\n💰 Tasa: 12.00 BS x 1 USD"},
        {n:"BRASIL", b:"🇧🇷", t:5.20, c:"BRL", m:"🟢 PIX: 91991076791"},
        {n:"CHILE", b:"🇨🇱", t:970, c:"CLP", m:"🏪 Banco Estado: 23710151\n👤 XAVIER FUENZALIDA"},
        {n:"COLOMBIA", b:"🇨🇴", t:3900, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu Bank: @PMG3555"},
        {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD", m:"🟨 Banco Pichincha: 2207195565"},
        {n:"ESPAÑA", b:"🇪🇸", t:1, c:"EUR", m:"💶 Bizum: 634033557\n👤 Yanni Hernández"},
        {n:"ESTADOS UNIDOS", b:"🇺🇸", t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.80, c:"GTQ", m:"🟩 Banrural: 4431164091"},
        {n:"HONDURAS", b:"🇭🇳", t:25, c:"HNL", m:"🔵 Bampais: 216400100524"},
        {n:"MÉXICO", b:"🇲🇽", t:20, c:"MXN", m:"🏦 Albo / Nu México: 5101 2506 8691 9389"},
        {n:"NICARAGUA", b:"🇳🇮", t:37, c:"NIO", m:"🏦 BAC Nicaragua: 371674409"},
        {n:"PANAMÁ", b:"🇵🇦", t:1, c:"USD", m:"🟠 Punto Pago Wally: +584128975265\n🟣 Zinli: chauran2001@gmail.com"},
        {n:"PARAGUAY", b:"🇵🇾", t:7500, c:"PYG", m:"🏦 Banco Itau: 300406285\n👤 Diego Leiva"},
        {n:"PERÚ", b:"🇵🇪", t:3.55, c:"PEN", m:"🟣 Yape/Plin: 954302258"},
        {n:"DOMINICANA", b:"🇩🇴", t:70, c:"DOP", m:"🟦 Banreservas: 9601546622"},
        {n:"VENEZUELA", b:"🇻🇪", t:550, c:"VES", m:"🟡 Pago Móvil: 0102 32958486 04125805981"}
    ],
    prods: [
        {cat:"ANDROID", items:[
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,20]},
            {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,20]},
            {n:"CUBAN MODS", d:[1,10,20,31], p:[3,9,13,19]},
            {n:"BR MODS + VIRTUAL", d:[1,7,15,30], p:[6,12,19,30]},
            {n:"BR MODS MOBILE", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"HG CHEATS", d:[1,10,30], p:[3,12,20]},
            {n:"HG CHEATS + VIRTUAL", d:[1,10,30], p:[5,16,25]},
            {n:"STRICK BR", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"STRICK BR + VIRTUAL", d:[1,7,15,30], p:[6,12,16,30]}
        ]},
        {cat:"IOS", items:[
            {n:"CERTIFICADOS GBOX", d:["12 MESES"], p:[20]},
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[22,35,50]},
            {n:"FLOURITE SOLO", d:[1,7,30], p:[5,16,30]},
            {n:"PANEL IOS", d:[7,30], p:[12,19]}
        ]},
        {cat:"PC", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERM"], p:[3,8,16,30]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

function hablar(txt) {
    const s = new SpeechSynthesisUtterance(txt);
    s.lang = 'es-ES'; s.pitch = 0.8; s.rate = 1;
    window.speechSynthesis.speak(s);
}

function login() {
    const fd = new FormData();
    fd.append('accion','login'); fd.append('u',document.getElementById('m_u').value); fd.append('p',document.getElementById('m_p').value);
    fetch('process.php',{method:'POST',body:fd}).then(r=>r.text()).then(res=>{
        if(res.trim()==='ok'){
            document.getElementById('bloqueo').style.display='none';
            hablar("Acceso verificado. Bienvenido."); renderHome();
        } else { 
            alert("USUARIO O CLAVE INCORRECTA"); 
            hablar("Acceso denegado.");
        }
    });
}

function renderHome() {
    const l = document.getElementById('list-p');
    l.innerHTML = '<p style="text-align:center; color:#555; letter-spacing:2px; font-size:0.8rem;">SOPORTE: +591 69591926</p>';
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        l.innerHTML += `<div class="p-card" onclick="verP('${p.n}')"><span>${p.b}</span><b>${p.n}</b></div>`;
    });
}

function verP(n) {
    const p = DB.paises.find(x => x.n === n);
    document.getElementById('p-home').classList.remove('active');
    document.getElementById('p-detail').classList.add('active');
    hablar("Región " + n);
    let h = `<div style="background:rgba(0,255,65,0.05); border:1px solid var(--p); padding:15px; border-radius:15px; margin-bottom:20px; color:var(--s); font-size:0.9rem;"><b>MÉTODOS DE PAGO:</b><br>${p.m.replace(/\n/g,'<br>')}</div>`;
    
    DB.prods.forEach(cat => {
        h += `<h2 style="color:var(--p); font-family:Orbitron; font-size:0.9rem; margin-top:25px;">🔱 ${cat.cat}</h2>`;
        cat.items.forEach(i => {
            let row = ""; let clip = `💎 LISTA DE PRECIOS: ${i.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            i.d.forEach((d, idx) => {
                let px = Math.ceil(i.p[idx] * p.t);
                let tag = isNaN(d) ? d : d + " DÍAS";
                row += `<div class="row-v"><span>✅ ${tag}</span><b>${px.toLocaleString()} ${p.c}</b></div>`;
                clip += `✅ ${tag}: ${px.toLocaleString()} ${p.c}\n`;
            });
            h += `<div class="prod-box"><h3>${i.n}</h3>${row}
            <button class="btn btn-p" style="margin-top:10px; padding:10px; font-size:0.7rem" onclick="copiar(this, \`${clip}\`)">COPIAR LISTA</button></div>`;
        });
    });
    document.getElementById('cont-d').innerHTML = h;
}

function copiar(btn, txt) {
    navigator.clipboard.writeText(txt);
    const old = btn.innerText; btn.innerText = "¡COPIADO!";
    hablar("Lista copiada");
    setTimeout(() => btn.innerText = old, 2000);
}

function subir(input) {
    if(!input.files[0]) return;
    const fd = new FormData(); fd.append('accion','comprobante'); fd.append('foto',input.files[0]);
    fetch('process.php', {method:'POST', body:fd}).then(() => {
        hablar("Comprobante enviado con éxito");
        alert("ENVIADO A TELEGRAM ✅");
    });
}

function irHome() { document.getElementById('p-detail').classList.remove('active'); document.getElementById('p-home').classList.add('active'); }
if("<?=$auth?>") renderHome();
</script>
</body>
</html>
