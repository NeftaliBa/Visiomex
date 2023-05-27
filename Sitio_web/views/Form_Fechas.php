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
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
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
    <button type="submit" class="prueba"><a type="button" class="boton" name="enviar" value="fecha">Enviar</a></button>
  </form>
</div>



<div class="container_a">
  <div class= "contain_i-t">
  <form action="MostrarGrafica2.php" method="POST">  
    <label for="dias">QUIERES CONOCER LAS ESTADISTICAS DE:</label>
    <button type="submit" class="prueba"><a type="button" class="boton2" name="enviar" value="fecha2">Enviar</a></button>
    <select id="dias" name="dias" class="epoca">
      <option value="1">ayer</option>
      <option value="6">los ultimos 7 dias</option>
      <option value="29">los ultimos 30 dias</option>
      <option value="<?php echo $DiasTranscurridos?>">este año </option>
    </select>
    </div>
  <form>
</div>

</body>
</html>
