<?php
// Conectarse a la base de datos
$conn = new mysqli("localhost", "root", "", "visiomex");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$DIAS = $_POST["dias"]; // Esta variable contiene desde qué fecha quiere conseguir datos el usuario

// Obtener la fecha actual
$DateNow = date('Y-m-d');

// Restar los días especificados a la fecha actual
$NewDate = date('Y-m-d', strtotime('-' . $DIAS . ' days', strtotime($DateNow)));

// Obtener la fecha más reciente de la tabla registro
$sql = "SELECT fecha FROM registro ORDER BY fecha DESC LIMIT 1";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $Date = $fila['fecha']; // Guardamos en una variable la fecha más reciente
} else {
    echo "No se encontraron resultados.";
}

do {
    $sql = "SELECT * FROM registro WHERE fecha = '$NewDate'";
    $resultado_all = $conn->query($sql);
    
    if ($resultado_all->num_rows > 0) {
        break;
    }
    
    $NewDate = date('Y-m-d', strtotime($NewDate . '+1 days'));
} while ($resultado_all->num_rows == 0);

// Sentencia para sumar la columna de personas CON cubrebocas limitada por la fecha más reciente y la fecha obtenida por restarle los días proporcionados
$sql = "SELECT SUM(con_cc) as total_suma_cc FROM registro WHERE fecha BETWEEN '$NewDate' AND '$Date'";
$resultado_cc = $conn->query($sql);
$fila_cc = $resultado_cc->fetch_assoc();
$total_suma_cc = $fila_cc["total_suma_cc"];

// Sentencia para sumar la columna de personas SIN cubrebocas limitada por la fecha más reciente y la fecha obtenida por restarle los días proporcionados
$sql = "SELECT SUM(con_sc) as total_suma_sc FROM registro WHERE fecha BETWEEN '$NewDate' AND '$Date'";
$resultado_sc = $conn->query($sql);
$fila_sc = $resultado_sc->fetch_assoc();
$total_suma_sc = $fila_sc["total_suma_sc"];

// Imprimir las sumas realizadas
echo "El total de personas detectadas CON cubrebocas en los últimos " . $DIAS . " días es de: " . $total_suma_cc . "<br>";
echo "El total de personas detectadas SIN cubrebocas en los últimos " . $DIAS . " días es de: " . $total_suma_sc . "<br><br>";

$sql = "SELECT * FROM registro WHERE fecha BETWEEN '$NewDate' AND '$Date'";
$resultado_all = $conn->query($sql);

if ($resultado_all->num_rows > 0) {
    foreach ($resultado_all as $fila) {
        // Acceder a los valores de cada columna en la fila
        $con_cc = $fila['con_cc'];
        $con_sc = $fila['con_sc'];
        $fecha = $fila['fecha'];
        echo "Fecha: " . $fecha . " - Personas con cubrebocas: " . $con_cc . ", Personas sin cubrebocas: " . $con_sc . "<br>";
    }
}

$conn->close();
?>
