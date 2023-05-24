<?php
// conectare a base de datos
$conn = new mysqli("localhost", "root", "", "visiomex");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$DIAS =$_POST["dias"]; //esta variable contiene desde que fecha quiere conseguir datos el usuario 

// Obtener la fecha actual
$DateNow = date('Y-m-d');

// Restar 6 días a la fecha actual
$NewDate = date('Y-m-d', strtotime('-'. $DIAS . 'days', strtotime($DateNow)));


    //sentencia que suma la columna de personas CON cubrebocas que se limita por el id de la fecha obtenida por restarle
    //a la fecha actual los dias proporcionados y el id de la ultima fecha en la que se hizo un registro
    $sql ="SELECT SUM(con_cc) as total_suma FROM registro WHERE fecha BETWEEN $NewDate AND $DateNow";
    $resultado_cc = $conn->query($sql);
    $fila = $resultado_cc->fetch_assoc();
    $total_suma_cc = $fila["total_suma"];


    //sentencia que suma la columna de personas SIN cubrebocas
    $sql ="SELECT SUM(con_cc) as total_suma FROM registro WHERE fecha BETWEEN $NewDate AND $DateNow";
    $resultado_sc = $conn->query($sql);
    $fila = $resultado_sc->fetch_assoc();
    $total_suma_sc = $fila["total_suma"];

    //Imprimimos la sumas realizadas
    print("el total de personas que fueron detectadas CON cubrebocas en los ultimo/s" . $DIAS ."dias es de: ". $total_suma_cc."<br>");
    print("el total de personas que fueron detectadas SIN cubrebocas en los ultimo/s" . $DIAS ."dias es de: ". $total_suma_sc."<br>");

    do{
        $sql ="SELECT * FROM registro WHERE id BETWEEN $id_1 AND $id_2";
        $resultado_all = $conn->query($sql);
        if ($resultado_all->num_rows > 0) {
            foreach ($resultado_all as $fila) {
                // Acceder a los valores de cada columna en la fila
                $con_cc = $fila['con_cc'];
                $con_sc = $fila['con_sc'];
                $fecha = $fila['fecha'];
                echo "fecha: ". $fecha . "  personas con cubrebocas: " . $con_cc . ",   personas sin cubrebocas:    " . $con_sc  ."<br>";
            }
            break;
        }
        $id_1++; 
    }while ($resultado_all->num_rows == 0);

?>