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
<title>Principal</title>
</head>
<body>
    <main>
        <div onclick="window.location.href='curso.php'">
            <p>cursos</p>
        </div>

        <div onclick="window.location.href='matricula.php'">
            <p>Matricula</p>
        </div>

        <div onclick="window.location.href='alunos.php'">
            <p>Alunos</p>
        </div>
    
        <div onclick="window.location.href='login.php'">
            <p>Voltar</p>
        </div>
    </main>
</body>
</html>
