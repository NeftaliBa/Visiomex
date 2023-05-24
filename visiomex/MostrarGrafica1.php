<?php
$DATE =$_POST["fecha"];//esta variable contiene la fecha exacta en la que el usaurio quiere conseguir datos

// conectare a base de datos
$conn = new mysqli("localhost", "root", "", "visiomex");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

    // consulta para comprobar la existencia de esa fecha y sus datos
    $sql = "SELECT * FROM registro WHERE fecha='$DATE'"; 
    $resultado = $conn->query($sql);
    // Verificar si la consulta ha devuelto algún resultado
    if ($resultado->num_rows > 0) {
        foreach ($resultado as $fila) {
            // Acceder a los valores de cada columna en la fila:
            $id = $fila['id'];
            $con_cc = $fila['con_cc'];
            $con_sc = $fila['con_sc'];
            $fecha = $fila['fecha'];
            
            //imprimimos la informacion de la fecha solicitada
            echo "personas con cubrebocas: " . $con_cc . ", personas sin cubrebocas: " . $con_sc . ",fecha:". $fecha ."<br>";
        }
    } else {
        echo "No se encontraron resultados.";
    }


// Cerrar la conexión a la base de datos
$conn->close();
?>