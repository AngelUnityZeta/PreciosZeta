<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ANGEL PRÍVATE | OFFICIAL STORE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700&display=swap');
        
        :root { --p: #00ff41; --s: #00f2ff; --bg: #030303; --card: rgba(15, 15, 15, 0.95); }
        
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; outline: none; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Rajdhani', sans-serif; overflow-x: hidden; }

        /* PANTALLA DE CARGA TÁCTICA */
        #loader {
            position: fixed; inset: 0; background: #000; z-index: 10000;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .scanner {
            width: 250px; height: 2px; background: var(--p);
            box-shadow: 0 0 20px var(--p); animation: scan 2s infinite;
        }
        @keyframes scan { 0% { transform: translateY(-50px); opacity: 0; } 50% { opacity: 1; } 100% { transform: translateY(50px); opacity: 0; } }

        /* HEADER & BRANDING */
        header {
            padding: 80px 20px 40px; text-align: center;
            background: radial-gradient(circle at top, #0a1f0a 0%, transparent 70%);
        }
        .main-title { font-family: 'Orbitron'; font-size: 3.5rem; font-weight: 900; margin: 0; letter-spacing: 15px; text-shadow: 0 0 30px var(--p); }
        .sub-title { font-family: 'Orbitron'; color: var(--s); letter-spacing: 5px; font-size: 0.9rem; margin-top: 10px; opacity: 0.8; }

        /* GRID DE PAÍSES ESTILO APP */
        .container { max-width: 1100px; margin: auto; padding: 20px; }
        .country-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 20px; margin-top: 30px;
        }
        .c-card {
            background: var(--card); border: 1px solid #222; border-radius: 15px;
            padding: 25px; cursor: pointer; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex; flex-direction: column; align-items: center; position: relative; overflow: hidden;
        }
        .c-card::before { content: ""; position: absolute; inset: 0; background: linear-gradient(45deg, transparent, rgba(0,255,65,0.05)); }
        .c-card:hover { border-color: var(--p); transform: translateY(-10px); box-shadow: 0 10px 40px rgba(0,255,65,0.15); }
        .c-card span { font-size: 3rem; margin-bottom: 15px; filter: drop-shadow(0 0 10px rgba(0,0,0,0.5)); }
        .c-card b { font-family: 'Orbitron'; font-size: 0.75rem; color: #aaa; letter-spacing: 2px; }

        /* VISTA DE PRODUCTOS ELITE */
        #store-view { display: none; animation: fadeIn 0.8s forwards; }
        .cat-header {
            font-family: 'Orbitron'; color: var(--p); font-size: 1.4rem;
            margin: 50px 0 20px; border-left: 5px solid var(--p); padding-left: 20px;
            text-transform: uppercase; letter-spacing: 3px;
        }
        .prod-card {
            background: #0a0a0a; border: 1px solid #1a1a1a; border-radius: 20px;
            padding: 30px; margin-bottom: 30px; position: relative;
        }
        .prod-card h3 { font-family: 'Orbitron'; margin: 0 0 20px; font-size: 1.2rem; border-bottom: 1px solid #222; padding-bottom: 15px; color: var(--s); }
        
        .price-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 0; border-bottom: 1px solid #111;
        }
        .p-val { color: var(--p); font-family: 'Orbitron'; font-weight: 700; font-size: 1.2rem; }

        .btn-order {
            background: var(--p); color: #000; font-weight: 900; border: none;
            padding: 10px 20px; border-radius: 8px; font-family: 'Orbitron';
            font-size: 0.7rem; cursor: pointer; transition: 0.3s;
        }
        .btn-order:hover { background: #fff; transform: scale(1.1); box-shadow: 0 0 20px #fff; }

        /* BOTÓN FLOTANTE SOPORTE */
        .sup-float {
            position: fixed; bottom: 30px; right: 30px; background: #25d366;
            width: 65px; height: 65px; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; font-size: 30px;
            box-shadow: 0 0 30px rgba(37,211,102,0.4); z-index: 5000;
        }

        @keyframes fadeIn { from { opacity: 0; filter: blur(10px); } to { opacity: 1; filter: blur(0); } }
    </style>
</head>
<body>

<div id="loader">
    <div class="main-title" style="font-size: 2rem;">ZETA</div>
    <div class="scanner"></div>
    <p style="font-family: Orbitron; font-size: 0.6rem; margin-top: 20px; color: #444;">INICIALIZANDO PROTOCOLOS DE VENTA...</p>
</div>

<header id="h-main">
    <div class="main-title">ÁNGEL ROJAS</div>
    <div class="sub-title">SISTEMAS DE PRODUCTOS PARA FREE FIRE</div>
</header>

<div id="country-view" class="container">
    <div style="text-align: center; color: #555; font-size: 0.8rem; letter-spacing: 4px; margin-bottom: 20px;">SELECCIONE REGIÓN DE OPERACIÓN</div>
    <div class="country-grid" id="cg"></div>
</div>

<div id="store-view" class="container">
    <button onclick="goBack()" style="background:transparent; border:1px solid #333; color:#777; padding:10px 25px; border-radius:5px; cursor:pointer; font-family:Orbitron; font-size:0.6rem;">&lt; VOLVER AL MAPA</button>
    <div id="region-title" style="font-family:Orbitron; font-size:2rem; color:var(--p); margin-top:20px; text-shadow: 0 0 15px var(--p);"></div>
    <div id="pl"></div>
</div>

<a href="https://wa.me/573001308078" class="sup-float" target="_blank"><i class="fab fa-whatsapp"></i></a>

<script>
const DB = {
    paises: [
        {n:"ARGENTINA", b:"🇦🇷", t:1500, c:"ARS"}, {n:"BOLIVIA", b:"🇧🇴", t:13, c:"BS"},
        {n:"BRASIL", b:"🇧🇷", t:5.2, c:"BRL"}, {n:"CHILE", b:"🇨🇱", t:970, c:"CLP"},
        {n:"COLOMBIA", b:"🇨🇴", t:3800, c:"COP"}, {n:"ECUADOR", b:"🇪🇨", t:1, c:"USD"},
        {n:"ESPAÑA", b:"🇪🇸", t:1, c:"EUR"}, {n:"USA", b:"🇺🇸", t:1, c:"USD"},
        {n:"GUATEMALA", b:"🇬🇹", t:7.8, c:"GTQ"}, {n:"HONDURAS", b:"🇭🇳", t:25, c:"HNL"},
        {n:"MÉXICO", b:"🇲🇽", t:20, c:"MXN"}, {n:"NICARAGUA", b:"🇳🇮", t:37, c:"NIO"},
        {n:"PANAMÁ", b:"🇵🇦", t:1, c:"USD"}, {n:"PARAGUAY", b:"🇵🇾", t:7500, c:"PYG"},
        {n:"PERÚ", b:"🇵🇪", t:3.55, c:"PEN"}, {n:"DOMINICANA", b:"🇩🇴", t:70, c:"DOP"},
        {n:"VENEZUELA", b:"🇻🇪", t:550, c:"VES"}
    ],
    prods: [
        {cat:"PRODUCTOS ANDROID", items:[
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"HG CHEATS", d:[1,10,30], p:[3,12,19]},
            {n:"HG CHEATS + VIRTUAL", d:[1,10,30], p:[5,16,28]},
            {n:"STRICK BR", d:[1,7,15,30], p:[3,8,12,19]},
            {n:"STRICK BR + VIRTUAL", d:[1,7,15,30], p:[6,12,16,25]}
        ]},
        {cat:"PRODUCTOS IOS", items:[
            {n:"CERTIFICADOS GBOX", d:["12 MESES"], p:[20]},
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[25,35,48]},
            {n:"FLOURITE SOLO", d:[1,7,30], p:[5,16,26]},
            {n:"PANEL IOS", d:[7,30], p:[12,19]}
        ]},
        {cat:"PRODUCTOS PC", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERMANENTE"], p:[3,8,16,25]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

setTimeout(() => { document.getElementById('loader').style.display='none'; }, 2000);

function track(d) {
    const fd = new FormData(); fd.append('accion', 'track_client'); fd.append('data', d);
    fetch('process.php', {method:'POST', body:fd});
}

function init() {
    const g = document.getElementById('cg');
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        const div = document.createElement('div'); div.className = 'c-card';
        div.onclick = () => renderStore(p);
        div.innerHTML = `<span>${p.b}</span><b>${p.n}</b>`;
        g.appendChild(div);
    });
}

function renderStore(p) {
    track("VIENDO: " + p.n);
    document.getElementById('h-main').style.display = 'none';
    document.getElementById('country-view').style.display = 'none';
    document.getElementById('store-view').style.display = 'block';
    document.getElementById('region-title').innerText = p.n;
    window.scrollTo(0,0);

    const l = document.getElementById('pl'); l.innerHTML = '';
    DB.prods.forEach(cat => {
        l.innerHTML += `<div class="cat-header">🔱 ${cat.cat}</div>`;
        cat.items.forEach(i => {
            let rs = '';
            i.d.forEach((d, idx) => {
                let v = Math.ceil(i.p[idx] * p.t);
                let t = isNaN(d) ? d : d + " DÍAS";
                rs += `<div class="price-item"><span>✅ ${t}</span><div class="p-val">${v.toLocaleString()} ${p.c}</div><button class="btn-order" onclick="buy('${i.n}','${t}','${v} ${p.c}')">ORDENAR</button></div>`;
            });
            l.innerHTML += `<div class="prod-card"><h3>${i.n}</h3>${rs}</div>`;
        });
    });
}

function buy(pr, du, pc) {
    track("CLICK COMPRA: " + pr);
    const m = `Hola ZETA HACKS, deseo adquirir:%0A💎 SOFTWARE: ${pr}%0A⏳ TIEMPO: ${du}%0A💰 COSTO: ${pc}`;
    window.open(`https://wa.me/573001308078?text=${m}`, '_blank');
}

function goBack() {
    document.getElementById('h-main').style.display = 'block';
    document.getElementById('store-view').style.display = 'none';
    document.getElementById('country-view').style.display = 'block';
}

init();
</script>
</body>
</html>
