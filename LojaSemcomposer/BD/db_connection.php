<?php
$nome = "localhost";
$usuario = "root";
$senha = "";
$dbnome = "bmcloset";//iria ser o nome da loja
 
$conn = new mysqli($nome, $usuario, $senha, $dbnome);

 
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>