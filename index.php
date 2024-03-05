<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["archivoCSV"])) {
    $archivoTmpPath = $_FILES["archivoCSV"]["tmp_name"];
    $archivo = fopen($archivoTmpPath, "r");
    
    if ($archivo !== FALSE) {
        echo "<table border='1'>";
        // Leer el contenido del CSV
        while (($datos = fgetcsv($archivo, 1000, ",")) !== FALSE) {
            // Convertir cada celda de ISO-8859-1 a UTF-8
            $datos = array_map(function($celda) {
                return mb_convert_encoding($celda, 'UTF-8', 'ISO-8859-1');
            }, $datos);

            echo "<tr>";
            foreach ($datos as $celda) {
                echo "<td>" . htmlspecialchars($celda) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        fclose($archivo);
    } else {
        echo "Error al abrir el archivo.";
    }
} else {
    echo "No se ha subido ningún archivo.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subir y Mostrar CSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
    <h2>Subir Archivo CSV</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        Selecciona el archivo CSV:
        <input type="file" name="archivoCSV" id="archivoCSV">
        <input type="submit" value="Subir Archivo" name="submit">
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
