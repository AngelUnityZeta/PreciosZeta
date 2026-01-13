<?php session_start(); $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | ELITE SYSTEM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Rajdhani:wght@400;700&display=swap');
        
        :root { --p: #00ff41; --s: #00f2ff; --a: #bc13fe; --bg: #050505; }
        
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; outline: none; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; overflow-x: hidden; }
        
        /* LOGIN ANIMADO */
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 99999; display: flex; align-items: center; justify-content: center; }
        .login-card { 
            width: 90%; max-width: 380px; padding: 40px; border-radius: 20px; background: #0a0a0a; 
            border: 1px solid #222; text-align: center; position: relative;
            box-shadow: 0 0 50px rgba(0,0,0,1), inset 0 0 20px rgba(0,255,65,0.05);
        }
        .login-card::before {
            content: ''; position: absolute; inset: 0; border-radius: 20px;
            padding: 2px; background: linear-gradient(45deg, var(--p), transparent, var(--s));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor; mask-composite: exclude;
        }

        .z-input { width: 100%; padding: 15px; margin: 10px 0; background: #000; border: 1px solid #333; color: var(--p); border-radius: 8px; font-family: 'Orbitron'; text-align: center; font-size: 0.9rem; transition: 0.3s; }
        .z-input:focus { border-color: var(--s); box-shadow: 0 0 15px rgba(0,242,255,0.2); }

        /* HEADER */
        header { position: fixed; top: 0; width: 100%; height: 75px; background: rgba(0,0,0,0.9); border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 10000; backdrop-filter: blur(15px); }
        .zeta-logo { font-family: 'Orbitron'; font-weight: 900; font-size: 1.8rem; background: linear-gradient(90deg, var(--p), var(--s)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: 4px; filter: drop-shadow(0 0 8px var(--p)); }

        .container { padding: 100px 15px 40px; display: none; max-width: 600px; margin: 0 auto; }
        .active { display: block; animation: slideIn 0.4s ease; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        /* CARDS */
        .p-card { background: linear-gradient(135deg, #0d0d0d, #151515); border: 1px solid #222; padding: 20px; border-radius: 15px; display: flex; align-items: center; margin-bottom: 15px; cursor: pointer; transition: 0.3s; border-left: 4px solid var(--p); }
        .p-card:hover { border-left-color: var(--s); transform: scale(1.02); background: #1a1a1a; }
        .p-card span { font-size: 35px; margin-right: 20px; }
        .p-card b { font-family: 'Orbitron'; letter-spacing: 1px; }

        .prod-box { background: #080808; border: 1px solid #1a1a1a; padding: 22px; border-radius: 20px; margin-bottom: 25px; box-shadow: 0 15px 35px rgba(0,0,0,0.5); border-top: 3px solid var(--p); }
        .row-v { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #151515; font-size: 1.1rem; }
        .row-v b { color: var(--p); text-shadow: 0 0 5px var(--p); font-family: 'Orbitron'; }

        .btn { width: 100%; padding: 16px; border: none; border-radius: 12px; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; text-transform: uppercase; margin-top: 10px; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-p { background: linear-gradient(45deg, #00ff41, #00cc33); color: #000; }
        .btn-s { background: #111; border: 1px solid #333; color: #aaa; }
        .btn-s:hover { border-color: var(--s); color: var(--s); }

        .fab { position: fixed; bottom: 25px; right: 25px; width: 65px; height: 65px; background: var(--p); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000; font-size: 28px; box-shadow: 0 0 25px var(--p); z-index: 9000; cursor: pointer; }
        
        #t-modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.95); z-index:30000; align-items:center; justify-content:center; padding:20px; backdrop-filter: blur(5px); }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-card">
        <div class="zeta-logo">ZETA HACKS</div>
        <div id="step1">
            <p style="color:#555; font-size:0.7rem; letter-spacing:2px;">ENCRYPTED TERMINAL</p>
            <input type="password" id="m_pass" class="z-input" placeholder="ACCESS TOKEN">
            <button class="btn btn-p" onclick="nextStep()">AUTENTICAR</button>
        </div>
        <div id="step2" style="display:none;">
            <p style="color:var(--s); font-size:0.7rem; letter-spacing:2px;">IDENTITY VERIFICATION</p>
            <input type="text" id="m_user" class="z-input" placeholder="AGENT USERNAME">
            <button class="btn btn-p" onclick="acceder()">INITIALIZE</button>
        </div>
    </div>
</div>

<header><div class="zeta-logo">ZETA HACKS</div></header>

<div id="p-home" class="container active">
    <div id="list-p"></div>
</div>

<div id="p-detail" class="container">
    <button onclick="irHome()" class="btn btn-s" style="width:auto; margin-bottom:20px;"><i class="fa fa-arrow-left"></i> VOLVER AL COMANDO</button>
    <div id="cont-d"></div>
</div>

<div class="fab" onclick="document.getElementById('file-in').click()"><i class="fa fa-cloud-upload-alt"></i></div>
<input type="file" id="file-in" style="display:none;" onchange="subir(this)">

<div id="t-modal">
    <div style="background:#0a0a0a; border:2px solid var(--p); padding:30px; border-radius:25px; width:100%; max-width:400px; box-shadow:0 0 50px var(--p);">
        <h3 style="color:var(--p); font-family:Orbitron; text-align:center; margin-top:0;">TICKET GENERATOR</h3>
        <input type="text" id="t_cli" class="z-input" placeholder="NOMBRE DEL CLIENTE">
        <input type="text" id="t_val" class="z-input" placeholder="MONTO PAGADO">
        <input type="text" id="t_dias" class="z-input" placeholder="DÍAS ADQUIRIDOS">
        <input type="hidden" id="t_prod">
        <button class="btn btn-p" onclick="descargar()">GENERAR TICKET</button>
        <button class="btn btn-s" onclick="document.getElementById('t-modal').style.display='none'">CANCELAR</button>
    </div>
</div>

<canvas id="canvas" width="500" height="800" style="display:none;"></canvas>

<script>
const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS", m:"💳 MERCADO PAGO:\n📋 oscar.hs.m"},
        {n:"BOLIVIA", b:"🇧🇴", t:12, c:"BS", m:"📌 QR SOPORTE (Escaneo)\n💰 Tasa: 12.00 por Dólar"},
        {n:"BRASIL", b:"🇧🇷", t:5.5, c:"BRL", m:"🟢 PIX: 91991076791"},
        {n:"CHILE", b:"🇨🇱", t:980, c:"CLP", m:"🏪 Banco Estado\n👤 XAVIER FUENZALIDA\n📋 RUT: 23.710.151-0\n📋 Cuenta: 23710151"},
        {n:"COLOMBIA", b:"🇨🇴", t:4300, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu Bank: @PMG3555"},
        {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD", m:"🟨 Banco Pichincha: 2207195565"},
        {n:"ESPANA", b:"🇪🇸", t:1, c:"EUR", m:"💶 Bizum: 634033557\n👤 Yanni Hernández"},
        {n:"USA", b:"🇺🇸", t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.8, c:"GTQ", m:"🟩 Banrural: 4431164091"},
        {n:"HONDURAS", b:"🇭🇳", t:24.7, c:"HNL", m:"🔵 Bampais: 216400100524"},
        {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN", m:"🏦 Albo (Transferencia)\n🏪 Nu México (OXXO): 5101 2506 8691 9389"},
        {n:"NICARAGUA", b:"🇳🇮", t:36.5, c:"NIO", m:"🏦 BAC: 371674409"},
        {n:"PANAMA", b:"🇵🇦", t:1, c:"USD", m:"🟠 Punto Pago: +584128975265\n🟣 Zinli: chauran2001@gmail.com"},
        {n:"PARAGUAY", b:"🇵🇾", t:7600, c:"PYG", m:"🏦 Itau: 300406285\n💳 Billetera Personal: 0993363424"},
        {n:"PERU", b:"🇵🇪", t:3.78, c:"PEN", m:"🟣 Yape/Plin: 954302258"},
        {n:"DOMINICANA", b:"🇩🇴", t:60, c:"DOP", m:"🟦 Banreservas: 9601546622\n🔴 Popular: 837147719"},
        {n:"VENEZUELA", b:"🇻🇪", t:45, c:"VED", m:"🟡 Pago Móvil: 0102 32958486 04125805981"}
    ],
    prods: [
        {cat:"ANDROID PREMIUM", items:[
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
        {cat:"IOS EXCLUSIVE", items:[
            {n:"CERTIFICADOS GBOX", d:["12 MESES"], p:[18]},
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[22,35,45]},
            {n:"FLOURITE SOLO", d:[1,7,30], p:[4,16,26]},
            {n:"PANEL IOS", d:[7,30], p:[12,19]}
        ]},
        {cat:"PC MASTERRACE", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERM"], p:[3,8,16,25]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

function hablar(t) {
    const s = new SpeechSynthesisUtterance(t);
    s.pitch = 0.7; s.rate = 1;
    speechSynthesis.speak(s);
}

function nextStep() {
    if(document.getElementById('m_pass').value === "EmpresaPrivada2026") {
        document.getElementById('step1').style.display='none';
        document.getElementById('step2').style.display='block';
        hablar("Access Granted. Identify yourself.");
    } else { alert("ACCESS DENIED"); }
}

function acceder() {
    const n = document.getElementById('m_user').value;
    if(!n) return;
    const fd = new FormData(); fd.append('accion','login'); fd.append('n',n); fd.append('p','EmpresaPrivada2026');
    fetch('process.php', {method:'POST', body:fd});
    document.getElementById('bloqueo').style.display='none';
    hablar("Welcome Commander " + n);
    renderHome();
}

function renderHome() {
    const l = document.getElementById('list-p');
    l.innerHTML = '<p style="text-align:center; color:#555; letter-spacing:3px; margin-bottom:20px;">SELECCIONE REGIÓN DE OPERACIÓN</p>';
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        l.innerHTML += `<div class="p-card" onclick="ver('${p.n}')"><span>${p.b}</span><b>${p.n}</b></div>`;
    });
}

function ver(n) {
    const p = DB.paises.find(x => x.n === n);
    document.getElementById('p-home').classList.remove('active');
    document.getElementById('p-detail').classList.add('active');
    hablar("Opening region " + n);
    let h = `<div style="background:rgba(0,242,255,0.05); border:1px solid var(--s); padding:15px; border-radius:15px; margin-bottom:25px; color:var(--s); font-size:0.9rem;"><b>💳 MÉTODOS DE PAGO ${p.n}:</b><br>${p.m.replace(/\n/g,'<br>')}</div>`;
    
    DB.prods.forEach(cat => {
        h += `<h2 style="color:var(--p); font-family:Orbitron; font-size:0.9rem; margin:30px 0 15px; border-left:3px solid var(--p); padding-left:10px;">🔱 ${cat.cat}</h2>`;
        cat.items.forEach(i => {
            let rows = ""; let clip = `💎 ZETA HACKS: ${i.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            i.d.forEach((d, idx) => {
                let px = Math.ceil(i.p[idx] * p.t);
                let tag = isNaN(d) ? d : d + " DÍAS";
                rows += `<div class="row-v"><span>✅ ${tag}</span><b>${px} ${p.c}</b></div>`;
                clip += `✅ ${tag}: ${px} ${p.c}\n`;
            });
            h += `<div class="prod-box"><h3 style="margin-top:0; color:#fff; font-family:Orbitron; font-size:1.1rem;">${i.n}</h3>${rows}
            <div style="display:flex; gap:10px; margin-top:15px;">
                <button class="btn btn-s" style="flex:1" onclick="copiar(this, \`${clip}\`)"><i class="fa fa-copy"></i></button>
                <button class="btn btn-p" style="flex:3" onclick="abrirT('${i.n}')">GENERAR VENTA</button>
            </div></div>`;
        });
    });
    document.getElementById('cont-d').innerHTML = h;
}

function copiar(btn, txt) {
    const area = document.createElement('textarea');
    area.value = txt; document.body.appendChild(area); area.select();
    document.execCommand('copy'); document.body.removeChild(area);
    const old = btn.innerHTML; btn.innerHTML = '<i class="fa fa-check"></i>';
    hablar("Data copied");
    setTimeout(() => btn.innerHTML = old, 2000);
}

function subir(input) {
    if(!input.files[0]) return;
    hablar("Uploading evidence to Telegram");
    const fd = new FormData();
    fd.append('accion', 'comprobante');
    fd.append('foto', input.files[0]);
    fetch('process.php', {method:'POST', body:fd}).then(() => alert("COMPROBANTE ENVIADO ✅"));
}

function abrirT(p) { document.getElementById('t-modal').style.display='flex'; document.getElementById('t_prod').value = p; }

function descargar() {
    const c = document.getElementById('canvas'); const x = c.getContext('2d');
    const cli = document.getElementById('t_cli').value || "CUSTOMER";
    const prod = document.getElementById('t_prod').value;
    const val = document.getElementById('t_val').value;
    const dias = document.getElementById('t_dias').value;

    // Fondo Profesional
    x.fillStyle="#000"; x.fillRect(0,0,500,800);
    x.strokeStyle="#00ff41"; x.lineWidth=4; x.strokeRect(15,15,470,770);
    
    // Header Logo
    x.fillStyle="rgba(0,255,65,0.1)"; x.fillRect(15,15,470,180);
    x.fillStyle="#00ff41"; x.font="900 48px Orbitron"; x.textAlign="center"; x.fillText("ZETA HACKS", 250, 100);
    x.fillStyle="#fff"; x.font="16px Orbitron"; x.fillText("LICENSE ACTIVATION RECEIPT", 250, 140);
    x.fillText("──────────────────────────", 250, 165);

    // Body
    x.textAlign="left"; x.font="22px Orbitron"; x.fillStyle="#00ff41";
    x.fillText("ID AGENTE:", 50, 260); x.fillStyle="#fff"; x.fillText("ZH-"+document.getElementById('m_user').value.toUpperCase(), 200, 260);
    
    x.fillStyle="#00ff41"; x.fillText("CLIENTE:", 50, 330); x.fillStyle="#fff"; x.fillText(cli.toUpperCase(), 180, 330);
    
    x.fillStyle="#00ff41"; x.fillText("MOD/PACK:", 50, 400); x.fillStyle="#fff"; x.fillText(prod, 190, 400);
    
    x.fillStyle="#00ff41"; x.fillText("MONTO:", 50, 470); x.fillStyle="#fff"; x.fillText(val, 160, 470);
    
    x.fillStyle="#00ff41"; x.fillText("DURACIÓN:", 50, 540); x.fillStyle="#fff"; x.fillText(dias, 200, 540);

    // Footer
    x.fillStyle="rgba(0,242,255,0.05)"; x.fillRect(15,620,470,165);
    x.textAlign="center"; x.fillStyle="#00f2ff"; x.font="bold 22px Orbitron"; x.fillText("ACCESO GARANTIZADO", 250, 680);
    x.fillStyle="#555"; x.font="14px Orbitron"; x.fillText("TIMESTAMP: " + new Date().toLocaleString(), 250, 720);
    x.fillText("ZETA HACKS V12 SECURITY PROTOCOL", 250, 745);

    const a = document.createElement('a'); a.download=`ZetaTicket_${cli}.png`; a.href=c.toDataURL(); a.click();
    hablar("Ticket generated and encrypted.");
}

function irHome() { document.getElementById('p-detail').classList.remove('active'); document.getElementById('p-home').classList.add('active'); }
if("<?=$auth?>") renderHome();
</script>
</body>
</html>
