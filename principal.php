<?php
include "sessao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Principal</title>
<link rel="stylesheet" href="style/principal.css">
<link rel="shortcut icon" href="img/school.ico" type="image/x-icon">
</head>
<body>
    <main>
        <div onclick="window.location.href='curso.php'" class="curso">
            <p>Cursos</p>
            <img src="" alt="">
        </div>

        <div onclick="window.location.href='matricula.php'" class="matricula">
            <p>Matrícula</p>
            <img src="" alt="">
        </div> 

        <div onclick="window.location.href='alunos.php'" class="alunos">
            <p>Alunos</p>
            <img src="" alt="">
        </div>
    
        <div onclick="window.location.href='login.php'" class="voltar">
            <p>Voltar</p>
            <img src="" alt="">
        </div>
    </main>
</body>
</html>
