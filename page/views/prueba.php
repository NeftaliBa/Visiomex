<?php
$conn = new mysqli("localhost", "root", "M33ty-2003", "visiomex");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/css/navbar.css">
    <link rel="stylesheet" href="../resources/css/MostrarGrafica.css">
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
$DIAS =$_POST["dias"]; //esta variable contiene desde que fecha quiere conseguir datos el usuario 
$DATE =$_POST["fecha"];//esta variable contiene la fecha exacta en la que el usaurio quiere conseguir datos
$año = 0;
if ($DIAS > 30){
    $año = 365;
}



//si la variable dias esta vacia indica que el usuario prefirio conocer una fecha exacta en vez de registros desde x dias
if (empty($_POST['dias'])) {
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
                     ['Con cubrebocas', <?php echo $con_cc ?> ],
                     ['Sin cubrebocas', <?php echo $con_sc ?>]
                   ]);
               
                   // Set chart options
                   var options = {
                                  width: 900,
                                  height: 400,
                                  title: 'Personas detectadas',
                                  colors: ['#406882', '#1A374D']
                                };

                    
                   // Instantiate and draw our chart, passing in some options.
                   var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                   chart.draw(data, options);
                 }
               </script>
                       </head>
             
            <div id="chart_div" class="grafica"></div>


            <?php            
            //imprimimos la informacion de la fecha solicitada
            echo "personas con cubrebocas: " . $con_cc . ", personas sin cubrebocas: " . $con_sc . ",fecha:". $fecha ."<br>";
        }
    } else {
        echo "No se encontraron resultados.";
    }

}else{


    switch ($DIAS) {
        case 30:
            echo "i es igual a 0";
            break;
        case 7:
            echo "i es igual a 1";
            break;
        case 1:
            echo "i es igual a 2";
            break;
        case $año:
            $sql ="SELECT SUM(con_cc) as total_suma  FROM registro WHERE YEAR(fecha) = '$DIAS'";
            $resultado_cc = $conn->query($sql);
            $fila = $resultado_cc->fetch_assoc();
            $total_suma_cc = $fila["total_suma"];
    
    
            //sentencia que suma la columna de personas SIN cubrebocas del actual año
            $sql ="SELECT SUM(con_sc) as total_suma  FROM registro WHERE YEAR(fecha) = '$DIAS'";
            $resultado_sc = $conn->query($sql);
            $fila = $resultado_sc->fetch_assoc();
            $total_suma_sc = $fila["total_suma"];
    
            $personas = $total_suma_sc + $total_suma_cc;
            $porc_conc = ($total_suma_cc * 100)/$personas;
            $porc_sinc = ($total_suma_sc *100)/$personas;
    
    
            ?>
            <h2 class="titulo-culero">Este ultimo año</h2>
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
                                      width: 400,
                                      height: 300,
                                      title: 'Personas detectadas',
                                      colors: ['#406882', '#1A374D']
                                    };
                        
                       // Instantiate and draw our chart, passing in some options.
                       var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                       chart.draw(data, options);
                     }
                   </script>
                           </head>
                 
                <div id="chart_div" class= "grafica"></div>
    
            <?php
            //Imprimimos la sumas realizadas
            print("el total de personas que fueron detectadas con cubrebocas este año es de: ". $total_suma_cc."<br>");
            print("el total de personas que fueron detectadas sin cubrebocas este año es de: ". $total_suma_sc."<br>");
    
            //Sentencia para imprimir todos los registros del actualaño
            $sql = "SELECT * FROM registro WHERE YEAR(fecha) = '$DIAS'"; 
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
            } else {
                echo "No se encontraron resultados.";
            }
            break;
    }
    


    if($DIAS > 30 ){
        //sentencia que suma la columna de personas CON cubrebocas del actual año

    //SI NO SE ESCOGIO LA OPCION DE AÑO, SE REALIZA UN POCO DIFERENTE LAS SENTENCIAS POR ELLO ESTAS DOS MANERAS     
    }else{
        //sentencia para el id del ultimo registro
        $sql ="SELECT * FROM registro ORDER BY id DESC LIMIT 1";
        $resultado = $conn->query($sql);
        if ($resultado->num_rows > 0) {
            foreach ($resultado as $fila) {
                // guardamos en una variable el id del ultimo registro
                $id_2 = $fila['id'];    
            }
        } else {
            echo "No se encontraron resultados.";
        }
    
        if($DIAS>1){
            $id_1 = $id_2-$DIAS;
        }else{
            $id_1 = $id_2;
        }
        
        //sentencia que suma la columna de personas CON cubrebocas que se limita por el id de la fecha obtenida por restarle
        //a la fecha actual los dias proporcionados y el id de la ultima fecha en la que se hizo un registro
        $sql ="SELECT SUM(con_cc) as total_suma FROM registro WHERE id BETWEEN $id_1 AND $id_2";
        $resultado_cc = $conn->query($sql);
        $fila = $resultado_cc->fetch_assoc();
        $total_suma_cc = $fila["total_suma"];


        //sentencia que suma la columna de personas SIN cubrebocas
        $sql ="SELECT SUM(con_sc) as total_suma FROM registro WHERE id BETWEEN $id_1 AND $id_2";
        $resultado_sc = $conn->query($sql);
        $fila = $resultado_sc->fetch_assoc();
        $total_suma_sc = $fila["total_suma"];


        $personas = $total_suma_sc + $total_suma_cc;
        $porc_conc = ($total_suma_cc * 100)/$personas;
        $porc_sinc = ($total_suma_sc *100)/$personas;
        //Imprimimos la sumas realizadas
        ?>
        <div class="canypor">
            <p class="cteng">En los ultimos <?php echo $DIAS ?> días, <?php echo $personas ?> personas fueron detectadas y de esas <?php echo $personas ?> personas: </p>
            <p class="ctcc"> <?php  echo $total_suma_cc  ?> estaban usando cubrebocas</p>
            <p class="ctsc"><?php  echo $total_suma_sc  ?> no estaban usando cubrebocas </p>
            <p>Por lo tanto</p>
            <p class="ppcc">La cantidad de personas que usaron cubrebocas en los ultimos <?php echo $DIAS ?> días, es del <?php echo $porc_conc ?> %</p>
            <p class="ppsc">La cantidad de personas que no usaron cubrebocas en los ultimos <?php echo $DIAS ?> días, es del <?php echo $porc_sinc ?> %</p>
        </div>
        <?php
        do{
            $sql ="SELECT * FROM registro WHERE id BETWEEN $id_1 AND $id_2";
            $resultado_all = $conn->query($sql);
            if ($resultado_all->num_rows > 0) {
                ?>
                   <table class="amortization">
                    <thead class="info">
                        <th>Fecha</th>
                        <th>Con cubrebocas</th>
                        <th>Sin Cubrebocas</th>
                    </thead>
                <?php
                foreach ($resultado_all as $fila) {
                    // Acceder a los valores de cada columna en la fila
                    $con_cc = $fila['con_cc'];
                    $con_sc = $fila['con_sc'];
                    $fecha = $fila['fecha'];
                    ?>
                    <tr>
                    <td>    <?php echo       $fecha             ?>     </td>
                    <td>    <?php echo round($con_cc)     ?>     </td>
                    <td>    <?php echo round($con_sc)  ?>     </td>
                    </tr>
                    
                    <?php
                }
                break;
                ?>
                </table> 
                <?php
            }
            $id_1++; 
        }while ($resultado_all->num_rows == 0);

    }
}



// Cerrar la conexión a la base de datos
$conn->close();
?>
</body>
</html>