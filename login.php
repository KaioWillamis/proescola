<?php
include "class/classusuario.php";

session_start();

if(!isset($_SESSION["admi"])){
    $admi = new Usuario();
    $_SESSION["admi"] = $admi;
}
else{
    $admi = $_SESSION["admi"];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/login.css">
    <link rel="shortcut icon" href="img/school.ico" type="image/x-icon">
</head>
<body>
    <main>
        <div class="informacao">
            <h1>Portal do Admi</h1> <br>
            <form action="verificar.php" method="POST">

            <input type="text" placeholder="Nome" name="login"> <br>
            <input type="text" placeholder="Senha" name="senha"> <br>
            <input type="submit" value="Entrar" class="inputprincipal">
            </form>

             <?php 
            // Verifica se há um erro na URL
            if (isset($_GET['erro']) && $_GET['erro'] == "1") {
                ?>
                <div class="mensagem">
                    <?php
                    echo "Senha ou nome errado!";
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        
        <div class="carrossel">
            <div class="carousel-images">
                <div class="img"><img src="img/imagem1.jpg" alt="Imagem 1"></div>
                <div class="img"><img src="img/imagem2.jpg" alt="Imagem 2"></div>
                <div class="img"><img src="img/imagem3.jpg" alt="Imagem 3" width="870" height="620"></div>
            </div>
        </div>
    </main>
</body>
</html>