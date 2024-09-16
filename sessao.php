<?php
session_start();

if (!isset($_SESSION["admi"])) {
    // Se não existir uma sessão é porque o usuário não informou os dados na página de login
    header("Location: login.php");
    exit();
} else {
    // Se existir os dados, vai continuar com a sessão
    $admi = $_SESSION["admi"];
}
?>