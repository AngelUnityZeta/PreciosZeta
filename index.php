<?php session_start(); $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | PREMIUM V12</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Rajdhani:wght@500;700&display=swap');
        
        :root { --p: #00ff41; --s: #00f2ff; --warn: #ff003c; --bg: #030303; }
        
        * { box-sizing: border-box; outline: none; -webkit-tap-highlight-color: transparent; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; overflow-x: hidden; }

        /* LOGIN CYBERPUNK */
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 99999; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        
        /* Fondo de malla tech */
        #bloqueo::before {
            content: ""; position: absolute; width: 200%; height: 200%;
            background-image: radial-gradient(var(--p) 0.5px, transparent 0.5px);
            background-size: 30px 30px; opacity: 0.1; animation: moveBg 60s linear infinite;
        }
        @keyframes moveBg { from { transform: translate(0,0); } to { transform: translate(-5%, -5%); } }

        .login-card { 
            width: 85%; max-width: 380px; padding: 40px; border-radius: 20px; 
            background: rgba(10, 10, 10, 0.9); border: 1px solid #1a1a1a;
            text-align: center; position: relative; backdrop-filter: blur(10px);
            box-shadow: 0 0 50px rgba(0,0,0,1); z-index: 100;
        }

        /* Línea de Escaneo */
        .scanner-line {
            position: absolute; top: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(to right, transparent, var(--s), var(--p), var(--s), transparent);
            box-shadow: 0 0 15px var(--p); animation: scanning 4s ease-in-out infinite;
            pointer-events: none; opacity: 0.6;
        }
        @keyframes scanning { 0%, 100% { top: 0%; } 50% { top: 100%; } }

        .zeta-title { font-family: 'Orbitron'; font-weight: 900; font-size: 2.3rem; margin-bottom: 30px; letter-spacing: 5px; background: linear-gradient(var(--p), var(--s)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; filter: drop-shadow(0 0 10px rgba(0,255,65,0.5)); }

        .z-input { 
            width: 100%; padding: 15px; margin: 15px 0; background: rgba(0,0,0,0.7); 
            border: 1px solid #222; color: var(--p); border-radius: 8px; font-family: 'Orbitron'; 
            text-align: center; font-size: 1rem; transition: 0.4s;
        }
        .z-input:focus { border-color: var(--s); box-shadow: 0 0 15px rgba(0,242,255,0.2); }

        .btn { width: 100%; padding: 16px; border: none; border-radius: 12px; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; text-transform: uppercase; transition: 0.3s; }
        .btn-p { background: var(--p); color: #000; box-shadow: 0 0 20px rgba(0,255,65,0.4); }
        .btn-p:active { transform: scale(0.95); }

        header { position: fixed; top: 0; width: 100%; height: 75px; background: rgba(0,0,0,0.9); border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(10px); }
        
        .container { padding: 100px 15px 40px; display: none; max-width: 600px; margin: 0 auto; animation: fadeInUp 0.5s ease; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .active { display: block; }

        .p-card { background: #0a0a0a; border: 1px solid #1a1a1a; padding: 22px; border-radius: 15px; display: flex; align-items: center; margin-bottom: 12px; cursor: pointer; border-left: 5px solid var(--p); transition: 0.3s; }
        .p-card:hover { background: #111; transform: translateX(8px); border-left-color: var(--s); }
        .p-card span { font-size: 35px; margin-right: 20px; }

        .prod-box { background: #070707; border: 1px solid #151515; padding: 20px; border-radius: 20px; margin-bottom: 25px; border-top: 4px solid var(--p); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .row-v { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #111; }
        .row-v b { color: var(--p); font-family: 'Orbitron'; text-shadow: 0 0 5px var(--p); }

        .fab { position: fixed; bottom: 25px; right: 25px; width: 65px; height: 65px; background: var(--p); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000; font-size: 28px; box-shadow: 0 0 30px var(--p); z-index: 5000; cursor: pointer; }

        #t-modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.95); z-index:30000; align-items:center; justify-content:center; padding:20px; backdrop-filter: blur(8px); }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-card">
        <div class="scanner-line"></div>
        <div class="zeta-title">ZETA HACKS</div>
        
        <div id="p1">
            <p style="color:#666; font-size:0.7rem; letter-spacing:3px;">SISTEMA ENCRIPTADO</p>
            <input type="password" id="m_pass" class="z-input" placeholder="PASSKEY" autocomplete="off">
            <button class="btn btn-p" onclick="checkP1()">AUTENTICAR</button>
        </div>
        
        <div id="p2" style="display:none;">
            <p style="color:var(--s); font-size:0.7rem; letter-spacing:3px;">IDENTIDAD AGENTE</p>
            <input type="text" id="m_user" class="z-input" placeholder="USERNAME" autocomplete="off">
            <button class="btn btn-p" onclick="accederFinal()">INICIAR SESIÓN</button>
        </div>
    </div>
</div>

<header><div class="zeta-title" style="font-size:1.4rem; margin:0;">ZETA HACKS</div></header>

<div id="p-home" class="container active">
    <div id="list-p"></div>
</div>

<div id="p-detail" class="container">
    <button onclick="irHome()" class="btn" style="background:#111; color:var(--s); border:1px solid var(--s); width:auto; padding:8px 20px; margin-bottom:20px;"><i class="fa fa-arrow-left"></i> VOLVER</button>
    <div id="cont-d"></div>
</div>

<div class="fab" onclick="document.getElementById('file-in').click()"><i class="fa fa-shield-alt"></i></div>
<input type="file" id="file-in" style="display:none;" onchange="subir(this)" accept="image/*">

<div id="t-modal">
    <div style="background:#0a0a0a; border:2px solid var(--p); padding:30px; border-radius:25px; width:100%; max-width:400px; box-shadow:0 0 50px var(--p);">
        <h3 style="color:var(--p); font-family:Orbitron; text-align:center;">GENERAR TICKET</h3>
        <input type="text" id="t_cli" class="z-input" placeholder="CLIENTE">
        <input type="text" id="t_val" class="z-input" placeholder="PRECIO TOTAL">
        <input type="text" id="t_dias" class="z-input" placeholder="TIEMPO (DÍAS)">
        <input type="hidden" id="t_prod">
        <button class="btn btn-p" onclick="crearTicket()">GENERAR IMAGEN</button>
        <button class="btn" onclick="document.getElementById('t-modal').style.display='none'" style="margin-top:10px; color:#555;">CANCELAR</button>
    </div>
</div>

<canvas id="canvas" width="500" height="800" style="display:none;"></canvas>

<script>
const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS", m:"💳 MERCADO PAGO:\n📋 oscar.hs.m"},
        {n:"BOLIVIA", b:"🇧🇴", t:12, c:"BS", m:"📌 QR SOPORTE\n💰 Tasa: 12.00"},
        {n:"BRASIL", b:"🇧🇷", t:5.5, c:"BRL", m:"🟢 PIX: 91991076791"},
        {n:"CHILE", b:"🇨🇱", t:980, c:"CLP", m:"🏪 Banco Estado\n📋 Cuenta: 23710151\n👤 X. Fuenzalida"},
        {n:"COLOMBIA", b:"🇨🇴", t:4300, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078"},
        {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN", m:"🏦 Albo / Nu México\n📋 5101 2506 8691 9389"},
        {n:"PERU", b:"🇵🇪", t:3.78, c:"PEN", m:"🟣 Yape/Plin: 954302258"},
        {n:"VENEZUELA", b:"🇻🇪", t:45, c:"VED", m:"🟡 Pago Móvil: 0102 32958486 04125805981"},
        {n:"USA", b:"🇺🇸", t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"}
    ],
    prods: [
        {cat:"ANDROID", items:[
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"CUBAN MODS", d:[1,10,20,31], p:[3,9,13,19]},
            {n:"BR MODS + VIRTUAL", d:[1,7,15,30], p:[6,12,19,28]},
            {n:"HG CHEATS + VIRTUAL", d:[1,10,30], p:[5,16,25]},
            {n:"STRICK BR", d:[1,7,15,30], p:[3,8,12,19]}
        ]},
        {cat:"PC & IOS", items:[
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[22,35,45]},
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERM"], p:[3,8,16,25]}
        ]}
    ]
};

function hablar(t) {
    const s = new SpeechSynthesisUtterance(t);
    s.pitch = 0.6; s.rate = 1; speechSynthesis.speak(s);
}

function checkP1() {
    if(document.getElementById('m_pass').value === "EmpresaPrivada2026") {
        document.getElementById('p1').style.display = 'none';
        document.getElementById('p2').style.display = 'block';
        hablar("Access Granted. Identifying agent.");
    } else { alert("ACCESO DENEGADO"); }
}

function accederFinal() {
    const n = document.getElementById('m_user').value;
    if(!n) return;
    const fd = new FormData(); fd.append('accion','login'); fd.append('n',n);
    fetch('process.php', {method:'POST', body:fd});
    document.getElementById('bloqueo').style.display='none';
    hablar("Welcome back agent " + n);
    renderHome();
}

function renderHome() {
    const l = document.getElementById('list-p');
    l.innerHTML = '<p style="text-align:center; color:#444; letter-spacing:3px;">SELECT TARGET REGION</p>';
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        l.innerHTML += `<div class="p-card" onclick="ver('${p.n}')"><span>${p.b}</span><b>${p.n}</b></div>`;
    });
}

function ver(n) {
    const p = DB.paises.find(x => x.n === n);
    document.getElementById('p-home').classList.remove('active');
    document.getElementById('p-detail').classList.add('active');
    hablar("Region " + n);
    let h = `<div style="background:rgba(0,255,65,0.05); border:1px solid var(--p); padding:15px; border-radius:15px; margin-bottom:20px; color:var(--s);"><b>OPERACIONES ${p.n}:</b><br>${p.m.replace(/\n/g,'<br>')}</div>`;
    DB.prods.forEach(c => {
        h += `<h2 style="color:var(--p); font-family:Orbitron; font-size:0.9rem; border-left:3px solid var(--p); padding-left:10px; margin-top:25px;">🔱 ${c.cat}</h2>`;
        c.items.forEach(i => {
            let row = ""; let copy = `💎 ZETA HACKS: ${i.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            i.d.forEach((d, idx) => {
                let px = Math.ceil(i.p[idx] * p.t);
                let tag = isNaN(d) ? d : d + " DÍAS";
                row += `<div class="row-v"><span>✅ ${tag}</span><b>${px} ${p.c}</b></div>`;
                copy += `✅ ${tag}: ${px} ${p.c}\n`;
            });
            h += `<div class="prod-box"><h3>${i.n}</h3>${row}
            <div style="display:flex; gap:10px; margin-top:15px;">
                <button class="btn" style="flex:1; background:#111; color:var(--s); border:1px solid #333;" onclick="copiar(this, \`${copy}\`)">COPIAR</button>
                <button class="btn btn-p" style="flex:2.5" onclick="abrirTicket('${i.n}')">TICKET</button>
            </div></div>`;
        });
    });
    document.getElementById('cont-d').innerHTML = h;
}

function copiar(btn, txt) {
    const a = document.createElement('textarea'); a.value = txt;
    document.body.appendChild(a); a.select(); document.execCommand('copy');
    document.body.removeChild(a);
    const old = btn.innerText; btn.innerText = "COPIADO";
    hablar("Information copied");
    setTimeout(() => btn.innerText = old, 2000);
}

function subir(input) {
    if(!input.files[0]) return;
    hablar("Sending proof to Telegram");
    const fd = new FormData(); fd.append('accion','comprobante'); fd.append('foto',input.files[0]);
    fetch('process.php', {method:'POST', body:fd}).then(() => alert("ENVIADO CON ÉXITO ✅"));
}

function abrirTicket(p) { document.getElementById('t-modal').style.display='flex'; document.getElementById('t_prod').value = p; }

function crearTicket() {
    const c = document.getElementById('canvas'); const x = c.getContext('2d');
    const cli = document.getElementById('t_cli').value || "CLIENTE";
    const ag = document.getElementById('m_user').value || "ADMIN";
    
    x.fillStyle="#000"; x.fillRect(0,0,500,800);
    x.strokeStyle="#00ff41"; x.lineWidth=6; x.strokeRect(15,15,470,770);
    
    // Header
    x.fillStyle="rgba(0,255,65,0.1)"; x.fillRect(15,15,470,180);
    x.fillStyle="#00ff41"; x.font="900 50px Orbitron"; x.textAlign="center"; x.fillText("ZETA HACKS", 250, 100);
    x.fillStyle="#fff"; x.font="16px Orbitron"; x.fillText("CERTIFICADO DE ACTIVACIÓN", 250, 140);
    
    // Contenido
    x.textAlign="left"; x.font="22px Orbitron"; x.fillStyle="#00ff41";
    x.fillText("AGENTE:", 50, 270); x.fillStyle="#fff"; x.fillText(ag.toUpperCase(), 180, 270);
    x.fillStyle="#00ff41"; x.fillText("CLIENTE:", 50, 340); x.fillStyle="#fff"; x.fillText(cli.toUpperCase(), 180, 340);
    x.fillStyle="#00ff41"; x.fillText("PRODUCTO:", 50, 410); x.fillStyle="#fff"; x.fillText(document.getElementById('t_prod').value, 200, 410);
    x.fillStyle="#00ff41"; x.fillText("VALOR:", 50, 480); x.fillStyle="#fff"; x.fillText(document.getElementById('t_val').value, 160, 480);
    x.fillStyle="#00ff41"; x.fillText("DÍAS:", 50, 550); x.fillStyle="#fff"; x.fillText(document.getElementById('t_dias').value, 150, 550);
    
    // Footer
    x.textAlign="center"; x.fillStyle="#00ff41"; x.font="bold 20px Orbitron"; x.fillText("¡DISFRUTA TUS HACKS!", 250, 700);
    x.fillStyle="#333"; x.font="12px Orbitron"; x.fillText(new Date().toLocaleString(), 250, 740);

    const a = document.createElement('a'); a.download=`Zeta_${cli}.png`; a.href=c.toDataURL(); a.click();
    hablar("Ticket generated successfully");
}

function irHome() { document.getElementById('p-detail').classList.remove('active'); document.getElementById('p-home').classList.add('active'); }
if("<?=$auth?>") renderHome();
</script>
</body>
</html>
    
