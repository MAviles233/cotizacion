<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Antonio Peñaherrera">
    <title>Cotizador de Departamentos</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function mostrarPopup(contenido) {
            var popup = document.createElement('div');
            popup.className = 'popup';
            popup.innerHTML = `
                <div class="popup-content">
                    ${contenido}
                    <button onclick="cerrarPopup()">Cerrar</button>
                </div>`;
            document.body.appendChild(popup);
            popup.style.display = 'block';
        }

        function cerrarPopup() {
            var popup = document.querySelector('.popup');
            if (popup) {
                popup.style.display = 'none';
                document.body.removeChild(popup);
            }
        }
    </script>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1>Cotizador de Departamentos</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="Inicio_Brilesa.html">Inicio</a></li>
                    
                    
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1>Formulario de Cotización</h1>

        

        <?php
        #REALIZADO POR MICHAEL AVILES
        function validar_input($input_name) {
            if (isset($_POST[$input_name]) && !empty(trim($_POST[$input_name]))) {
                return htmlspecialchars(trim($_POST[$input_name]));
            }
            return false;
        }

        
        function calcular_valor_departamento($tipo_departamento, $estilo_cocina) {
            $precios_base = [
                'suite' => 25000,
                'dos_habitaciones' => 50000,
                'tres_habitaciones' => 90000,
            ];
            $valor_cotizacion = $precios_base[$tipo_departamento];
            if ($estilo_cocina === 'isla') {
                $valor_cotizacion += 4000;
            }
            return $valor_cotizacion;
        }

        
        function calcular_valor_alicuota($servicios) {
            $valor_base = 50;
            $incrementos = [
                'coworking' => 30,
                'gimnasio' => 20,
                'spa' => 5,
            ];
            foreach ($servicios as $servicio) {
                if (isset($incrementos[$servicio])) {
                    $valor_base += $incrementos[$servicio];
                }
            }
            return $valor_base;
        }

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = validar_input('nombre');
            $correo = validar_input('correo');
            $tipo_departamento = validar_input('tipo_departamento');
            $estilo_cocina = validar_input('estilo_cocina');
            $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : [];

            
            if ($nombre && $correo && $tipo_departamento && $estilo_cocina) {
                $valor_departamento = calcular_valor_departamento($tipo_departamento, $estilo_cocina);
                $valor_alicuota = calcular_valor_alicuota($servicios);

                
                $mensaje = "<h1>Hola, $nombre</h1>";
                $mensaje .= "<p>Correo: $correo</p>";
                $mensaje .= "<p>Tipo de Departamento: $tipo_departamento</p>";
                $mensaje .= "<p>Estilo de Cocina: $estilo_cocina</p>";
                $mensaje .= "<p>Servicios Adicionales: " . implode(', ', $servicios) . "</p>";
                $mensaje .= "<p>Valor de Cotización del Departamento: $$valor_departamento</p>";
                $mensaje .= "<p>Valor de la Alícuota: $$valor_alicuota</p>";

                echo "<script>
                    window.onload = function() {
                        mostrarPopup(`$mensaje`);
                    };
                </script>";
            } else {
                
                echo "<p>Error: Todos los campos son obligatorios.</p>";
            }
        }
        ?>

        <form id="cotizadorForm" method="post" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="tipo_departamento">Tipo de Departamento:</label>
            <select id="tipo_departamento" name="tipo_departamento" required>
                <option value="">Seleccione una opción</option>
                <option value="suite">Suite</option>
                <option value="dos_habitaciones">Dos Habitaciones</option>
                <option value="tres_habitaciones">Tres Habitaciones</option>
            </select>

            <label for="estilo_cocina">Estilo de Cocina:</label>
            <select id="estilo_cocina" name="estilo_cocina" required>
                <option value="">Seleccione una opción</option>
                <option value="Americana">Americana</option>
                <option value="isla">Isla</option>
            </select>

            <fieldset>
                <legend>Servicios Adicionales:</legend>
                <input type="checkbox" id="coworking" name="servicios[]" value="coworking">
                <label for="coworking">Coworking</label><br>
                <input type="checkbox" id="gimnasio" name="servicios[]" value="gimnasio">
                <label for="gimnasio">Gimnasio</label><br>
                <input type="checkbox" id="spa" name="servicios[]" value="spa">
                <label for="spa">SPA</label> 
            </fieldset>

            <div class="button-group">
                <input type="submit" value="Cotizar">
                <input type="reset" value="Restablecer">
            </div>
        </form>
    </div>

    <footer>
    <nav>
            <a href="contactenos.html">Contactenos</a>
        </nav>
        <div class="data">
            <p><i></i>+593 98 024 5452</p>
            <p><i></i>BrilesaInmobiliaria@gmail.com</p>
            <p><i></i>Avenida 9 de octubre y Pedro Carbo</p>
        </div>
    </footer>
</body>
</html>
