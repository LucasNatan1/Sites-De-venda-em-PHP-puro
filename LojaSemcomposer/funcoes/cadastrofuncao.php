<?php
include_once("bd/db_connection.php");

function cadastrar_cliente($nome, $cpf, $senha, $cep) {
    global $conn;


    $sql_verificar = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
    $result_verificar = $conn->query($sql_verificar);

    if ($result_verificar->num_rows > 0) {
        return "CPF já cadastrado";
    }

    $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);


    $sql_cadastrar = $conn->prepare("INSERT INTO usuarios (nome, cpf, senha, cep) VALUES (?, ?, ?, ?)");
    $sql_cadastrar->bind_param("ssss", $nome, $cpf, $senha_criptografada, $cep);
    if ($sql_cadastrar->execute()) {
        return "Cadastro realizado com sucesso";
    } else {
        return "Erro ao cadastrar: " . $conn->error;
    }
}
?>