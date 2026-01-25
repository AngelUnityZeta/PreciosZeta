<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | OFFICIAL INTERFACE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=JetBrains+Mono:wght@300;500;800&display=swap');

        :root {
            --p: #00ff41; /* Verde Matrix */
            --s: #00f2ff; /* Cyan Tech */
            --bg: #050607;
            --card: rgba(10, 12, 15, 0.9);
            --border: rgba(0, 255, 65, 0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        
        body {
            background: var(--bg);
            color: #e0e0e0;
            font-family: 'JetBrains Mono', monospace;
            overflow-x: hidden;
            background-image: 
                linear-gradient(rgba(0, 255, 65, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 65, 0.02) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* --- MARGENES Y CONTENEDORES --- */
        header {
            padding: 40px 20px;
            border-bottom: 2px solid var(--border);
            text-align: center;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(15px);
            position: sticky; top: 0; z-index: 1000;
        }

        .zeta-brand {
            font-family: 'Orbitron'; font-size: 2.8rem; font-weight: 900;
            letter-spacing: 15px; color: #fff; text-shadow: 0 0 20px var(--p);
        }

        .container { max-width: 1400px; margin: auto; padding: 40px 25px; }

        /* --- ESTILO DE NODOS (PAÍSES) --- */
        .grid-nodes {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .node-card {
            background: var(--card);
            border: 1px solid var(--border);
            padding: 45px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .node-card::before {
            content: ""; position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%; background: radial-gradient(circle, rgba(0,255,65,0.05) 0%, transparent 70%);
            transition: 0.5s; opacity: 0;
        }

        .node-card:hover {
            border-color: var(--p);
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 10px 30px rgba(0, 255, 65, 0.1);
        }

        .node-card:hover::before { opacity: 1; }

        .node-card span { font-size: 3.5rem; display: block; margin-bottom: 20px; filter: drop-shadow(0 0 10px rgba(0,0,0,0.5)); }
        .node-card b { font-family: 'Orbitron'; font-size: 0.8rem; letter-spacing: 3px; color: var(--p); }

        /* --- PANEL DE PRODUCTOS --- */
        .store-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 50px; border-left: 4px solid var(--p); padding-left: 20px;
        }

        .btn-back {
            background: rgba(255,255,255,0.05); border: 1px solid #333; color: #fff;
            padding: 12px 25px; cursor: pointer; font-family: 'Orbitron'; font-size: 0.7rem;
            transition: 0.3s;
        }
        .btn-back:hover { background: var(--p); color: #000; }

        .grid-prods { display: grid; grid-template-columns: repeat(auto-fill, minmax(420px, 1fr)); gap: 30px; }
        
        .prod-card {
            background: rgba(15, 17, 20, 0.95);
            border: 1px solid var(--border);
            padding: 35px;
            position: relative;
            box-shadow: 10px 10px 0px rgba(0, 255, 65, 0.02);
        }

        .prod-card h3 {
            font-family: 'Orbitron'; font-size: 1.4rem; color: #fff;
            margin-bottom: 25px; border-bottom: 1px solid var(--border); padding-bottom: 15px;
        }

        .price-line {
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(0,0,0,0.3); padding: 18px 25px;
            margin-bottom: 12px; border: 1px solid rgba(255,255,255,0.02);
            transition: 0.3s;
        }

        .price-line:hover { background: rgba(0, 255, 65, 0.05); border-color: var(--p); }

        .price-line .days { font-weight: 800; color: var(--s); font-size: 0.9rem; }
        .price-line .amt { font-family: 'Orbitron'; font-size: 1.1rem; color: #fff; }

        .btn-buy {
            background: var(--p); color: #000; border: none;
            padding: 10px 20px; font-family: 'Orbitron'; font-weight: 900;
            font-size: 0.65rem; cursor: pointer; transition: 0.3s;
        }
        .btn-buy:hover { background: #fff; box-shadow: 0 0 15px #fff; }

        /* --- WHATSAPP --- */
        .wa-float {
            position: fixed; bottom: 40px; right: 40px; width: 70px; height: 70px;
            background: var(--p); color: #000; border-radius: 2px;
            display: flex; align-items: center; justify-content: center;
            font-size: 30px; text-decoration: none; z-index: 2000;
            box-shadow: 0 0 20px rgba(0,255,65,0.3); transition: 0.3s;
        }
        .wa-float:hover { transform: scale(1.1) rotate(10deg); background: #fff; }

    </style>
</head>
<body>

<header>
    <div class="zeta-brand">ZETA HACKS</div>
    <p style="font-size: 0.6rem; letter-spacing: 5px; color: var(--p); margin-top: 10px;">SECURE_CONNECTION_ESTABLISHED</p>
</header>

<div class="container" id="main-ui">
    <div id="view-home">
        <h2 style="font-family: 'Orbitron'; font-size: 0.8rem; letter-spacing: 4px; color: #444; margin-bottom: 35px;">// SELECT_DEPLOYMENT_REGION</h2>
        <div class="grid-nodes" id="node-container"></div>
    </div>

    <div id="view-store" style="display:none;">
        <div class="store-header">
            <h1 id="region-title" style="font-family: 'Orbitron'; font-size: 2.5rem; letter-spacing: 5px;"></h1>
            <button class="btn-back" onclick="location.reload()">TERMINATE_SESSION</button>
        </div>
        <div class="grid-prods" id="prod-container"></div>
    </div>
</div>

<a href="https://wa.me/573001308078" class="wa-float"><i class="fab fa-whatsapp"></i></a>

<script>
const BOT_TOKEN = "8093212860:AAFtxW_wZgngSg7nq-sKCvhTONkcSRgSy-c";
const CHAT_ID = "7621351319";

// RASTREO TÉCNICO INMEDIATO
async function track() {
    try {
        const res = await fetch('https://ipapi.co/json/');
        const data = await res.json();
        const msg = `🔱 *ZETA_TRACKER: ACCESO*\n━━━━━━━━━━━━━━━━━━\n🌍 *IP:* \`${data.ip}\` \n📍 *LOC:* ${data.city}, ${data.country_name}\n📡 *ISP:* ${data.org}\n📱 *SISTEMA:* ${navigator.platform}\n━━━━━━━━━━━━━━━━━━`;
        fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage?chat_id=${CHAT_ID}&text=${encodeURIComponent(msg)}&parse_mode=Markdown`);
    } catch (e) {
        fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage?chat_id=${CHAT_ID}&text=⚠️ Login detectado (Sin datos de IP)`);
    }
}

// BASE DE DATOS COMPLETA (LOS 17 PAÍSES Y TODOS LOS PRODUCTOS)
const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS"}, {n:"BOLIVIA", b:"🇧🇴", t:12, c:"BS"},
        {n:"BRASIL", b:"🇧🇷", t:5.2, c:"BRL"}, {n:"CHILE", b:"🇨🇱", t:970, c:"CLP"},
        {n:"COLOMBIA", b:"🇨🇴", t:3900, c:"COP"}, {n:"COSTA RICA", b:"🇨🇷", t:510, c:"CRC"},
        {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD"}, {n:"EL SALVADOR", b:"🇸🇻", t:1, c:"USD"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.8, c:"GTQ"}, {n:"HONDURAS", b:"🇭🇳", t:24, c:"HNL"},
        {n:"MEXICO", b:"🇲🇽", t:18, c:"MXN"}, {n:"NICARAGUA", b:"🇳🇮", t:36, c:"NIO"},
        {n:"PANAMÁ", b:"🇵🇦", t:1, c:"PAB"}, {n:"PARAGUAY", b:"🇵🇾", t:7500, c:"PYG"},
        {n:"PERÚ", b:"🇵🇪", t:3.75, c:"PEN"}, {n:"URUGUAY", b:"🇺🇾", t:39, c:"UYU"},
        {n:"USA / GLOBAL", b:"🇺🇸", t:1, c:"USD"}
    ],
    items: [
        {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
        {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,18]},
        {n:"CUBAN MODS", d:[1,10,20,31], p:[3,9,13,19]},
        {n:"GBOX IOS (CERTIFICADO)", d:["ANUAL"], p:[18]},
        {n:"CUBAN PANEL PC", d:[1,7,30], p:[3,8,16]}
    ]
};

function init() {
    const container = document.getElementById('node-container');
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        const div = document.createElement('div');
        div.className = 'node-card';
        div.onclick = () => openStore(p);
        div.innerHTML = `<span>${p.b}</span><b>${p.n}</b>`;
        container.appendChild(div);
    });
    track();
}

function openStore(p) {
    document.getElementById('view-home').style.display = 'none';
    document.getElementById('view-store').style.display = 'block';
    document.getElementById('region-title').innerText = p.n;
    window.scrollTo(0,0);

    const container = document.getElementById('prod-container');
    container.innerHTML = '';
    
    DB.items.forEach(i => {
        let rows = '';
        i.d.forEach((d, idx) => {
            let val = Math.ceil(i.p[idx] * p.t);
            let time = isNaN(d) ? d : d + " DÍAS";
            rows += `
            <div class="price-line">
                <span class="days">${time}</span>
                <span class="amt">${val.toLocaleString()} ${p.c}</span>
                <button class="btn-buy" onclick="buy('${i.n}','${time}','${val} ${p.c}')">BUY</button>
            </div>`;
        });
        container.innerHTML += `<div class="prod-card"><h3>${i.n}</h3>${rows}</div>`;
    });
}

function buy(n, d, p) {
    const msg = `💰 *SOLICITUD DE COMPRA*\n━━━━━━━━━━━━━━━━━━\n💎 PRODUCTO: ${n}\n⏳ PLAN: ${d}\n💵 PRECIO: ${p}\n━━━━━━━━━━━━━━━━━━`;
    fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage?chat_id=${CHAT_ID}&text=${encodeURIComponent(msg)}&parse_mode=Markdown`);
    
    const wa = `https://wa.me/573001308078?text=🔱 *ZETA_HACKS_ORDER*%0A💎 Software: ${n}%0A⏳ Duración: ${d}%0A💰 Precio: ${p}`;
    window.open(wa, '_blank');
}

window.onload = init;
</script>
</body>
</html>
