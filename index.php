<!DOCTYPE html>
<html>
<head>
    <title>Subir y Mostrar CSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./stylos.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center fondo">
        <div class="row noprint">
            <h2>Subir Archivo CSV</h2>
            <form action="index.php" method="post" enctype="multipart/form-data">
                Selecciona el archivo CSV:
                <input type="file" name="archivoCSV" id="archivoCSV">
                <input type="submit" value="Subir Archivo" name="submit">
            </form>
        </div>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["archivoCSV"])) {
                $archivoTmpPath = $_FILES["archivoCSV"]["tmp_name"];
                $archivo = fopen($archivoTmpPath, "r");
                
                if ($archivo !== FALSE) {
                    // Portada
                    echo "<div class='row hoja' >";
                    echo "<div class='col-12'><img src='./imagenes/PORTADA-PLANTILLA.png' width= '100%';></img></div>";
                    echo "</div>";
                    // Leer el contenido del CSV
                    $contArticulos = 0;
                    $encabezado = "";
                    while (($datos = fgetcsv($archivo, 1000, ",")) !== FALSE) {
                        // Convertir cada celda de ISO-8859-1 a UTF-8
                        $datos = array_map(function($celda) {
                            return mb_convert_encoding($celda, 'UTF-8', 'ISO-8859-1');
                        }, $datos);
                        //
                        if($contArticulos==0){
                            $cont = 0;
                            foreach ($datos as $celda) {
                                $cont++;
                                if($cont != 2 && $cont != 3 ){
                                    $encabezado = $encabezado."<th style='font-size: .4rem!important;padding: 0;'>". htmlspecialchars($celda) . "</th>";
                                }
                            }
                            // --- Primer Hoja ---
                            echo "<div class='row hoja' >";
                            echo "<div class='col-12'><img src='./imagenes/pleca-top.png' width= '100%';></img></div>";
                        }else{
                            echo "<div class='col-4 '>";
                            //IMAGEN
                            echo "<img src='./imagenes/".$datos[0].".png' height='100rem' max-width='auto' alt='...'>"; 
                            // Nombre
                            echo "<p style='font-size: .5rem!important;padding: 0; margin: 0;'>$datos[1]</p>";
                            //TABLA
                            echo "<table class='table table-sm'>";
                            echo "<thead class='table-dark'><tr>".$encabezado."</tr></thead>";
                            echo "<tr>";
                            $cont = 0;
                            foreach ($datos as $celda) {
                                $cont++;
                                if($cont != 2 && $cont != 3 ){
                                    echo "<td style='font-size: .4rem!important;padding: 0;'>". htmlspecialchars($celda) . "</td>";
                                }
                            }
                            echo "</tr></table>";
                            echo "</div>";
                            // --- Nueva Hoja ---
                            if($contArticulos %9 == 0){
                                echo "<div class='col-12'><img src='./imagenes/pleca-bot.png' width= '100%';></img></div></div>";
                                echo " <div class='row hoja saltopagina'>";
                                echo "<div class='col-12'><img src='./imagenes/pleca-top.png' width= '100%';></img></div>";
                            }
                        }
                        //
                        $contArticulos ++;
                    }
                    echo "<div class='col-12'><img src='./imagenes/pleca-bot.png' width= '100%';></img></div></div>";
                    // Portada
                    echo "<div class='row hoja' >";
                    echo "<div class='col-12'><img src='./imagenes/CONTRAPORTADA.png' width= '100%';></img></div>";
                    echo "</div>";
                    //container
                    echo "</div>";
                    fclose($archivo);
                } else {
                    echo "Error al abrir el archivo.";
                }
            } else {
                echo "No se ha subido ningún archivo.";
            }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</body>
</html>
