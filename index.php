<?php session_start(); $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | V12 OFFICIAL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Rajdhani:wght@500;700&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #020202; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; background-image: radial-gradient(circle at 50% 50%, #0a150a 0%, #020202 100%); background-attachment: fixed; }
        
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 99999; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 85%; max-width: 360px; padding: 40px; background: rgba(10,10,10,0.9); border: 1px solid #1a1a1a; border-radius: 25px; text-align: center; border-top: 4px solid var(--p); box-shadow: 0 10px 50px rgba(0,255,65,0.1); }
        .z-input { width: 100%; padding: 15px; margin: 10px 0; background: #000; border: 1px solid #222; color: var(--p); border-radius: 12px; font-family: 'Orbitron'; text-align: center; transition: 0.3s; }
        .z-input:focus { border-color: var(--p); box-shadow: 0 0 15px rgba(0,255,65,0.2); }
        
        header { position: fixed; top: 0; width: 100%; height: 75px; background: rgba(0,0,0,0.8); backdrop-filter: blur(15px); border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 1000; }
        .container { padding: 100px 15px 40px; display: none; max-width: 600px; margin: 0 auto; }
        .active { display: block; animation: slideUp 0.4s ease; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .p-card { background: rgba(20,20,20,0.6); border: 1px solid #222; padding: 18px; border-radius: 15px; display: flex; align-items: center; margin-bottom: 12px; cursor: pointer; transition: 0.3s; position: relative; overflow: hidden; }
        .p-card:hover { border-color: var(--p); background: rgba(0,255,65,0.05); }
        .p-card span { font-size: 28px; margin-right: 15px; }

        .prod-box { background: rgba(10,10,10,0.8); border: 1px solid #1a1a1a; padding: 25px; border-radius: 20px; margin-bottom: 25px; border-bottom: 4px solid var(--p); }
        .row-v { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #151515; font-size: 1.1rem; }
        .row-v b { color: var(--p); font-family: 'Orbitron'; }
        
        .method-box { background: #050505; border: 1px dashed var(--s); padding: 15px; border-radius: 12px; margin-bottom: 20px; font-size: 0.9rem; line-height: 1.6; color: #ccc; }
        .btn { width: 100%; padding: 16px; border: none; border-radius: 12px; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; text-transform: uppercase; transition: 0.3s; }
        .btn-p { background: var(--p); color: #000; box-shadow: 0 5px 20px rgba(0,255,65,0.3); }
        .fab { position: fixed; bottom: 25px; right: 25px; width: 65px; height: 65px; background: var(--p); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000; font-size: 28px; box-shadow: 0 0 30px var(--p); z-index: 5000; }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-card">
        <h2 style="font-family:'Orbitron'; color:var(--p); letter-spacing:4px; margin:0;">ZETA HACKS</h2>
        <p style="color:#555; font-size:0.8rem; margin-bottom:25px;">SISTEMA DE VENTAS V12</p>
        <input type="text" id="m_u" class="z-input" placeholder="ACCESO USUARIO">
        <input type="password" id="m_p" class="z-input" placeholder="PASSWORD">
        <button class="btn btn-p" onclick="login()">AUTENTICAR</button>
    </div>
</div>

<header><div style="font-family:'Orbitron'; font-weight:900; color:var(--p); font-size:1.4rem; text-shadow: 0 0 10px var(--p);">ZETA HACKS</div></header>

<div id="p-home" class="container active">
    <div id="list-p"></div>
</div>

<div id="p-detail" class="container">
    <button onclick="irHome()" class="btn" style="background:#111; color:var(--s); width:auto; padding:8px 25px; margin-bottom:20px; border:1px solid #222"> < VOLVER</button>
    <div id="cont-d"></div>
</div>

<div class="fab" onclick="document.getElementById('file-in').click()"><i class="fa fa-upload"></i></div>
<input type="file" id="file-in" style="display:none;" onchange="subir(this)">

<script>
const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1020, c:"ARS", m:"💳 MERCADO PAGO:\n📋 oscar.hs.m"},
        {n:"BOLIVIA", b:"🇧🇴", t:12, c:"BS", m:"📌 QR SOPORTE (Pedir al soporte)\n💰 Tasa: 12.00 por Dólar"},
        {n:"BRASIL", b:"🇧🇷", t:5.5, c:"BRL", m:"🟢 PIX (TRANSFERENCIA):\n📋 Chave PIX: 91991076791"},
        {n:"CHILE", b:"🇨🇱", t:970, c:"CLP", m:"🏪 Banco Estado (Caja Vecina)\n📋 Titular: XAVIER FUENZALIDA\n📋 RUT: 23.710.151-0\n📋 Cuenta: 23710151"},
        {n:"COLOMBIA", b:"🇨🇴", t:4400, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu Bank: @PMG3555"},
        {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD", m:"🟨 Banco Pichincha: 2207195565"},
        {n:"ESPAÑA", b:"🇪🇸", t:1, c:"EUR", m:"💶 Bizum: 634033557\n👤 Nombre: Yanni Hernández"},
        {n:"USA", b:"🇺🇸", t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.8, c:"GTQ", m:"🟩 Banrural: 4431164091"},
        {n:"HONDURAS", b:"🇭🇳", t:25, c:"HNL", m:"🔵 Bampais: 216400100524"},
        {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN", m:"🏦 Albo / Nu: 5101 2506 8691 9389"},
        {n:"PERU", b:"🇵🇪", t:3.8, c:"PEN", m:"🟣 Yape/Plin: 954302258"},
        {n:"VENEZUELA", b:"🇻🇪", t:300, c:"VES", m:"🟡 Pago Móvil: 0102 32958486 04125805981"}
    ],
    prods: [
        {cat:"ANDROID PREMIUM", items:[
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[5,12,18,25]},
            {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[5,12,18,25]},
            {n:"CUBAN MODS", d:[1,10,20,31], p:[5,15,22,35]},
            {n:"BR MODS + VIRTUAL", d:[1,7,15,30], p:[8,18,28,40]}
        ]},
        {cat:"PC & IOS HIGH", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERM"], p:[6,15,30,55]},
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[25,45,65]}
        ]}
    ]
};

function login() {
    const fd = new FormData();
    fd.append('accion','login'); fd.append('u',document.getElementById('m_u').value); fd.append('p',document.getElementById('m_p').value);
    fetch('process.php',{method:'POST',body:fd}).then(r=>r.text()).then(res=>{
        if(res.trim()==='ok') { document.getElementById('bloqueo').style.display='none'; renderHome(); }
        else { alert("ACCESO DENEGADO"); }
    });
}

function renderHome() {
    const l = document.getElementById('list-p');
    l.innerHTML = '<p style="text-align:center; color:var(--p); font-family:Orbitron; font-size:0.7rem; letter-spacing:2px;">SELECCIONE REGIÓN DE PAGO</p>';
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        l.innerHTML += `<div class="p-card" onclick="verP('${p.n}')"><span>${p.b}</span><b>${p.n}</b><i class="fa fa-chevron-right" style="position:absolute; right:20px; color:#333;"></i></div>`;
    });
}

function verP(n) {
    const p = DB.paises.find(x => x.n === n);
    document.getElementById('p-home').classList.remove('active');
    document.getElementById('p-detail').classList.add('active');
    window.scrollTo(0,0);
    let h = `<div class="method-box"><b>MÉTODOS DE PAGO ${p.n}:</b><br>${p.m.replace(/\n/g,'<br>')}</div>`;
    DB.prods.forEach(cat => {
        h += `<h2 style="color:var(--p); font-size:1rem; font-family:Orbitron; margin-top:30px;">🔱 ${cat.cat}</h2>`;
        cat.items.forEach(i => {
            let row = ""; let clip = `💎 LISTA DE PRECIOS: ${i.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            i.d.forEach((d, idx) => {
                let px = Math.ceil(i.p[idx] * p.t);
                let tag = isNaN(d) ? d : d + " DÍAS";
                row += `<div class="row-v"><span>✅ ${tag}</span><b>${px.toLocaleString()} ${p.c}</b></div>`;
                clip += `✅ ${tag}: ${px.toLocaleString()} ${p.c}\n`;
            });
            h += `<div class="prod-box"><h3>${i.n}</h3>${row}<button class="btn btn-p" style="margin-top:15px; padding:10px; font-size:0.7rem;" onclick="copiar(this, \`${clip}\`)">COPIAR LISTA</button></div>`;
        });
    });
    document.getElementById('cont-d').innerHTML = h;
}

function copiar(btn, txt) {
    navigator.clipboard.writeText(txt);
    btn.innerText = "¡COPIADO!"; setTimeout(() => btn.innerText = "COPIAR LISTA", 2000);
}

function subir(input) {
    if(!input.files[0]) return;
    const fd = new FormData(); fd.append('accion','comprobante'); fd.append('foto',input.files[0]);
    fetch('process.php',{method:'POST',body:fd}).then(()=>{ alert("COMPROBANTE ENVIADO ✅"); });
}

function irHome() { document.getElementById('p-detail').classList.remove('active'); document.getElementById('p-home').classList.add('active'); }
if("<?=$auth?>") renderHome();
</script>
</body>
</html>
