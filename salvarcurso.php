<?php
include "class/classcurso.php";

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $duracao = $_POST['duracao'];

    $aluno = new Curso($_POST['nome'],$_POST['telefone']);

    // Caminho do arquivo JSON
    $arquivoJson = 'json/cursos.json';
    $dadosExistentes = [];

    // Verifica se o arquivo JSON já existe
    if (file_exists($arquivoJson)) {
        $dadosJson = file_get_contents($arquivoJson); //Lê o conteúdo do arquivo JSON
        $dadosExistentes = json_decode($dadosJson, true); //Decodifica o JSON para um array PHP
    }

    // Verifica se o curso já existe no arquivo JSON
    $$cursoExistente = false; // Inicializa uma flag para verificar se o curso já existe
    foreach ($dadosExistentes as $registro) {
        if ($registro['nome'] == $nome) {
            $$cursoExistente = true; //Define a flag como verdadeira se o aluno for encontrado
            break;
        }
    }

    if ($cursoExistente) {
        echo "O Curso já está cadastrado.";
    }

    else {
        // Adiciona o novo aluno ao array
        $novoCurso = array(
            'nome' => $nome,
            'duracao' => $duracao,
        );
    }

    $dadosExistentes[] = $novoCurso;

    // Salva os dados atualizados no arquivo JSON
    file_put_contents($arquivoJson, json_encode($dadosExistentes, JSON_PRETTY_PRINT));

    header("Location: curso.php");
    exit();
}

else {
echo "Método de requisição inválido!";
}
?>