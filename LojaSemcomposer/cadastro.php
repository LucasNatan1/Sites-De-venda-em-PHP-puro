<?php
session_start();
include_once("bd/db_connection.php");
include_once("funcoes/carrinhofuncao.php");
//include_once("funcoes/categoriasfuncao.php"); 
include_once("funcoes/loginfuncao.php");
include_once("funcoes/cadastrofuncao.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $senha = $_POST["senha"];
    $cep = $_POST["cep"];

     
    $mensagem = cadastrar_cliente($nome, $cpf, $senha, $cep);

    
    echo "<script>alert('$mensagem'); window.location.href = 'login.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
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
        
    <div class="login">
    <h1>Cadastro</h1>
    <form action="cadastro.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required><br><br>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required><br><br>
            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" required><br><br>
            <button type="submit" class="cadastrar" >Cadastrar</button>
        </form>
    </div>
    </main>
    <footer>
        <p>&copy; 2024 Loja Online. Todos os direitos reservados LN Express</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
