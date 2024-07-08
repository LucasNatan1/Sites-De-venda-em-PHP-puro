<?php
include_once("bd/db_connection.php");

function enviar_mensagem($nome, $email, $mensagem) {
    global $conn;

    $sql = "INSERT INTO mensagens_contato (nome, email, mensagem) VALUES ('$nome', '$email', '$mensagem')";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}
?>