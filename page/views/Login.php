<?php
$connect = mysqli_connect("localhost", "root", "M33ty-2003", "visiomex");
// aqui validamos al usuario cliente
$NAME= test_input($_POST['name']);
$PASSWORD= test_input($_POST['password']);

// una funcion para limpiar y evitar inyecciones 
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// validar id y password
$consult="SELECT*
           FROM users 
           WHERE name ='$NAME' and password ='$PASSWORD' ";
$result = mysqli_query($connect, $consult);

$rows= mysqli_num_rows($result);
if($rows){
    session_start();
    $_SESSION["name"] = $_POST["name"];
    header("location:Form_Fechas.php"); 

}else{
    echo "<script>
        alert('Usuario o Password incorrecto');
        window.location =Login_Form.php;
        </script>";
    header("location:Login_Form.php"); 

}

mysqli_free_result($result);
mysqli_close($connect);

?>