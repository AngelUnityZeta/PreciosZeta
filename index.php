<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | AGENT TERMINAL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Share+Tech+Mono&display=swap');
        
        :root { --p: #00ff41; --s: #00f2ff; --bg: #010a01; --panel: rgba(0, 20, 0, 0.8); }
        
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; cursor: crosshair; }
        body { 
            margin: 0; background: var(--bg); color: #fff; 
            font-family: 'Share Tech Mono', monospace; overflow-x: hidden;
            background-image: linear-gradient(rgba(0,255,65,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(0,255,65,0.05) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        /* LOGIN / REGISTRO HOLOGRÁFICO */
        #auth-overlay {
            position: fixed; inset: 0; background: #000; z-index: 5000;
            display: flex; align-items: center; justify-content: center;
        }
        .auth-card {
            background: var(--panel); border: 2px solid var(--p); padding: 40px;
            text-align: center; border-radius: 20px; box-shadow: 0 0 50px var(--p);
            max-width: 400px; width: 90%; position: relative;
        }
        .auth-card h2 { font-family: 'Orbitron'; color: var(--p); letter-spacing: 5px; }
        .auth-input {
            background: #000; border: 1px solid var(--p); color: var(--p);
            padding: 15px; width: 100%; margin: 20px 0; font-family: 'Share Tech Mono';
            text-align: center; font-size: 1.2rem;
        }

        /* HEADER */
        header {
            padding: 40px 20px; text-align: center; border-bottom: 2px solid var(--p);
            background: rgba(0,0,0,0.9); position: sticky; top: 0; z-index: 1000;
        }
        .logo { font-family: 'Orbitron'; font-size: 3.5rem; font-weight: 900; letter-spacing: 15px; text-shadow: 0 0 20px var(--p); }

        /* HUD AGENTE */
        .agent-hud {
            max-width: 1200px; margin: 20px auto; padding: 15px;
            border: 1px solid var(--s); display: flex; justify-content: space-between;
            background: rgba(0,242,255,0.05); font-size: 0.8rem; color: var(--s);
        }

        .container { max-width: 1300px; margin: auto; padding: 40px 20px; }

        /* GRID PAÍSES CHETADO */
        .country-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px; }
        .c-card {
            background: rgba(255,255,255,0.02); border: 1px solid #222; padding: 30px;
            border-radius: 15px; text-align: center; transition: 0.3s; position: relative;
        }
        .c-card:hover { border-color: var(--p); box-shadow: 0 0 20px var(--p); transform: translateY(-5px); }
        .c-card span { font-size: 3rem; display: block; margin-bottom: 10px; }

        /* PRODUCTOS ESTILO TERMINAL */
        .prod-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 30px; }
        .prod-card {
            background: #000; border: 1px solid #333; border-radius: 4px; padding: 25px;
            position: relative; border-left: 5px solid var(--p);
        }
        .prod-card::before { content: "DATA_NODE"; position: absolute; top: 5px; right: 10px; font-size: 0.6rem; color: #444; }
        .prod-card h3 { font-family: 'Orbitron'; font-size: 1.1rem; color: #fff; border-bottom: 1px solid #222; padding-bottom: 15px; }

        .price-line {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 0; border-bottom: 1px dashed #222;
        }
        .val { color: var(--p); font-size: 1.4rem; font-weight: bold; }

        .buy-btn {
            background: var(--p); color: #000; border: none; padding: 12px 20px;
            font-family: 'Orbitron'; font-weight: 900; font-size: 0.7rem; cursor: pointer;
        }
        .buy-btn:hover { background: #fff; box-shadow: 0 0 20px #fff; }

        .wa-float {
            position: fixed; bottom: 30px; right: 30px; background: #25d366;
            width: 70px; height: 70px; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; font-size: 35px; color: #fff;
            box-shadow: 0 0 30px rgba(37,211,102,0.5); z-index: 1000;
        }

        #view-store { display: none; }
    </style>
</head>
<body>

<div id="auth-overlay">
    <div class="auth-card">
        <h2>IDENTIFÍQUESE</h2>
        <p style="color:#666; font-size:0.7rem;">INGRESE SU NOMBRE DE AGENTE</p>
        <input type="text" id="agent-name" class="auth-input" placeholder="ALIAS..." maxlength="12">
        <button class="buy-btn" onclick="login()" style="width:100%; font-size:1rem;">INICIAR SESIÓN</button>
    </div>
</div>

<header>
    <div class="logo">ZETA</div>
</header>

<div class="agent-hud">
    <span id="hud-name">AGENTE: DESCONOCIDO</span>
    <span id="hud-status">STATUS: ENCRIPTADO</span>
    <span id="hud-region">REGIÓN: PENDIENTE</span>
</div>

<div id="view-home" class="container">
    <h2 style="color:var(--p); font-family:Orbitron; margin-bottom:30px;">[ SELECCIONE ZONA DE OPERACIÓN ]</h2>
    <div class="country-grid" id="cg"></div>
</div>

<div id="view-store" class="container">
    <button onclick="logoutRegion()" style="background:none; border:1px solid #333; color:#555; padding:10px; cursor:pointer; font-family:Orbitron; font-size:0.6rem; margin-bottom:30px;">CERRAR SESIÓN DE REGIÓN</button>
    <div id="pl" class="prod-grid"></div>
</div>

<a href="https://wa.me/573001308078" class="wa-float"><i class="fab fa-whatsapp"></i></a>

<script>
const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS"}, {n:"BOLIVIA", b:"🇧🇴", t:14, c:"BS"},
        {n:"BRASIL", b:"🇧🇷", t:5.2, c:"BRL"}, {n:"CHILE", b:"🇨🇱", t:970, c:"CLP"},
        {n:"COLOMBIA", b:"🇨🇴", t:3900, c:"COP"}, {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD"},
        {n:"ESPAÑA", b:"🇪🇸", t:1, c:"EUR"}, {n:"USA", b:"🇺🇸", t:1, c:"USD"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.8, c:"GTQ"}, {n:"HONDURAS", b:"🇭🇳", t:25, c:"HNL"},
        {n:"MÉXICO", b:"🇲🇽", t:20, c:"MXN"}, {n:"NICARAGUA", b:"🇳🇮", t:37, c:"NIO"},
        {n:"PANAMÁ", b:"🇵🇦", t:1, c:"USD"}, {n:"PARAGUAY", b:"🇵🇾", t:7500, c:"PYG"},
        {n:"PERÚ", b:"🇵🇪", t:3.55, c:"PEN"}, {n:"DOMINICANA", b:"🇩🇴", t:70, c:"DOP"},
        {n:"VENEZUELA", b:"🇻🇪", t:550, c:"VES"}
    ],
    prods: [
        {cat:"ANDROID", items:[
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"CUBAN MODS", d:[1,10,20,31], p:[3,9,13,19]},
            {n:"BR MODS MOBILE", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"STRICK BR", d:[1,7,15,30], p:[3,8,12,19]}
        ]},
        {cat:"IOS ELITE", items:[
            {n:"CERTIFICADOS GBOX", d:["ACCESO 12M"], p:[18]},
            {n:"PANEL IOS", d:[7,30], p:[12,19]}
        ]},
        {cat:"PC MASTER", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERMANENTE"], p:[3,8,16,25]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

const talk = (t) => {
    const s = window.speechSynthesis;
    const u = new SpeechSynthesisUtterance(t);
    u.lang = 'es-ES'; u.rate = 0.9; u.pitch = 0.8;
    s.speak(u);
};

function login() {
    const name = document.getElementById('agent-name').value;
    if(name.length < 3) return alert("ALIAS DEMASIADO CORTO");
    localStorage.setItem('zeta_agent', name);
    document.getElementById('auth-overlay').style.display = 'none';
    document.getElementById('hud-name').innerText = "AGENTE: " + name.toUpperCase();
    talk("Bienvenido Agente " + name + ". Sistema Zeta Hacks operativo.");
}

function init() {
    const saved = localStorage.getItem('zeta_agent');
    if(saved) {
        document.getElementById('auth-overlay').style.display = 'none';
        document.getElementById('hud-name').innerText = "AGENTE: " + saved.toUpperCase();
    }
    
    const g = document.getElementById('cg');
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        const d = document.createElement('div'); d.className = 'c-card';
        d.onclick = () => showStore(p);
        d.innerHTML = `<span>${p.b}</span><b>${p.n}</b>`;
        g.appendChild(d);
    });
}

function showStore(p) {
    talk("Accediendo a base de datos de " + p.n);
    document.getElementById('view-home').style.display = 'none';
    document.getElementById('view-store').style.display = 'block';
    document.getElementById('hud-region').innerText = "REGIÓN: " + p.n;
    window.scrollTo(0,0);

    const pl = document.getElementById('pl'); pl.innerHTML = '';
    DB.prods.forEach(c => {
        c.items.forEach(i => {
            let rs = '';
            i.d.forEach((d, idx) => {
                let v = Math.ceil(i.p[idx] * p.t);
                let t = isNaN(d) ? d : d + " DÍAS";
                rs += `<div class="price-line"><span>${t}</span><span class="val">${v.toLocaleString()} ${p.c}</span><button class="buy-btn" onclick="buy('${i.n}','${t}','${v} ${p.c}')">ADQUIRIR</button></div>`;
            });
            pl.innerHTML += `<div class="prod-card"><h3>${i.n}</h3>${rs}</div>`;
        });
    });
}

function buy(n, d, p) {
    const agent = localStorage.getItem('zeta_agent') || "Desconocido";
    talk("Orden generada para el agente " + agent);
    const link = `https://wa.me/573001308078?text=🔱 *ZETA TERMINAL ORDER*%0A👤 *Agente:* ${agent}%0A💎 *Software:* ${n}%0A⏳ *Duración:* ${d}%0A💰 *Precio:* ${p}`;
    window.open(link, '_blank');
}

function logoutRegion() {
    document.getElementById('view-store').style.display = 'none';
    document.getElementById('view-home').style.display = 'block';
    document.getElementById('hud-region').innerText = "REGIÓN: PENDIENTE";
}

init();
</script>
</body>
</html>
