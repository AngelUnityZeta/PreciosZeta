<?php include 'process.php'; $auth = $_SESSION['zeta_auth'] ?? false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ZETA HACKS | PREMIUM SYSTEM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;700&family=Orbitron:wght@900&display=swap');
        :root { --p: #00ff41; --s: #00f2ff; --bg: #050505; }
        body { margin: 0; background: var(--bg); color: #fff; font-family: 'Fira Code', monospace; height: 100vh; overflow: hidden; }
        header { position: fixed; top: 0; width: 100%; height: 60px; background: #000; border-bottom: 2px solid var(--p); display: flex; align-items: center; justify-content: space-between; padding: 0 20px; z-index: 10000; box-sizing: border-box; }
        .neon-text { font-family: 'Orbitron'; color: var(--p); text-shadow: 0 0 10px var(--p); text-align: center; }
        .contenedor { display: none; padding: 80px 15px 40px; height: 100vh; overflow-y: auto; box-sizing: border-box; }
        .contenedor.active { display: block; }
        .grid-paises { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 20px; }
        .btn-pais { background: rgba(20,20,20,0.9); border: 1px solid var(--p); padding: 15px 5px; border-radius: 8px; text-align: center; cursor: pointer; font-size: 12px; font-weight: bold; }
        .btn-pais:active { background: var(--p); color: #000; }
        .tarjeta { background: rgba(15,15,15,0.95); border: 1px solid #333; padding: 15px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid var(--p); font-size: 13px; }
        .btn-regresar { background: #111; color: var(--p); border: 1px solid var(--p); padding: 12px; border-radius: 5px; margin-bottom: 15px; cursor: pointer; width: 100%; font-family: 'Orbitron'; }
        .fila-precio { display: flex; justify-content: space-between; padding: 5px 0; border-bottom: 1px dotted #333; }
        #bloqueo { position: fixed; inset: 0; background: #000; z-index: 20000; display: flex; align-items: center; justify-content: center; }
        .login-box { width: 85%; max-width: 380px; padding: 40px; background: #0a0a0a; border: 2px solid var(--p); text-align: center; border-radius: 10px; }
        input { width: 100%; padding: 14px; margin-bottom: 12px; background: #000; border: 1px solid #444; color: var(--p); border-radius: 5px; box-sizing: border-box; }
        .btn-zeta { width: 100%; padding: 15px; background: var(--p); color: #000; border: none; font-family: 'Orbitron'; font-weight: 900; border-radius: 5px; }
    </style>
</head>
<body>

<div id="bloqueo" style="display: <?= $auth ? 'none' : 'flex' ?>;">
    <div class="login-box">
        <h2 class="neon-text">ZETA HACKS</h2>
        <div id="paso1"><input type="password" id="m_pass" placeholder="CLAVE MAESTRA"><button class="btn-zeta" onclick="document.getElementById('paso1').style.display='none';document.getElementById('paso2').style.display='block';">SIGUIENTE</button></div>
        <div id="paso2" style="display:none;"><input type="text" id="m_user" placeholder="AGENTE"><button class="btn-zeta" onclick="entrar()">ACCEDER</button></div>
    </div>
</div>

<header>
    <div onclick="ver('inicio')" style="color:var(--p); font-size:22px;"><i class="fa fa-home"></i></div>
    <div class="neon-text" style="font-size: 15px;">ZETA HACKS SYSTEM</div>
    <div onclick="ver('ticket')" style="color:var(--s); font-size:22px;"><i class="fa fa-list"></i></div>
</header>

<section id="inicio" class="contenedor active">
    <h1 class="neon-text" style="font-size: 22px; margin-bottom: 5px;">PRECIOS PARA:</h1>
    <div class="grid-paises">
        <div class="btn-pais" onclick="abrirPais('ARGENTINA')">🇦🇷 ARGENTINA</div>
        <div class="btn-pais" onclick="abrirPais('BOLIVIA')">🇧🇴 BOLIVIA</div>
        <div class="btn-pais" onclick="abrirPais('BRASIL')">🇧🇷 BRASIL</div>
        <div class="btn-pais" onclick="abrirPais('CHILE')">🇨🇱 CHILE</div>
        <div class="btn-pais" onclick="abrirPais('COLOMBIA')">🇨🇴 COLOMBIA</div>
        <div class="btn-pais" onclick="abrirPais('ECUADOR')">🇪🇨 ECUADOR</div>
        <div class="btn-pais" onclick="abrirPais('ESPANA')">🇪🇸 ESPAÑA</div>
        <div class="btn-pais" onclick="abrirPais('USA')">🇺🇸 USA</div>
        <div class="btn-pais" onclick="abrirPais('GUATEMALA')">🇬🇹 GUATEMALA</div>
        <div class="btn-pais" onclick="abrirPais('HONDURAS')">🇭🇳 HONDURAS</div>
        <div class="btn-pais" onclick="abrirPais('MEXICO')">🇲🇽 MÉXICO</div>
        <div class="btn-pais" onclick="abrirPais('NICARAGUA')">🇳🇮 NICARAGUA</div>
        <div class="btn-pais" onclick="abrirPais('PANAMA')">🇵🇦 PANAMÁ</div>
        <div class="btn-pais" onclick="abrirPais('PARAGUAY')">🇵🇾 PARAGUAY</div>
        <div class="btn-pais" onclick="abrirPais('PERU')">🇵🇪 PERÚ</div>
        <div class="btn-pais" onclick="abrirPais('DOMINICANA')">🇩🇴 DOMINICANA</div>
        <div class="btn-pais" onclick="abrirPais('VENEZUELA')">🇻🇪 VENEZUELA</div>
    </div>
</section>

<section id="detalle" class="contenedor">
    <button class="btn-regresar" onclick="ver('inicio')">« VOLVER</button>
    <div id="contenido_pais"></div>
</section>

<section id="ticket" class="contenedor">
    <div class="tarjeta">
        <h3 class="neon-text">REGISTRAR VENTA</h3>
        <input id="tk_c" placeholder="Cliente">
        <input id="tk_p" placeholder="Producto">
        <input id="tk_m" placeholder="Monto">
        <button class="btn-zeta" onclick="generarTicket()">GUARDAR VENTA</button>
    </div>
    <div id="lista_historial"></div>
</section>

<script>
const DB = {
    tasas: {
        "ARGENTINA": {t:1500, c:"ARS", m:"💳 METODOS DE PAGO POR MERCADO PAGO ARGENTINA:\n📋 oscar.hs.m"},
        "BOLIVIA": {t:12, c:"BS", m:"METODO DE PAGO PARA BOLIVIA💳\n📌 Escanee el código QR que le mande el número soporte para realizar el pago.\n💰 Tasa establecida: 12.00"},
        "BRASIL": {t:5.5, c:"BRL", m:"💳 MÉTODOS DE PAGO BRASIL:\n🟢 PIX: 91991076791"},
        "CHILE": {t:980, c:"CLP", m:"💳 MÉTODOS DE PAGO CHILE:\n🏪 Banco Estado (Caja Vecina)\n📋 Titular: XAVIER FUENZALIDA\n📋 RUT: 23.710.151-0\n📋 CuentaRUT: 23710151"},
        "COLOMBIA": {t:4300, c:"COP", m:"💳 MÉTODOS DE PAGO COLOMBIA:\n🟡 Bancolombia: 76900007797\n🔵 Nequi: 3001308078\n🟣 Nu Bank: @PMG3555"},
        "ECUADOR": {t:1, c:"USD", m:"💳 MÉTODOS DE PAGO ECUADOR:\n🟨 Banco Pichincha: 2207195565"},
        "ESPANA": {t:1, c:"EUR", m:"💳 MÉTODOS DE PAGO ESPAÑA:\n💶 Bizum: 634033557\n👤 Nombre: Yanni Hernández"},
        "USA": {t:1, c:"USD", m:"💳 MÉTODOS DE PAGO USA:\n💎 Zelle: +1 (754) 317-1482"},
        "GUATEMALA": {t:7.8, c:"GTQ", m:"💳 MÉTODOS DE PAGO GUATEMALA:\n🟩 Banrural: 4431164091"},
        "HONDURAS": {t:24.7, c:"HNL", m:"💳 MÉTODOS DE PAGO HONDURAS:\n🔵 Bampais: 216400100524"},
        "MEXICO": {t:20, c:"MXN", m:"💳 MÉTODOS DE PAGO MÉXICO (Tasa 20):\n🏦 Albo (Transferencias)\n🏪 Nu México (Depósito OXXO): 5101 2506 8691 9389"},
        "NICARAGUA": {t:36.5, c:"NIO", m:"💳 MÉTODOS DE PAGO NICARAGUA:\n🏦 BAC Nicaragua: 371674409"},
        "PANAMA": {t:1, c:"USD", m:"💳 MÉTODOS DE PAGO PANAMA:\n🟠 Punto Pago Wally: +584128975265\n🟣 Zinli: chauran2001@gmail.com"},
        "PARAGUAY": {t:7600, c:"PYG", m:"💳 MÉTODOS DE PAGO PARAGUAY:\n🏦 Banco Itau: 300406285 (Diego Leiva)\n💳 Billetera Personal: 0993363424"},
        "PERU": {t:3.78, c:"PEN", m:"💳 MÉTODOS DE PAGO PERU:\n🟣 Yape/Plin: 954302258"},
        "DOMINICANA": {t:60, c:"DOP", m:"💳 MÉTODOS DOMINICANA:\n🟦 Banreservas: 9601546622\n🔴 Banco Popular: 837147719"},
        "VENEZUELA": {t:45, c:"VED", m:"💳 MÉTODOS VENEZUELA:\n🟡 Pago Móvil: 0102 32958486 04125805981"}
    },
    productos: [
        {cat:"ANDROID", items:[
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
        {cat:"IOS", items:[
            {n:"CERTIFICADOS GBOX", d:["12 MESES"], p:[18]},
            {n:"FLOURITE + GBOX", d:[1,7,30], p:[22,35,45]},
            {n:"FLOURITE SOLO", d:[1,7,30], p:[4,16,26]},
            {n:"PANEL IOS", d:[7,30], p:[12,19]}
        ]},
        {cat:"PC", items:[
            {n:"CUBAN PANEL PC", d:[1,7,30,"PERM"], p:[3,8,16,25]},
            {n:"BR MODS BYPASS", d:[1,10,30], p:[3,12,20]}
        ]}
    ]
};

function hablar(t){ const s=new SpeechSynthesisUtterance(t); s.lang='es-ES'; s.rate=0.9; window.speechSynthesis.speak(s); }
function ver(id){ document.querySelectorAll('.contenedor').forEach(c=>c.classList.remove('active')); document.getElementById(id).classList.add('active'); }

async function entrar() {
    let b="N/A"; try{ const bat=await navigator.getBattery(); b=(bat.level*100)+"% "+(bat.charging?"⚡":"🔋"); }catch(e){}
    const fd=new FormData(); fd.append('accion','login'); fd.append('p',document.getElementById('m_pass').value); fd.append('n',document.getElementById('m_user').value); fd.append('bat',b);
    const r=await fetch('process.php',{method:'POST',body:fd});
    if(await r.text()==='ok'){ hablar("Bienvenido Comandante"); location.reload(); } else { hablar("Acceso Denegado"); alert("CLAVE INCORRECTA"); }
}

function abrirPais(p){
    hablar("Precios " + p);
    const t=DB.tasas[p];
    let html = `<div class="tarjeta" style="border-left-color:var(--s);" onclick="copiarSimple(this)">${t.m.replace(/\n/g,'<br>')}</div>`;
    DB.productos.forEach(c => {
        html += `<h3 class="neon-text" style="font-size:13px; margin:20px 0 10px;">💎 PRODUCTOS ${c.cat}</h3>`;
        c.items.forEach(it => {
            let copyText = `💎 LISTA DE PRECIOS: ${it.n}\n📍 Región: ${p}\n───────────────────\n`;
            let card = `<div class="tarjeta" onclick="copiarDirecto('${it.n}', '${p}', this)"><b>${it.n}</b><br>`;
            it.d.forEach((dia, i) => {
                let v = Math.ceil(it.p[i] * t.t);
                let etiqueta = (dia === "PERM" || dia === "12 MESES") ? dia : dia + " DÍAS";
                card += `<div class="fila-precio"><span>✅ ${etiqueta}</span> <b>${v} ${t.c}</b></div>`;
                copyText += `✅ ${etiqueta}: ${v} ${t.c}\n`;
            });
            card += `<textarea style="display:none;">${copyText}</textarea></div>`;
            html += card;
        });
    });
    document.getElementById('contenido_pais').innerHTML = html;
    ver('detalle');
}

function copiarDirecto(n, p, el){
    const txt = el.querySelector('textarea').value;
    navigator.clipboard.writeText(txt);
    hablar("Copiado");
    const fd=new FormData(); fd.append('accion','reportar_copiado'); fd.append('info',txt);
    fetch('process.php',{method:'POST',body:fd});
    alert("LISTA COPIADA: " + n);
}

function copiarSimple(el){
    navigator.clipboard.writeText(el.innerText);
    hablar("Datos de pago copiados");
    alert("PAGOS COPIADOS");
}

async function generarTicket(){
    const fd=new FormData(); fd.append('accion','registrar_ticket');
    fd.append('c',document.getElementById('tk_c').value);
    fd.append('p',document.getElementById('tk_p').value);
    fd.append('m',document.getElementById('tk_m').value);
    await fetch('process.php',{method:'POST',body:fd});
    hablar("Registro exitoso");
    alert("VENTA GUARDADA");
    location.reload();
}
</script>
</body>
</html>
