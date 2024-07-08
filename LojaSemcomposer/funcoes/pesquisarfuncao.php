<?php
include_once("bd/db_connection.php");

function pesquisar_produtos($termo) {
    global $conn;
    $termo = "%" . $termo . "%";
    $sql = $conn->prepare("SELECT * FROM produtos WHERE nome LIKE ? OR descricao LIKE ?");
    $sql->bind_param("ss", $termo, $termo);
    $sql->execute();
    $result = $sql->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
