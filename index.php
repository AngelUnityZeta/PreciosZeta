<?php include 'process.php'; $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | SYSTEM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;700&family=Orbitron:wght@900&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #050505; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Fira Code', monospace; overflow: hidden; height: 100vh; }
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 20000; display: flex; align-items: center; justify-content: center; }
        .login-box { width: 85%; max-width: 380px; padding: 40px; background: rgba(10,10,10,0.98); border: 2px solid var(--p); text-align: center; border-radius: 10px; box-shadow: 0 0 20px var(--p); }
        header { position: fixed; top: 0; width: 100%; height: 70px; background: #000; border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: space-between; padding: 0 20px; z-index: 10000; box-sizing: border-box; }
        .neon-text { font-family: 'Orbitron'; color: var(--p); text-shadow: 0 0 10px var(--p); }
        .menu-lateral { position: fixed; left: -100%; top: 0; width: 280px; height: 100%; background: #000; border-right: 2px solid var(--p); transition: 0.4s; z-index: 11000; padding-top: 80px; }
        .menu-lateral.active { left: 0; }
        .menu-lateral a { display: block; padding: 18px 25px; color: #fff; text-decoration: none; border-bottom: 1px solid #111; font-size: 14px; }
        .contenedor { display: none; padding: 90px 15px 80px; height: 100vh; overflow-y: auto; box-sizing: border-box; }
        .contenedor.active { display: block; }
        .tarjeta { background: rgba(15,15,15,0.95); border: 1px solid #333; padding: 15px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid var(--p); }
        input, select { width: 100%; padding: 14px; margin-bottom: 12px; background: #000; border: 1px solid #444; color: var(--p); border-radius: 5px; box-sizing: border-box; font-family: 'Fira Code'; }
        .btn-zeta { width: 100%; padding: 15px; background: var(--p); color: #000; border: none; font-family: 'Orbitron'; font-weight: 900; cursor: pointer; border-radius: 5px; transition: 0.3s; }
        .btn-zeta:active { transform: scale(0.95); background: var(--s); }
        .fila-precio { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dotted #333; font-size: 12px; }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-box">
        <h2 class="neon-text">ZETA HACKS</h2>
        <div id="paso1"><input type="password" id="m_pass" placeholder="CLAVE MAESTRA"><button class="btn-zeta" onclick="siguiente()">SIGUIENTE</button></div>
        <div id="paso2" style="display:none;"><input type="text" id="m_user" placeholder="NOMBRE AGENTE"><button class="btn-zeta" onclick="entrar()">AUTORIZAR</button></div>
    </div>
</div>

<header>
    <div onclick="toggleMenu()" style="color:var(--p); font-size:22px;"><i class="fa fa-bars"></i></div>
    <div class="neon-text" style="font-size:18px;">ZETA HACKS</div>
    <div id="reloj" style="color:var(--s); font-size:12px;">00:00:00</div>
</header>

<nav class="menu-lateral" id="menu">
    <a onclick="ver('inicio')"><i class="fa fa-home"></i> INICIO</a>
    <a onclick="ver('cotizador')"><i class="fa fa-search-dollar"></i> COTIZADOR</a>
    <a onclick="ver('ticket')"><i class="fa fa-ticket-alt"></i> REGISTRAR VENTA</a>
    <a onclick="cargarHistorial()"><i class="fa fa-history"></i> HISTORIAL</a>
    <a href="?salir=1" style="color:#ff4444;"><i class="fa fa-power-off"></i> CERRAR SESIÓN</a>
</nav>

<section id="inicio" class="contenedor active">
    <div style="text-align:center; margin-top:10%;">
        <img src="https://i.imgur.com/your-logo.png" style="width:120px; filter: drop-shadow(0 0 10px var(--p));">
        <h2 class="neon-text">SISTEMA ACTIVO</h2>
        <div class="tarjeta">AGENTE: <?= $_SESSION['agente'] ?? 'SIN NOMBRE' ?></div>
        <div class="tarjeta" style="border-left-color: var(--s);">STATUS: CONECTADO</div>
    </div>
</section>

<section id="cotizador" class="contenedor">
    <select id="pais" onchange="dibujarPrecios()">
        <option value="">Seleccione País</option>
        <option value="BOLIVIA">Bolivia</option>
        <option value="MEXICO">México</option>
        <option value="COLOMBIA">Colombia</option>
        <option value="ARGENTINA">Argentina</option>
        <option value="CHILE">Chile</option>
        <option value="PERU">Perú</option>
        <option value="ECUADOR">Ecuador</option>
        <option value="ESPANA">España</option>
        <option value="USA">USA</option>
        <option value="GUATEMALA">Guatemala</option>
        <option value="HONDURAS">Honduras</option>
        <option value="NICARAGUA">Nicaragua</option>
        <option value="PANAMA">Panamá</option>
        <option value="PARAGUAY">Paraguay</option>
        <option value="DOMINICANA">Rep. Dominicana</option>
        <option value="VENEZUELA">Venezuela</option>
        <option value="BRASIL">Brasil</option>
    </select>
    <div id="lista_precios"></div>
</section>

<section id="ticket" class="contenedor">
    <div class="tarjeta">
        <h3 class="neon-text">REGISTRO DE VENTA</h3>
        <input id="tk_c" placeholder="Nombre del Cliente">
        <input id="tk_p" placeholder="Producto Vendido">
        <input id="tk_m" placeholder="Monto Final">
        <button class="btn-zeta" onclick="generarTicket()">SUBIR A LA NUBE</button>
    </div>
</section>

<section id="historial" class="contenedor">
    <h2 class="neon-text">REGISTROS RECIENTES</h2>
    <div id="lista_historial"></div>
</section>

<script>
const DB_PRECIOS = {
    tasas: {
        "BOLIVIA": {t:12, c:"BS", m:"📌 QR SOPORTE\nTasa: 12.00"},
        "MEXICO": {t:20, c:"MXN", m:"🏦 Albo / Nu OXXO: 5101 2506 8691 9389"},
        "COLOMBIA": {t:4300, c:"COP", m:"🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu: @PMG3555"},
        "ARGENTINA": {t:1500, c:"ARS", m:"📋 Mercado Pago: oscar.hs.m"},
        "CHILE": {t:980, c:"CLP", m:"🏪 Banco Estado: 23.710.151-0"},
        "PERU": {t:3.75, c:"PEN", m:"🟣 Yape/Plin: 954302258"},
        "ECUADOR": {t:1, c:"USD", m:"🟨 Pichincha: 2207195565"},
        "ESPANA": {t:1, c:"EUR", m:"💶 Bizum: 634033557"},
        "USA": {t:1, c:"USD", m:"💎 Zelle: +1 (754) 317-1482"},
        "GUATEMALA": {t:7.8, c:"GTQ", m:"🟩 Banrural: 4431164091"},
        "HONDURAS": {t:24.7, c:"HNL", m:"🔵 Bampais: 216400100524"},
        "NICARAGUA": {t:36, c:"NIO", m:"🏦 BAC: 371674409"},
        "PANAMA": {t:1, c:"USD", m:"🟣 Zinli: chauran2001@gmail.com"},
        "PARAGUAY": {t:7500, c:"PYG", m:"🏦 Itau: 300406285"},
        "DOMINICANA": {t:60, c:"DOP", m:"🟦 Banreservas: 9601546622"},
        "VENEZUELA": {t:40, c:"VED", m:"🟡 Pago Móvil: 0102 32958486 04125805981"},
        "BRASIL": {t:5, c:"BRL", m:"🟢 PIX: 91991076791"}
    },
    productos: [
        {cat:"ANDROID", items:[
            {n:"DRIP MOBILE NORMAL", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"DRIP MOBILE ROOT", d:[1,7,15,30], p:[3,8,12,18]},
            {n:"CUBAN MODS", d:[1,10,20,31], p:[3,9,13,19]},
            {n:"BR MODS + VIRTUAL", d:[1,7,15,30], p:[6,12,19,28]},
            {n:"HG CHEATS", d:[1,10,30], p:[3,12,18]},
            {n:"STRICK BR", d:[1,7,15,30], p:[3,8,12,19]}
        ]},
        {cat:"IOS", items:[
            {n:"CERTIFICADOS GBOX", d:["12 MESES"], p:[18]},
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[22,35,45]},
            {n:"PANEL IOS", d:[7,30], p:[12,19]}
        ]},
        {cat:"PC", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERM"], p:[3,8,16,25]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

// --- VOZ DE IA ---
function hablar(texto) {
    const s = new SpeechSynthesisUtterance(texto);
    s.lang = 'es-ES'; s.rate = 0.9; s.pitch = 0.8;
    window.speechSynthesis.speak(s);
}

function toggleMenu(){ document.getElementById('menu').classList.toggle('active'); }
function ver(id){ 
    document.querySelectorAll('.contenedor').forEach(c=>c.classList.remove('active')); 
    document.getElementById(id).classList.add('active'); 
    if(window.innerWidth < 800) toggleMenu(); 
}

function siguiente(){ hablar("Clave maestra requerida"); document.getElementById('paso1').style.display='none'; document.getElementById('paso2').style.display='block'; }

async function entrar() {
    hablar("Iniciando Protocolo Zeta");
    let bat = "Desconocida";
    try { const b = await navigator.getBattery(); bat = (b.level*100)+"% "+(b.charging?"⚡":"🔋"); } catch(e){}
    const net = navigator.connection ? navigator.connection.effectiveType : "Desconocida";
    
    const fd = new FormData();
    fd.append('accion','login');
    fd.append('p', document.getElementById('m_pass').value);
    fd.append('n', document.getElementById('m_user').value);
    fd.append('bat', bat); fd.append('net', net);

    const r = await fetch('process.php', {method:'POST', body:fd});
    if(await r.text() === 'ok') location.reload(); 
    else { hablar("Acceso denegado"); alert("CLAVE INCORRECTA"); }
}

function dibujarPrecios(){
    const p = document.getElementById('pais').value;
    const l = document.getElementById('lista_precios'); l.innerHTML='';
    if(!p) return;
    const t = DB_PRECIOS.tasas[p];
    hablar("Cargando precios para " + p);
    
    let html = `<div class="tarjeta"><b>🏦 MÉTODOS ${p}:</b><br><pre style="white-space:pre-wrap; font-size:11px;">${t.m}</pre></div>`;
    
    DB_PRECIOS.productos.forEach(cat => {
        html += `<h3 class="neon-text" style="font-size:14px; margin:20px 0 10px;">💎 ${cat.cat}</h3>`;
        cat.items.forEach(it => {
            let card = `<div class="tarjeta" onclick="copiarInfo(this)" style="cursor:pointer;"><b>${it.n}</b><br>`;
            it.d.forEach((dia, i) => {
                let precioLocal = Math.ceil(it.p[i] * t.t);
                card += `<div class="fila-precio"><span>✅ ${dia} ${isNaN(dia)?'':'DÍAS'}</span> <b>${precioLocal} ${t.c}</b></div>`;
            });
            html += card + `</div>`;
        });
    });
    l.innerHTML = html;
}

function copiarInfo(el) {
    const text = el.innerText;
    navigator.clipboard.writeText(text);
    hablar("Información clonada");
    
    const fd = new FormData();
    fd.append('accion', 'reportar_copiado');
    fd.append('info', text);
    fetch('process.php', {method:'POST', body:fd});
    alert("LISTA COPIADA");
}

async function generarTicket() {
    const c = document.getElementById('tk_c').value;
    const p = document.getElementById('tk_p').value;
    const m = document.getElementById('tk_m').value;
    if(!c || !p || !m) return;
    
    const fd = new FormData();
    fd.append('accion', 'registrar_ticket');
    fd.append('c', c); fd.append('p', p); fd.append('m', m);
    await fetch('process.php', {method:'POST', body:fd});
    hablar("Venta registrada con éxito");
    alert("TICKET SUBIDO");
    cargarHistorial();
}

async function cargarHistorial() {
    const fd = new FormData(); fd.append('accion', 'obtener_historial');
    const r = await fetch('process.php', {method:'POST', body:fd});
    const v = await r.json();
    let h = '';
    v.forEach(x => {
        h += `<div class="tarjeta" style="font-size:11px;"><b>${x.fecha}</b> | ${x.agente}<br>📦 ${x.producto}<br>👤 ${x.cliente} | 💰 ${x.monto}</div>`;
    });
    document.getElementById('lista_historial').innerHTML = h || 'HISTORIAL VACÍO';
    ver('historial');
}

setInterval(()=>document.getElementById('reloj').innerText=new Date().toLocaleTimeString(),1000);
</script>
</body>
</html>
    
