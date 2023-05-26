<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/navbar.css">
    <link rel="stylesheet" href="/resources/css/MostrarGrafica.css">
    <title>Document</title>

</head>
<body>

<header> 
    <div class="espacio">
        <nav class="navegacion">
            <ul class="menu">
                <p class="logo">Visiomex</p>
                <li><a href="Logout.php" class="owo">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </div>
</header>

<?php
$DATE =$_POST["fecha"];//esta variable contiene la fecha exacta en la que el usaurio quiere conseguir datos

// conectare a base de datos
$conn = new mysqli("localhost", "root", "M33ty-2003", "visiomex");

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