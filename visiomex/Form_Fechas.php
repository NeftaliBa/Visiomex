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
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
</head>
<body>
  QUIERES CONOCER LAS ESTADISTICAS DE UNA FECHA EN ESPECIFICO
  <form action="MostrarGrafica1.php" method="POST">
    <label for="fecha">Selecciona la fecha:</label>
    <input type="text" id="fecha" name="fecha">

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
      <script>
        $(function() {
          $("#fecha").datepicker({
            dateFormat: "yy/mm/dd"
          });
        });
      </script>
    <button type="submit" class="Boton" name="enviar" value="fecha" >ENVIAR</button><br><br>
  </form>


  <form action="MostrarGrafica2.php" method="POST">  
    <label for="dias">QUIERES CONOCER LAS ESTADISTICAS DE:</label>
    <select id="dias" name="dias">
      <option value="1">ayer</option>
      <option value="6">los ultimos 7 dias</option>
      <option value="29">los ultimos 30 dias</option>
      <option value="<?php echo $DiasTranscurridos?>">este año </option>
    </select>
    <button type="submit" class="Boton" name="enviar" value="fecha2" >ENVIAR</button><br><br>
  <form>


</body>
</html>
