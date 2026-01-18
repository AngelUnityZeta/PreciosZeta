<?php session_start(); $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | V12 ELITE CONTROL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS AVANZADO - ESTILO DEEP WEB / MILITAR */
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Share+Tech+Mono&display=swap');
        
        :root { --p: #00ff41; --s: #00f2ff; --a: #ff003c; --bg: #000000; }
        
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; outline: none; }
        body { 
            margin: 0; background: var(--bg); color: #fff; 
            font-family: 'Share Tech Mono', monospace; overflow-x: hidden;
            user-select: none;
        }

        /* FONTO DE PARTÍCULAS MATRIX */
        #matrix-canvas { position: fixed; top: 0; left: 0; z-index: -1; opacity: 0.2; }

        /* SCANNER LÁSER */
        .laser {
            position: fixed; top: 0; left: 0; width: 100%; height: 2px;
            background: var(--p); box-shadow: 0 0 15px var(--p);
            z-index: 9999; pointer-events: none; animation: scan 4s linear infinite;
        }
        @keyframes scan { 0% { top: -5%; } 100% { top: 105%; } }

        /* LOGIN INTERFACE */
        #bloqueo {
            position: fixed; inset: 0; background: #000; z-index: 10000;
            display: flex; align-items: center; justify-content: center;
        }
        .login-box {
            width: 90%; max-width: 400px; padding: 40px; border: 1px solid var(--p);
            background: rgba(10,10,10,0.9); border-radius: 5px; text-align: center;
            box-shadow: 0 0 50px rgba(0,255,65,0.2); position: relative;
        }

        /* HEADER PROFESIONAL */
        header {
            position: fixed; top: 0; width: 100%; height: 70px;
            background: rgba(0,0,0,0.9); border-bottom: 2px solid var(--p);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 20px; z-index: 1000; backdrop-filter: blur(10px);
        }

        /* MENÚ LATERAL CUBAN STYLE */
        .side-nav {
            position: fixed; top: 0; left: -300px; width: 300px; height: 100%;
            background: #050505; border-right: 2px solid var(--p);
            z-index: 2000; transition: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            padding-top: 80px;
        }
        .side-nav.open { left: 0; box-shadow: 0 0 100px rgba(0,255,65,0.3); }

        /* CARDS DE PAISES */
        .container { padding: 90px 15px 40px; display: none; max-width: 700px; margin: 0 auto; }
        .active { display: block; animation: glt 0.3s ease-out; }

        .country-btn {
            background: rgba(20,20,20,0.8); border: 1px solid #222;
            padding: 20px; margin-bottom: 12px; border-radius: 4px;
            display: flex; align-items: center; cursor: pointer;
            transition: 0.3s; border-left: 4px solid var(--s);
        }
        .country-btn:hover { background: #111; border-color: var(--p); transform: scale(1.02); }

        /* PRECIOS HUD */
        .price-card {
            background: #080808; border: 1px solid #1a1a1a;
            padding: 25px; border-radius: 10px; margin-bottom: 25px;
            position: relative; overflow: hidden;
        }
        .price-card::before {
            content: "ZETA SECURITY"; position: absolute; top: 5px; right: 10px;
            font-size: 0.6rem; color: #333;
        }
        .row-item {
            display: flex; justify-content: space-between; padding: 12px 0;
            border-bottom: 1px solid #111; font-size: 1.1rem;
        }
        .row-item b { color: var(--p); text-shadow: 0 0 5px var(--p); }

        .btn-copy {
            width: 100%; background: var(--p); color: #000; font-weight: 900;
            padding: 15px; border: none; border-radius: 5px; cursor: pointer;
            font-family: 'Orbitron'; margin-top: 15px; transition: 0.3s;
        }

        /* NOTIFICACIONES HUD */
        #hud-notif {
            position: fixed; bottom: 20px; left: 20px; z-index: 9999;
            pointer-events: none;
        }
        .notif {
            background: rgba(0,0,0,0.9); border-left: 5px solid var(--p);
            padding: 15px 25px; margin-top: 10px; animation: slideIn 0.5s forwards;
            font-size: 0.8rem; color: var(--p); box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }

        @keyframes slideIn { from { transform: translateX(-100%); } to { transform: translateX(0); } }
        @keyframes glt { 0% { opacity: 0; transform: skewX(10deg); } 100% { opacity: 1; transform: skewX(0); } }
    </style>
</head>
<body>

<div class="laser"></div>
<canvas id="matrix-canvas"></canvas>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-box">
        <h1 style="font-family:'Orbitron'; color:var(--p);">ZETA HACKS</h1>
        <p style="color:#555; font-size:0.7rem;">SISTEMA DE CONTROL DE VENDEDORES</p>
        <input type="text" id="m_u" style="width:100%; padding:15px; background:#000; border:1px solid #333; color:var(--p); margin:10px 0;" placeholder="USUARIO">
        <input type="password" id="m_p" style="width:100%; padding:15px; background:#000; border:1px solid #333; color:var(--p); margin:10px 0;" placeholder="CONTRASEÑA">
        <button class="btn-copy" onclick="login()">AUTENTICAR SISTEMA</button>
    </div>
</div>

<header>
    <i class="fa fa-bars" style="font-size:25px; color:var(--p);" onclick="toggleNav()"></i>
    <div style="font-family:'Orbitron'; font-size:1.5rem; letter-spacing:5px;">ZETA<span style="color:var(--p);">HACKS</span></div>
    <div id="clock" style="color:var(--s);">00:00:00</div>
</header>

<div class="side-nav" id="sideNav">
    <div class="menu-item" style="padding:20px; border-bottom:1px solid #111; color:var(--p); font-family:Orbitron;">MENU PRINCIPAL</div>
    <div onclick="irHome()" style="padding:20px; cursor:pointer;"><i class="fa fa-home"></i> PANEL DE PRECIOS</div>
    <div onclick="location.reload()" style="padding:20px; cursor:pointer;"><i class="fa fa-sync"></i> ACTUALIZAR</div>
    <div style="padding:20px; color:#333; position:absolute; bottom:0;">V12.0.4 ELITE</div>
</div>

<div id="p-home" class="container active">
    <div id="list-p"></div>
</div>

<div id="p-detail" class="container">
    <button onclick="irHome()" style="background:#111; color:var(--s); border:1px solid #222; padding:10px 25px; margin-bottom:25px; font-family:'Orbitron';">VOLVER</button>
    <div id="cont-d"></div>
</div>

<div id="hud-notif"></div>

<script>
/* 🔱 MOTOR VISUAL Y DE SEGURIDAD ZETA 🔱 */

const canvas = document.getElementById('matrix-canvas');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth; canvas.height = window.innerHeight;
const chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ$#@&";
const fontSize = 14;
const columns = canvas.width / fontSize;
const drops = Array(Math.floor(columns)).fill(1);

function drawMatrix() {
    ctx.fillStyle = "rgba(0, 0, 0, 0.05)";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = "#0F0"; ctx.font = fontSize + "px monospace";
    for(let i=0; i<drops.length; i++) {
        const text = chars[Math.floor(Math.random()*chars.length)];
        ctx.fillText(text, i*fontSize, drops[i]*fontSize);
        if(drops[i]*fontSize > canvas.height && Math.random() > 0.975) drops[i] = 0;
        drops[i]++;
    }
}
setInterval(drawMatrix, 50);

// SEGURIDAD ANTI-INSPECCIÓN
document.onkeydown = (e) => {
    if(e.keyCode == 123 || (e.ctrlKey && e.shiftKey && (e.keyCode == 73 || e.keyCode == 74)) || (e.ctrlKey && e.keyCode == 85)) {
        trackAlert("INTENTO DE INSPECCIÓN DETECTADO");
        return false;
    }
};
document.addEventListener('contextmenu', e => e.preventDefault());

function trackAlert(m) {
    const fd = new FormData(); fd.append('accion','shield_alert');
    fetch('process.php',{method:'POST', body:fd});
}

function showHUD(m) {
    const h = document.getElementById('hud-notif');
    const n = document.createElement('div'); n.className = 'notif'; n.innerHTML = `> ${m}`;
    h.appendChild(n); setTimeout(() => n.remove(), 4000);
}

// RELOJ
setInterval(() => {
    document.getElementById('clock').innerText = new Date().toLocaleTimeString();
}, 1000);

const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS"}, {n:"BOLIVIA", b:"🇧🇴", t:13, c:"BS"},
        {n:"BRASIL", b:"🇧🇷", t:5.20, c:"BRL"}, {n:"CHILE", b:"🇨🇱", t:970, c:"CLP"},
        {n:"COLOMBIA", b:"🇨🇴", t:3900, c:"COP"}, {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD"},
        {n:"ESPAÑA", b:"🇪🇸", t:1, c:"EUR"}, {n:"USA", b:"🇺🇸", t:1, c:"USD"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.8, c:"GTQ"}, {n:"HONDURAS", b:"🇭🇳", t:25, c:"HNL"},
        {n:"MÉXICO", b:"🇲🇽", t:20, c:"MXN"}, {n:"NICARAGUA", b:"🇳🇮", t:37, c:"NIO"},
        {n:"PANAMÁ", b:"🇵🇦", t:1, c:"USD"}, {n:"PARAGUAY", b:"🇵🇾", t:7500, c:"PYG"},
        {n:"PERÚ", b:"🇵🇪", t:3.55, c:"PEN"}, {n:"DOMINICANA", b:"🇩🇴", t:70, c:"DOP"},
        {n:"VENEZUELA", b:"🇻🇪", t:550, c:"VES"}
    ],
    prods: [
        {cat:"ANDROID ELITE", items:[
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
        {cat:"IOS ELITE", items:[
            {n:"CERTIFICADOS GBOX", d:["12 MESES"], p:[18]},
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[22,35,45]},
            {n:"FLOURITE SOLO", d:[1,7,30], p:[4,16,26]},
            {n:"PANEL IOS", d:[7,30], p:[12,19]}
        ]},
        {cat:"PC ELITE", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERMANENTE"], p:[3,8,16,25]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

function login() {
    const fd = new FormData(); fd.append('accion','login');
    fd.append('u',document.getElementById('m_u').value); fd.append('p',document.getElementById('m_p').value);
    fetch('process.php',{method:'POST', body:fd}).then(r=>r.text()).then(res=>{
        if(res.trim()=='ok'){
            document.getElementById('bloqueo').style.display='none';
            showHUD("SISTEMA AUTORIZADO - BIENVENIDO COMANDANTE");
            renderHome();
        } else { showHUD("ERROR DE CREDENCIALES - IP RASTREADA"); }
    });
}

function renderHome() {
    const l = document.getElementById('list-p'); l.innerHTML = '';
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        l.innerHTML += `<div class="country-btn" onclick="verP('${p.n}')"><span>${p.b}</span><b style="margin-left:20px;">${p.n}</b></div>`;
    });
}

function verP(n) {
    const p = DB.paises.find(x => x.n === n);
    document.getElementById('p-home').classList.remove('active');
    document.getElementById('p-detail').classList.add('active');
    window.scrollTo(0,0);
    showHUD("CARGANDO DATOS DE " + n);
    
    let h = `<div style="background:rgba(255,0,0,0.1); border:1px dashed #f00; padding:15px; border-radius:5px; margin-bottom:20px; color:#ff4444; font-size:0.8rem; text-align:center;">SISTEMA DE PAGOS EN MANTENIMIENTO</div>`;
    
    DB.prods.forEach(cat => {
        h += `<h2 style="color:var(--p); border-bottom:1px solid #222; padding-bottom:10px; font-family:Orbitron;">🔱 ${cat.cat}</h2>`;
        cat.items.forEach(i => {
            let row = ""; let clip = `💎 PRECIOS ZETA: ${i.n}\n📍 Región: ${p.n}\n───────────────────\n`;
            i.d.forEach((d, idx) => {
                let px = Math.ceil(i.p[idx] * p.t);
                let tag = isNaN(d) ? d : d + " DIAS";
                row += `<div class="row-item"><span>✅ ${tag}</span><b>${px.toLocaleString()} ${p.c}</b></div>`;
                clip += `✅ ${tag}: ${px.toLocaleString()} ${p.c}\n`;
            });
            h += `<div class="price-card"><h3>${i.n}</h3>${row}<button class="btn-copy" onclick="copiar(this, \`${clip}\`)">COPIAR LISTA</button></div>`;
        });
    });
    document.getElementById('cont-d').innerHTML = h;
}

function copiar(btn, txt) {
    navigator.clipboard.writeText(txt);
    btn.innerText = "LISTA COPIADA";
    showHUD("BUFFER DE PORTAPAPELES ACTUALIZADO");
    setTimeout(() => btn.innerText = "COPIAR LISTA", 2000);
}

function toggleNav() { document.getElementById('sideNav').classList.toggle('open'); }
function irHome() { toggleNav(); document.getElementById('p-detail').classList.remove('active'); document.getElementById('p-home').classList.add('active'); }

if("<?=$auth?>") renderHome();
</script>
</body>
</html>
