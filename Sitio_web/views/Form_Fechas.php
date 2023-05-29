<?php
// Obtener la fecha actual
$fechaActual = date('Y-m-d');

// Obtener la fecha del inicio del año
$fechaInicioAño = date('Y-01-01');

// Calcular los días transcurridos
$DiasTranscurridos = floor((strtotime($fechaActual) - strtotime($fechaInicioAño)) / (60 * 60 * 24));
?>

<!DOCTYPE html>
<html>
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="../resources/css/navbar.css">
  <link rel="stylesheet" href="../resources/css/form_fechas.css">
  <link rel="icon" type="image/x-icon" href="/resources/img/icon.png">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
  <title>Fechas</title>
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

  <h2 class="titulo"> QUIERES CONOCER LAS ESTADISTICAS DE UNA FECHA EN ESPECIFICO </h2>
<!--
<div class="container_a">
  <div class= "contain_i-t">
  <form action="MostrarGrafica1.php" method="POST">
    <label for="fecha">Selecciona la fecha:</label>
    <input type="text" id="fecha" name="fecha" class="fecha">
    <script>
        $(function() {
          $("#fecha").datepicker({
            dateFormat: "yy/mm/dd"
          });
        });
      </script>
    </div>
    <input class="boton" type="submit" value="Enviar">
  </form>
</div>



<div class="container_a">
  <div class= "contain_i-t">
  <form action="MostrarGrafica2.php" method="POST">  
    <label for="dias">QUIERES CONOCER LAS ESTADISTICAS DE:</label>
    <select id="dias" name="dias" class="epoca">
      <option value="1">ayer</option>
      <option value="6">los ultimos 7 dias</option>
      <option value="29">los ultimos 30 dias</option>
      <option value="<?php //echo $DiasTranscurridos?>">este año </option>
    </select>
    <input class="boton2" type="submit" value="Enviar">
  </div>
  <form>
</div>
      -->
<div class="container-cards">
            <div class="card">
            <div class="cover-card">
                    <img src="/resources/img/" alt="">
                </div>
                <h2>Dia en particular</h2>
                <p>Escoja un dia en especifico para checar sus estadisticas</p>

            <div class= "contain_i-t">
            <form action="MostrarGrafica1.php" method="POST">
            <label for="fecha"><label>
            <input type="text" id="fecha" name="fecha" class="fecha">              
            <script>
                  $(function() {
                    $("#fecha").datepicker({
                      dateFormat: "yy/mm/dd"
                    });
                  });
                </script>
              </div>
              <input class="" type="submit" value="Enviar">
            </form>

            </div>
            
            <div class="card">
            <div class="cover-card">
                    <img src="/resources/img/" alt="">
                </div>
                <h2>Rango de dias</h2>
                <p>Escoja un rango de dias para poder ver sus estadisticas</p>

                <div class= "contain_i-t">
                <form action="MostrarGrafica2.php" method="POST">  
                  <select id="dias" name="dias" class="epoca">
                    <option value="1">Ayer</option>
                    <option value="6">Los ultimos 7 dias</option>
                    <option value="29">Los ultimos 30 dias</option>
                    <option value="<?php echo $DiasTranscurridos?>">Este año </option>
                  </select>
                </div>
                <input class="" type="submit" value="Enviar">
                <form>

            </div>
            


    </div>

</body>
</html>
