<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | OFFICIAL STORE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Orbitron:wght@700;900&display=swap');
        
        :root { 
            --primary: #00ff41; 
            --accent: #00f2ff; 
            --bg: #0a0a0a; 
            --card: #151515;
            --text: #ffffff;
        }
        
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; margin: 0; padding: 0; }
        body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; line-height: 1.6; }

        /* NAVBAR PROFESIONAL */
        nav {
            background: rgba(0,0,0,0.95);
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            border-bottom: 1px solid #222;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo { font-family: 'Orbitron'; font-size: 1.8rem; font-weight: 900; letter-spacing: 4px; color: var(--primary); }
        .support-link { color: #888; text-decoration: none; font-size: 0.8rem; border: 1px solid #333; padding: 8px 15px; border-radius: 5px; transition: 0.3s; }
        .support-link:hover { border-color: var(--primary); color: var(--primary); }

        /* HERO SECTION */
        .hero {
            padding: 60px 5%;
            background: radial-gradient(circle at top right, #00ff4110, transparent);
            text-align: center;
        }
        .hero h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 15px; }
        .hero p { color: #888; font-size: 1.1rem; max-width: 600px; margin: auto; }

        /* SECCIÓN DE PAÍSES */
        .container { padding: 40px 5%; max-width: 1400px; margin: auto; }
        .section-title { font-family: 'Orbitron'; font-size: 1.2rem; margin-bottom: 30px; color: var(--accent); letter-spacing: 2px; }

        .country-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }
        .country-card {
            background: var(--card);
            padding: 30px 20px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            border: 1px solid #222;
            transition: all 0.3s ease;
        }
        .country-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
            background: #1a1a1a;
            box-shadow: 0 10px 30px rgba(0,255,65,0.1);
        }
        .country-card .flag { font-size: 3rem; display: block; margin-bottom: 15px; }
        .country-card span { font-weight: 600; letter-spacing: 1px; font-size: 0.9rem; }

        /* VISTA DE PRODUCTOS */
        #store-view { display: none; }
        .back-btn { background: none; border: none; color: #666; cursor: pointer; margin-bottom: 30px; font-size: 1rem; }
        .back-btn:hover { color: var(--text); }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }
        .product-card {
            background: var(--card);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #222;
        }
        .product-info { padding: 25px; }
        .product-info h3 { font-family: 'Orbitron'; font-size: 1.1rem; margin-bottom: 20px; color: var(--primary); }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-top: 1px solid #222;
        }
        .price-text { font-weight: 800; font-size: 1.2rem; }
        .duration { color: #888; font-size: 0.9rem; }

        .buy-button {
            background: var(--primary);
            color: #000;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 800;
            font-size: 0.8rem;
            transition: 0.3s;
        }
        .buy-button:hover { transform: scale(1.05); box-shadow: 0 0 15px var(--primary); }

        /* WHATSAPP FLOAT */
        .wa-float {
            position: fixed; bottom: 30px; right: 30px;
            background: #25d366; width: 60px; height: 60px;
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-size: 30px; color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index: 1000;
        }

        @media (max-width: 768px) {
            .product-grid { grid-template-columns: 1fr; }
            .hero h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">ZETA</div>
    <a href="https://wa.me/573001308078" class="support-link">SOPORTE TÉCNICO</a>
</nav>

<div id="home-view">
    <div class="hero">
        <h1>Tienda Oficial Zeta</h1>
        <p>Software de alto rendimiento para usuarios exigentes. Selecciona tu país para ver precios locales y métodos de pago disponibles.</p>
    </div>

    <div class="container">
        <h2 class="section-title">SELECCIONA TU REGIÓN</h2>
        <div class="country-grid" id="country-grid"></div>
    </div>
</div>

<div id="store-view" class="container">
    <button class="back-btn" onclick="showHome()"><i class="fa fa-arrow-left"></i> Volver a regiones</button>
    <h1 id="selected-country" style="margin-bottom: 40px; font-family: 'Orbitron';"></h1>
    
    <div id="product-list"></div>
</div>

<a href="https://wa.me/573001308078" class="wa-float" target="_blank"><i class="fab fa-whatsapp"></i></a>

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
    categorias: [
        {nombre: "SOLUCIONES ANDROID", prods: [
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"STRICK BR", d:[1,7,15,30], p:[3,8,12,19]}
        ]},
        {nombre: "SOLUCIONES IOS", prods: [
            {n:"CERTIFICADOS GBOX (12 MESES)", d:["ACCESO"], p:[18]},
            {n:"PANEL IOS", d:[7,30], p:[12,19]}
        ]},
        {nombre: "SOLUCIONES PC", prods: [
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERMANENTE"], p:[3,8,16,25]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

function init() {
    const grid = document.getElementById('country-grid');
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        const div = document.createElement('div');
        div.className = 'country-card';
        div.onclick = () => showStore(p);
        div.innerHTML = `<span class="flag">${p.b}</span><span>${p.n}</span>`;
        grid.appendChild(div);
    });
}

function showStore(p) {
    document.getElementById('home-view').style.display = 'none';
    document.getElementById('store-view').style.display = 'block';
    document.getElementById('selected-country').innerText = "Catálogo " + p.n;
    window.scrollTo(0,0);

    const list = document.getElementById('product-list');
    list.innerHTML = '';

    DB.categorias.forEach(cat => {
        let html = `<h2 class="section-title" style="margin-top:50px;">${cat.nombre}</h2><div class="product-grid">`;
        cat.prods.forEach(i => {
            let prices = '';
            i.d.forEach((d, idx) => {
                let localVal = Math.ceil(i.p[idx] * p.t);
                let dur = isNaN(d) ? d : d + " DÍAS";
                prices += `
                    <div class="price-row">
                        <div class="duration">${dur}</div>
                        <div class="price-text">${localVal.toLocaleString()} ${p.c}</div>
                        <button class="buy-button" onclick="buy('${i.n}','${dur}','${localVal} ${p.c}')">COMPRAR</button>
                    </div>`;
            });
            html += `<div class="product-card"><div class="product-info"><h3>${i.n}</h3>${prices}</div></div>`;
        });
        html += `</div>`;
        list.innerHTML += html;
    });
}

function buy(prod, dur, price) {
    const msg = `Hola Ángel, deseo comprar:%0A💎 *Producto:* ${prod}%0A⏳ *Duración:* ${dur}%0A💰 *Precio:* ${price}`;
    window.open(`https://wa.me/573001308078?text=${msg}`, '_blank');
}

function showHome() {
    document.getElementById('store-view').style.display = 'none';
    document.getElementById('home-view').style.display = 'block';
}

init();
</script>
</body>
</html>
