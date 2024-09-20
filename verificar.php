<?php
include "sessao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['login'];
    $senha = $_POST['senha'];

    if (file_exists('json/login.json')) {
        $login = json_decode(file_get_contents('json/login.json'), true);
        if (isset($login[$nome]) && $login[$nome] === $senha){
            header("Location: principal.php");
            exit();
        }
        else{
            // Redireciona para login.php com um parâmetro de erro
            header("Location: login.php?erro=1");
            exit();
        }
    }
}
?>