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





    ?>

<!--
    <div class="informacion">
        <p class="text-information">El dia <?php// $fecha ?> se detectaron <?php //$con_cc ?> con cubrebocas</p>
        <p class="text-information">El dia <?php// $fecha ?> se detectaron <?php //$con_sc ?> sin cubrebocas</p>
    </div>
-->

<h2 class="titulo">Dia <?php  ?></h2>


    <table class="amortization">
     <thead class="info">
         <th>Fecha</th>
         <th>Con cubrebocas</th>
         <th>Sin Cubrebocas</th>
     </thead>
    <?php
    if ($resultado->num_rows > 0) {
        foreach ($resultado as $fila) {
            $id = $fila['id'];
            $con_cc = $fila['con_cc'];
            $con_sc = $fila['con_sc'];
            $fecha = $fila['fecha'];

            $personas = $con_sc + $con_cc;
            $porc_conc = ($con_cc * 100)/$personas;
            $porc_sinc = ($con_sc *100)/$personas;


            ?>
            <tr>
            <td>    <?php echo       $fecha             ?>     </td>
            <td>    <?php echo round($con_cc)     ?>     </td>
            <td>    <?php echo round($con_sc)  ?>    </td>
            </tr>
            <?php
        }                
        ?>
        </table> 
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
     
    <div id="chart_div" class= "grafica1"></div>
        <?php
    } else {
        echo "No se encontraron resultados.";
    }


// Cerrar la conexión a la base de datos
$conn->close();
?>