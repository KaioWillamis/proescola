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
    <link rel="stylesheet" href="style/cadastrarmatricula.css">
</head>
<body>
    <main>
        <div>
            <h1>Cadastro de Matricula</h1>
            <form method="POST" action="salvarmatricula.php">
                Id do Aluno:<br> <input type="text" name="aluno" placeholder="Informe o id do aluno"><br>
                Id do Curso:<br> <input type="text" name="curso" placeholder="Informe o nome do curso"><br>
                Data de Inicio:<br> <input type="date" name="data"><br>
                <input type="submit" value="Salvar" class="inputsalvar"><br>
                <input type="reset" value="Apagar informações" class="inputapagar">
                <button type="button" onclick="window.location.href='matricula.php'">Cancelar</button>
            </form>
        </div>
    </main>
</body>
</html>