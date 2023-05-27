<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../resources/css/navbar.css">
        <link rel="stylesheet" href="../resources/css/MostrarGrafica.css">
        <title></title>
</head>
<body>
        <header class="">
        <div class="espacio">Menú</div>
                <nav class="navegacion">
                        <ul class = menu>
                        <p class="logo">Visiomex</p>
                        <li><a href="../index.php">Inicio </a></li>
                        <li><a href="equipo.php">Sobre nosotros</a></li>
                        <li><a href="galeria.php">Galeria </a></li>
                        </ul>
                </nav>
        </header>
        <main>
        <form method="post" action="Login.php" class="">
                <h2 class="">Ingrese datos del usuario</h2>
                <div class="">      
                <input class="" type="text" name="name" maxlength="60" id="name" placeholder=" " required>
                <label for="name" class="">Usuario</label>
                <input class="" type="password" name="password" maxlength="30" id="password"  placeholder=" " required>
                <label for="password" class="">Contraseña</label>
                <input class="" type="submit" value="Ingresar">
                </div>
        </form>
        </main>

</body>