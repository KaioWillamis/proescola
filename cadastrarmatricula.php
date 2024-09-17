<?php
include "sessao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Matricula</title>
    <link rel="shortcut icon" href="img/school.ico" type="image/x-icon">
</head>
<body>
    <h1>Cadastro de Matricula</h1>
    <form method="POST" action="salvarmatricula.php">
        Id do Aluno: <input type="text" name="aluno">
        Id do Curso: <input type="text" name="curso">
        Data de Inicio: <input type="date" name="data">
        <input type="submit" value="Salvar">
        <button type="button" onclick="window.location.href='matricula.php'">Cancelar</button>
    </form>
</body>
</html>