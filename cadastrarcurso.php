<?php
session_start();

if(!isset($_SESSION["admi"])){
    //Se não existir uma sessão é porque o usuario não informou os dados na pagina de login
    header("Location: login.php");
    exit();
}
else{
    //Se existir os dados vai continuar com sessão
    $admi = $_SESSION["admi"];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Curso</title>
</head>
<body>
    <main>
        <h1>Cadastrar Curso</h1>
        <form method="POST" action="salvarcurso.php">
            Nome: <input type="text" name="nome">
            Duração: <input type="number" name="duracao">

            <input type="submit" value="Salvar">
            <button type="button" onclick="window.location.href='curso.php'">Cancelar</button>
        </form>
    </main>
</body>
</html>