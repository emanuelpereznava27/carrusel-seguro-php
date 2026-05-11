<?php
session_start();
include 'db.php';

// 1. SEGURIDAD: Si no hay sesión iniciada, mandarlo al login
if (!isset($_SESSION['usuario'])) {
    header("Location: auth.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizador de Medios - Pro</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        body { 
            background: #0b0e14; 
            color: #00ff41; 
            font-family: 'Courier New', monospace; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            height: 100vh; 
            margin: 0; 
        }

        /* Botón de acceso a la administración */
        .btn-panel { 
            position: absolute; 
            top: 20px; 
            right: 20px; 
            background: #00ff41; 
            color: black; 
            padding: 10px 15px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold; 
            font-family: sans-serif; 
            transition: 0.3s;
        }
        .btn-panel:hover { background: #00cc33; box-shadow: 0 0 10px #00ff41; }

        /* Contenedor principal del carrusel */
        .container { 
            border: 2px solid #00ff41; 
            padding: 30px; 
            border-radius: 15px; 
            background: #151921; 
            text-align: center; 
            width: 750px; 
            box-shadow: 0 0 25px rgba(0,255,65,0.15); 
        }

        /* REQUERIMIENTO DEL MAESTRO: Ajuste estricto de imagen */
        #viewer { 
            width: 100%;      /* Se ajusta al ancho del contenedor */
            height: 400px;    /* Altura fija para evitar saltos en el diseño */
            object-fit: fill; /* Fuerza a la imagen a llenar el recuadro exacto */
            border: 1px solid #00ff41; 
            border-radius: 8px; 
            margin: 20px 0; 
            display: block;
        }

        #img-nombre { 
            font-weight: bold; 
            font-size: 1.2em;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Controles de navegación */
        .controls { 
            display: flex; 
            justify-content: space-between; 
            gap: 20px;
        }

        button { 
            background: transparent; 
            border: 2px solid #00ff41; 
            color: #00ff41; 
            padding: 12px 25px; 
            cursor: pointer; 
            border-radius: 8px; 
            font-weight: bold; 
            font-family: 'Courier New', monospace;
            transition: 0.2s;
            flex: 1;
        }

        button:hover { 
            background: #00ff41; 
            color: black; 
            box-shadow: 0 0 15px #00ff41;
        }

        .status-bar {
            margin-top: 15px;
            font-size: 0.8em;
            color: #008822;
        }
    </style>
</head>
<body>

    <a href="editar.php" class="btn-panel">> ACCESO ROOT _</a>

    <div class="container">
        <h2>[ VISUALIZADOR DE MEDIOS ]</h2>
        
        <img id="viewer" src="" alt="Cargando sistema...">
        
        <p id="img-nombre">Iniciando protocolo...</p>
        
        <div class="controls">
            <button id="prev"><< VOLVER</button>
            <button id="next">AVANZAR >></button>
        </div>

        <div class="status-bar" id="status">Sincronizado con MariaDB v10.x</div>
    </div>

    <script>
        let currentOffset = 0;

        // Función AJAX para cargar imágenes sin recargar la página
        function loadImg(dir) {
            $("#status").text("Consultando base de datos...");
            
            $.ajax({
                url: 'get_imagenes.php',
                type: 'GET',
                data: { offset: currentOffset, direction: dir },
                dataType: 'json',
                success: function(data) {
                    if(data.success) {
                        currentOffset = data.new_index;
                        
                        // Efecto de transición suave (UX fluido)
                        $("#viewer").fadeOut(150, function() {
                            $(this).attr("src", data.ruta).fadeIn(150);
                        });
                        
                        $("#img-nombre").text(data.nombre);
                        $("#status").text("Datos recibidos: OK");
                    } else {
                        $("#status").text("Error: No se encontraron registros.");
                    }
                },
                error: function() {
                    $("#status").text("Error crítico: Fallo en el puente AJAX.");
                }
            });
        }

        // Eventos de los botones
        $("#next").click(() => loadImg('next'));
        $("#prev").click(() => loadImg('prev'));

        // Cargar la primera imagen al iniciar
        $(document).ready(() => loadImg('next'));
    </script>
</body>
</html>
