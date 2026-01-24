<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | AGENT DATABASE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=Share+Tech+Mono&display=swap');
        
        :root { --p: #00ff41; --s: #00f2ff; --bg: #050505; --card: rgba(20,20,20,0.9); }
        
        body { 
            margin: 0; background: var(--bg); color: #fff; 
            font-family: 'Share Tech Mono', monospace; 
            background-image: radial-gradient(circle at 50% 50%, #00ff410a, transparent);
        }

        /* LOGIN / REGISTER SYSTEM */
        #auth-overlay {
            position: fixed; inset: 0; background: #000; z-index: 10000;
            display: flex; align-items: center; justify-content: center;
        }
        .auth-card {
            background: var(--card); border: 2px solid var(--p); padding: 40px;
            width: 90%; max-width: 400px; border-radius: 15px; text-align: center;
            box-shadow: 0 0 30px rgba(0,255,65,0.2);
        }
        .auth-input {
            background: #000; border: 1px solid #333; color: var(--p);
            width: 100%; padding: 12px; margin: 10px 0; font-family: 'Share Tech Mono';
            border-radius: 5px; text-align: center;
        }
        .auth-btn {
            background: var(--p); color: #000; border: none; width: 100%;
            padding: 15px; font-family: 'Orbitron'; font-weight: 900;
            cursor: pointer; margin-top: 10px; border-radius: 5px;
        }

        /* ADMIN PANEL */
        #admin-panel {
            display: none; background: #111; border: 2px solid var(--s);
            margin: 20px; padding: 20px; border-radius: 10px;
        }
        .user-row {
            display: flex; justify-content: space-between; 
            padding: 10px; border-bottom: 1px solid #222; font-size: 0.9rem;
        }

        /* INTERFAZ GENERAL */
        header { padding: 40px; text-align: center; border-bottom: 1px solid #222; }
        .logo { font-family: 'Orbitron'; font-size: 3rem; letter-spacing: 10px; color: var(--p); }
        .container { max-width: 1200px; margin: auto; padding: 20px; }

        .country-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px; }
        .c-card { background: #111; padding: 25px; border-radius: 10px; text-align: center; cursor: pointer; border: 1px solid #222; }
        .c-card:hover { border-color: var(--p); background: #151515; }

        .p-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; }
        .p-card { background: #0a0a0a; border: 1px solid #222; padding: 25px; border-radius: 15px; border-left: 4px solid var(--p); }
        
        .wa-btn { position: fixed; bottom: 30px; right: 30px; background: #25d366; color: #fff; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; text-decoration: none; }
    </style>
</head>
<body>

<div id="auth-overlay">
    <div class="auth-card" id="login-form">
        <h2 style="font-family:Orbitron; color:var(--p);">SISTEMA ZETA</h2>
        <p id="auth-msg">CREE SU CUENTA DE AGENTE</p>
        <input type="text" id="reg-user" class="auth-input" placeholder="USUARIO">
        <input type="password" id="reg-pass" class="auth-input" placeholder="CONTRASEÑA">
        <button class="auth-btn" onclick="registerUser()">REGISTRAR E INGRESAR</button>
        <p style="margin-top:20px; font-size:0.7rem; color:#444;">ADMIN: INGRESE CON SUS CREDENCIALES</p>
    </div>
</div>

<header>
    <div class="logo">ZETA</div>
    <div id="agent-info" style="color:var(--s); margin-top:10px; font-size:0.8rem;"></div>
</header>

<div class="container">
    <button id="btn-view-admin" onclick="toggleAdmin()" style="display:none; background:var(--s); color:#000; border:none; padding:10px; font-family:Orbitron; cursor:pointer; margin-bottom:20px;">VER BASE DE DATOS DE COMPRADORES</button>

    <div id="admin-panel">
        <h3 style="color:var(--s); font-family:Orbitron;">BASE DE DATOS DE AGENTES</h3>
        <div id="user-list-admin"></div>
    </div>

    <div id="home-view">
        <h2 style="font-family:Orbitron; margin-bottom:20px;">ZONAS DISPONIBLES</h2>
        <div class="country-grid" id="country-grid"></div>
    </div>

    <div id="store-view" style="display:none;">
        <button onclick="location.reload()" style="background:none; border:none; color:#555; cursor:pointer; margin-bottom:20px;">[ VOLVER ]</button>
        <h2 id="region-name" style="color:var(--p); font-family:Orbitron; margin-bottom:30px;"></h2>
        <div id="product-list" class="p-grid"></div>
    </div>
</div>

<a href="https://wa.me/573001308078" class="wa-btn"><i class="fab fa-whatsapp"></i></a>

<script>
// --- BASE DE DATOS SIMULADA ---
let USERS = JSON.parse(localStorage.getItem('zeta_db')) || [];

function registerUser() {
    const u = document.getElementById('reg-user').value;
    const p = document.getElementById('reg-pass').value;

    if(u === "" || p === "") return alert("RELLENE LOS DATOS");

    // Verificar si ya existe
    const exists = USERS.find(user => user.username === u);
    
    if(!exists) {
        USERS.push({username: u, password: p, date: new Date().toLocaleString()});
        localStorage.setItem('zeta_db', JSON.stringify(USERS));
    } else {
        if(exists.password !== p) return alert("CONTRASEÑA INCORRECTA");
    }

    sessionStorage.setItem('current_user', u);
    startApp(u);
}

function startApp(user) {
    document.getElementById('auth-overlay').style.display = 'none';
    document.getElementById('agent-info').innerText = "AGENTE ACTIVO: " + user.toUpperCase();
    
    // Si eres tú (ADMIN), muestra el botón secreto
    if(user.toLowerCase() === 'admin' || user.toLowerCase() === 'zeta') {
        document.getElementById('btn-view-admin').style.display = 'block';
    }
    
    loadCountries();
}

function loadCountries() {
    const countries = ["ARGENTINA", "BOLIVIA", "CHILE", "COLOMBIA", "MEXICO", "PERU", "USA", "ESPAÑA"];
    const grid = document.getElementById('country-grid');
    countries.forEach(c => {
        const d = document.createElement('div');
        d.className = 'c-card';
        d.innerHTML = `<b>${c}</b>`;
        d.onclick = () => showStore(c);
        grid.appendChild(d);
    });
}

function showStore(name) {
    document.getElementById('home-view').style.display = 'none';
    document.getElementById('store-view').style.display = 'block';
    document.getElementById('region-name').innerText = "TIENDA: " + name;

    const list = document.getElementById('product-list');
    const prods = [
        {n:"DRIP MOBILE", p:15},
        {n:"CUBAN PANEL PC", p:25},
        {n:"CERTIFICADO GBOX", p:18}
    ];

    prods.forEach(pr => {
        list.innerHTML += `
        <div class="p-card">
            <h3>${pr.n}</h3>
            <p style="color:var(--p); font-size:1.5rem;">$${pr.p} USD</p>
            <button class="auth-btn" onclick="buy('${pr.n}', '${pr.p}')">ORDENAR</button>
        </div>`;
    });
}

function buy(n, p) {
    const user = sessionStorage.getItem('current_user');
    window.open(`https://wa.me/573001308078?text=🔱 *ZETA ORDER*%0A👤 AGENTE: ${user}%0A💎 PRODUCTO: ${n}%0A💰 PRECIO: ${p} USD`, '_blank');
}

function toggleAdmin() {
    const panel = document.getElementById('admin-panel');
    const list = document.getElementById('user-list-admin');
    panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
    
    list.innerHTML = '';
    USERS.forEach(user => {
        list.innerHTML += `
        <div class="user-row">
            <span style="color:var(--p)">👤 ${user.username}</span>
            <span style="color:#555">🔑 ${user.password}</span>
            <span style="font-size:0.6rem; color:#333">${user.date}</span>
        </div>`;
    });
}

// Auto-login si ya existe sesión
const session = sessionStorage.getItem('current_user');
if(session) startApp(session);
</script>

</body>
</html>
