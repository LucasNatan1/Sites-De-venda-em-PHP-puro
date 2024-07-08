<?php
include_once("bd/db_connection.php");

function fazer_login($cpf, $senha) {
    global $conn;

    
    $sql = $conn->prepare("SELECT id, nome, cpf, senha FROM usuarios WHERE cpf = ?");
    $sql->bind_param("s", $cpf);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        
        if (password_verify($senha, $row['senha'])) {
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['cpf'] = $row['cpf'];
            return true;
        }
    }
    return false;
}
?>