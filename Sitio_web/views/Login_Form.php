<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../resources/css/navbar.css">
        <link rel="stylesheet" href="../resources/css/login.css">
        <link rel="icon" type="image/x-icon" href="/resources/img/icon.png">

        <title>Login</title>
</head>
<body>
        <header class="">
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
        <div class="login-form">
                <h2 class="">Inicio de sesion</h2>    
                  
                <form method="post" action="Login.php">
                        <div class="userdata">
                                <input class="inputs" type="text" name="name" maxlength="60" id="name" placeholder=" " required>
                                <label for="name" class="labia">Usuario</label>
                        </div>
                        <div class="userdata">
                                <input class="inputs" type="password" name="password" maxlength="30" id="password"  placeholder=" " required>
                                <label for="cont" class="labia">Contraseña</label><br>
                        </div>
                        <input class="button" type="submit" value="Ingresar">
                </form>
        </div>
</main>

</body>