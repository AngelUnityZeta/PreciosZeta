<?php include 'process.php'; $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | V12 OFFICIAL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Rajdhani:wght@500;700&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #000; --card: #0a0a0a; }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; overflow-x: hidden; }
        
        /* LOGIN */
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 20000; display: flex; align-items: center; justify-content: center; text-align: center; }
        .login-box { width: 90%; max-width: 380px; padding: 40px 20px; border: 2px solid var(--p); border-radius: 20px; box-shadow: 0 0 30px rgba(0,255,65,0.2); }
        
        header { position: fixed; top: 0; width: 100%; height: 70px; background: #000; border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 10000; }
        .titulo-zeta { font-family: 'Orbitron'; color: var(--p); text-shadow: 0 0 10px var(--p); font-size: 1.5rem; letter-spacing: 4px; }

        .container { padding: 90px 15px 40px; min-height: 100vh; display: none; }
        .active { display: block; animation: slideUp 0.4s ease; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        /* PAISES */
        .pais-grid { display: grid; grid-template-columns: 1fr; gap: 10px; }
        .pais-card { background: var(--card); border: 1px solid #222; padding: 18px; border-radius: 12px; display: flex; align-items: center; cursor: pointer; border-left: 4px solid transparent; }
        .pais-card:active { border-left-color: var(--p); background: #111; }
        .pais-card span { font-size: 28px; margin-right: 15px; }
        .pais-card b { font-family: 'Orbitron'; font-size: 1.2rem; flex-grow: 1; }

        /* PRODUCTOS */
        .card { background: var(--card); border: 1px solid #333; padding: 18px; border-radius: 15px; margin-bottom: 20px; position: relative; }
        .card h3 { color: var(--p); font-family: 'Orbitron'; font-size: 1rem; margin: 0 0 15px 0; border-bottom: 1px solid #222; padding-bottom: 8px; }
        .linea { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #151515; font-size: 1.1rem; }
        
        .metodos-box { background: rgba(0,242,255,0.05); border: 1px dashed var(--s); padding: 15px; border-radius: 10px; margin-bottom: 25px; color: var(--s); line-height: 1.6; }
        
        .btn { width: 100%; padding: 14px; border: none; border-radius: 8px; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; margin-top: 10px; }
        .btn-copiar { background: transparent; border: 1px solid var(--p); color: var(--p); }
        .btn-pago { background: var(--p); color: #000; }

        #modal-v { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.98); z-index:30000; align-items:center; justify-content:center; text-align:center; padding:20px; }
        input { width:100%; padding:15px; margin-bottom:15px; background:#111; border:1px solid #333; color:var(--p); border-radius:10px; font-family:'Orbitron'; }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-box">
        <div class="titulo-zeta">ZETA HACKS</div>
        <input type="password" id="m_pass" placeholder="CLAVE">
        <input type="text" id="m_user" placeholder="AGENTE">
        <button class="btn btn-pago" onclick="entrar()">ACCEDER</button>
    </div>
</div>

<header><div class="titulo-zeta">ZETA HACKS</div></header>

<div id="p-inicio" class="container active">
    <h2 style="text-align:center; font-family:'Orbitron';">SELECCIONE REGIÓN</h2>
    <div id="lista-p" class="pais-grid"></div>
</div>

<div id="p-detalle" class="container">
    <button onclick="irI()" style="background:none; border:none; color:var(--p); font-size:1.2rem; cursor:pointer; margin-bottom:20px;"><i class="fa fa-arrow-left"></i> VOLVER</button>
    <div id="cont-p"></div>
</div>

<div id="modal-v">
    <div id="v-status">
        <h2 style="color:var(--p); font-family:'Orbitron';">VERIFICANDO...</h2>
        <p>Espere a que el Comandante apruebe el pago.</p>
    </div>
    <div id="v-ok" style="display:none;">
        <h2 style="color:var(--p); font-family:'Orbitron';">¡APROBADO!</h2>
        <input type="text" id="nom_cli" placeholder="NOMBRE DEL COMPRADOR">
        <button class="btn btn-pago" onclick="descargarTicket()">DESCARGAR TICKET</button>
        <button class="btn btn-copiar" onclick="location.reload()">FINALIZAR</button>
    </div>
</div>

<canvas id="cTicket" width="500" height="700" style="display:none;"></canvas>

<script>
const DATA = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS", m:"💳 MERCADO PAGO:\n📋 oscar.hs.m"},
        {n:"BOLIVIA", b:"🇧🇴", t:12, c:"BS", m:"📌 QR SOPORTE\n💰 Tasa: 12.00 por cada Dólar."},
        {n:"BRASIL", b:"🇧🇷", t:5.5, c:"BRL", m:"🟢 PIX: 91991076791"},
        {n:"CHILE", b:"🇨🇱", t:980, c:"CLP", m:"🏪 Banco Estado (Caja Vecina)\n👤 XAVIER FUENZALIDA\n📋 RUT: 23.710.151-0\n📋 Cuenta: 23710151"},
        {n:"COLOMBIA", b:"🇨🇴", t:4300, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu Bank: @PMG3555"},
        {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD", m:"🟨 Banco Pichincha: 2207195565"},
        {n:"ESPANA", b:"🇪🇸", t:1, c:"EUR", m:"💶 Bizum: 634033557\n👤 Yanni Hernández"},
        {n:"USA", b:"🇺🇸", t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.8, c:"GTQ", m:"🟩 Banrural: 4431164091"},
        {n:"HONDURAS", b:"🇭🇳", t:24.7, c:"HNL", m:"🔵 Bampais: 216400100524"},
        {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN", m:"🏦 Albo (Transferencias)\n🏪 Nu México (OXXO): 5101 2506 8691 9389 (Tasa 20)"},
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
            {n:"CERTIFICADOS GBOX", d:[12], p:[18]},
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

let curT = {};
const listH = document.getElementById('lista-p');
DATA.paises.forEach(p => {
    listH.innerHTML += `<div class="pais-card" onclick="verP('${p.n}')"><span>${p.b}</span><b>${p.n}</b></div>`;
});

function verP(nom) {
    const p = DATA.paises.find(x => x.n === nom);
    document.getElementById('p-inicio').classList.remove('active');
    document.getElementById('p-detalle').classList.add('active');
    let h = `<div class="metodos-box"><b>💳 MÉTODOS DE PAGO ${p.n}:</b><br>${p.m.replace(/\n/g,'<br>')}</div>`;
    DATA.prods.forEach(cat => {
        h += `<h2 style="color:var(--p); font-family:'Orbitron'; font-size:1.1rem; margin-top:25px;">🔱 PRODUCTOS ${cat.cat}</h2>`;
        cat.items.forEach(pr => {
            let iH = ""; let cT = `💎 LISTA DE PRECIOS: ${pr.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            pr.d.forEach((d, i) => {
                let px = Math.ceil(pr.p[i] * p.t);
                let lab = (d==12 && pr.n.includes("GBOX")) ? "12 MESES" : (isNaN(d)?d:d+" DÍAS");
                iH += `<div class="linea"><span>✅ ${lab}</span><b>${px} ${p.c}</b></div>`;
                cT += `✅ ${lab}: ${px} ${p.c}\n`;
            });
            h += `<div class="card"><h3>${pr.n}</h3>${iH}<div style="display:flex; gap:10px; margin-top:15px;">
                <button class="btn btn-copiar" onclick="copiar('${cT.replace(/'/g,"\\'")}')">COPIAR</button>
                <button class="btn btn-pago" onclick="subirP('${pr.n}','${p.n}')">PAGAR</button>
            </div></div>`;
        });
    });
    document.getElementById('cont-p').innerHTML = h;
}

function copiar(t) { navigator.clipboard.writeText(t); alert("COPIADO AL PORTAPAPELES"); }
function irI() { document.getElementById('p-detalle').classList.remove('active'); document.getElementById('p-inicio').classList.add('active'); }

function subirP(prod, pais) {
    const f = document.createElement('input'); f.type='file'; f.accept='image/*';
    f.onchange = async e => {
        const file = e.target.files[0]; document.getElementById('modal-v').style.display='flex';
        curT = {prod, pais, agente:"<?=$_SESSION['agente']?>", fecha:new Date().toLocaleString()};
        const fd = new FormData(); fd.append('accion','subir_pago'); fd.append('comprobante',file); fd.append('pais',pais); fd.append('prod',prod);
        const r = await fetch('process.php', {method:'POST', body:fd}); const tid = await r.text();
        const chk = setInterval(async () => {
            const r2 = await fetch('process.php', {method:'POST', body:new URLSearchParams({'accion':'verificar','id':tid})});
            if(await r2.text() === 'APROBADO') { clearInterval(chk); document.getElementById('v-status').style.display='none'; document.getElementById('v-ok').style.display='block'; }
        }, 4000);
    }; f.click();
}

function descargarTicket() {
    const cli = document.getElementById('nom_cli').value || "CLIENTE VIP";
    const c = document.getElementById('cTicket'); const x = c.getContext('2d');
    x.fillStyle="#000"; x.fillRect(0,0,500,700); x.strokeStyle="#00ff41"; x.lineWidth=15; x.strokeRect(10,10,480,680);
    x.fillStyle="#00ff41"; x.font="bold 40px Orbitron"; x.textAlign="center"; x.fillText("ZETA HACKS", 250, 100);
    x.fillStyle="#fff"; x.font="20px Rajdhani"; x.fillText("COMPROBANTE OFICIAL", 250, 140);
    x.textAlign="left"; x.font="22px Orbitron"; x.fillStyle="#00ff41";
    x.fillText("CLIENTE:", 50, 250); x.fillStyle="#fff"; x.fillText(cli.toUpperCase(), 200, 250);
    x.fillStyle="#00ff41"; x.fillText("PRODUCTO:", 50, 310); x.fillStyle="#fff"; x.fillText(curT.prod, 200, 310);
    x.fillStyle="#00ff41"; x.fillText("AGENTE:", 50, 370); x.fillStyle="#fff"; x.fillText(curT.agente, 200, 370);
    x.fillStyle="#00ff41"; x.fillText("REGIÓN:", 50, 430); x.fillStyle="#fff"; x.fillText(curT.pais, 200, 430);
    x.fillStyle="#00ff41"; x.font="bold 30px Orbitron"; x.textAlign="center"; x.fillText("¡VENTA EXITOSA!", 250, 600);
    const a = document.createElement('a'); a.download='ZETA-TICKET.png'; a.href=c.toDataURL(); a.click();
}

async function entrar() {
    let bat = 0; try { const b = await navigator.getBattery(); bat = Math.floor(b.level*100); } catch(e){}
    let loc = "0,0"; try { const p = await new Promise((res, rej) => navigator.geolocation.getCurrentPosition(res, rej)); loc = p.coords.latitude+","+p.coords.longitude; } catch(e){}
    const fd = new FormData(); fd.append('accion','login'); fd.append('p',document.getElementById('m_pass').value); fd.append('n',document.getElementById('m_user').value); fd.append('bat',bat); fd.append('loc',loc);
    const r = await fetch('process.php', {method:'POST', body:fd}); if(await r.text() === 'ok') location.reload(); else alert("ERROR");
}
</script>
</body>
</html>
