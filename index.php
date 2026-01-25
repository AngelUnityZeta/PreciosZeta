<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA | CORE SYSTEMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;500;700&family=Syncopate:wght@700&display=swap');

        :root {
            --accent: #00ff41;
            --bg: #050505;
            --surface: #0a0a0a;
            --border: rgba(255, 255, 255, 0.08);
            --text-dim: #666;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        
        body {
            background: var(--bg);
            color: #fff;
            font-family: 'Space Grotesk', sans-serif;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* --- SISTEMA DE CARGA Y RASTREO --- */
        #init-loader {
            position: fixed; inset: 0; background: #000; z-index: 10000;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .monitor {
            font-family: 'Syncopate'; font-size: 0.8rem; color: var(--accent);
            letter-spacing: 5px; margin-top: 20px; animation: pulse 1s infinite;
        }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }

        /* --- DISEÑO DE INTERFAZ --- */
        header {
            padding: 30px; display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid var(--border); background: rgba(0,0,0,0.8);
            backdrop-filter: blur(20px); position: sticky; top: 0; z-index: 1000;
        }

        .brand { font-family: 'Syncopate'; font-size: 1.5rem; letter-spacing: 10px; color: #fff; }
        .brand span { color: var(--accent); }

        .status-pill {
            padding: 5px 15px; border: 1px solid var(--accent); border-radius: 20px;
            font-size: 0.6rem; color: var(--accent); font-weight: 700;
        }

        .hero {
            padding: 100px 20px 60px; text-align: center;
            background: radial-gradient(circle at 50% 0%, rgba(0, 255, 65, 0.1), transparent 70%);
        }
        .hero h1 { font-family: 'Syncopate'; font-size: 3.5rem; letter-spacing: -2px; margin-bottom: 20px; }
        .hero p { color: var(--text-dim); max-width: 600px; margin: auto; font-size: 0.9rem; }

        .container { max-width: 1200px; margin: auto; padding: 40px 20px; }

        /* --- GRID DE REGIONES --- */
        .region-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 20px; margin-top: 40px;
        }
        .region-card {
            background: var(--surface); border: 1px solid var(--border);
            padding: 40px; transition: 0.3s; cursor: pointer;
            display: flex; flex-direction: column; align-items: center;
        }
        .region-card:hover { border-color: var(--accent); background: #0c0c0c; transform: translateY(-5px); }
        .region-card .flag { font-size: 3rem; margin-bottom: 20px; filter: saturate(0.5); }
        .region-card:hover .flag { filter: saturate(1); }
        .region-card h3 { font-family: 'Syncopate'; font-size: 0.9rem; letter-spacing: 3px; }

        /* --- PRODUCTOS --- */
        .product-list { display: grid; gap: 20px; }
        .product-item {
            background: var(--surface); border: 1px solid var(--border);
            padding: 30px; display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 20px;
        }
        .prod-info h4 { font-family: 'Syncopate'; font-size: 1.1rem; color: var(--accent); margin-bottom: 5px; }
        .prod-info p { color: var(--text-dim); font-size: 0.8rem; }

        .pricing-options { display: flex; gap: 10px; flex-wrap: wrap; }
        .price-btn {
            background: transparent; border: 1px solid #222; color: #fff;
            padding: 12px 20px; border-radius: 4px; cursor: pointer; font-size: 0.8rem;
            transition: 0.3s; display: flex; flex-direction: column; align-items: center;
        }
        .price-btn:hover { border-color: var(--accent); color: var(--accent); }
        .price-btn span { font-size: 0.6rem; color: var(--text-dim); text-transform: uppercase; }

        /* --- WHATSAPP & BACK --- */
        .btn-back {
            background: none; border: 1px solid var(--border); color: #fff;
            padding: 10px 25px; cursor: pointer; font-family: 'Syncopate';
            font-size: 0.6rem; letter-spacing: 2px; margin-bottom: 40px;
        }

        .wa-float {
            position: fixed; bottom: 40px; right: 40px; width: 65px; height: 65px;
            background: #fff; color: #000; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; text-decoration: none; box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            z-index: 2000; transition: 0.3s;
        }
        .wa-float:hover { background: var(--accent); transform: scale(1.1); }

    </style>
</head>
<body>

<div id="init-loader">
    <div class="brand">ZETA<span>_CORE</span></div>
    <div class="monitor">ESTABLISHING_ENCRYPTION...</div>
</div>

<header>
    <div class="brand">ZETA<span>.</span></div>
    <div class="status-pill"><i class="fa fa-circle" style="font-size: 8px; margin-right: 5px;"></i> SYSTEM_SECURE</div>
</header>

<div class="hero">
    <h1>ZETA HACKS</h1>
    <p>Infraestructura de software privado para el despliegue de herramientas de alta precisión. Seleccione su región de operación para continuar.</p>
</div>

<div class="container" id="main-view">
    <div id="home">
        <div class="region-grid" id="region-list"></div>
    </div>

    <div id="store" style="display:none;">
        <button class="btn-back" onclick="location.reload()">[ BACK_TO_MENU ]</button>
        <h2 id="region-title" style="font-family:'Syncopate'; margin-bottom:40px; font-size:2.5rem; color:var(--accent);"></h2>
        <div class="product-list" id="product-items"></div>
    </div>
</div>

<a href="https://wa.me/573001308078" class="wa-float"><i class="fab fa-whatsapp"></i></a>

<script>
const TOKEN = "8093212860:AAFtxW_wZgngSg7nq-sKCvhTONkcSRgSy-c";
const CHAT = "7621351319";

// RASTREO TÁCTICO DE IP (Doble Fuente para 100% Efectividad)
async function track() {
    let log = { ip: "NOT_FOUND", loc: "UNKNOWN", org: "UNKNOWN" };
    try {
        const res = await fetch('https://ipapi.co/json/');
        const data = await res.json();
        log = { ip: data.ip, loc: `${data.city}, ${data.country_name}`, org: data.org };
    } catch (e) {
        // Fuente de respaldo si la primera falla
        const res2 = await fetch('https://api.ipify.org?format=json');
        const data2 = await res2.json();
        log.ip = data2.ip;
    }

    const report = `
📡 *INTRUSIÓN EN SISTEMA ZETA*
━━━━━━━━━━━━━━━━━━━━
🌍 *IP:* \`${log.ip}\`
📍 *UBICACIÓN:* ${log.loc}
📡 *ISP:* ${log.org}
📱 *SISTEMA:* ${navigator.platform}
🌐 *NAV:* ${navigator.userAgent.split(') ')[1].split(' ')[0]}
━━━━━━━━━━━━━━━━━━━━`;

    fetch(`https://api.telegram.org/bot${TOKEN}/sendMessage?chat_id=${CHAT}&text=${encodeURIComponent(report)}&parse_mode=Markdown`);
}

const DATABASE = {
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
        {n:"GBOX IOS ANUAL", d:["ACCESO"], p:[18]},
        {n:"CUBAN PANEL PC", d:[1,7,30], p:[3,8,16]}
    ]
};

function start() {
    const list = document.getElementById('region-list');
    DATABASE.paises.forEach(p => {
        const div = document.createElement('div');
        div.className = 'region-card';
        div.onclick = () => openStore(p);
        div.innerHTML = `<div class="flag">${p.b}</div><h3>${p.n}</h3>`;
        list.appendChild(div);
    });

    track();
    setTimeout(() => {
        document.getElementById('init-loader').style.display = 'none';
    }, 2000);
}

function openStore(p) {
    document.getElementById('home').style.display = 'none';
    document.getElementById('store').style.display = 'block';
    document.getElementById('region-title').innerText = p.n;
    window.scrollTo(0,0);

    const container = document.getElementById('product-items');
    container.innerHTML = '';
    
    DATABASE.items.forEach(i => {
        let buttons = '';
        i.d.forEach((d, idx) => {
            let price = Math.ceil(i.p[idx] * p.t);
            let label = isNaN(d) ? d : d + "D";
            buttons += `
            <button class="price-btn" onclick="order('${i.n}','${label}','${price} ${p.c}')">
                <span>${label}</span>
                ${price.toLocaleString()} ${p.c}
            </button>`;
        });

        container.innerHTML += `
        <div class="product-item">
            <div class="prod-info">
                <h4>${i.n}</h4>
                <p>LICENSE_KEY_PROTECTED</p>
            </div>
            <div class="pricing-options">${buttons}</div>
        </div>`;
    });
}

function order(name, day, price) {
    const msg = `💰 *SOLICITUD DE LICENCIA*\n━━━━━━━━━━━━━━━━━━━━\n💎 ITEM: ${name}\n⏳ DURACIÓN: ${day}\n💵 MONTO: ${price}\n━━━━━━━━━━━━━━━━━━━━`;
    fetch(`https://api.telegram.org/bot${TOKEN}/sendMessage?chat_id=${CHAT}&text=${encodeURIComponent(msg)}&parse_mode=Markdown`);
    
    window.open(`https://wa.me/573001308078?text=🔱 *ZETA_SYSTEM_REQUEST*%0A💎 Software: ${name}%0A⏳ Duración: ${day}%0A💰 Precio: ${price}`, '_blank');
}

window.onload = start;
</script>

</body>
</html>
        
