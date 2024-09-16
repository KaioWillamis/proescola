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
        </div>
        
        <div class="imagem">

        </div>
    </main>
</body>
</html>