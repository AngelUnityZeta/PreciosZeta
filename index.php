<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | PREMIUM TERMINAL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Outfit:wght@300;600;900&display=swap');
        
        :root { --p: #00ff41; --s: #00f2ff; --bg: #010203; --glass: rgba(255, 255, 255, 0.02); }
        
        * { box-sizing: border-box; outline: none; -webkit-tap-highlight-color: transparent; }
        body { 
            margin: 0; background: var(--bg); color: #fff; font-family: 'Outfit', sans-serif;
            background-image: radial-gradient(circle at 50% -20%, #00ff4112, transparent);
            background-attachment: fixed; overflow-x: hidden;
        }

        /* LOGIN OVERLAY */
        #auth-screen {
            position: fixed; inset: 0; background: #000; z-index: 10000;
            display: flex; align-items: center; justify-content: center;
        }
        .auth-card {
            background: var(--glass); padding: 50px 30px; border-radius: 40px;
            border: 1px solid rgba(0,255,65,0.2); backdrop-filter: blur(20px);
            text-align: center; width: 90%; max-width: 420px;
            box-shadow: 0 0 40px rgba(0,255,65,0.1);
        }
        .auth-card h2 { font-family: 'Orbitron'; letter-spacing: 5px; margin-bottom: 30px; }
        
        .t-input {
            background: rgba(0,0,0,0.5); border: 1px solid #222; color: var(--p);
            width: 100%; padding: 18px; margin: 10px 0; border-radius: 12px;
            font-family: 'Orbitron'; text-align: center; font-size: 0.9rem;
        }
        .btn-zeta {
            background: var(--p); color: #000; border: none; width: 100%;
            padding: 18px; border-radius: 12px; font-family: 'Orbitron';
            font-weight: 900; cursor: pointer; transition: 0.4s; margin-top: 20px;
        }
        .btn-zeta:hover { background: #fff; box-shadow: 0 0 25px var(--p); transform: scale(1.02); }

        /* HEADER */
        header { padding: 40px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .logo { font-family: 'Orbitron'; font-size: 3.5rem; letter-spacing: 15px; font-weight: 900; filter: drop-shadow(0 0 10px var(--p)); }

        .container { max-width: 1400px; margin: auto; padding: 50px 20px; }
        
        /* GRID REGIONES */
        .country-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
        .c-card {
            background: var(--glass); border: 1px solid rgba(255,255,255,0.05);
            padding: 40px 20px; border-radius: 30px; text-align: center; cursor: pointer;
            transition: 0.4s;
        }
        .c-card:hover { border-color: var(--s); transform: translateY(-10px); background: rgba(0,242,255,0.03); }
        .c-card span { font-size: 3.5rem; display: block; margin-bottom: 15px; }
        .c-card b { font-family: 'Orbitron'; font-size: 0.75rem; letter-spacing: 2px; }

        /* PRODUCTOS */
        .p-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 30px; }
        .p-card {
            background: linear-gradient(145deg, #0a0a0a, #020202);
            border-radius: 35px; padding: 35px; border: 1px solid rgba(255,255,255,0.05);
        }
        .p-card h3 { font-family: 'Orbitron'; color: var(--p); margin-bottom: 30px; font-size: 1.4rem; }

        .price-row {
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(255,255,255,0.02); padding: 18px 22px; border-radius: 18px;
            margin-bottom: 12px; border: 1px solid transparent;
        }
        .price-row:hover { border-color: var(--p); background: rgba(0,255,65,0.02); }
        .val { font-family: 'Orbitron'; font-weight: 900; color: #fff; font-size: 1.2rem; }

        .buy-btn {
            background: var(--p); color: #000; border: none; padding: 10px 20px;
            border-radius: 10px; font-family: 'Orbitron'; font-weight: 900; font-size: 0.65rem; cursor: pointer;
        }

        .wa-float {
            position: fixed; bottom: 35px; right: 35px; background: #25d366;
            width: 70px; height: 70px; border-radius: 22px; display: flex;
            align-items: center; justify-content: center; font-size: 35px; color: #fff;
            box-shadow: 0 15px 30px rgba(0,0,0,0.5); z-index: 1000;
        }
    </style>
</head>
<body>

<div id="auth-screen">
    <div class="auth-card">
        <h2>ZETA ACCESS</h2>
        <input type="text" id="user" class="t-input" placeholder="USERNAME">
        <input type="password" id="pass" class="t-input" placeholder="PASSWORD">
        <button class="btn-zeta" onclick="sendAuth()">AUTHORIZE ACCESS</button>
    </div>
</div>

<header>
    <div class="logo">ZETA</div>
</header>

<div class="container" id="main-ui" style="display:none;">
    <div id="home-view">
        <h2 style="font-family:Orbitron; font-size:0.8rem; color:#444; margin-bottom:35px; letter-spacing:4px;">01. SELECT REGION</h2>
        <div class="country-grid" id="c-grid"></div>
    </div>

    <div id="store-view" style="display:none;">
        <button onclick="location.reload()" style="background:none; border:none; color:#555; cursor:pointer; margin-bottom:30px; font-family:Orbitron;">[ BACK_TO_MENU ]</button>
        <h1 id="country-name" style="font-family:Orbitron; font-size:3rem; color:var(--p); margin-bottom:50px;"></h1>
        <div id="p-list" class="p-grid"></div>
    </div>
</div>

<a href="https://wa.me/573001308078" class="wa-float" target="_blank"><i class="fab fa-whatsapp"></i></a>

<script>
async function sendAuth() {
    const user = document.getElementById('user').value;
    const pass = document.getElementById('pass').value;
    if(!user || !pass) return;

    await fetch('config.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ tipo: 'REGISTRO', user: user, pass: pass })
    });

    localStorage.setItem('zeta_ag', user);
    document.getElementById('auth-screen').style.display = 'none';
    document.getElementById('main-ui').style.display = 'block';
    renderHome();
}

const DB = {
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

function renderHome() {
    const grid = document.getElementById('c-grid');
    DB.paises.sort((a,b)=>a.n.localeCompare(b.n)).forEach(p => {
        const d = document.createElement('div');
        d.className = 'c-card';
        d.onclick = () => showStore(p);
        d.innerHTML = `<span>${p.b}</span><b>${p.n}</b>`;
        grid.appendChild(d);
    });
}

function showStore(p) {
    document.getElementById('home-view').style.display = 'none';
    document.getElementById('store-view').style.display = 'block';
    document.getElementById('country-name').innerText = p.n;
    window.scrollTo(0,0);

    const list = document.getElementById('p-list'); list.innerHTML = '';
    DB.items.forEach(i => {
        let rs = '';
        i.d.forEach((d, idx) => {
            let v = Math.ceil(i.p[idx] * p.t);
            let t = isNaN(d) ? d : d + " DÍAS";
            rs += `<div class="price-row"><div><b style="color:var(--s)">${t}</b></div><div class="val">${v.toLocaleString()} ${p.c}</div><button class="buy-btn" onclick="buy('${i.n}','${t}','${v} ${p.c}')">ADQUIRIR</button></div>`;
        });
        list.innerHTML += `<div class="p-card"><h3>${i.n}</h3>${rs}</div>`;
    });
}

async function buy(n, d, p) {
    const user = localStorage.getItem('zeta_ag');
    await fetch('config.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ tipo: 'COMPRA', user: user, producto: n, precio: p })
    });
    window.open(`https://wa.me/573001308078?text=🔱 *ZETA ORDER*%0A👤 Agente: ${user}%0A💎 Software: ${n}%0A⏳ Plan: ${d}%0A💰 Precio: ${p}`, '_blank');
}

if(localStorage.getItem('zeta_ag')) {
    document.getElementById('auth-screen').style.display = 'none';
    document.getElementById('main-ui').style.display = 'block';
    renderHome();
}
</script>
</body>
</html>
