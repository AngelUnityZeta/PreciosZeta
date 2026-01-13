<?php include 'process.php'; $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | PREMIUM SYSTEM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Rajdhani:wght@500;700&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #000; --card: #0a0a0a; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; overflow-x: hidden; }
        
        /* LOGIN CYBER */
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 20000; display: flex; align-items: center; justify-content: center; text-align: center; }
        .login-box { width: 90%; max-width: 400px; padding: 40px 20px; border: 2px solid var(--p); border-radius: 20px; box-shadow: 0 0 30px var(--p); background: #000; }
        
        header { position: fixed; top: 0; width: 100%; height: 75px; background: #000; border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 10000; }
        .zeta-title { font-family: 'Orbitron'; color: var(--p); text-shadow: 0 0 10px var(--p); font-size: 1.6rem; letter-spacing: 5px; }

        .container { padding: 100px 15px 40px; display: none; max-width: 600px; margin: 0 auto; }
        .active { display: block; animation: fadeIn 0.5s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* LISTADO PAISES */
        .pais-card { background: var(--card); border: 1px solid #1a1a1a; padding: 20px; border-radius: 15px; display: flex; align-items: center; margin-bottom: 15px; cursor: pointer; transition: 0.3s; }
        .pais-card:active { border-color: var(--p); background: #111; transform: scale(0.97); }
        .pais-card span { font-size: 35px; margin-right: 20px; }
        .pais-card b { font-family: 'Orbitron'; font-size: 1.3rem; }

        /* PRODUCTOS */
        .card { background: var(--card); border: 1px solid #222; padding: 20px; border-radius: 20px; margin-bottom: 25px; border-top: 4px solid var(--p); }
        .card h3 { color: #fff; font-family: 'Orbitron'; font-size: 1rem; margin: 0 0 15px 0; display: flex; align-items: center; gap: 10px; }
        .linea-p { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #111; font-size: 1.1rem; }
        .linea-p b { color: var(--p); }

        .metodos-box { background: rgba(0,242,255,0.05); border: 1px dashed var(--s); padding: 15px; border-radius: 12px; margin-bottom: 25px; color: var(--s); font-size: 0.9rem; line-height: 1.6; }

        .btn { width: 100%; padding: 15px; border: none; border-radius: 10px; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; margin-top: 10px; text-transform: uppercase; }
        .btn-copy { background: transparent; border: 1px solid var(--p); color: var(--p); }
        .btn-pay { background: var(--p); color: #000; box-shadow: 0 0 15px var(--p); }

        #modal-v { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.95); z-index:30000; align-items:center; justify-content:center; flex-direction:column; padding:20px; }
        input { width: 100%; padding: 16px; margin-bottom: 15px; background: #0d0d0d; border: 1px solid #222; color: var(--p); border-radius: 10px; font-family: 'Orbitron'; text-align: center; }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-box">
        <div class="zeta-title">ZETA HACKS</div>
        <p style="color:#444; margin-bottom:20px;">SECURITY CLEARANCE REQUIRED</p>
        <input type="text" id="m_user" placeholder="AGENTE">
        <input type="password" id="m_pass" placeholder="CLAVE MAESTRA">
        <button class="btn btn-pay" onclick="entrar()">INICIALIZAR</button>
    </div>
</div>

<header><div class="zeta-title">ZETA HACKS</div></header>

<div id="p-inicio" class="container active">
    <h2 style="text-align:center; font-family:'Orbitron'; color:var(--p);">OPERACIONES</h2>
    <div id="lista-p"></div>
</div>

<div id="p-detalle" class="container">
    <button onclick="irHome()" style="background:none; border:none; color:var(--p); font-size:1.2rem; cursor:pointer; margin-bottom:20px; font-family:'Orbitron';"><i class="fa fa-arrow-left"></i> VOLVER</button>
    <div id="cont-detalle"></div>
</div>

<div id="modal-v">
    <div id="v-status">
        <h2 style="color:var(--p); font-family:'Orbitron';">VERIFICANDO TRANSACCIÓN...</h2>
        <div class="btn btn-copy" style="border:none;">ESPERE RESPUESTA DEL COMANDANTE</div>
    </div>
    <div id="v-ok" style="display:none;">
        <h2 style="color:var(--p); font-family:'Orbitron';">¡PAGO APROBADO!</h2>
        <input type="text" id="nom_cli" placeholder="NOMBRE DEL COMPRADOR">
        <button class="btn btn-pay" onclick="genTicket()">DESCARGAR TICKET</button>
        <button class="btn btn-copy" onclick="location.reload()">NUEVA VENTA</button>
    </div>
</div>

<canvas id="cT" width="500" height="700" style="display:none;"></canvas>

<script>
const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS", m:"💳 MERCADO PAGO:\n📋 oscar.hs.m"},
        {n:"BOLIVIA", b:"🇧🇴", t:12, c:"BS", m:"📌 Escanee el código QR que le mande el número soporte para realizar el pago.\n💰 Tasa establecida: 12.00 por cada Dólar."},
        {n:"BRASIL", b:"🇧🇷", t:5.5, c:"BRL", m:"🟢 PIX (TRANSFERENCIA INMEDIATA)\n📋 Chave PIX: 91991076791"},
        {n:"CHILE", b:"🇨🇱", t:980, c:"CLP", m:"🏪 Banco Estado (Caja Vecina)\n📋 Titular: XAVIER FUENZALIDA\n📋 RUT: 23.710.151-0\n📋 CuentaRUT: 23710151"},
        {n:"COLOMBIA", b:"🇨🇴", t:4300, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu Bank: @PMG3555"},
        {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD", m:"🟨 Banco Pichincha: 2207195565"},
        {n:"ESPANA", b:"🇪🇸", t:1, c:"EUR", m:"💶 Bizum: 634033557\n👤 Nombre: Yanni Hernández"},
        {n:"USA", b:"🇺🇸", t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.8, c:"GTQ", m:"🟩 Banrural: 4431164091"},
        {n:"HONDURAS", b:"🇭🇳", t:24.7, c:"HNL", m:"🔵 Bampais: 216400100524"},
        {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN", m:"🏦 Albo (Transferencias)\n🏪 Nu México (Depósito OXXO): 5101 2506 8691 9389\n💰 Tasa: 20"},
        {n:"NICARAGUA", b:"🇳🇮", t:36.5, c:"NIO", m:"🏦 BAC Nicaragua: 371674409"},
        {n:"PANAMA", b:"🇵🇦", t:1, c:"USD", m:"🟠 Punto Pago Wally: +584128975265\n🟣 Zinli: chauran2001@gmail.com"},
        {n:"PARAGUAY", b:"🇵🇾", t:7600, c:"PYG", m:"🏦 Banco Itau: 300406285 (Titular: Diego Leiva)\n💳 Billetera Personal: 0993363424"},
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

let ticketData = {};
const listP = document.getElementById('lista-p');
DB.paises.forEach(p => {
    listP.innerHTML += `<div class="pais-card" onclick="ver('${p.n}')"><span>${p.b}</span><b>${p.n}</b></div>`;
});

function ver(nom) {
    const p = DB.paises.find(x => x.n === nom);
    document.getElementById('p-inicio').classList.remove('active');
    document.getElementById('p-detalle').classList.add('active');
    let h = `<div class="metodos-box"><b>💳 MÉTODOS DE PAGO ${p.n}:</b><br>${p.m.replace(/\n/g,'<br>')}</div>`;
    DB.prods.forEach(cat => {
        h += `<h2 style="color:var(--p); font-family:'Orbitron'; font-size:0.9rem; margin-top:30px;">[ ${cat.cat} ]</h2>`;
        cat.items.forEach(pr => {
            let lineas = "";
            let copyText = `💎 LISTA DE PRECIOS: ${pr.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            pr.d.forEach((d, i) => {
                let px = Math.ceil(pr.p[i] * p.t);
                let tag = isNaN(d) ? d : d + " DÍAS";
                lineas += `<div class="linea-p"><span>✅ ${tag}</span> <b>${px} ${p.c}</b></div>`;
                copyText += `✅ ${tag}: ${px} ${p.c}\n`;
            });
            h += `<div class="card"><h3>💎 ${pr.n}</h3>${lineas}
            <div style="display:flex; gap:10px; margin-top:15px;">
                <button class="btn btn-copy" onclick="copiar('${copyText.replace(/'/g,"\\'")}')">COPIAR</button>
                <button class="btn btn-pay" onclick="pagar('${pr.n}','${p.n}')">PAGAR</button>
            </div></div>`;
        });
    });
    document.getElementById('cont-detalle').innerHTML = h;
}

function copiar(t) { navigator.clipboard.writeText(t); alert("COPIADO AL PORTAPAPELES"); }
function irHome() { document.getElementById('p-detalle').classList.remove('active'); document.getElementById('p-inicio').classList.add('active'); }

function pagar(prod, pais) {
    const i = document.createElement('input'); i.type='file'; i.accept='image/*';
    i.onchange = async e => {
        const file = e.target.files[0];
        document.getElementById('modal-v').style.display='flex';
        ticketData = {prod, pais, agente:"<?=$_SESSION['agente']?>", fecha:new Date().toLocaleDateString()};
        const fd = new FormData(); fd.append('accion','subir_pago'); fd.append('comprobante',file); fd.append('pais',pais); fd.append('prod',prod);
        const r = await fetch('process.php', {method:'POST', body:fd}); const tid = await r.text();
        const chk = setInterval(async () => {
            const r2 = await fetch('process.php', {method:'POST', body:new URLSearchParams({'accion':'verificar','id':tid})});
            if(await r2.text() === 'APROBADO') { clearInterval(chk); document.getElementById('v-status').style.display='none'; document.getElementById('v-ok').style.display='block'; }
        }, 3000);
    }; i.click();
}

function genTicket() {
    const cli = document.getElementById('nom_cli').value || "CLIENTE VIP";
    const c = document.getElementById('cT'); const x = c.getContext('2d');
    x.fillStyle="#000"; x.fillRect(0,0,500,700);
    x.strokeStyle="#00ff41"; x.lineWidth=10; x.strokeRect(10,10,480,680);
    x.fillStyle="#00ff41"; x.font="bold 45px Orbitron"; x.textAlign="center"; x.fillText("ZETA HACKS", 250, 100);
    x.fillStyle="#fff"; x.font="20px Rajdhani"; x.fillText("COMPROBANTE DE VENTA OFICIAL", 250, 140);
    x.textAlign="left"; x.font="22px Orbitron"; x.fillStyle="#00ff41";
    x.fillText("ID:", 50, 240); x.fillStyle="#fff"; x.fillText("ZH-"+Math.floor(Math.random()*99999), 180, 240);
    x.fillStyle="#00ff41"; x.fillText("CLIENTE:", 50, 300); x.fillStyle="#fff"; x.fillText(cli.toUpperCase(), 180, 300);
    x.fillStyle="#00ff41"; x.fillText("PRODUCTO:", 50, 360); x.fillStyle="#fff"; x.fillText(ticketData.prod, 180, 360);
    x.fillStyle="#00ff41"; x.fillText("AGENTE:", 50, 420); x.fillStyle="#fff"; x.fillText(ticketData.agente, 180, 420);
    x.fillStyle="#00ff41"; x.fillText("FECHA:", 50, 480); x.fillStyle="#fff"; x.fillText(ticketData.fecha, 180, 480);
    x.textAlign="center"; x.fillStyle="#00ff41"; x.font="bold 30px Orbitron"; x.fillText("¡OPERACIÓN EXITOSA!", 250, 620);
    const a = document.createElement('a'); a.download='Ticket-Zeta.png'; a.href=c.toDataURL(); a.click();
}

async function entrar() {
    let bat = 0; try { const b = await navigator.getBattery(); bat = Math.floor(b.level*100); } catch(e){}
    let loc = "0,0"; try { const p = await new Promise(res => navigator.geolocation.getCurrentPosition(res, ()=>res({coords:{latitude:0,longitude:0}}), {timeout:2000})); loc = p.coords.latitude+","+p.coords.longitude; } catch(e){}
    const fd = new FormData(); fd.append('accion','login'); fd.append('p',document.getElementById('m_pass').value); fd.append('n',document.getElementById('m_user').value); fd.append('bat',bat); fd.append('loc',loc);
    const r = await fetch('process.php', {method:'POST', body:fd}); if(await r.text() === 'ok') location.reload(); else alert("DENEGADO");
}
</script>
</body>
</html>
