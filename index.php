<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Visualizador de Medios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Tema Oscuro Personalizado */
        body {
            background-color: #0d1117; /* Fondo súper oscuro */
            color: #c9d1d9;
            font-family: 'Consolas', 'Courier New', monospace; /* Toque de terminal */
        }

        #contenedor-ajax {
            min-height: 550px;
            background-color: #000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: none !important;
            border-bottom: 2px solid #2ea043; /* Línea de acento verde neón */
        }

        .img-sustituida {
            height: 550px;
            width: 100%;
            object-fit: contain; /* Cambiado a contain para que no recorte la foto */
            display: block;
            opacity: 0.9;
        }

        .btn-admin { 
            position: fixed; 
            top: 20px; 
            right: 20px; 
            z-index: 1000; 
            background-color: #2ea043;
            color: #0d1117;
            border: none;
            font-weight: bold;
        }
        .btn-admin:hover { background-color: #238636; color: white; }

        .card-personalizada {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #30363d;
            box-shadow: 0 0 15px rgba(46, 160, 67, 0.15); 
        }

        .panel-controles {
            background-color: #161b22;
            border-top: 1px solid #30363d;
        }

        .btn-control {
            background-color: transparent;
            color: #2ea043;
            border: 1px solid #2ea043;
            font-weight: bold;
        }
        .btn-control:hover {
            background-color: #2ea043;
            color: #0d1117;
        }
    </style>
</head>
<body>

<a href="admin.php" class="btn btn-admin shadow">> ACCESO ROOT _</a>

<div class="container mt-5">
    <h2 class="text-center mb-4" style="color: #2ea043; letter-spacing: 2px;">[ VISUALIZADOR DE MEDIOS ]</h2>
    
    <div class="card card-personalizada">
        <div id="contenedor-ajax">
            <div class="text-success p-5">Estableciendo conexión con el servidor...</div>
        </div>
        
        <div class="d-flex justify-content-between p-3 panel-controles">
            <button class="btn btn-control px-4" id="btn-prev"><< Volver</button>
            <div class="text-center">
                <span id="contador" class="badge mb-1" style="background-color: #2ea043; color: black;">Cargando...</span>
                <div id="nombre-foto" class="fw-bold d-block" style="color: #8b949e;"></div>
            </div>
            <button class="btn btn-control px-4" id="btn-next">Avanzar >></button>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let imagenes = [];
    let indiceActual = 0;

    function cargarServidor() {
        $.ajax({
            url: 'get_imagenes.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                imagenes = data;
                if(imagenes.length > 0) {
                    actualizarNodo(0);
                } else {
                    $('#contenedor-ajax').html('<div class="text-warning p-5">No hay registros en la base de datos.</div>');
                }
            },
            error: function() {
                $('#contenedor-ajax').html('<div class="text-danger p-5">[ ERROR ] Conexión rechazada por el servidor.</div>');
            }
        });
    }

    function actualizarNodo(index) {
        const foto = imagenes[index];
        $('#contenedor-ajax').empty();
        
        const timestamp = new Date().getTime();
        const nuevaImagen = `
            <img src="${foto.ruta}" 
                 id="img-node-${timestamp}" 
                 class="img-sustituida" 
                 alt="${foto.nombre}">
        `;
        
        $('#contenedor-ajax').append(nuevaImagen);
        
        $('#nombre-foto').text(foto.nombre);
        $('#contador').text(`REGISTRO ${index + 1} // ${imagenes.length}`);
    }

    $('#btn-next').click(function() {
        if(imagenes.length > 0) {
            indiceActual = (indiceActual + 1) % imagenes.length;
            actualizarNodo(indiceActual);
        }
    });

    $('#btn-prev').click(function() {
        if(imagenes.length > 0) {
            indiceActual = (indiceActual - 1 + imagenes.length) % imagenes.length;
            actualizarNodo(indiceActual);
        }
    });

    cargarServidor();
});
</script>

</body>
</html>
