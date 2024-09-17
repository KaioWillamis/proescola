<?php
include "sessao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Curso</title>
    <link rel="shortcut icon" href="img/school.ico" type="image/x-icon">
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