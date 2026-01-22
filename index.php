<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | PREMIUM STORE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@400;600;700&display=swap');
        
        :root { 
            --p: #00ff41; --s: #00f2ff; --bg: #050505; 
            --card-bg: #0d0d0d; --border: #1a1a1a;
            --accent-glow: rgba(0, 255, 65, 0.2);
        }
        
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; cursor: crosshair; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; overflow-x: hidden; }

        /* PANTALLA DE ACCESO (INTRO) */
        #intro {
            position: fixed; inset: 0; background: #000; z-index: 10000;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .intro-btn {
            border: 2px solid var(--p); padding: 20px 50px; font-family: 'Orbitron';
            color: var(--p); font-size: 1.2rem; background: transparent;
            box-shadow: 0 0 20px var(--accent-glow); transition: 0.3s;
        }
        .intro-btn:hover { background: var(--p); color: #000; box-shadow: 0 0 40px var(--p); }

        /* HEADER DE ALTA POTENCIA */
        header {
            padding: 60px 0; text-align: center; border-bottom: 1px solid var(--border);
            background: linear-gradient(180deg, #0a0a0a 0%, #050505 100%);
        }
        .brand { font-family: 'Orbitron'; font-size: 4.5rem; font-weight: 900; letter-spacing: 25px; margin: 0; text-shadow: 0 0 25px var(--p); }
        .tagline { font-family: 'Orbitron'; font-size: 0.8rem; color: var(--s); letter-spacing: 10px; margin-top: 15px; text-transform: uppercase; }

        /* HUD DEL SISTEMA */
        .hud-bar {
            max-width: 1200px; margin: 20px auto; padding: 10px 20px;
            background: rgba(255,255,255,0.02); border: 1px solid var(--border);
            display: flex; justify-content: space-between; font-size: 0.7rem; color: #444; font-family: 'Orbitron';
        }

        /* CONTENEDOR PRINCIPAL */
        .main-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .grid-view { display: none; }
        .active { display: block; animation: powerOn 1s ease-out; }

        /* TARJETAS DE PAÍS (NUEVO DISEÑO) */
        .countries {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 25px;
        }
        .country-box {
            background: var(--card-bg); border: 1px solid var(--border); border-radius: 4px;
            padding: 40px 20px; text-align: center; transition: 0.4s;
            position: relative; overflow: hidden;
        }
        .country-box::before { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: var(--p); transform: scaleX(0); transition: 0.4s; }
        .country-box:hover { border-color: var(--p); background: #111; transform: translateY(-10px); }
        .country-box:hover::before { transform: scaleX(1); }
        .country-box span { font-size: 3.5rem; display: block; margin-bottom: 20px; filter: grayscale(0.5); }
        .country-box b { font-family: 'Orbitron'; font-size: 0.9rem; letter-spacing: 2px; }

        /* PRODUCTOS (DISEÑO INDUSTRIAL) */
        .product-item {
            background: #080808; border: 1px solid var(--border); padding: 0;
            margin-bottom: 40px; border-radius: 8px; overflow: hidden;
        }
        .product-header {
            background: #111; padding: 20px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 20px;
        }
        .product-header h3 { font-family: 'Orbitron'; margin: 0; font-size: 1.3rem; color: var(--s); }
        .price-table { padding: 20px; }
        .price-row {
            display: grid; grid-template-columns: 1fr 1fr 150px;
            align-items: center; padding: 15px; border-bottom: 1px solid #111;
        }
        .price-row:last-child { border: none; }
        .p-price { color: var(--p); font-family: 'Orbitron'; font-weight: 900; font-size: 1.4rem; }

        .buy-btn {
            background: var(--p); color: #000; border: none; padding: 12px;
            font-family: 'Orbitron'; font-weight: 900; font-size: 0.7rem;
            cursor: pointer; clip-path: polygon(10% 0, 100% 0, 90% 100%, 0 100%);
            transition: 0.3s;
        }
        .buy-btn:hover { background: #fff; transform: scale(1.05); }

        /* SOPORTE */
        .support-card {
            background: #25d366; color: #000; position: fixed; bottom: 30px; right: 30px;
            width: 70px; height: 70px; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; font-size: 35px;
            box-shadow: 0 0 30px rgba(37,211,102,0.5); z-index: 100;
        }

        @keyframes powerOn { 0% { opacity: 0; filter: brightness(3); } 100% { opacity: 1; filter: brightness(1); } }
    </style>
</head>
<body>

<div id="intro">
    <h1 style="font-family:'Orbitron'; font-size:1.5rem; margin-bottom:30px; letter-spacing:10px;">ZETA HACKS V12</h1>
    <button class="intro-btn" onclick="bootSystem()">ACCEDER AL SISTEMA</button>
</div>

<header>
    <div class="brand">Zeta Hacks</div>
    <div class="tagline">TIENDA OFICIAL DE SOFTWARE ELITE</div>
</header>

<div class="hud-bar">
    <span>SYSTEM: ONLINE</span>
    <span>SECURITY: ENC-V12</span>
    <span id="timer">REGION: PENDING</span>
</div>

<div class="main-container">
    <div id="view-countries" class="grid-view active">
        <div class="countries" id="c-grid"></div>
    </div>

    <div id="view-store" class="grid-view">
        <button onclick="backToMap()" style="background:none; border:none; color:var(--s); font-family:Orbitron; margin-bottom:30px; cursor:pointer;">&lt;&lt; VOLVER AL TERMINAL</button>
        <h2 id="current-region" style="font-family:Orbitron; font-size:2.5rem; color:var(--p); margin-bottom:40px;"></h2>
        <div id="p-list"></div>
    </div>
</div>

<a href="https://wa.me/573001308078" class="support-card"><i class="fab fa-whatsapp"></i></a>

<script>
const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS"}, {n:"BOLIVIA", b:"🇧🇴", t:13, c:"BS"},
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
        {cat:"ANDROID SOLUTIONS", items:[
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"HG CHEATS", d:[1,10,30], p:[3,12,20]},
            {n:"HG CHEATS + VIRTUAL", d:[1,10,30], p:[5,16,29]},
            {n:"STRICK BR", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"STRICK BR + VIRTUAL", d:[1,7,15,30], p:[6,12,16,29]}
        ]},
        {cat:"IOS SOLUTIONS", items:[
            {n:"CERTIFICADOS GBOX", d:["12 MESES"], p:[20]},
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[25,38,50]},
            {n:"FLOURITE SOLO", d:[1,7,30], p:[5,16,28]},
        {cat:"PC SOLUTIONS", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERMANENTE"], p:[3,8,16,30]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

const talk = (txt) => {
    const synth = window.speechSynthesis;
    const ut = new SpeechSynthesisUtterance(txt);
    ut.lang = 'es-ES'; ut.rate = 0.95; ut.pitch = 0.8;
    synth.speak(ut);
};

function bootSystem() {
    document.getElementById('intro').style.display = 'none';
    talk("Sistema Zeta Hacks iniciado. Bienvenido a la tienda oficial. Seleccione una región para ver los precios locales.");
}

function init() {
    const grid = document.getElementById('c-grid');
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        const d = document.createElement('div'); d.className = 'country-box';
        d.onclick = () => loadStore(p);
        d.innerHTML = `<span>${p.b}</span><b>${p.n}</b>`;
        grid.appendChild(d);
    });
}

function loadStore(p) {
    talk("Analizando precios para " + p.n);
    document.getElementById('view-countries').classList.remove('active');
    document.getElementById('view-store').classList.add('active');
    document.getElementById('current-region').innerText = "REGION: " + p.n;
    document.getElementById('timer').innerText = "REGION: " + p.n;
    window.scrollTo(0,0);

    const container = document.getElementById('p-list');
    container.innerHTML = '';

    DB.prods.forEach(cat => {
        container.innerHTML += `<h2 style="font-family:Orbitron; border-bottom:2px solid #222; padding-bottom:10px; margin-top:60px; color:#444;">${cat.cat}</h2>`;
        cat.items.forEach(i => {
            let rows = '';
            i.d.forEach((d, idx) => {
                let localPx = Math.ceil(i.p[idx] * p.t);
                let tag = isNaN(d) ? d : d + " DÍAS";
                rows += `
                <div class="price-row">
                    <span style="font-weight:700;">✅ ${tag}</span>
                    <span class="p-price">${localPx.toLocaleString()} ${p.c}</span>
                    <button class="buy-btn" onclick="order('${i.n}', '${tag}', '${localPx} ${p.c}')">REALIZAR ORDEN</button>
                </div>`;
            });
            container.innerHTML += `<div class="product-item"><div class="product-header"><i class="fa fa-microchip" style="color:var(--p);"></i><h3>${i.n}</h3></div><div class="price-table">${rows}</div></div>`;
        });
    });
}

function order(name, dur, px) {
    talk("Procesando pedido de " + name + ". Redirigiendo a soporte.");
    const link = `https://wa.me/573001308078?text=🔱 *NUEVA ORDEN ZETA HACKS*%0A💎 PRODUCTO: ${name}%0A⏳ DURACIÓN: ${dur}%0A💰 PRECIO: ${px}`;
    setTimeout(() => { window.open(link, '_blank'); }, 800);
}

function backToMap() {
    document.getElementById('view-store').classList.remove('active');
    document.getElementById('view-countries').classList.add('active');
}

init();
</script>
</body>
</html>
