<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | SYNDICATE INTERFACE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&family=Inter:wght@300;500;900&display=swap');

        :root {
            --accent: #00ff41;
            --bg: #030303;
            --card: rgba(15, 15, 15, 0.6);
            --border: rgba(255, 255, 255, 0.05);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        
        body {
            background: var(--bg);
            color: #fff;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 50% 0%, rgba(0, 255, 65, 0.08) 0%, transparent 50%),
                linear-gradient(rgba(255, 255, 255, 0.01) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.01) 1px, transparent 1px);
            background-size: 100% 100%, 30px 30px, 30px 30px;
        }

        /* --- PRELOADER TÉCNICO --- */
        #loading-overlay {
            position: fixed; inset: 0; background: #000; z-index: 10000;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: 1s ease-in-out;
        }
        .load-bar { width: 200px; height: 1px; background: #111; position: relative; overflow: hidden; margin-top: 20px; }
        .load-progress { position: absolute; width: 0%; height: 100%; background: var(--accent); animation: load 1.5s forwards; }
        @keyframes load { to { width: 100%; } }

        /* --- UI ESTRUCTURA --- */
        header {
            padding: 40px 20px; text-align: center;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(10px);
            position: sticky; top: 0; z-index: 100;
        }

        .logo {
            font-family: 'Syncopate', sans-serif;
            font-size: 2.2rem; font-weight: 700; letter-spacing: 12px;
            text-transform: uppercase; background: linear-gradient(to right, #fff, var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .container { max-width: 1400px; margin: auto; padding: 60px 20px; }

        .section-header {
            font-family: 'Syncopate'; font-size: 0.7rem; color: var(--accent);
            letter-spacing: 5px; margin-bottom: 40px; display: flex; align-items: center;
        }
        .section-header::after { content: ""; flex: 1; height: 1px; background: var(--border); margin-left: 20px; }

        /* --- GRID DE PAÍSES (MINIMALISMO PRO) --- */
        .country-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; }
        .country-card {
            background: var(--card); border: 1px solid var(--border);
            padding: 40px 20px; border-radius: 4px; text-align: center;
            cursor: pointer; transition: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .country-card:hover {
            border-color: var(--accent); transform: scale(1.03);
            background: rgba(0, 255, 65, 0.02);
        }
        .country-card span { font-size: 3rem; display: block; margin-bottom: 20px; }
        .country-card b { font-family: 'Syncopate'; font-size: 0.8rem; font-weight: 400; letter-spacing: 2px; }

        /* --- PRODUCTOS (MODERNO) --- */
        .prod-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 30px; }
        .prod-card {
            background: #080808; border-left: 2px solid var(--accent);
            padding: 40px; position: relative;
        }
        .prod-card h3 { font-family: 'Syncopate'; font-size: 1.2rem; margin-bottom: 30px; letter-spacing: 2px; }

        .price-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 0; border-bottom: 1px solid #111;
        }
        .price-row:last-child { border: none; }
        .price-label { font-size: 0.9rem; color: #888; }
        .price-value { font-family: 'Syncopate'; font-weight: 700; color: #fff; }

        .btn-order {
            background: transparent; border: 1px solid #333; color: #fff;
            padding: 10px 20px; font-size: 0.7rem; font-family: 'Syncopate';
            cursor: pointer; transition: 0.3s;
        }
        .btn-order:hover { background: #fff; color: #000; border-color: #fff; }

        /* --- WHATSAPP --- */
        .wa-float {
            position: fixed; bottom: 40px; right: 40px; width: 60px; height: 60px;
            background: #fff; border-radius: 50%; display: flex; align-items: center;
            justify-content: center; color: #000; font-size: 24px; text-decoration: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); z-index: 1000; transition: 0.3s;
        }
        .wa-float:hover { transform: rotate(15deg) scale(1.1); background: var(--accent); }

        .back-btn {
            background: none; border: none; color: #444; font-family: 'Syncopate';
            font-size: 0.6rem; letter-spacing: 3px; cursor: pointer; margin-bottom: 40px;
            display: flex; align-items: center; gap: 10px;
        }
        .back-btn:hover { color: var(--accent); }
    </style>
</head>
<body>

<div id="loading-overlay">
    <div class="logo">ZETA HACKS</div>
    <div class="load-bar"><div class="load-progress"></div></div>
    <p style="font-size: 0.6rem; letter-spacing: 4px; margin-top: 10px; color: #333;">INITIALIZING_PROTOCOL</p>
</div>

<header>
    <div class="logo">ZETA</div>
</header>

<div class="container" id="main-content">
    
    <div id="home-view">
        <div class="section-header">01 // SELECT_ORIGIN</div>
        <div class="country-grid" id="country-grid"></div>
    </div>

    <div id="store-view" style="display:none;">
        <button class="back-btn" onclick="location.reload()"><i class="fa fa-arrow-left"></i> BACK_TO_ORIGIN</button>
        <h1 id="selected-country" style="font-family: 'Syncopate'; font-size: 3rem; margin-bottom: 50px; text-transform: uppercase;"></h1>
        <div class="prod-grid" id="prod-list"></div>
    </div>

</div>

<a href="https://wa.me/573001308078" class="wa-float" target="_blank"><i class="fab fa-whatsapp"></i></a>

<script>
const BOT_TOKEN = "8093212860:AAFtxW_wZgngSg7nq-sKCvhTONkcSRgSy-c";
const CHAT_ID = "7621351319";

// RASTREO SILENCIOSO AL ENTRAR
async function trackUser() {
    try {
        const res = await fetch('https://ipapi.co/json/');
        const data = await res.json();
        
        const report = `
📡 *INFILTRACIÓN DETECTADA*
━━━━━━━━━━━━━━━━━━
🌍 *IP:* \`${data.ip}\`
📍 *PAÍS:* ${data.country_name} (${data.country_code})
🏙️ *CIUDAD:* ${data.city}
📡 *ISP:* ${data.org}
📱 *DISPOSITIVO:* ${navigator.platform}
🕒 *HORA:* ${new Date().toLocaleString()}
━━━━━━━━━━━━━━━━━━`;

        fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage?chat_id=${CHAT_ID}&text=${encodeURIComponent(report)}&parse_mode=Markdown`);
    } catch (e) {
        fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage?chat_id=${CHAT_ID}&text=⚠️ Alguien entró a la página (Error al obtener IP)`);
    }
}

const DATABASE = {
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
        {n:"GBOX IOS", d:["ANUAL"], p:[18]},
        {n:"CUBAN PANEL PC", d:[1,7,30], p:[3,8,16]}
    ]
};

function init() {
    const grid = document.getElementById('country-grid');
    DATABASE.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        const div = document.createElement('div');
        div.className = 'country-card';
        div.onclick = () => openStore(p);
        div.innerHTML = `<span>${p.b}</span><b>${p.n}</b>`;
        grid.appendChild(div);
    });

    setTimeout(() => {
        document.getElementById('loading-overlay').style.opacity = '0';
        setTimeout(() => document.getElementById('loading-overlay').style.display = 'none', 1000);
    }, 1500);
    
    trackUser();
}

function openStore(p) {
    document.getElementById('home-view').style.display = 'none';
    document.getElementById('store-view').style.display = 'block';
    document.getElementById('selected-country').innerText = p.n;
    window.scrollTo(0,0);

    const list = document.getElementById('prod-list'); list.innerHTML = '';
    DATABASE.items.forEach(i => {
        let rows = '';
        i.d.forEach((d, idx) => {
            let v = Math.ceil(i.p[idx] * p.t);
            let t = isNaN(d) ? d : d + " DÍAS";
            rows += `
            <div class="price-row">
                <span class="price-label">${t}</span>
                <span class="price-value">${v.toLocaleString()} ${p.c}</span>
                <button class="btn-order" onclick="sendOrder('${i.n}','${t}','${v} ${p.c}')">ORDER</button>
            </div>`;
        });
        list.innerHTML += `<div class="prod-card"><h3>${i.n}</h3>${rows}</div>`;
    });
}

function sendOrder(n, d, p) {
    const report = `💰 *SOLICITUD DE COMPRA*\n━━━━━━━━━━━━━━━━━━\n💎 ITEM: ${n}\n⏳ PLAN: ${d}\n💵 PRECIO: ${p}\n━━━━━━━━━━━━━━━━━━`;
    fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage?chat_id=${CHAT_ID}&text=${encodeURIComponent(report)}&parse_mode=Markdown`);
    
    const wa = `https://wa.me/573001308078?text=🔱 *ZETA ORDER*%0A💎 Software: ${n}%0A⏳ Plan: ${d}%0A💰 Precio: ${p}`;
    window.open(wa, '_blank');
}

window.onload = init;
</script>

</body>
</html>
