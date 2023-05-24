<?php
// conectare a base de datos
$conn = new mysqli("localhost", "root", "Admin123?", "visiomex");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}