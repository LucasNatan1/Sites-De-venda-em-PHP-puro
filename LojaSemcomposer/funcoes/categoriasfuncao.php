<?php
include_once("bd/db_connection.php");


function obter_categorias() {
    global $conn;

    $categorias = array();

    $sql = "SELECT id, nome FROM categorias";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $categorias[] = $row;
        }
    }

    return $categorias;
}

function obter_nome_categoria($categoria_id) {
    global $conn;

    $sql = "SELECT nome FROM categorias WHERE id = $categoria_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['nome'];
    } else {
        return "Categoria Desconhecida";
    }
}

function obter_produtos_por_categoria($categoria_id) {
    global $conn;

    $produtos = array();

    $sql = "SELECT id, nome, preco, imagem FROM produtos WHERE categoria_id = $categoria_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $produtos[] = $row;
        }
    }

    return $produtos;
}
?>

