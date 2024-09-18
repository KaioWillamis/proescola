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
    <link rel="stylesheet" href="style/cadastrarcurso.css">
</head>
<body>
    <main>
        <div>
            <h1>Cadastrar Curso</h1>
            <form method="POST" action="salvarcurso.php">
                Nome: <br> <input type="text" name="nome" placeholder="Nome do Curso"> <br>
                Duração: <br> <input type="number" name="duracao" placeholder="Duração do Curso"> <br>

                <input type="submit" value="Salvar" class="inputsalvar"> <br>

                <input type="reset" value="Apagar informações" class="inputapagar">
                <button type="button" onclick="window.location.href='curso.php'">Cancelar</button>
            </form>
        </div>
    </main>
</body>
</html>