<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | OFFICIAL STORE V12</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Share+Tech+Mono&display=swap');
        
        :root { --p: #00ff41; --s: #00f2ff; --bg: #000; --glass: rgba(255, 255, 255, 0.03); }
        
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body { 
            margin: 0; background: var(--bg); color: #fff; 
            font-family: 'Share Tech Mono', monospace; overflow-x: hidden;
            user-select: none;
        }

        /* FONDO MATRIX DINÁMICO */
        .bg-glow {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at 50% 50%, #0a1a0a 0%, #000 100%);
            z-index: -1;
        }

        /* HEADER ELITE */
        header {
            position: fixed; top: 0; width: 100%; height: 75px;
            background: rgba(0,0,0,0.9); backdrop-filter: blur(15px);
            display: flex; align-items: center; justify-content: center;
            border-bottom: 2px solid var(--p); z-index: 1000;
            box-shadow: 0 0 20px rgba(0,255,65,0.3);
        }
        .logo-text { font-family: 'Orbitron'; font-weight: 900; font-size: 1.8rem; letter-spacing: 5px; }

        /* VISTA PRINCIPAL (PAÍSES) */
        .hero { padding: 110px 20px 40px; text-align: center; }
        .hero h1 { font-family: 'Orbitron'; font-size: 1.5rem; margin-bottom: 5px; color: var(--p); text-shadow: 0 0 10px var(--p); }
        
        .grid-countries {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 12px; padding: 20px; max-width: 1000px; margin: auto;
        }
        .country-card {
            background: var(--glass); border: 1px solid #222;
            padding: 15px; border-radius: 12px; cursor: pointer; transition: 0.3s;
            display: flex; flex-direction: column; align-items: center;
        }
        .country-card:hover { border-color: var(--p); transform: scale(1.05); background: rgba(0,255,65,0.05); }
        .country-card span { font-size: 2.2rem; margin-bottom: 8px; }
        .country-card b { font-size: 0.8rem; letter-spacing: 1px; }

        /* VISTA TIENDA */
        #store-view { display: none; padding: 100px 15px 40px; max-width: 800px; margin: auto; }
        .back-btn { background: #111; border: 1px solid var(--s); color: var(--s); padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-bottom: 25px; font-family: 'Orbitron'; font-size: 0.7rem; }

        .category-title {
            font-family: 'Orbitron'; font-size: 1.1rem; color: var(--p);
            margin: 40px 0 20px; border-left: 5px solid var(--p); padding-left: 15px;
            background: rgba(0,255,65,0.05); padding-top: 5px; padding-bottom: 5px;
        }

        .product-card {
            background: #050505; border: 1px solid #151515; border-radius: 15px; padding: 20px;
            margin-bottom: 25px; border-top: 4px solid var(--s); box-shadow: 0 10px 30px rgba(0,0,0,0.8);
        }
        .product-card h3 { font-family: 'Orbitron'; color: #fff; margin-top: 0; font-size: 1rem; border-bottom: 1px solid #222; padding-bottom: 10px; }

        .price-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 0; border-bottom: 1px solid #111;
        }
        .price-tag { color: var(--p); font-weight: 900; font-size: 1.1rem; }

        .btn-buy {
            background: var(--p); color: #000; font-weight: 900;
            padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer;
            font-family: 'Orbitron'; font-size: 0.7rem; transition: 0.3s;
        }
        .btn-buy:hover { background: #fff; box-shadow: 0 0 15px #fff; }

        /* ANIMACIÓN */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeInUp 0.5s ease-out; }

        .mantenimiento { background: rgba(255,0,0,0.1); border: 1px dashed #f00; color: #ff4444; padding: 15px; text-align: center; border-radius: 10px; font-size: 0.8rem; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="bg-glow"></div>

<header>
    <div class="logo-text">ZETA<span style="color:var(--p);">STORE</span></div>
</header>

<div id="country-view" class="hero fade-in">
    <h1>SISTEMA DE VENTAS OFICIAL</h1>
    <p style="color: #444; margin-bottom: 40px;">[ SELECCIONE SU REGIÓN PARA CONTINUAR ]</p>
    <div class="grid-countries" id="country-grid"></div>
</div>

<div id="store-view">
    <button class="back-btn" onclick="goHome()"><i class="fa fa-arrow-left"></i> REGRESAR</button>
    <div id="region-tag" style="font-family:'Orbitron'; color:var(--s); margin-bottom:20px; text-align:center; font-size:1.2rem;"></div>
    
    <div class="mantenimiento">⚠️ MÉTODOS DE PAGO EN ACTUALIZACIÓN - PAGO MANUAL VÍA WHATSAPP</div>
    
    <div id="product-list"></div>
</div>

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
        {cat:"PRODUCTOS PARA ANDROID", items:[
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
        {cat:"PRODUCTOS PARA IOS", items:[
            {n:"CERTIFICADOS GBOX", d:["12 MESES"], p:[18]},
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[22,35,45]},
            {n:"FLOURITE SOLO", d:[1,7,30], p:[4,16,26]},
            {n:"PANEL IOS", d:[7,30], p:[12,19]}
        ]},
        {cat:"PRODUCTOS PARA PC", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERMANENTE"], p:[3,8,16,25]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

function track(info) {
    const fd = new FormData(); fd.append('accion', 'track_client'); fd.append('data', info);
    fetch('process.php', {method: 'POST', body: fd});
}

function renderCountries() {
    const grid = document.getElementById('country-grid');
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        const div = document.createElement('div');
        div.className = 'country-card';
        div.onclick = () => showStore(p);
        div.innerHTML = `<span>${p.b}</span><b>${p.n}</b>`;
        grid.appendChild(div);
    });
}

function showStore(p) {
    track("Cliente consultó región: " + p.n);
    document.getElementById('country-view').style.display = 'none';
    document.getElementById('store-view').style.display = 'block';
    document.getElementById('region-tag').innerText = "📍 " + p.n;
    window.scrollTo(0,0);

    const list = document.getElementById('product-list');
    list.innerHTML = '';

    DB.prods.forEach(cat => {
        list.innerHTML += `<div class="category-title">🔱 ${cat.cat}</div>`;
        cat.items.forEach(i => {
            let pricesRows = '';
            i.d.forEach((d, idx) => {
                let localVal = Math.ceil(i.p[idx] * p.t);
                let tag = isNaN(d) ? d : d + " DÍAS";
                pricesRows += `
                    <div class="price-row">
                        <span>✅ ${tag}</span>
                        <div class="price-tag">${localVal.toLocaleString()} ${p.c}</div>
                        <button class="btn-buy" onclick="buy('${i.n}', '${tag}', '${localVal} ${p.c}')">COMPRAR</button>
                    </div>`;
            });
            list.innerHTML += `<div class="product-card fade-in"><h3>${i.n}</h3>${pricesRows}</div>`;
        });
    });
}

function buy(prod, dur, price) {
    track("BOTÓN COMPRA: " + prod + " | " + price);
    const msg = `Hola ZETA HACKS, quiero comprar:%0A💎 PRODUCTO: ${prod}%0A⏳ DURACIÓN: ${dur}%0A💰 PRECIO: ${price}`;
    window.open(`https://wa.me/573001308078?text=${msg}`, '_blank');
}

function goHome() {
    document.getElementById('store-view').style.display = 'none';
    document.getElementById('country-view').style.display = 'block';
}

renderCountries();
</script>
</body>
</html>
