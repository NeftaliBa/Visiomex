<?php

$DIAS =$_POST["dias"]; //esta variable contiene desde que fecha quiere conseguir datos el usuario 
$DATE =$_POST["fecha"];//esta variable contiene la fecha exacta en la que el usaurio quiere conseguir datos

// conectare a base de datos
$conn = new mysqli("localhost", "root", "Admin123?", "visiomex");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
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
            
            //imprimimos la informacion de la fecha solicitada
            echo "personas con cubrebocas: " . $con_cc . ", personas sin cubrebocas: " . $con_sc . ",fecha:". $fecha ."<br>";
        }
    } else {
        echo "No se encontraron resultados.";
    }

}else{
    if($DIAS > 30 ){
    
        //sentencia que suma la columna de personas CON cubrebocas del actual año
        $sql ="SELECT SUM(con_cc) as total_suma  FROM registro WHERE YEAR(fecha) = '$DIAS'";
        $resultado_cc = $conn->query($sql);
        $fila = $resultado_cc->fetch_assoc();
        $total_suma_cc = $fila["total_suma"];


        //sentencia que suma la columna de personas SIN cubrebocas del actual año
        $sql ="SELECT SUM(con_sc) as total_suma  FROM registro WHERE YEAR(fecha) = '$DIAS'";
        $resultado_sc = $conn->query($sql);
        $fila = $resultado_sc->fetch_assoc();
        $total_suma_sc = $fila["total_suma"];

        //Imprimimos la sumas realizadas
        print("el total de personas que fueron detectadas con cubrebocas este año es de: ". $total_suma_cc."<br>");
        print("el total de personas que fueron detectadas sin cubrebocas este año es de: ". $total_suma_sc."<br>");

        //Sentencia para imprimir todos los registros del actualaño
        $sql = "SELECT * FROM registro WHERE YEAR(fecha) = '$DIAS'"; 
        $resultado_all = $conn->query($sql);
        if ($resultado_all->num_rows > 0) {
            foreach ($resultado_all as $fila) {
                $con_cc = $fila['con_cc'];
                $con_sc = $fila['con_sc'];
                $fecha = $fila['fecha'];
                echo "fecha: ". $fecha . "  personas con cubrebocas: " . $con_cc . ",   personas sin cubrebocas:    " . $con_sc  ."<br>";

            }
        } else {
            echo "No se encontraron resultados.";
        }
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

        //Imprimimos la sumas realizadas
        print("el total de personas que fueron detectadas CON cubrebocas en los ultimo/s" . $DIAS ."dias es de: ". $total_suma_cc."<br>");
        print("el total de personas que fueron detectadas SIN cubrebocas en los ultimo/s" . $DIAS ."dias es de: ". $total_suma_sc."<br>");

        do{
            $sql ="SELECT * FROM registro WHERE id BETWEEN $id_1 AND $id_2";
            $resultado_all = $conn->query($sql);
            if ($resultado_all->num_rows > 0) {
                foreach ($resultado_all as $fila) {
                    // Acceder a los valores de cada columna en la fila
                    $con_cc = $fila['con_cc'];
                    $con_sc = $fila['con_sc'];
                    $fecha = $fila['fecha'];
                    echo "fecha: ". $fecha . "  personas con cubrebocas: " . $con_cc . ",   personas sin cubrebocas:    " . $con_sc  ."<br>";
                }
                break;
            }
            $id_1++; 
        }while ($resultado_all->num_rows == 0);

    }
}



// Cerrar la conexión a la base de datos
$conn->close();
?>