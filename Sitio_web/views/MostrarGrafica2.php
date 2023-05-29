<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/css/navbar.css">
    <link rel="stylesheet" href="../resources/css/MostrarGrafica2.css">
    <link rel="icon" type="image/x-icon" href="/resources/img/icon.png">
    <title>Data</title>
</head>
<body>

<header> 
      <div class="espacio">
          <nav class="navegacion">
              <ul class="menu">
                  <p class="logo">Visiomex</p>
                  <li><a href="Form_Fechas.php">Regresar</a></li>
                  <li><a href="Logout.php" class="owo">Cerrar Sesion</a></li>
              </ul>
          </nav>
      </div>
</header>

<?php
// Conectarse a la base de datos
$conn = new mysqli("localhost", "root", "M33ty-2003", "visiomex");

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

$personas = $total_suma_sc + $total_suma_cc;
$porc_conc = ($total_suma_cc * 100)/$personas;
$porc_sinc = ($total_suma_sc *100)/$personas;


switch($DIAS){
    case 1:
        ?> <h2 class="titulo">Ayer</h2> <?php
        break;
    case 6:
        ?> <h2 class="titulo">Los ultimos 7 dias</h2> <?php
        break;
    case 29:
        ?> <h2 class="titulo">El ultimo mes</h2> <?php
        break;
    default:
        ?> <h2 class="titulo">Este año</h2> <?php

}

?>

<head>
       <!--Load the AJAX API-->
       <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
       <script type="text/javascript">
        
         // Load the Visualization API and the corechart package.
         google.charts.load('current', {'packages':['corechart']});
        
         // Set a callback to run when the Google Visualization API is loaded.
         google.charts.setOnLoadCallback(drawChart);
        
         // Callback that creates and populates a data table,
         // instantiates the pie chart, passes in the data and
         // draws it.
         function drawChart() {
        
           // Create the data table.
           var data = new google.visualization.DataTable();
           data.addColumn('string', 'Topping');
           data.addColumn('number', 'Slices');
           data.addRows([
             ['Con cubrebocas', <?php echo $porc_conc ?> ],
             ['Sin cubrebocas', <?php echo $porc_sinc ?>]
           ]);
       
           // Set chart options
           var options = {
                          width: 500,
                          height: 500,
                          title: 'Personas detectadas',
                          colors: ['#406882', '#1A374D']
                        };
            
           // Instantiate and draw our chart, passing in some options.
           var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
           chart.draw(data, options);
         }
       </script>
               </head>
     
    <div id="chart_div" class= "grafica2"></div>

    <div class="informacion">
        <p class="text-information">La cantidad total de personas con cubrebocas en los ultimos <?php echo $DIAS ?> es de: <?php echo $total_suma_cc ?></p>
        <p class="text-information">La cantidad total de personas sin cubrebocas en los ultimos <?php echo $DIAS ?> es de: <?php echo $total_suma_sc ?></p>
    </div>


<?php
// Imprimir las sumas realizadas


$sql = "SELECT * FROM registro WHERE fecha BETWEEN '$NewDate' AND '$Date'";
$resultado_all = $conn->query($sql);

?>

<table class="amortization">
 <thead class="info">
     <th>Fecha</th>
     <th>Con cubrebocas</th>
     <th>Sin Cubrebocas</th>
 </thead>
<?php
if ($resultado_all->num_rows > 0) {
    foreach ($resultado_all as $fila) {
        $con_cc = $fila['con_cc'];
        $con_sc = $fila['con_sc'];
        $fecha = $fila['fecha'];
        ?>
        <tr>
        <td>    <?php echo       $fecha             ?>     </td>
        <td>    <?php echo round($con_cc)     ?>     </td>
        <td>    <?php echo round($con_sc)  ?>    </td>
        </tr>
        <?php
    }                
    ?>
  <tfoot>
    <td>    <p>Total</p>    </td>
    <td>    <?php echo round($total_suma_cc)  ?>    </td>
    <td>    <?php echo round($total_suma_sc)  ?>    </td>
 </tfoot>
        
    </table> 
    <?php
} 

$conn->close();
?>
