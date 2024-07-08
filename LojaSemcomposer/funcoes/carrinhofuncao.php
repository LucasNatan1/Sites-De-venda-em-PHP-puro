<?php

include_once("bd/db_connection.php");

function obter_conteudo_carrinho($user_id) {
    global $conn;

    $conteudo_carrinho = array();

    $sql = "SELECT c.produto_id, p.nome, p.preco, p.imagem, c.quantidade
            FROM carrinho_compras c
            INNER JOIN produtos p ON c.produto_id = p.id
            WHERE c.user_id = $user_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
           
            $caminho_imagem = "img/" . $row['imagem'];
            $conteudo_carrinho[] = array(
                'id' => $row['produto_id'],
                'nome' => $row['nome'],
                'preco' => $row['preco'],
                'imagem' => $caminho_imagem,
                'quantidade' => $row['quantidade']
            );
        }
    }

    return $conteudo_carrinho;
}

function adicionar_produto_carrinho($user_id, $produto_id) {
    global $conn;
 
    $sql_check = "SELECT * FROM carrinho_compras WHERE user_id = $user_id AND produto_id = $produto_id";
    $result_check = $conn->query($sql_check);

    if ($result_check && $result_check->num_rows > 0) {
         
        $sql_update = "UPDATE carrinho_compras SET quantidade = quantidade + 1 WHERE user_id = $user_id AND produto_id = $produto_id";
        $conn->query($sql_update);
    } else {
      
        $sql_insert = "INSERT INTO carrinho_compras (user_id, produto_id, quantidade) VALUES ($user_id, $produto_id, 1)";
        $conn->query($sql_insert);
    }
}

function remover_produto_carrinho($user_id, $produto_id) {
    global $conn;

    $sql = "DELETE FROM carrinho_compras WHERE user_id = $user_id AND produto_id = $produto_id";
    $conn->query($sql);
}

function aumentar_quantidade_produto($user_id, $produto_id) {
    global $conn;

    $sql = "UPDATE carrinho_compras SET quantidade = quantidade + 1 WHERE user_id = $user_id AND produto_id = $produto_id";
    $conn->query($sql);
}

function diminuir_quantidade_produto($user_id, $produto_id) {
    global $conn;

    $sql = "UPDATE carrinho_compras SET quantidade = quantidade - 1 WHERE user_id = $user_id AND produto_id = $produto_id AND quantidade > 1";
    $conn->query($sql);
}

?>
