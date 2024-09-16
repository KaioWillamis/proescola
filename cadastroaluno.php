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
    <title>Cadastro Aluno</title>
</head>
<body>
    <main>
        <div>
            <h1>Cadastro de Aluno</h1>
            <form method="POST" action="salvaraluno.php">
            Nome <input type="text" placeholder="Nome Aluno" name="nome">
            Telefone <input type="text" placeholder="(00) 00000-0000" name="telefone">
            CPF <input type="text" placeholder="000.000.000-00" name="cpf">
            <input type="submit" value="Salvar">
            <button type="button" onclick="window.location.href='alunos.php'">Cancelar</button>
            </form>
        </div>
    </main>
</body>
</html>