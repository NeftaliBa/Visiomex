<?php
$año = date("Y");
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">

  <!--
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  -->
  <link rel="stylesheet" href="./resources/css/index.css">
  <link rel="stylesheet" href="./resources/css/navbar.css">
</head>
<body>

<header> 
    <div class="espacio">
        <nav class="navegacion">
            <ul class="menu">
                <p class="logo">Visiomex</p>
                <li><a href="Logout.php">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </div>
</header>



<h2 class="titulo-culero">QUIERES CONOCER LAS ESTADISTICAS DE UNA FECHA EN ESPECIFICO</h1>






  <div class="container_a">
    <div class= "contain_i-t">
    <form action="../views/MostrarGrafica.php" method="POST">
      <label for="fecha">Selecciona la fecha:</label>
      <input type="text" id="fecha" name="fecha" class="fecha">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
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
      <form action= "../views/MostrarGrafica.php" method="POST">  
        <label for="dias">Estadisticas de una epoca en especifico </label>
        <button type="submit" class="prueba"><a type="button" class="boton2" name="enviar" value="fecha2">Enviar</a></button>
        <select id="dias" name="dias" class="epoca">
          <option value="1">Ayer</option>
          <option value="6">Los ultimos 7 dias</option>
          <option value="29">Los ultimos 30 dias</option>
          <option value="<?php echo $año?>">Este año </option>
        </select>
      </div>
    <form>
  </div>


    
</body>
</html>
