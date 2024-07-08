<?php
session_start();

include_once("funcoes/carrinhofuncao.php");
include_once("bd/db_connection.php");
include_once("funcoes/categoriasfuncao.php");
$categorias = obter_categorias();

if (!isset($_SESSION['id'])) {
 
    header("Location: login.php");
    exit(); 
}

$user_id = $_SESSION['id'];


if(isset($_POST['adicionar_ao_carrinho'])) {
    $produto_id = $_POST['id_produto'];
    adicionar_produto_carrinho($user_id, $produto_id);
}


if(isset($_POST['remover_produto'])) {
    $produto_id = $_POST['product_id'];
    remover_produto_carrinho($user_id, $produto_id);
}


if(isset($_POST['aumentar_quantidade'])) {
    $produto_id = $_POST['product_id'];
    aumentar_quantidade_produto($user_id, $produto_id);
}


if(isset($_POST['diminuir_quantidade'])) {
    $produto_id = $_POST['product_id'];
    diminuir_quantidade_produto($user_id, $produto_id);
}

$conteudo_carrinho = obter_conteudo_carrinho($user_id);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header >
        <div class="logo">
            <img src="img/logo.jpg" alt="Logo da Loja">
        </div>
        <hr >
    </header>
    <nav class="navbar navbar-expand-lg navbar-#0A7FDE bg-#0A7FDE" style="background-color: #0A7FDE;">
        <div class="collapse navbar-collapse" id="navbarSupportedContent color">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Produtos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Categorias
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        
                        foreach ($categorias as $categoria) {
                            echo "<a class='dropdown-item' href='produtos_categorizados.php?categoria=" . htmlspecialchars($categoria['id'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($categoria['nome'], ENT_QUOTES, 'UTF-8') . "</a>";
                        }
                        ?>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="carrinho.php">Carrinho</a>
                </li>
                <?php if(isset($_SESSION['nome'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?php echo htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8'); ?></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Fazer Login</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="contato.php">Fale conosco </a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="pesquisar.php" method="get">
                <input class="form-control mr-sm-2" type="search" name="termo" placeholder="Pesquisar..." aria-label="Search">
                <button class="botaopesquisar" id="botao" type="submit">&#128269;</button>
            </form>
            <?php
            if(isset($_SESSION['id'])) {
            ?>
            <form action="#" method="post">
                <?php
                if(isset($_POST['logout'])) {
                    session_destroy(); 
                    header("Location: login.php"); 
                    exit;
                }
                ?>
                <button type="submit" name="logout" class="btn btn-danger">Sair</button>
            </form>
            <?php
            }
            ?>
        </div>
    </nav>
<main>
    <h1>Carrinho de Compras</h1>
    <div class="carrinhoinfo">
        <?php
        $total_carrinho = 0;

        if (!empty($conteudo_carrinho)) {
            echo "<h2>Produtos no Carrinho:</h2>";
            foreach ($conteudo_carrinho as $produto) {
                echo "<hr>";
                echo "<div class='product'>";
                echo "<img src='" . $produto['imagem'] . "' alt='" . $produto['nome'] . "'>";
                echo "<p>" . $produto['nome'] . " - R$ " . $produto['preco'] . "</p>";
                echo "<p>Quantidade: " . $produto['quantidade'] . "</p>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='product_id' value='" . $produto['id'] . "'>";
                echo "<button type='submit' name='remover_produto'>Remover Produto</button>";
                echo "<button type='submit' name='aumentar_quantidade'  class='aumentar'>+</button>";
                echo "<button type='submit' name='diminuir_quantidade' class='diminuir'>-</button>";
                echo "</form>";
                echo "</div>";
                $total_carrinho += $produto['preco'] * $produto['quantidade'];
            }

            echo "<h3>Total do Carrinho: R$ " . number_format($total_carrinho, 2, ',', '.') . "</h3>";
        } else {
            echo "<p>O carrinho está vazio.</p>";
        }
        ?>
         <?php
         if (!empty($conteudo_carrinho)) {
            echo "<form action='finalizar.php' method='post'>";
            echo "<button type='submit' name='finalizar_compra' class='finalizarcompra'>Finalizar Compra</button>";
            echo "</form>";
        }?>
    </div>
  
</main>
<br>
<br><br>
<footer>
    <p>&copy; 2024 Loja Online. Todos os direitos reservados LN Express</p>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
