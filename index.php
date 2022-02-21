<?php
require 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container pb-5">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php?class=produto">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?class=produto&op=create">Cadastrar</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="py-5 text-center">
        <h2 class="text-dark">Sistema de Cadastro de Produtos</h2>
        <p class="lead">Crud simples em PHP/MySql para cadastro de produtos.</p>
    </div>

    <?php
    //classe e método padrão de início do sistema
    $class = 'produto';
    $method = 'index';

    if (array_key_exists("class", $_GET)) {
        $class = $_GET['class'];
    }

    //os Controllers devem está no padrão Camel Case e primeira letra maíscula ex: ProdutoController
    $class = ucfirst($class);
    $classe = "\Evand\\CrudPhpPdoMySql\\Controller\\{$class}Controller";

    if (array_key_exists('op', $_GET)) {
        $method = $_GET['op'];
    }

    if (class_exists($classe)) {
        $pagina = new $classe;
    } else {
        throw new \Exception("Classe {$classe} não Existe");
    }

    if (method_exists($pagina, $method)) {
        call_user_func(array($pagina, $method));
    } else {
        throw new \Exception("Página não Existe");
    }
    ?>

</div>
</body>
</html>
